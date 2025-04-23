<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function create() {
        return view('users.register');
    }

    public function login() {
        return view('users.login');
    }

    public function logout(Request $request) {
        auth()->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('message', 'Hai eseguito il logout correttamente!');

    }

    public function store(Request $request) {
        $formFields = $request->validate([
            'surname' => ['required', 'min:3'],
            'name' => ['required', 'min:3'],
            'email' => ['required', 'email', Rule::unique('users', 'email')],
            'password' => 'required|confirmed|min:6'
        ]);

        // Hash Password
        $formFields['password'] = bcrypt($formFields['password']);

        // Create User
        $user = User::create($formFields);

        // Login
        auth()->login($user);

        return redirect('/')->with('message', 'Utente creato e loggato correttamente!');
    }

    public function authenticate(Request $request) {
        $formFields = $request->validate([
            'email' => ['required', 'email'],
            'password' => 'required'
        ]);

        if(auth()->attempt($formFields)) {
            $request->session()->regenerate();

            return redirect('/dashboard/home');
        }

        return back()->withErrors(['email' => 'Credenziali non valide'])->onlyInput('email');
    }
    
    // Mostra il form
    public function showChangePasswordForm() {
        return view('users.change_password');
    }

    // Esegue il cambio password
    public function changePassword(Request $request)
    {
        // Validazione dei campi
        $request->validate([
            'current_password' => ['required'],
            'new_password' => ['required', 'min:6', 'confirmed'],
        ]);

        // Prendi l'utente autenticato
        $user = User::find(auth()->id());

        // Verifica la password corrente
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'La password attuale non è corretta.']);
        }

        // Verifica se la nuova password è uguale alla vecchia
        if ($request->new_password === $request->current_password) {
            return back()->withErrors(['new_password' => 'La nuova password non può essere uguale a quella precedente.']);
        }

        // Hash della nuova password
        $user->password = bcrypt($request->new_password);

        // Salva l'utente con la nuova password
        $user->save();

        return redirect('/dashboard/home')->with('message', 'Password cambiata con successo!');
    }

}