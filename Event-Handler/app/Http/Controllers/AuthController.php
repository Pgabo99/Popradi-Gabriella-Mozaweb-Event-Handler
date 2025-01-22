<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Redirects to the Login page
     * @return \Illuminate\Contracts\View\View
     */
    public function login()
    {
        return view("auth.login");
    }

    /**
     * Redirects to the Register page
     * @return \Illuminate\Contracts\View\View
     */
    public function register()
    {
        return view("auth.register");
    }

    /**
     * Login into existing user account
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function loginPost(Request $request)
    {
        $request->validate([
            "email" => "required|email",
            "password" => "required",
        ]);
        $credentials = $request->only("email", "password");
        if (Auth::attempt($credentials)) {
            return redirect()->intended(route('home'))->with('success', 'Sikeres bejelentkezés');
        }
        return redirect(route("login"))->with("error", "Hibás email vagy jelszó.");
    }

     /**
     * Creating a new user
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function registerPost(Request $request)
    {
        $request->validate([
            "email" => "required|email|unique:App\Models\User",
            "password" => "required|min:8|max:30",
            "password_again" => "required|same:password",
            "name" => "required|string",
        ]);

        $user = new User();
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->name = $request->name;

        if ($user->save()) {
            return redirect(route("login"))->with("success", "Sikeres regisztráció!");
        }

        return redirect(route("register"))->with("error", "Sikertelen regisztráció, próbáld újra");
    }

    /**
     * Logout
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logoutPost(Request $request)
    {
        Auth::logout();

        return redirect(route('login'))->with('success', 'Sikeres kijelentkezés');
    }

}
