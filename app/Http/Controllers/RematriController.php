<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class RematriController extends Controller
{
    public function index()
    {
        $menu = 'Data Rematri';
        return view('rematri.data', compact('menu'));
    }

    public function create()
    {
        $menu = 'Tambah Data Rematri';

        return view('Rematri.create', compact('menu'));
    }

    public function edit()
    {
        $menu = 'Edit Data Rematri';
        return view('rematri.edit', compact('menu',));
    }
}
