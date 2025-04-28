<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        // Validate the incoming request
        $credentials = $request->validate([
            'username' => 'required|string',
            'password' => 'required',
        ]);

        // Attempt to log in the user
        if (Auth::attempt($credentials)) {
            return redirect()->route('products.index');
        }

        // If login fails, redirect back with an error message
        return back()->withErrors([
            'username' => 'The provided credentials do not match our records.',
        ]);
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
