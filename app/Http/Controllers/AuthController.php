<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function login() {
        if (Auth::check()) {
            $user = User::with("role")->where("id", Auth::user()->id)->first();

            if ($user->role->role_slug == "administrator") {
                return redirect()->route("admin.dashboard");
            }
            if ($user->role->role_slug == "user") {
                return redirect()->route("user.user");
            }
            if ($user->role->role_slug == "instructor") {
                return redirect()->route("instructor.dashboard");
            }
        }

        return view("auth.login");
    }

    public function loginPost(Request $request) {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $user = User::with("role")->where("id", Auth::user()->id)->first();

            if ($user->role->role_slug == "administrator") {
                return redirect("/admin");
            }
            if ($user->role->role_slug == "user") {
                return redirect("/user");
            }
            if ($user->role->role_slug == "instructor") {
                return redirect("/instructor");
            }
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    public function register() {
        return view("auth.register");
    }

    public function logout() {
        Session::flush();
        Auth::logout();

        return redirect('login');
    }
}
