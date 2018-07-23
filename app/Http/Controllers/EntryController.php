<?php

namespace App\Http\Controllers;

use App\Entry;
use App\Media;
use App\Portfolio;
use App\Http\Requests\CreateEntryRequest;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;

class EntryController extends Controller
{
    public function index(Portfolio $portfolio)
    {
        $this->authorize('view', $portfolio);

        $filter = request('location');

        $entries = $portfolio->entries()->orderBy('created_at', 'DESC');
        if(!empty($filter) && $filter != "Alle") {
            $locationIds = $portfolio->locations()->whereIn('name', $filter)->pluck('id')->toArray();
            $entries->whereIn('location_id', $locationIds);
        }

        $customPagination = $this->_buildCustomPagination($entries, 9);

        return view('entries.index', [
            'portfolio' => $portfolio,
            'entries' => $customPagination->data->get(),
            'locations' => $this->entryLocations($portfolio->entries()->orderBy('created_at', 'DESC')->get()),
            'customPagination' => $customPagination
        ]);
    }

    public function create(Portfolio $portfolio)
    {
        $portfolios = Auth::user()->portfolios()->orderBy('sort', 'ASC')->get();
        $this->authorize('view', $portfolio);

        return view('entries.create', [
            'portfolio' => $portfolio,
            'portfolios' => $portfolios,
            'tags' => Auth::user()->tags()->orderBy('name')->get(),
            'mediaInfos' => Auth::user()->mediaInfos,
            'locations' => Auth::user()->locations,
        ]);
    }

    public function store(CreateEntryRequest $request)
    {
        $portfolio = Portfolio::findOrFail($request->portfolio_id);
        $this->authorize('view', $portfolio);

        $data = $request->only(['title', 'description', 'location_id', 'wordcount']);
        $data['date'] = Carbon::createFromFormat('d.m.Y', $request->date);
        $data['date_to'] = $request->date_to ? Carbon::createFromFormat('d.m.Y', $request->date_to) : null;
        $data['duration'] = $this->calcDuration($request->duration);

        $media = $this->_processMedia($request);

        $entry = $portfolio->entries()->create($data);
        $entry->retag($request->tags);
        $entry->relink($media);

        $request->session()->flash('status', 'Der Eintrag wurde erfolgreich erstellt.');

        return redirect()->route('portfolios.entries.show', [$portfolio->id, $entry->id]);
    }

    public function show(Portfolio $portfolio, Entry $entry)
    {
        $this->authorize('view', $portfolio);

        return view('entries.show', [
            'portfolio' => $portfolio,
            'entry' => $entry,
        ]);
    }

    public function edit(Portfolio $portfolio, Entry $entry)
    {
        $this->authorize('view', $portfolio);
        $portfolios = Auth::user()->portfolios()->orderBy('sort', 'ASC')->get();

        return view('entries.edit', [
            'portfolio' => $portfolio,
            'portfolios' => $portfolios,
            'entry' => $entry,
            'tags' => Auth::user()->tags()->orderBy('name')->get(),
            'mediaInfos' => Auth::user()->mediaInfos,
            'locations' => Auth::user()->locations,
        ]);
    }

    public function update(CreateEntryRequest $request, Portfolio $portfolio, Entry $entry)
    {
        $this->authorize('update', $portfolio);

        $data = $request->only(['title', 'description', 'location_id', 'portfolio_id', 'wordcount']);
        $data['date'] = Carbon::createFromFormat('d.m.Y', $request->date);
        $data['date_to'] = $request->date_to ? Carbon::createFromFormat('d.m.Y', $request->date_to) : null;
        $data['duration'] = $this->calcDuration($request->duration);

        $media = $this->_processMedia($request);

        if ($request->portfolio_id != $entry->portfolio_id) {
            $entry = Auth::user()->entries()->create($data);
            $request->session()->flash('status', 'Der Eintrag wurde erfolgreich kopiert.');
        } else {
            $entry->update($data);
            $request->session()->flash('status', 'Der Eintrag wurde erfolgreich gespeichert.');
        }

        $entry->retag($request->tags);
        $entry->relink($media);

        return redirect()->route('portfolios.entries.show', [$entry->portfolio_id, $entry->id]);
    }

