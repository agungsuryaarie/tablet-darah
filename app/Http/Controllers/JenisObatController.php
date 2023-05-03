<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class JenisObatController extends Controller
{
    public function index()
    {
        $menu = 'Jenis Obat';
        return view('jenis-obat.data', compact('menu'));
    }

    // public function create()
    // {
    //     $menu = 'Tambah User';

    //     return view('user.create', compact('menu'));
    // }

    // public function edit()
    // {
    //     $menu = 'Edit User';
    //     return view('user.edit', compact('menu',));
    // }
}
