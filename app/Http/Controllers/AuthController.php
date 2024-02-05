<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'login' => 'required|unique:users',
            'password' => 'required|min:3|confirmed',
        ], [
            'required' => 'Это обязательное поле для заполнения',
            'login.unique' => 'Этот логин уже занят',
            'password.min' => 'Пароль должен быть не менее 3 символов',
            'password.confirmed' => 'Пароли не совпадают',
        ]);

        $data = $request->all();

        try {
            $user = User::create([
                'name' => $data['name'],
                'login' => $data['login'],
                'password' => bcrypt($data['password']),
            ]);

            Auth::login($user);

            return response()->json($user);
        }
        catch(Exception $e) {
            return response()->json(['message' => $e->getMessage(), 403]);
        }
    }


    public function login(Request $request)
    {
        $request->validate([
            'login' => 'required',
            'password' => 'required',
            'remember' => '',
        ], [
            'required' => 'Это обязательное поле для заполнения',
        ]);

        $data = $request->all();

        if (Auth::attempt(['login' => $data['login'], 'password' => $data['password']], $data['remember'])) {
            $user = Auth::user();

            return response()->json($user);
        } 

        return response()->json(['message' => 'Некорректный логин или пароль'], 403);
    }


    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return response()->json(['result' => 'success']);
    }


    public function authUser()
    {
        $user = Auth::user();

        return response()->json($user);
    }
}
