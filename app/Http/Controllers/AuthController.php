<?php

namespace App\Http\Controllers;

use App\Models\InstructorWallet;
use App\Models\Organization;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
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
                return redirect()->route("welcome");
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
                return redirect("/");
            }

            if ($user->role->role_slug == "instructor") {
                $wallet = InstructorWallet::where("user_id", $user->id)->first();
                if (!$wallet) {
                    $wallet1 = new InstructorWallet();
                    $wallet1->user_id = $user->id;
                    $wallet1->type = "Primary";
                    $wallet1->balance = 0;
                    $wallet1->save();

                    $wallet2 = new InstructorWallet();
                    $wallet2->user_id = $user->id;
                    $wallet2->type = "Commission";
                    $wallet2->balance = 0;
                    $wallet2->save();
                }

                return redirect("/instructor");
            }
        }

        return redirect()->back()->with("error", "Email atau password salah");
    }

    public function register() {
        return view("auth.register");
    }

    public function registerPost(Request $request) {
        try {
            $cUser = User::where("email", $request->email)->first();

            if (!$request->name) throw new \Exception("Nama harus di isi");
            if (!$request->email) throw new \Exception("Email harus di isi");
            if (!$request->password) throw new \Exception("Password harus di isi");
            if (strlen($request->password) < 8) throw new \Exception("Minimal password 8 karakter");
            if ($cUser) throw new \Exception("Email telah digunakan");

            DB::beginTransaction();

            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->email_verified_at = Carbon::now();

            if ($request->type == "student") {
                $user->role_id = 2;
                $user->sub_role_id = 5;
                $user->save();
            }
            if ($request->type == "instructor") {
                $user->role_id = 3;
                $user->sub_role_id = 5;
                $user->save();
            }
            if ($request->type == "organization") {
                $user->role_id = 2;
                $user->sub_role_id = 4;
                $user->save();

                $organization = new Organization();
                $organization->user_id = $user->id;
                $organization->organization_name = $request->organization_name;
                $organization->organization_address = $request->organization_address;
                $organization->organization_contact = $request->organization_contact;
                $organization->save();
            }

            DB::commit();
            return redirect()->route("login")->with("success", "Berhasil melakukan pendaftaran");
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with("error", $e->getMessage());
        }
    }

    public function logout() {
        Session::flush();
        Auth::logout();

        return redirect("/");
    }
}
