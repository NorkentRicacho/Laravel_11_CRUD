<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        // Validate incoming registration data
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users',
            'password' => 'required|string|confirmed|min:8',
        ]);

        // Create the new user
        User::create([
            'name' => $request->name,
            'username' => $request->username,
            'password' => Hash::make($request->password),
        ]);

        // Redirect to login page with success message
        return redirect()->route('login')
            ->with('success', 'Registration successful! Please login with your credentials.');
    }
}
