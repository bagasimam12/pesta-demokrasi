<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

use App\Http\Controllers\Admin;
use App\Http\Controllers\Admin\Ajax as AdminAjax;

use App\Http\Controllers;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/login', [Controllers\AuthController::class, 'index'])->name('login');
Route::get('/logout', [Controllers\VotingController::class, 'logout'])->name('logout');

Route::middleware('throttle:3,1')->group(function(){
    Route::post('/login', [Controllers\AuthController::class, 'login'])->name('login');
});

Route::middleware('auth')->group(function(){
    Route::get('/', [Controllers\VotingController::class, 'index'])->name('home');

    Route::post('/agreement', function(Request $request){
        $request->session()->forget('agreement');

        session(['welcome' => true]);

        return redirect()->route('home');
    })->name('agreement');

    Route::post('/next', function(Request $request){
        $request->session()->forget('welcome');

        session(['next' => true]);
        session()->flash('message', 'Silahkan berikan hak pilih anda disini');

        return redirect()->route('home');
    })->name('next');

    Route::post('/letsgo', function(Request $request){
        $request->session()->forget('next');

        session()->flash('message', 'Silahkan berikan hak pilih anda disini');

        return redirect()->route('home');
    })->name('letsgo');

    Route::get('/aspirasi', [Controllers\VotingController::class, 'aspirasi'])->name('aspirasi');
    Route::post('/aspirasi', [Controllers\VotingController::class, 'submitAspirasi'])->name('aspirasi');
    Route::post('/vote-osis', [Controllers\VotingController::class, 'voteOsis'])->name('vote.osis');
    Route::post('/vote-mpk', [Controllers\VotingController::class, 'voteMpk'])->name('vote.mpk');
});

// ---- admin -----
Route::prefix('admin')->name('admin.')->group(function(){
    Route::get('/', function(){
        if (auth()->check()) {
            return redirect()->route('admin.dashboard');
        }
        return redirect()->route('admin.login');
    });

    Route::get('/login', [Admin\AuthController::class, 'loginForm'])->name('login');
    Route::post('/login', [Admin\AuthController::class, 'loginPost'])->name('login');

    Route::middleware('auth.admin')->group(function(){
        Route::post('/logout', [Admin\AuthController::class, 'logout'])->name('logout');

        // change voting type
        Route::post('/change-voting', function(Request $request){
            $current = \ConfigVoting::getConfig()->voting;
            $change  = $current === 'osis' ? 'mpk' : 'osis';
            $config  = \App\Models\Config::find(1);
            $config->voting = $change;

            if ($config->save()) {
                $status = ['success', 'Mode pemilihan berhasil diganti ke pemilihan ' . $change];
            } else {
                $status = ['error', 'Mode pemilihan gagal diganti ke pemilihan ' . $change];
            }

            return redirect()->route('admin.pengaturan')->with($status[0], $status[1]);
        })->name('config.voting');


        // change user token
        Route::post('/change-token', function(Request $request){
            $v = \Validator::make($request->all(), [
                'token' => 'required|min:6|max:6'
            ]);

            // if (empty($request->id)) {
            //     return redirect()->back()->with('error', 'User tidak ditemukan!');
            // }

            $user = \App\Models\User::where(['uuid' => $request->uuid])->first();
            if (is_null($user)) {
                return redirect()->back()->with('error', 'User tidak ditemukan!');
            }

            if ($v->fails()) {
                return redirect()->back()->with('error', 'Token tidak sesuai format');
            }

            $token = strtoupper($request->token);

            $user->password = Hash::make($token);
            if ($user->save()) {
                $status = ['success', 'Token ' . $user->name . ' berhasil diperbarui menjadi ' . $token];
            } else {
                $status = ['error', 'Token ' . $user->name . ' gagal diperbarui'];
            }

            return redirect()->route('admin.pengaturan')->with($status[0], $status[1]);
        })->name('change.token');

        // dashboard
        Route::get('/dashboard', [Admin\DashboardController::class, 'dashboard'])->name('dashboard');

        // pengaturan
        Route::get('/pengaturan', [Admin\DashboardController::class, 'pengaturan'])->name('pengaturan');

        Route::get('/profile', function(Request $request){
            return $request->user();
        })->name('profile');

        // kandidat
        Route::prefix('kandidat')->name('kandidat.')->group(function(){
            // osis
            Route::get('/osis', [Admin\KandidatController::class, 'osis'])->name('osis');
            Route::get('/osis/d/{id}', [Admin\KandidatController::class, 'detailOsis'])->name('osis.detail');

            // mpk
            Route::get('/mpk', [Admin\KandidatController::class, 'mpk'])->name('mpk');
            Route::get('/mpk/d/{id}', [Admin\KandidatController::class, 'detailMpk'])->name('mpk.detail');
        });

        // peserta
        Route::prefix('peserta')->name('peserta.')->group(function(){
            Route::get('/siswa', [Admin\PesertaController::class, 'siswa'])->name('siswa');
            Route::get('/guru', [Admin\PesertaController::class, 'guru'])->name('guru');
            Route::get('/dpk', [Admin\PesertaController::class, 'dpk'])->name('dpk');
        });

        // voting
        Route::prefix('voting')->name('voting.')->group(function(){
            Route::get('/osis', [Admin\VotingController::class, 'osis'])->name('osis');
            Route::get('/mpk', [Admin\VotingController::class, 'mpk'])->name('mpk');
        });

        // aspirasi
        Route::prefix('aspirasi')->name('aspirasi.')->group(function(){
            Route::get('/osis/siswa', [Admin\AspirasiController::class, 'osisSiswa'])->name('osis.siswa');
            Route::get('/osis/guru', [Admin\AspirasiController::class, 'osisGuru'])->name('osis.guru');
            Route::get('/mpk', [Admin\AspirasiController::class, 'mpk']);
        });

        // ajax 
        Route::prefix('ajax')->name('ajax.')->group(function(){
            // datatables
            Route::prefix('datatables')->name('datatables.')->group(function(){
                Route::post('/siswa', [AdminAjax\DatatablesController::class, 'pesertaSiswa'])->name('siswa');
                Route::post('/guru', [AdminAjax\DatatablesController::class, 'pesertaGuru'])->name('guru');
                Route::post('/dpk', [AdminAjax\DatatablesController::class, 'pesertaDpk'])->name('dpk');
            });

            Route::prefix('aspirasi')->name('aspirasi.')->group(function(){
                Route::post('/osis/{type}', [AdminAjax\DatatablesController::class, 'aspirasiOsis'])->name('osis');
                Route::post('/mpk', [AdminAjax\DatatablesController::class, 'aspirasiMpk'])->name('mpk');
            });
        });
    });
});
