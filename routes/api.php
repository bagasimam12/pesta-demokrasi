<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('throttle:3,1')->post('/login', [AuthController::class, 'login']);

Route::middleware(['auth:sanctum', 'throttle:10,1'])->group(function(){
    Route::get('/user', function(Request $request){
        $user =  new \App\Http\Resources\UserResource($request->user());

        return response()->json($user);
    });

    Route::post('/logout', [AuthController::class, 'logout']);
});
