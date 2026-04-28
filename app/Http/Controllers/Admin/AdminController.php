<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;   

class AdminController extends Controller
{
    public function index()
    {   
        $totalUsers = User::count();
        $newUsers = User::where('created_at', now()->month)->whereYear('created_at', now()->year)->count();
        $users = User::select('id', 'name', 'email', 'role', 'created_at')->latest()->get();

        return view('admin.dashboard', compact('totalUsers', 'newUsers', 'users'));
        }

}
