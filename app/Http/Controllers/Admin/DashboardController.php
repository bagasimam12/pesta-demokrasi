<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\KandidatMpk;
use App\Models\KandidatOsis;
use App\Models\VotingOsis;
use App\Models\VotingMpk;
use App\Models\AnggotaDpk;

class DashboardController extends Controller
{
    public function dashboard()
    {
    	$siswa = User::where(['level' => 'user', 'user_type' => 'siswa'])->count();
    	$guru  = User::where(['level' => 'user', 'user_type' => 'guru'])->count();
    	$dpk   = AnggotaDpk::count();

    	$dids = [];
    	foreach (AnggotaDpk::all() as $k) {
    		$dids []= $k->user_id;
    	}

    	$vote_siswa = VotingOsis::where(
    		['users.level' => 'user', 'users.user_type' => 'siswa']
    	)->join(
    		'users', 'users.id', '=', 'voting_osis.user_id'
    	)->get()->count();

    	$vote_guru  = VotingOsis::where(
    		['users.level' => 'user', 'users.user_type' => 'guru']
    	)->join(
    		'users', 'users.id', '=', 'voting_osis.user_id'
    	)->get()->count();

    	$vote_dpk   = VotingMpk::count() / 2;
    	$golput     = User::where(['level' => 'user'])->count() - ($vote_siswa + $vote_guru + $vote_dpk);

        return view('admin.dashboard', compact('siswa','guru', 'dpk', 'vote_siswa', 'vote_guru', 'vote_dpk', 'golput'));
    }

    public function pengaturan()
    {
        return view('admin.pengaturan');
    }
}
