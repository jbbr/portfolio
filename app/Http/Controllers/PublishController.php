<?php

namespace App\Http\Controllers;

use App\Entry;
use App\Portfolio;
use App\Publish;
use App\PublishedEntries;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class PublishController extends Controller
{
    /* Public Routes */
    public function index($urlkey)
    {
        if (!$publish = $this->_checkCreationDate($urlkey)) {
            return abort(404);
        }

        $publishedEntries = PublishedEntries::whereHas('publish', function ($q) use ($urlkey) {
            $q->where('url', $urlkey);
        })->get();

        $entryIds = $publishedEntries->map(function ($entry) {
            return $entry->entry_id;
        });

        $portfolios = (new Portfolio())
            ->with([
                'entries' => function ($qry) use ($entryIds) {
                    $qry->whereIn('id', $entryIds);
                }
            ])
            ->whereHas('entries', function ($qry) use ($entryIds) {
                $qry->whereIn('id', $entryIds);
            })->get();

        if ($portfolios->count() <= 0) {
            return abort(404);
        }

        return view('publish.index', [
            'publish' => $publish,
            'portfolios' => $portfolios,
            'urlkey' => $urlkey
        ]);
    }

    public function entryList($urlkey, $portfolioId)
    {
        if (!$publish = $this->_checkCreationDate($urlkey)) {
            return abort(404);
        }

        $publishedEntries = PublishedEntries::whereHas('publish', function ($q) use ($urlkey) {
            $q->where('url', $urlkey);
        })->get();

        $entryIds = $publishedEntries->map(function ($entry) {
            return $entry->entry_id;
        });

        $entries = (new Entry())
            ->with([
                'portfolio' => function ($qry) use ($portfolioId) {
                    $qry->where('id', $portfolioId);
                }
            ])
            ->whereHas('portfolio', function ($qry) use ($portfolioId) {
                $qry->where('id', $portfolioId);
            })->whereIn('id', $entryIds)->paginate(9);

        return view('publish.entries.index', [
            'publish' => $publish,
            'urlkey' => $urlkey,
            'portfolioId' => $portfolioId,
            'entries' => $entries
        ]);

    }

    public function entry($urlkey, $portfolioId, $entryId)
    {
        if (!$publish = $this->_checkCreationDate($urlkey)) {
            return abort(404);
        }

        $entryPublish = PublishedEntries::whereHas('publish', function ($q) use ($urlkey) {
            $q->where('url', $urlkey);
        })->where('entry_id', $entryId)->get();

        // This Entry is not Published for this URL!
        if ($entryPublish->count() <= 0) {
            return abort(404);
        }


        $entry = (new Entry())
            ->with([
                'portfolio' => function ($qry) use ($portfolioId) {
                    $qry->where('id', $portfolioId);
                }
            ])
            ->whereHas('portfolio', function ($qry) use ($portfolioId) {
                $qry->where('id', $portfolioId);
            })->where('id', $entryId)->firstOrFail();

        return view('publish.entries.show', [
            'publish' => $publish,
            'urlkey' => $urlkey,
            'portfolioId' => $portfolioId,
            'entryId' => $entryId,
            'entry' => $entry
        ]);
    }

    private function _checkCreationDate($urlkey)
    {
        $publish = Publish::where('url', $urlkey)->firstOrFail();

        if ($publish->created_at->addDays(30) < Carbon::now()) {
            return false;
        }
        return $publish;
    }

    /* Backend Routes (Auth) */

    public function tree()
    {
        $portfolios = Auth::user()->portfolios()->with(['entries', 'entries.location'])->orderBy('sort', 'ASC')->get();
        $publishes = Auth::user()->publishes()->orderBy('created_at', 'DESC')->get();

        return view('publish.profile.tree', [
            'portfolios' => $portfolios,
            'publishes' => $publishes
        ]);
    }

    public function store(Request $request)
    {
        $request->validate(['title' => 'required']);

        $selectedEntries = $request->get('entries');
        if (!$selectedEntries) {
            $request->session()->flash('failed', 'Bitte wähle mindestens einen Eintrag aus.');
            return redirect()->route('publish.profile.tree');
        }
        while (true) {
            $randomUrl = Str::random(24);
            if (!Publish::where('url', $randomUrl)->count()) {
                break;
            }
        }

        $publish = (new Publish())->create([
            'user_id' => Auth::id(),
            'url' => $randomUrl,
            'title' => $request->get('title'),
            'subtitle' => $request->get('subtitle')
        ]);

        foreach ($selectedEntries as $_entryId => $_) {
            PublishedEntries::create([
                'publish_id' => $publish->id,
                'entry_id' => $_entryId
            ]);
        }

        return redirect()->route('publish.profile.tree');
    }

    public function destroy(Publish $publish)
    {
        // Load the publish by user to check if the current user has the permissions to delete it!
        $publish = Auth::user()->publishes()->where('id', $publish->id)->firstOrFail();

        PublishedEntries::where('publish_id', $publish->id)->delete();
        $publish->delete();

        return redirect()->route('publish.profile.tree');
    }
}
