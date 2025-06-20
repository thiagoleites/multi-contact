<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Importa a fachada Auth
use Illuminate\Validation\ValidationException; // Para lançar exceções de validação

class AuthController extends Controller
{
    /**
     * Show login form
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Get login
     */
    public function login(Request $request)
    {
        // Valid credentials
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        //Attempts to authenticate the user
        if (Auth::attempt($credentials)) {
            // Regenerate session
            $request->session()->regenerate();


            return redirect()->intended(route('people.index'))
                ->with('success', 'Login realizado com sucesso!');
        }

        // If authentication fails, throw a validation exception
        // which will return the user to the login form with an error.
        throw ValidationException::withMessages([
            'email' => 'As credenciais fornecidas não correspondem aos nossos registros.',
        ]);
    }

    /**
     * Logout user
     */
    public function logout(Request $request)
    {
        Auth::logout(); // logout method

        // Invalidates the session
        $request->session()->invalidate();

        // Regenerates the session CSRF token for security
        $request->session()->regenerateToken();

        // Redirects to the home page (people list) with a success message
        return redirect()->route('people.index')->with('success', 'Logout realizado com sucesso.');
    }
}

