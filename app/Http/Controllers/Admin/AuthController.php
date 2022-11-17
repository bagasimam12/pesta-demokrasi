<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;

class AuthController extends Controller
{
    public function loginForm()
    {
        return view('admin.auth.login');
    }

    public function loginPost(Request $request)
    {
        $this->validate($request, [
            'email'    => 'required|email',
            'password' => 'required|string'
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            
            return redirect()->route('admin.dashboard');
        }

        return redirect()->back()->withErrors([
            'email'    => 'Please check your login details again',
            'password' => 'Please check your login details again'
        ]);
    }

    public function logout()
    {
        Auth::logout();

        return redirect()->route('admin.login');
    }
}
