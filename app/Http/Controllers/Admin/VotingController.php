<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\VotingMpk;
use App\Models\VotingOsis;

class VotingController extends Controller
{
    public function osis()
    {
        $data = VotingOsis::getVotingData();

        return view('admin.voting.osis', compact('data'));
    }

    public function mpk()
    {
        $ketua = VotingMpk::getVotingData('ketua');
        $wakil = VotingMpk::getVotingData('wakil');

        return view('admin.voting.mpk', compact('ketua', 'wakil'));
    }
}
