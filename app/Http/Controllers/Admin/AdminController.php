<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;   

class AdminController extends Controller
{
     public function index()
    {
        $users      = User::orderBy('created_at', 'desc')->get();
        $totalUsers = $users->count();
        $newUsers   = User::whereMonth('created_at', now()->month)
                          ->whereYear('created_at',  now()->year)
                          ->count();

        $usersJson = $users->map(function ($u) {
            return [
                'name'   => $u->name,
                'email'  => $u->email,
                'joined' => $u->created_at->format('d M Y'),
                'role'   => $u->role ?? 'user',
            ];
        });

        // Growth chart:6 bulan terakhir
        $growthLabels     = [];
        $monthlyGrowth    = [];
        $cumulativeGrowth = [];
        $cumulative       = 0;

        for ($i = 5; $i >= 0; $i--) {
            $date  = now()->subMonths($i);
            $count = User::whereYear('created_at',  $date->year)
                         ->whereMonth('created_at', $date->month)
                         ->count();

            $cumulative += $count;

            $growthLabels[]     = $date->format('M Y');
            $monthlyGrowth[]    = $count;
            $cumulativeGrowth[] = $cumulative;
        }

        return view('admin.dashboard', compact(
            'users',
            'totalUsers',
            'newUsers',
            'usersJson',
            'growthLabels',
            'monthlyGrowth',
            'cumulativeGrowth'
        ));
    }

}
