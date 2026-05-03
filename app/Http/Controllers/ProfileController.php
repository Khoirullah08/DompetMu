<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function index()
    {
        return view('profile.index');
    }

    public function edit()
    {
        return view('profile.edit');
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'name'   => ['required', 'string', 'max:255'],
            'alamat' => ['nullable', 'string', 'max:255'],
            'email'  => ['required', 'email', 'unique:users,email,' . Auth::id()],
            'phone'  => ['nullable', 'string', 'max:20'],
            'bio'    => ['nullable', 'string', 'max:500'],
        ]);

        Auth::user()->update($validated);

        return redirect()
            ->route('profile')
            ->with('success', 'Profil berhasil diperbarui!');
    }

    public function destroy()
    {
        $user = Auth::user();
        Auth::logout();
        $user->delete();

        return redirect()->route('login')->with('success', 'Akun berhasil dihapus.');
    }
}