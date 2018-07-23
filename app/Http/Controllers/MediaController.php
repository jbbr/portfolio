<?php

namespace App\Http\Controllers;

use App\Media;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

class MediaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('media.index', ['media' => $this->mediaPagination()]);
    }

    /**
     * Display a listing of the resource for TinyMCE Dialog.
     *
     * @return \Illuminate\Http\Response
     */
    public function dialog()
    {
        return view('media.dialog.list', ['media' => Auth::user()->media()->with(['mediaInfos'])->orderBy('media_info.created_at', 'DESC')->get()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!$request->hasFile('file')) {
            return;
        }

        $files = $request->file('file');
        foreach ($files as $_file) {
            if (!in_array($_file->getMimeType(), array_keys(Config::get('media.allowedMimeTypes')))) {
                continue;
            }

            $name = md5_file($_file->getPathname());
            $filename = $name . "." . $this->getFileExtension($_file);
            $store = $_file->storeAs('media', $filename, ['disk' => 'public']);

            Media::firstOrCreate([
                'path' => $store,
                'filename' => $_file->getClientOriginalName(),
                'mime_type' => $_file->getMimeType(),
                'size' => $_file->getClientSize()
            ])->mediaInfos()->firstOrCreate(['user_id' => Auth::id()]);

            Media::processFile($filename);
        }

        return response()->json(['view' => view('media.partials.list', ['media' => $this->mediaPagination()])->render()]);
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
     * Display the specified resource.
     *
     * @param  \App\Media $media
     * @return \Illuminate\Http\Response
     */
    public function show(Media $medium)
    {
        return response()->json([
            'modal' => [
                'header' => $medium->filename,
                'content' => view('media.preview', ['mediaInfo' => $this->getMediaInfoByMediaId($medium->id), 'medium' => $medium])->render(),
                'actions' => view('media.actions.preview')->render()
            ]
        ]);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Media $media
     * @return \Illuminate\Http\Response$
     */
    public function edit(Media $medium)
    {
        return response()->json([
            'modal' => [
                'header' => $medium->filename,
                'content' => view('media.edit',
                    ['mediaInfo' => $this->getMediaInfoByMediaId($medium->id), 'medium' => $medium, 'tags' => Auth::user()->tags()->orderBy('name')->get()])->render(),
                'actions' => view('media.actions.edit')->render()
            ]
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Media $media
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Media $medium)
    {
        $data = $request->only(['description', 'author', 'place_of_creation', 'copyright', 'license']);

        $mediaInfo = $this->getMediaInfoByMediaId($medium->id);
        $mediaInfo->update($data);
        $mediaInfo->retag($request->tags);

        $item = view('media.partials.item', [
            '_medium' => $medium,
            'mediaInfo' => $this->getMediaInfoByMediaId($medium->id),
        ])->render();

        return response()->json(['view' => $item]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Media $media
     * @return \Illuminate\Http\Response
     */
    public function destroy(Media $medium)
    {
        $mediaInfos = Auth::user()->mediaInfos()->where('media_id', $medium->id)->get();
        foreach ($mediaInfos as $mediaInfo) {
            $mediaInfo->delete();
        }

        return redirect()->route('media.index');
    }

    /**
     * @param Media $medium
     * @return bool|\Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function download(Media $medium)
    {
        $mediaCount = Auth::user()->mediaInfos()->where('media_id', $medium->id)->count();
        if ($mediaCount == 0) {
            return false;
        }

        try {
            return response()->download(
                storage_path('app/public/') . $medium->path,
                $medium->filename,
                [
                    'Pragma' => 'public',
                    'Expires' => '0',
                    'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
                    'Content-Type' => $medium->mime_type,
                    'Content-Disposition' => 'attachment; filename="' . $medium->filename . '";',
                    'Content-Transfer-Encoding' => 'binary',
                    'Content-Length' => $medium->size,
                ]
            );
        } catch (\Exception $e) {
            // File don't exists
            return false;
        }
    }

    /**
     * @param int $items
     * @return mixed
     */
    private function mediaPagination($items = 10)
    {
        return Auth::user()->media()->with(['mediaInfos'])->orderBy('media_info.created_at', 'DESC')->paginate($items);
    }

    /**
     * @param $mediaId
     * @return mixed
     */
    private function getMediaInfoByMediaId($mediaId)
    {
        return Auth::user()->mediaInfos()->where('media_id', $mediaId)->first();
    }
}
