<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AspirasiController extends Controller
{
    public function osisGuru(Request $request)
    {
    	return view('admin.aspirasi.osis_guru');
    }

    public function osisSiswa(Request $request)
    {
    	return view('admin.aspirasi.osis_siswa');
    }

    public function mpk(Request $request)
    {
    	return view('admin.aspirasi.mpk');
    }
}
