<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{

    public function index()
    {

        $menu = "Dashboard";
        // $user = User::where('role', '!=', 1)->count();
        return view('admin.dashboard', compact('menu'));
    }
}
