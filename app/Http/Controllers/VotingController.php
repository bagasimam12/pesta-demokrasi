<?php

namespace App\Http\Controllers;

use App\Models\Aspirasi;
use App\Models\KandidatMpk;
use Illuminate\Http\Request;
use App\Models\KandidatOsis;
use App\Models\VotingMpk;
use App\Models\VotingOsis;
use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use ConfigVoting;

class VotingController extends Controller
{
    public function __construct()
    {
        $this->middleware(function(Request $request, Closure $next){
            if ($request->user()->level === 'admin') {
                abort(403, 'Only user can access this page');
            }

            return $next($request);
        });
    }

    public function index()
    {   
        $voting = ConfigVoting::getConfig()->voting;

        if ($voting === 'osis') {

            if (VotingOsis::where(['user_id' => auth()->user()->id])->first()) {
                session()->flash('voting', 'Voting berhasil dilakukan, selanjutnya silahkan berikan aspirasi anda.');

                return redirect()->route('aspirasi');
            }

            if (session()->has('agreement')) {
                return view('profile');
            }

            // if (session()->has('welcome') || session()->has('next')) {
            //     return view('welcome_osis');
            // }

            $kandidat = KandidatOsis::join(
                'users as u1', 'u1.id', '=', 'kandidat_osis.ketua'
            )->join(
                'users as u2', 'u2.id', '=', 'kandidat_osis.wakil'
            )->selectRaw(
                'u1.name as ketua, u2.name as wakil, kandidat_osis.id, gambar, paslon_no, visi, misi'
            )->orderBy('paslon_no', 'ASC')->get();

            return view('voting_osis', compact('kandidat'));
        }

        if (VotingMpk::checkStatusVote('ketua') && VotingMpk::checkStatusVote('wakil')) {
            session()->flash('voting', 'Voting berhasil dilakukan, selanjutnya silahkan berikan aspirasi anda.');

            return redirect()->route('aspirasi');
        }

        if (session()->has('agreement')) {
            return view('agreement');
        }

        if (session()->has('welcome') || session()->has('next')) {
            return view('welcome_mpk');
        }

        if (VotingMpk::checkStatusVote('ketua')) {
            $calon = 'wakil';
        } else {
            $calon = 'ketua';
        }

        $kandidat = KandidatMpk::where(
            'kandidat_mpk.type', $calon
        )->join(
            'users', 'users.id', '=', 'kandidat_mpk.user_id'
        )->selectRaw(
            'users.name, kandidat_mpk.id, gambar, kandidat_no, visi, misi'
        )->orderBy('kandidat_no', 'ASC')->get();

        return view('voting_mpk', compact('kandidat', 'calon'));
    }

    public function aspirasi()
    {
        $voting = ConfigVoting::getConfig()->voting;

        if ($voting === 'mpk') {
            if (!VotingMpk::checkStatusVote('wakil')) {
                return redirect()->route('home');
            }
        } else {
            if (is_null(VotingOsis::where(['user_id' => auth()->user()->id])->first())) {
                return redirect()->route('home');
            }
        }

        return view('aspirasi', compact('voting'));
    }

    public function submitAspirasi(Request $request)
    {
        $this->validate($request, [
            'voting'   => 'required|in:osis,mpk',
            'aspirasi' => 'required|min:10',
            'ucapan' => 'required|min:10'
        ]);

        if (Aspirasi::where(['user_id' => auth()->user()->id, 'voting' => $request->voting])->first()) {
            session()->flash('voting', 'Terimakasih ' . auth()->user()->name . ' sudah berpartisipasi dalam ' . ConfigVoting::getConfig()->title . ' ' . ConfigVoting::getConfig()->title_prefix . ' untuk periode ' . ConfigVoting::getConfig()->periode);
            Auth::logout();

            return redirect()->route('login');
        }

        $aspirasi = [
            'user_id'    => auth()->user()->id,
            'voting'     => $request->voting,
            'aspirasi'   => strip_tags($request->aspirasi),
            'ucapan'     => strip_tags($request->ucapan),
            'created_at' => now()
        ];

        if (Aspirasi::insert($aspirasi)) {
            session()->flash('voting', 'Terimakasih ' . auth()->user()->name . ' sudah berpartisipasi dalam ' . ConfigVoting::getConfig()->title . ' ' . ConfigVoting::getConfig()->title_prefix . ' untuk periode ' . ConfigVoting::getConfig()->periode);
            Auth::logout();

            return redirect()->route('login');
        }

        return redirect()->back()->withErrors(['voting' => 'Telah terjadi error, silahkan mencoba kembali, jika error tetap berlanjut silahkan hubungi pihak panitia.']);
    }

    public function voteOsis(Request $request)
    {
        $this->validate($request, [
            'kandidat_id' => 'required|exists:kandidat_osis,id' 
        ]);
        
        $data = [
            'user_id'          => auth()->user()->id,
            'kandidat_osis_id' => $request->kandidat_id,
            'signature'        => Hash::make( auth()->user()->uuid . ':' . $request->kandidat_id ),
            'created_at'       => now()
        ];

        
        if (VotingOsis::insert($data)) {

            session()->flash('voting', 'Voting berhasil dilakukan, selanjutnya silahkan berikan aspirasi anda.');

            return redirect()->route('aspirasi');
        }

        return redirect()->back()->withErrors(['voting' => 'Telah terjadi error, silahkan mencoba kembali, jika error tetap berlanjut silahkan hubungi pihak panitia.']);
    }

    public function voteMpk(Request $request)
    {
        $this->validate($request, [
            'kandidat_id' => 'required|exists:kandidat_mpk,id' 
        ]);
        
        $data = [
            'user_id'          => auth()->user()->id,
            'kandidat_mpk_id' => $request->kandidat_id,
            'signature'        => Hash::make( auth()->user()->uuid . ':' . $request->kandidat_id ),
            'created_at'       => now()
        ];

        if (VotingMpk::insert($data)) {
            if (VotingMpk::checkStatusVote('ketua')) {
                session()->flash('voting', 'next');

                return redirect()->route('home');
            }

            return redirect()->route('aspirasi');
        }

        return redirect()->back()->withErrors(['voting' => 'Telah terjadi error, silahkan mencoba kembali, jika error tetap berlanjut silahkan hubungi pihak panitia.']);
    }

    public function logout()
    {
        Auth::logout();

        return redirect()->route('login')->withErrors([
            'login'  => 'Silahkan login ulang'
        ]);
    }
}
