<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $validationRules = [
            'username' => ['required', 'string', 'max:255', 'unique:'.User::class],
            'phonenumber' => ['required', 'string', 'lowercase', 'max:255', 'regex:/^(.*[0-9]){10,12}/', 'unique:'.User::class],
        ];
        $validationMessages = [
            'phonenumber.regex' => 'The phone number should contain only 10 to 12 digits.',
        ];
        $request->validate($validationRules, $validationMessages);

        $user = User::create([
            'username' => $request->username,
            'phonenumber' => $request->phonenumber,
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}
