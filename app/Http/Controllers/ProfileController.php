<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function index()
    {
        return view('profile.index', ['user' => Auth::user()]);
    }

    public function edit()
    {
        return view('profile.edit', ['user' => Auth::user()]);
    }

    public function update(Request $request)
    {
        $data = $request->only(['name', 'profession', 'location_of_birth', 'street', 'city', 'phone', 'education']);
        $data['date_of_birth'] = $request->date_of_birth ? Carbon::createFromFormat('d.m.Y', $request->date_of_birth) : null;
        $data['training_date_from'] = $request->training_date_from ? Carbon::createFromFormat('d.m.Y', $request->training_date_from) : null;
        $data['training_date_to'] = $request->training_date_to ? Carbon::createFromFormat('d.m.Y', $request->training_date_to) : null;

        if ($request->hasFile('picture')) {
            $file = $request->file('picture');
            if (in_array($file->getMimeType(), ['image/png', 'image/jpeg', 'image/gif'])) {
                $name = md5_file($file->getPathname());
                $filename = $name . "." . $file->guessExtension();
                $store = $file->storeAs('profile/' . Auth::id(), $filename, ['disk' => 'public']);

                $data['picture'] = $store;
            }
        } else {
            if (!is_null($request->picture_delete)) {
                $pic = Auth::user()->picture;
                if ($pic && !empty($pic)) {
                    if (Storage::disk('public')->delete($pic)) {
                        $data['picture'] = "";
                    }
                }
            }
        }


        Auth::user()->update($data);

        $request->session()->flash('status', 'Das Profil wurde erfolgreich gespeichert.');

        return redirect()->route('profile.index');
    }
}
