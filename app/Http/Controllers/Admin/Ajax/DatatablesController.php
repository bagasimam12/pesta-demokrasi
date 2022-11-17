<?php

namespace App\Http\Controllers\Admin\Ajax;

use App\Http\Controllers\Controller;
use App\Models\VotingMpk;
use App\Models\VotingOsis;
use App\Models\Aspirasi;
use Illuminate\Http\Request;

class DatatablesController extends Controller
{
    public function __construct(Request $request)
    {
        if (!$request->ajax()) {
            abort(403, 'Only accept AJAX requests');
        }
    }

    public function pesertaSiswa()
    {
        $peserta = \App\Models\User::where(
            ['level' => 'user', 'user_type' => 'siswa']
        )->join(
            'kelas', 'users.kelas_id', '=', 'kelas.id' 
        )->selectRaw(
            'users.id, users.uuid, users.name, kelas.name as kelas'
        )->groupBy(['id', 'uuid', 'name', 'kelas'])->get();

        return datatables()->of(
            $peserta
        )->addColumn('voting_osis', function($data){
            if (VotingOsis::where(['user_id' => $data->id])->first()) {
                return '<span class="badge badge-pill badge-success">Yes</span>';
            }
            return '<span class="badge badge-pill badge-danger">No</span>';
        })->rawColumns(['voting_osis'])->make(true);
    }

    public function pesertaGuru()
    {
        $peserta = \App\Models\User::where(
            ['level' => 'user', 'user_type' => 'guru']
        )->selectRaw(
            'users.id, users.uuid, users.name'
        )->groupBy(['id', 'uuid', 'name'])->get();

        return datatables()->of(
            $peserta
        )->addColumn('voting_osis', function($data){
            if (VotingOsis::where(['user_id' => $data->id])->first()) {
                return '<span class="badge badge-pill badge-success">Yes</span>';
            }
            return '<span class="badge badge-pill badge-danger">No</span>';
        })->rawColumns(['voting_osis'])->make(true);
    }

    public function pesertaDpk()
    {
        $peserta = \App\Models\User::where(
            ['level' => 'user', 'user_type' => 'siswa']
        )->join(
            'kelas', 'users.kelas_id', '=', 'kelas.id' 
        )->join(
            'anggota_dpk', 'anggota_dpk.user_id', '=', 'users.id'
        )->selectRaw(
            'users.id, users.uuid, users.name, kelas.name as kelas'
        )->groupBy(['id', 'uuid', 'name', 'kelas'])->get();

        return datatables()->of(
            $peserta
        )->addColumn('voting_mpk', function($data){
            if (VotingMpk::where(['user_id' => $data->id])->get()->count() === 2) {
                return '<span class="badge badge-pill badge-success">Yes</span>';
            }
            return '<span class="badge badge-pill badge-danger">No</span>';
        })->rawColumns(['voting_mpk'])->make(true);
    }

    public function aspirasiOsis(Request $request, $type)
    {

        $data = Aspirasi::where([
            'users.level'     => 'user', 
            'users.user_type' => $type === 'guru' ? 'guru' : 'siswa',
            'aspirasi.voting' => 'osis'
        ])->join(
            'users', 'users.id', '=', 'aspirasi.user_id'
        )->leftJoin(
            'kelas', 'users.kelas_id', '=', 'kelas.id'
        )->selectRaw(
            'users.name, aspirasi.aspirasi, kelas.name as kelas'
        )->get();

        return datatables()->of($data)->make(true);
    }

    public function aspirasiMpk(Request $request)
    {

        $data = Aspirasi::where([
            'users.level'     => 'user', 
            'users.user_type' => 'siswa',
            'aspirasi.voting' => 'mpk'
        ])->join(
            'users', 'users.id', '=', 'aspirasi.user_id'
        )->join(
            'kelas', 'users.kelas_id', '=', 'kelas.id'
        )->selectRaw(
            'users.name, aspirasi.aspirasi, kelas.name as kelas'
        )->get();

        return datatables()->of($data)->make(true);
    }
}
