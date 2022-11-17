<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\VotingMpk;
use App\Models\VotingOsis;
use App\Models\AnggotaDpk;
use Closure;
use ConfigVoting;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware(function(Request $request, Closure $next){
            if (auth()->check()) {
                return redirect()->route('home');
            }

            return $next($request);
        });
    }
    public function index()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $this->validate($request, [
            'uuid'  => 'required',
            'token' => 'required'
        ]);

        $uuid = $request->uuid . \ConfigVoting::getConfig()->email_prefix;
        
        if (is_null($user = \App\Models\User::where('email', $uuid)->first())) {
            return redirect()->route('login')->withErrors([
                'login'  => 'ID Tersebut tidak terdaftar!'
            ]);
        }

        $voting = ConfigVoting::getConfig()->voting;

        if ($voting === 'osis') {
            if (VotingOsis::where(['user_id' => $user->id])->first()) {
                return redirect()->back()->withErrors([
                    'login' => 'ID Tersebut telah digunakan untuk melakukan voting!'
                ]);
            }
        } else {
            if (VotingMpk::where(['user_id' => $user->id])->get()->count() === 2) {
                return redirect()->back()->withErrors([
                    'login' => 'ID Tersebut telah digunakan untuk melakukan voting!'
                ]);
            }

            if (is_null(AnggotaDpk::where(['user_id' => $user->id])->first())) {
                return redirect()->back()->withErrors([
                    'login' => 'Hanya anggota DPK yang dapat melakukan pemilihan kandidat MPK'
                ]);
            }
        }

        $credentials = [
            'email'    => $uuid,
            'password' => $request->token
        ];

        if (!Auth::attempt($credentials)) {
            return redirect()->route('login')->withErrors([
                'login' => 'Silahkan cek kembali token anda!'
            ])->withInput();
        }

        $request->session()->regenerate();

        session(['agreement' => true]);

        return redirect()->route('home');
    }
}
