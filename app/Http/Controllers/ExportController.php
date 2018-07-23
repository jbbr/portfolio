<?php

namespace App\Http\Controllers;

use App;
use App\Location;
use App\Media;
use App\MediaInfo;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

class ExportController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $entries = Auth::user()->entries();

        if ($request->portfolios) {
            $entries->whereIn('portfolio_id', explode(',', $request->portfolios));
        }

        if ($request->date_from) {
            $entries->where('date', '>=', Carbon::parse(request('date_from'))->format('Y-m-d'));
        }

        if ($request->date_to) {
            $entries->where('date', '<=', Carbon::parse(request('date_to'))->format('Y-m-d'));
        }

        if ($request->tags) {
            $entries->whereHas('tags', function ($query) use ($request) {
                return $query->whereIn('tag_id', explode(',', $request->tags));
            });
        }

        if ($request->locations) {
            $entries->whereIn('location_id', explode(',', $request->locations));
        }

        $request->flash();

        return view('export.index', [
            'portfolios' => Auth::user()->portfolios()->with(['entries'])->orderBy('sort', 'ASC')->get(),
            'tags' => Auth::user()->tags()->orderBy('name')->get(),
            'locations' => Auth::user()->locations,
            'entries' => $entries->orderBy('date', 'DESC')->get(),
        ]);
    }

    public function filterList(Request $request) {

        $entries = Auth::user()->entries();

        if ($request->portfolios) {
            $entries->whereIn('portfolio_id', explode(',', $request->portfolios));
        }

        if ($request->date_from) {
            $entries->where('date', '>=', Carbon::parse(request('date_from'))->format('Y-m-d'));
        }

        if ($request->date_to) {
            $entries->where('date', '<=', Carbon::parse(request('date_to'))->format('Y-m-d'));
        }

        if ($request->tags) {
            $entries->whereHas('tags', function ($query) use ($request) {
                return $query->whereIn('tag_id', explode(',', $request->tags));
            });
        }

        if ($request->locations) {
            $entries->whereIn('location_id', explode(',', $request->locations));
        }

        $entries->orderBy('date', 'DESC');

        $output = [];
        foreach($entries->get() as $_entry ) {
            $output[] = view('export.partials.entry', ['entry' => $_entry])->render();
        }

        return response()->json([
            'view' => implode("", $output)
        ]);

    }

    public function send(Request $request)
    {
        // Filter?
        if ($request->action == "filter") {
            return $this->index($request);
        } // or PDF?
        else {
            return $this->generate($request);
        }
    }

    /**
     * @return mixed
     */
    public function generate(Request $request)
    {
        if (!$request->entries) {
            return view('export.pdf.info');
        }

        $entries = [];
        $action = str_replace("preview_", "", $request->action);

        switch ($action) {
            case 'individual':
                $entries = $this->generateIndividualCertificate($request);
                break;
            case 'explicit':
                $entries = $this->generateTrainingCertificate($request);
                break;
        }

        $allowedEntries = $entries->pluck('id')->toArray();

        list($integrate, $attach) = $this->_loadMedia($request, $allowedEntries);

        $additionals = [];
        foreach (Config::get('location.pdf') as $label => $path) {
            $segs = explode('.', $path);
            $type = $segs[0];
            $field = $segs[1];

            $location = Auth::user()->locations()->whereType($type)->first();
            if (!$location) {
                continue;
            }
            if ($location->$field != null) {
                $additionals[] = [$label, $location->$field];
            } else {
                $additionals[] = [$label, $location->additionals->$field];
            }
        }

        $pdf = App::make('dompdf.wrapper');
        $pdf->setPaper('A4');
        $pdf->loadView('export.pdf.pdf', [
            'entries' => $entries,
            'media' => [
                'integrate' => $integrate,
                'attach' => $attach
            ],
            'title' => $request->title,
            'description' => $request->description,
            'type' => $action,
            'additionals' => $additionals,
        ]);

        $filename = Auth::id() . md5(uniqid());

        if ($action == "explicit") {
            $pdf->save(storage_path("app/pdf/{$filename}.pdf"));
            $mergeAttachments = [
                [storage_path("app/pdf/{$filename}.pdf") => [1, Media::MERGE_END]]
            ];
            foreach ($attach as $id => $mediaInfos) {
                foreach ($mediaInfos as $mediaInfo) {
                    $attachFilename = pathinfo($mediaInfo->media->path)['filename'];
                    $path = storage_path("app/public/media/attachment/") . $attachFilename . '.pdf';
                    $mergeAttachments[] = [$path => [1, Media::MERGE_END]];
                }
            }
            Media::mergePDFs($mergeAttachments, "{$filename}-merge.pdf");
            unlink(storage_path("app/pdf/{$filename}.pdf"));
        } else {
            $pdf->save(storage_path("app/pdf/{$filename}-merge-unattached.pdf"));
            $mergeAttachments = [
                [storage_path("app/pdf/{$filename}-merge-unattached.pdf") => [1, Media::MERGE_END]],
            ];
            foreach ($attach as $id => $mediaInfos) {
                foreach ($mediaInfos as $mediaInfo) {
                    $attachFilename = pathinfo($mediaInfo->media->path)['filename'];
                    $path = storage_path("app/public/media/attachment/") . $attachFilename . '.pdf';
                    $mergeAttachments[] = [$path => [1, Media::MERGE_END]];
                }
            }
            Media::mergePDFs($mergeAttachments, "{$filename}-merge.pdf");
            unlink(storage_path("app/pdf/{$filename}-merge-unattached.pdf"));
        }

        // Generate PDF Output as PDF
        if (strpos(request('action'), 'preview') === false) {
            return response()->download(storage_path("app/pdf/{$filename}-merge.pdf"), 'portfolio.pdf', [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'attachment; filename="portfolio.pdf"'
            ])->deleteFileAfterSend(true);
        }

        // Generate PDF Output and Stream to Browser
        return response()->file(storage_path("app/pdf/{$filename}-merge.pdf"), [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="portfolio.pdf"'
        ])->deleteFileAfterSend(true);
    }

    public function generateIndividualCertificate(Request $request)
    {
        return Auth::user()->entries()->with([
            'portfolio',
            'tags',
            'location'
        ])
            ->whereIn('entries.id', $request->entries)
            ->orderBy('entries.date', $request->get('sort-date'))
            ->get();
    }

    public function generateTrainingCertificate(Request $request)
    {
        return Auth::user()
                ->entries()
                ->with([
                    'tags',
                    'location'
                ])
                ->whereIn('entries.id', $request->entries)
                ->orderBy('portfolios.sort', 'ASC')
                ->orderBy('portfolios.title', 'ASC')
                ->orderBy('entries.date', $request->get('sort-date'))
                ->get(['entries.*', 'portfolios.title as portfolio_title']);
    }

    protected function _loadMedia(Request $request, $allowedEntries)
    {
        $attach = $request->attach ?: [];
        $integrate = $request->integrate ?: [];

        foreach (array_keys($attach) as $k) {
            if (!in_array($k, $allowedEntries)) {
                unset($attach[$k]);
            }
        }

        foreach (array_keys($integrate) as $k) {
            if (!in_array($k, $allowedEntries)) {
                unset($integrate[$k]);
            }
        }

        if (!empty($attach) || !empty($integrate)) {
            $ids = array_unique(array_merge(...$integrate, ...$attach));

            $mediaInfos = MediaInfo::whereIn('id', $ids)->get();

            $integrate = $this->_mapMediaInfos($integrate, $mediaInfos);
            $attach = $this->_mapMediaInfos($attach, $mediaInfos);
        }

        return [$integrate, $attach];
    }

    protected function _mapMediaInfos($type, $mediaInfos)
    {
        if (!$type) {
            return [];
        }
        return array_map(function ($arr) use ($mediaInfos) {
            $new = [];
            foreach ($arr as $_id) {
                $new[] = $mediaInfos->find($_id);
            }
            return $new;
        }, $type);
    }
}
