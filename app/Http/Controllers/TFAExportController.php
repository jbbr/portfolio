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

class TFAExportController extends ExportController
{
    /**
     * @return mixed
     */
    public function generate(Request $request)
    {
        if (!$request->entries) {
            return view('export.pdf_tfa.info');
        }

        $entries = [];
        $action = str_replace("preview_", "", $request->action);
        $p1c = 0;
        $p2c = 0;

        switch ($action) {
            case 'individual':
                $entries = $this->generateIndividualCertificate($request);
                break;
            case 'explicit':
                list($p1c, $p2c, $entries) = $this->generateTrainingCertificate($request);
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
        $pdf->loadView('export.pdf_tfa.pdf', [
            'entries' => $entries,
            'part' => [
                'c1' => $p1c,
                'c2' => $p2c,
            ],
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
                [storage_path("app/pdf/{$filename}.pdf") => [1]],
                [storage_path(Config::get('export.mergefile.path')) => Config::get('export.mergefile.pages')],
                [storage_path("app/pdf/{$filename}.pdf") => [2, Media::MERGE_END]],
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

    public function generateTrainingCertificate(Request $request)
    {
        $p1 = $this->_trainingCertificateData($request, function ($q) {
            $q->whereIn('name', [
                'Schwerpunktthema',
                'Zusammenfassung'
            ]);
        });

        $p2 = $this->_trainingCertificateData($request, function ($q) {
            $q->whereIn('name', [
                'Quartalsbericht'
            ]);
        });

        return [$p1->count(), $p2->count(), $p1->merge($p2)];
    }

    protected function _trainingCertificateData(Request $request, $closure)
    {
        return Auth::user()->entries()->with([
            'portfolio',
            'tags',
            'location'
        ])
            ->whereIn('entries.id', $request->entries)
            ->orderBy('date', 'ASC')
            ->whereHas('tags', $closure)
            ->get();
    }

}
