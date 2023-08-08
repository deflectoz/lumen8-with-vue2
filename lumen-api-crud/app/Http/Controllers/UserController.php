<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserController extends Controller
{

    public function register(Request $request)
    {
        $this->validate($request, [
            'userName' => 'required|unique:users,userName',
            'password' => 'required|min:6',
            'firstName' => 'required',
            'lastName' => 'required',
            'age' => 'required',
            'idEducation' => 'required'
        ]);

        $doInsert = User::create([
            'userName' => $request->input('userName'),
            'password' => Hash::make($request->input('password')),
            'firstName' => $request->input('firstName'),
            'lastName' => $request->input('lastName'),
            'age' => $request->input('age'),
            'idEducation' => $request->input('idEducation')
        ]);

        return response()->json(['message' => 'Data added successfully'], 201);
    }

    public function login(Request $request)
    {
        $this->validate($request, [
            'userName' => 'required',
            'password' => 'required|min:6'
        ]);

        $userName = $request->input('userName');
        $password = $request->input('password');

        $user = User::where('userName', $userName)->first();
        if (!$user) {
            return response()->json(['message' => 'User Not Found'], 401);
        }

        $isValidPassword = Hash::check($password, $user->password);
        if (!$isValidPassword) {
            return response()->json(['message' => 'Login failed'], 401);
        }

        $generateToken = bin2hex(random_bytes(40));
        $user->update([
            'token' => $generateToken
        ]);

        return response()->json($user, 200);
    }
}
