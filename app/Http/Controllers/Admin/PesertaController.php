<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class PesertaController extends Controller
{
    public function siswa()
    {
        return view('admin.peserta.siswa');
    }

    public function guru()
    {
        return view('admin.peserta.guru');
    }

    public function dpk()
    {
        return view('admin.peserta.dpk');
    }
}
