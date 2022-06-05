<?php

namespace Mirror\Web\EndPoints\Auth\Registration;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules;
use Mirror\Core\Accounts\Contracts\UsersRepository;
use Mirror\Core\Accounts\Entities\User;
use Mirror\Web\EndPoints\Controller;
use Mirror\Web\Providers\RouteServiceProvider;

class RegisteredUserController extends Controller
{

    public function __construct(private readonly UsersRepository $users_repository)
    {
    }

    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:Mirror\Core\Accounts\Entities\User'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::register(
            name: $request->input('name'),
            email: $request->input('email'),
            password: $request->input('password'),
        );

        $this->users_repository->save($user);

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
}
