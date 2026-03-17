<?php

namespace App\Http\Controllers\Customer;

use App\Enums\UserRole;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function showLogin(): View
    {
        // Store template intent from query string
        if (request()->has('template')) {
            session(['intended_template' => request()->integer('template')]);
        }

        return view('auth.login');
    }

    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            $redirect = $this->redirectAfterAuth();
            return redirect($redirect);
        }

        return back()->withErrors([
            'email' => 'البريد الإلكتروني أو كلمة المرور غير صحيحة.',
        ])->onlyInput('email');
    }

    public function showRegister(): View
    {
        if (request()->has('template')) {
            session(['intended_template' => request()->integer('template')]);
        }

        return view('auth.register');
    }

    public function register(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'email', 'unique:users'],
            'password' => ['required', 'min:8', 'confirmed'],
        ]);

        $user = User::create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => Hash::make($data['password']),
            'role'     => UserRole::Customer,
        ]);

        Auth::login($user);

        return redirect($this->redirectAfterAuth());
    }

    private function redirectAfterAuth(): string
    {
        $templateId = session()->pull('intended_template');

        if ($templateId) {
            return route('customer.events.create') . '?template=' . $templateId;
        }

        return route('customer.dashboard');
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
