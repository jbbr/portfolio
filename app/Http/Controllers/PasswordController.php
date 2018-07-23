<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class PasswordController extends Controller
{
    public function edit()
    {
        return view('password.edit');
    }

    public function update(Request $request)
    {
        $this->validate($request, [
            'current_password' => 'required',
            'password' => 'required|confirmed',
        ]);

        if (!Hash::check($request->current_password, Auth::user()->password)) {
            return redirect()->back()->withErrors(['message' => 'Das eingegebene Passwort ist nicht korrekt.']);
        }

        Auth::user()->update(['password' => Hash::make($request->password)]);

        $request->session()->flash('status', 'Das Passwort wurde erfolgreich gespeichert.');

        return redirect()->route('profile.edit');
    }
}
