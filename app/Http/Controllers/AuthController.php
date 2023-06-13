<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Auth;
use Session;

class AuthController extends Controller
{
    public function welcome()
    {
        if(!Auth::user()) {
            return view('welcome');
        } else {
            return redirect()->back();
        }
            
    }  

    public function logout()
    {
        session()->flush();
        Auth()->logout();

        return redirect('/');
    }

    public function index()
    {
        if(!Auth::user()) {
            return view('auth.login');
        } else {
            return redirect()->back();
        }
    }  
      
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);
   
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            return redirect()->intended('home');
        }

        return redirect()->back()->with('info', 'Usuario y/o contraseña incorrecto');
    }

    public function signup()
    {
        if(!Auth::user()) {
            return view('auth.signup');
        } else {
            return redirect()->back();
        }
    }

    public function register(Request $request)
    {
        /* VALIDACIONES */
        $request->validate([
            'username'              => 'required',
            'email'                 => 'required|unique:users|string|max:50',
            'password'              => ['required', 'confirmed', Password::min(6)],
            'password_confirmation' => ['required', Password::min(6)],
        ],
        [   
            'username.required'              => 'Es necesario ingresar un nombre.',
            'email.required'                 => 'Es necesario ingresar un correo electrónico.',
            'email.unique'                   => 'Otro usuario ya tiene ese correo electrónico.',
            'email.max'                      => 'El email no debe exceder los 50 caracteres.',
            'password.required'              => 'Es necesario ingresar una contraseña.',
            'password.min'                   => 'La contraseña debe tener minimo 6 caracteres.',
            'password_confirmation.required' => 'Es necesario que repita la contraseña.',
            'password_confirmation.min'      => 'Este campo tambien debe tener minimo 6 caracteres.',
        ]);

        $user = User::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            return redirect()->intended('home');
        }
        return redirect()->back()->with('error', 'Hubo un error al registrarse.');
    }

    public function create(array $data)
    {
      return User::create([
        'name' => $data['name'],
        'email' => $data['email'],
        'password' => bcrypt($request->password)
      ]);
    }    
}