<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (session('admin_auth')) {
            return redirect()->route('admin.work.index');
        }

        return view('admin.login');
    }

    public function login(Request $request)
    {
        $request->validate(['password' => 'required']);

        if ($request->password !== env('ADMIN_PASSWORD', 'storytale2026')) {
            return back()->withErrors(['password' => 'Wrong password.'])->withInput();
        }

        session(['admin_auth' => true]);

        return redirect()->route('admin.work.index');
    }

    public function logout()
    {
        session()->forget('admin_auth');

        return redirect()->route('admin.login');
    }
}
