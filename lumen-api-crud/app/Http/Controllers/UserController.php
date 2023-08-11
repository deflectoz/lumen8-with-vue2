<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Validator;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Str;


class UserController extends Controller
{

    public function index(Request $request)
    {

        $checkMethode = $request->input('methodType');

        if ($request->isMethod('post')) {
            switch ($checkMethode) {
                case 'login':
                    return $this->login($request);
                    break;
            }
        }
    }

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

        $validator = Validator::make(
            $request->all(),
            [
                'userName' => 'required',
                'password' => 'required|min:6'
            ]
        );

        if ($validator->fails()) {
            $resp = [
                'metadata' => [
                    'message' => $validator->errors()->first(),
                    'code'    => 422
                ]
            ];
            return response()->json($resp, 422);
            die();
        }

        $user = User::where('userName', $request->userName)->first();
        if ($user) {

            if (Hash::check($request->password, $user->password)) {

                $token = \Auth::login($user);
                $resp = [
                    'response' => [
                        'token' => $token
                    ],
                    'metadata' => [
                        'message' => 'OK',
                        'code'    => 200
                    ]
                ];

                return response()->json($resp);
            } else {

                $resp = [
                    'metadata' => [
                        'message' => 'Username Atau Password Tidak Sesuai',
                        'code'    => 401
                    ]
                ];

                return response()->json($resp, 401);
            }
        } else {
            $resp = [
                'metadata' => [
                    'message' => 'Username Atau Password Tidak Sesuai',
                    'code'    => 401
                ]
            ];

            return response()->json($resp, 401);
        }
    }

    public function refresh(Request $request)
    {
        try {
            $newToken = JWTAuth::setToken($request->input('refresh_token'))->refresh();
            return response()->json(['token' => $newToken]);
        } catch (\Exception $th) {
            return response()->json(['message' => 'Invalid refresh token'], 401);
        }
    }

    public function crsf()
    {
        $csrfToken = csrf_token();
        $csrfSignature = hash_hmac('sha256', $csrfToken, env('APP_CSRF_KEY'));

        return response()->json($csrfToken, 200);
    }
}
