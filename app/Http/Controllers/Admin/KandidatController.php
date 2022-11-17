<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KandidatMpk;
use Illuminate\Http\Request;
use App\Models\KandidatOsis;

class KandidatController extends Controller
{
    public function osis()
    {
        $osis = KandidatOsis::all();

        return view('admin.kandidat.osis', compact('osis'));
    }

    public function detailOsis(Request $request, $id)
    {
        $osis = KandidatOsis::findOrFail($id);
        
        return view('admin.kandidat.osis_detail', compact('osis'));
    }

    public function mpk()
    {
        $ketua = KandidatMpk::where('type', 'ketua')->orderBy('kandidat_no', 'ASC')->get();
        $wakil = KandidatMpk::where('type', 'wakil')->orderBy('kandidat_no', 'ASC')->get();

        return view('admin.kandidat.mpk', compact('ketua','wakil'));
    }

    public function detailMpk(Request $request, $id)
    {
        $mpk = KandidatMpk::where('kandidat_mpk.id', $id)->join(
            'users', 'users.id', '=', 'kandidat_mpk.user_id'
        )->join(
            'kelas', 'kelas.id', '=', 'users.kelas_id'
        )->selectRaw(
            'kandidat_no,type,gambar,visi,misi,users.name,kelas.name as kelas'
        )->firstOrFail();

        return view('admin.kandidat.mpk_detail', compact('mpk'));
    }
}
