<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class AuthController extends Controller {
    public function form() { return view('auth.login'); }
    public function login(Request $r) {
        $c = $r->validate(['email' => 'required|email', 'password' => 'required']);
        if (! Auth::attempt($c, $r->boolean('remember'))) return back()->withErrors('Identifiants incorrects.')->onlyInput('email');
        $r->session()->regenerate();
        return redirect()->intended(route('dashboard'));
    }
    public function logout(Request $r) {
        Auth::logout(); $r->session()->invalidate(); $r->session()->regenerateToken();
        return redirect()->route('home');
    }
}
