<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePortfolioRequest;
use App\MediaInfo;
use App\Portfolio;
use App\Share;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PortfolioController extends Controller
{
    public function index()
    {
        $portfolios = Auth::user()->portfolios()->with('entries')->orderBy('sort', 'ASC')->get();

        return view('portfolios.index', [
            'portfolios' => $portfolios,
        ]);
    }

    public function arrange()
    {
        $portfolios = Auth::user()->portfolios()->orderBy('sort', 'ASC')->get();
        $share = Auth::user()->shares()->orderBy('created_at', 'DESC')->first();

        return view('portfolios.arrange', [
            'portfolios' => $portfolios,
            'share' => $share
        ]);
    }

    public function create()
    {
        return view('portfolios.create', [
            'tags' => Auth::user()->tags()->orderBy('name')->get(),
            'mediaInfos' => Auth::user()->mediaInfos,
        ]);
    }

    public function store(CreatePortfolioRequest $request)
    {
        $data = $request->only('title', 'subtitle', 'description', 'sort');

        $portfolio = Auth::user()->portfolios()->create($data);
        $portfolio->retag($request->tags);
        $portfolio->relink($request->media);

        $request->session()->flash('status', 'Der Aufgabenbereich wurde erfolgreich erstellt.');

        return redirect()->route('portfolios.arrange');
    }

    public function multiedit(Request $request)
    {
        $action = $request->action;
        switch ($action) {
            case 'edit':
                return $this->edit($request);
                break;
            case 'delete':
                return $this->delete($request);
                break;
            case 'share':
                return $this->share($request);
                break;
        }
        return redirect()->route('portfolios.arrange');
    }

    protected function edit(Request $request)
    {
        $portfolioIds = $request->portfolios;
        $this->validate($request, [
            'portfolios' => 'required|array|exists:portfolios,id',
        ]);

        $portfolios = Portfolio::whereIn('id', $portfolioIds)->orderBy('sort', 'ASC')->get();
        foreach ($portfolios as $portfolio) {
            $this->authorize('view', $portfolio);
        }

        return view('portfolios.multiedit', [
            'portfolios' => $portfolios,
            'tags' => Auth::user()->tags()->orderBy('name')->get(),
            'mediaInfos' => Auth::user()->mediaInfos,
        ]);
    }

    protected function delete(Request $request)
    {
        $portfolioIds = $request->portfolios;
        $this->validate($request, [
            'portfolios' => 'required|array|exists:portfolios,id',
        ]);

        $portfolios = Portfolio::whereIn('id', $portfolioIds)->orderBy('sort', 'ASC')->get();
        foreach ($portfolios as $portfolio) {
            $this->authorize('delete', $portfolio);

            if($portfolio->entries()->count() > 0) {
                $errormsg = 'Aufgabenbereich ' . $portfolio->title . ' kann nicht gelöscht werden, da er Einträge enthält. Bitte kopiere die Einträge zuvor in einen anderen Aufgabenbereich.';
                return redirect()->route('portfolios.arrange')->withErrors(['portfolios' => $errormsg]);
            }

            $portfolio->delete();
        }

        $request->session()->flash('status', 'Der ausgewählte Aufgabenbereich wurden erfolgreich gelöscht.');

        return redirect()->route('portfolios.arrange');
    }

    protected function share(Request $request)
    {
        $portfolioIds = $request->portfolios;
        $this->validate($request, [
            'portfolios' => 'required|array|exists:portfolios,id',
        ]);

        $portfolios = Portfolio::whereIn('id', $portfolioIds)->orderBy('sort', 'ASC')->get();
        foreach ($portfolios as $portfolio) {
            $this->authorize('view', $portfolio);
        }

        $share = Auth::user()->shares()->create(['code' => str_random(6)]);
        foreach ($portfolioIds as $id) {
            $share->addPortfolio($id);
        }

        return redirect()->route('portfolios.arrange');
    }

    public function multiupdate(Request $request)
    {
        foreach ($request->portfolios as $id => $data) {
            $this->update($id, collect($data));
        }

        $request->session()->flash('status', 'Die Aufgabenbereiche wurden erfolgreich gespeichert.');

        return redirect()->route('portfolios.arrange');
    }

    protected function update($id, $collection)
    {
        $portfolio = Portfolio::findOrFail($id);
        $this->authorize('update', $portfolio);

        $data = $collection->only(['title', 'subtitle', 'description', 'sort'])->all();

        $portfolio->update($data);
        $portfolio->retag($collection->get('tags'));
        $portfolio->relink($collection->get('media'));
    }

    public function confirmImport($code)
    {
        $share = Share::where('code', $code)->first();
        if (!$share) {
            return response()->json([
                'modal' => [
                    'header' => 'Nummer ungültig',
                    'content' => 'Leider konnten wir die eingegebene Nummer nicht finden.<br>Bitte überprüfe ob deine Eingabe korrekt ist.',
                    'actions' => '<button type="button" class="ui secondary button modal-abort-btn"><i class="close icon"></i> Schließen</button>'
                ],
            ]);
        }

        $portfolios = $share->portfolios()->orderBy('sort', 'ASC')->get();
        $portfolioCount = count($portfolios);

        return response()->json([
            'modal' => [
                'header' => $portfolioCount . ' ' . trans_choice('portfolios.portfolios', $portfolioCount) . ' importieren',
                'content' => view('portfolios.confirmimport', ['portfolios' => $portfolios, 'code' => $code])->render(),
                'actions' => view('portfolios.actions.import')->render()
            ],
        ]);
    }

    public function import(Request $request)
    {
        $this->validate($request, [
            'code' => 'required|exists:shares,code',
        ]);

        $share = Share::where('code', $request->code)->firstOrFail();
        foreach ($share->portfolios as $portfolio) {
            $newp = $portfolio->replicate();
            $newp->user_id = Auth::id();
            $newp->save();

            $tags = $portfolio->tags()->pluck('name')->toArray();
            $newp->retag($tags);

            $mediaInfoIds = [];
            foreach ($portfolio->mediaInfos as $mediaInfo) {
                $currentMI = MediaInfo::where('media_id', $mediaInfo->media_id)->where('user_id', Auth::id())->first();
                if (!$currentMI) {
                    $newmi = $mediaInfo->replicate();
                    $newmi->user_id = Auth::id();
                    $newmi->save();
                    $mediaInfoIds[] = $newmi->id;
                } else {
                    $mediaInfoIds[] = $currentMI->id;
                }
            }
            $newp->relink($mediaInfoIds);
        }

        $request->session()->flash('status', 'Die Aufgabenbereiche wurde erfolgreich importiert.');

        return redirect()->route('portfolios.arrange');
    }

    public function help(Portfolio $portfolio)
    {
        $this->authorize('view', $portfolio);

        return response()->json([
            'modal' => [
                'header' => $portfolio->title . ' ' . $portfolio->subtitle,
                'content' => $portfolio->description,
                'actions' => view('portfolios.actions.close')->render(),
            ],
        ]);
    }
}
