<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        /* VALIDACIONES */
        $request->validate([
            'username'              => 'required',
            'email'                 => 'required|unique:users|string|max:50',
            'password'              => ['required', 'confirmed', Password::min(8)],
            'password_confirmation' => ['required', Password::min(8)],
        ],
        [   
            'username.required'              => 'Es necesario ingresar un nombre.',
            'email.required'                 => 'Es necesario ingresar un correo electrónico.',
            'email.unique'                   => 'Otro usuario ya tiene ese correo electrónico.',
            'email.max'                      => 'El email no debe exceder los 50 caracteres.',
            'password.required'              => 'Es necesario ingresar una contraseña.',
            'password.min'                   => 'La contraseña debe tener minimo 8 caracteres.',
            'password_confirmation.required' => 'Es necesario que repita la contraseña.',
            'password_confirmation.min'      => 'Este campo tambien debe tener minimo 8 caracteres.',
        ]);

        /* INSTANCIA DE USER */
        $user = User::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        /* CREAR REGISTRO */
        if($user){
            return redirect()->back()->with('success', 'Se registró el usuario de forma exitosa.');
        }
        return redirect()->back()->with('error', 'Hubo un error al tratar de registrarse.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $user = User::find($id);
        if ($user) {
            $user->delete();
            return redirect()->back()->with('success', 'Se ha eliminado el usuario.');
        }
        return redirect()->back()->with('error', 'No fue posible eliminar el usuario.');
    }
}
