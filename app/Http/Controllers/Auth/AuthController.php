<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }
    public function login(Request $request)
    {
        //validate form
        $kredensial =  $request->validate(
            [
                'email' => 'required|email',
                'password' => 'required',
            ],
            [
                'email.required' => 'Email tidak boleh kosong.',
                'email.email' => 'Penulisan email tidak benar.',
                'password.required' => 'Password tidak boleh kosong.',
            ]
        );

        if (Auth::guard('admdinas')->attempt($kredensial)) {
            $request->session()->regenerate();
            return redirect()->intended('dashboard');
        } elseif (Auth::guard('admpuskes')->attempt($kredensial)) {
            $request->session()->regenerate();
            return redirect()->intended('dashboard');
        }
        return back()->withErrors(['email' => 'Maaf email dan password salah!'])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        if (Auth::guard('admdinas')->check()) {

            $request->session()->invalidate();
            $request->session()->regenerateToken();
            Auth::guard('admdinas')->logout();
        } elseif (Auth::guard('admpuskes')->check()) {

            $request->session()->invalidate();
            $request->session()->regenerateToken();
            Auth::guard('admpuskes')->logout();
        }
        return redirect('/login');
    }
}
