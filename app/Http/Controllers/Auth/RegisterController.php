<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class RegisterController extends Controller
{
    //méthode pour gérer l'affichage de notre formulaire d'inscription
    public function __construct()
    {
        $this->middleware('guest');
    }
    
    public function ShowRegistrationForm(): View
    {
        return view ('Auth.register');
    }

    public function register(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name'      => ['required', 'string', 'between:5,255'],
            'email'     => ['required', 'email', 'unique:users'], //l'email doit être unique dans la table Users
            'password'  => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $validated['password'] = Hash::make($validated['password']);

        $user = User::create($validated);

        Auth::login($user);
        
        return redirect()->route('home')->withStatus('Inscription réussie !');
    }
}
