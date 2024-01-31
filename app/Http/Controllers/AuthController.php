<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    private $messages = [];

    public function login()
    {
        Auth::logout();
        return view('welcome');
    }

    public function makeLogin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ],
        [
            'email.required' => 'Informe o e-mail',
            'password.required' => 'Informe a senha',

        ]
        );

        if ($validator->fails()) {
            return redirect('login')->withErrors($validator->errors());
        }

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('horizon');
        }

        return redirect('login')->withErrors('Dados Inválidos.');
    }
}