    protected function _processMedia(Request $request) {
        $media = $request->media;

        $processedFiles = $request->processedMediaFiles;
        if($processedFiles) {
            $split = explode(',', $processedFiles);
            $media = explode(',', $media);

            $media = array_merge($split, $media);
            $media = array_filter($media);
            $media = array_unique($media);
        }

        return $media;
    }

    public function upload(Request $request)
    {
        $media = null;
        if ($request->hasFile('file')) {
            $files = $request->file('file');
            foreach ($files as $_file) {
                if (!in_array($_file->getMimeType(), array_keys(Config::get('media.allowedMimeTypes')))) {
                    continue;
                }

                $name = md5_file($_file->getPathname());
                $filename = $name . "." . $this->getFileExtension($_file);
                $store = $_file->storeAs('media', $filename, ['disk' => 'public']);

                $mediaObj = Media::firstOrCreate([
                    'path' => $store,
                    'filename' => $_file->getClientOriginalName(),
                    'mime_type' => $_file->getMimeType(),
                    'size' => $_file->getClientSize()
                ])->mediaInfos()->firstOrCreate(['user_id' => Auth::id()]);

                Media::processFile($filename);

                $media = (!is_null($media) ? $media . "," : "") . $mediaObj->id;
            }
        }
        return response()->json(['ids' => $media]);
    }

    public function destroy(Request $request, Portfolio $portfolio, Entry $entry)
    {
        $this->authorize('delete', $portfolio);

        $entry->delete();

        $request->session()->flash('status', 'Der Eintrag wurde erfolgreich gelöscht.');

        return redirect()->route('portfolios.entries.index', $portfolio->id);
    }

    private function getFileExtension($file)
    {
        $exts = [
            'audio/mpeg' => 'mp3',
            'audio/ogg' => 'mp3',
            'video/mp4' => 'mp4',
        ];

        $mimeType = $file->getMimeType();

        if(array_key_exists($mimeType, $exts)) {
            return $exts[$mimeType];
        }

        return $file->guessExtension();
    }

    /**
     * Generates seconds from a string like "10:50"
     *
     * @param $duration
     * @return null
     */
    protected function calcDuration($duration)
    {
        if (strpos($duration, ':') !== false) {
            list($hours, $minutes) = explode(':', $duration);
            $duration = ($hours * 60 * 60) + ($minutes * 60);
        }
        return $duration ?: null;
    }

    protected function entryLocations($entries)
    {
        $locations = [];
        foreach ($entries as $entry) {
            if (!$entry->location) {
                continue;
            }
            $loc = $entry->location->name;
            if (!array_key_exists($loc, $locations)) {
                $locations[$loc] = 0;
            }
            $locations[$loc]++;
        }
        ksort($locations);

        return ['Alle' => ''] + $locations;
    }

    protected function _buildCustomPagination($entries, $perPage = 3)
    {
        $count = $entries->count();
        $currentPage = request('page', 1);

        $pages = 1;
        if ($count > ($perPage - 1)) {
            $pages = ceil(($count - ($perPage - 1)) / $perPage) + 1;
        }

        if ($currentPage == 1) {
            $perPage = $perPage - 1;
            $skip = 0;
        } else {
            $skip = ($currentPage - 1) * $perPage - 1;
        }

        if ($currentPage > $pages) {
            $currentPage = 1;
            $skip = 0;
        }

        $queryString = http_build_query(request()->except('page'));
        if(!empty($queryString)) {
            $queryString = "&" . $queryString;
        }

        return (object)[
            'total' => $count,
            'per_page' => $perPage,
            'current_page' => $currentPage,
            'last_page' => $pages,
            'prev_page_url' => (($currentPage > 1) ? request()->url() . "?page=" . (request('page', 1) - 1) . ($queryString ? $queryString : "") : ""),
            'next_page_url' => (($currentPage + 1 <= $pages) ? request()->url() . "?page=" . (request('page', 1) + 1) . ($queryString ? $queryString : "") : ""),
            'url' => request()->url(),
            'query_string' => ($queryString ? $queryString : ""),
            'data' => $entries->skip($skip)->take($perPage)
        ];
    }
}
