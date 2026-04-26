<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    // GET /profile
    public function index()
    {
         $summary = [
            'title' => 'Profil Mu',
            'subtitle' => 'Kelola profil mu.',

        ];

        $user = Auth::user();
        return view('profil', compact('user','summary'));
    }

    // GET /profile/edit
    public function edit()
    {
        $user = Auth::user();
        return view('profile.edit', compact('user'));
    }

    // PUT /profile/update
    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'bio'   => 'nullable|string|max:500',
        ]);

        $user->update($request->only('name', 'email', 'phone', 'bio'));

        return redirect()->route('profile')->with('success', 'Profil berhasil diperbarui!');
    }

    public function security()   { return view('profile.security'); }
    public function teams()      { return view('profile.teams'); }
    public function teamMember() { return view('profile.team-member'); }
    public function notifications() { return view('profile.notifications'); }
    public function billing()    { return view('profile.billing'); }
    public function dataExport() { return view('profile.data-export'); }
    public function deleteConfirm() { return view('profile.delete'); }



    // DELETE /profile
    public function destroy()
    {
        $user = Auth::user();
        Auth::logout();
        $user->delete();

        return redirect('/')->with('success', 'Akun berhasil dihapus.');
    }
}