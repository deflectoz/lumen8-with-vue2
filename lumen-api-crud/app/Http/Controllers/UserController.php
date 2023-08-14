<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Validator;
use Tymon\JWTAuth\Facades\JWTAuth;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\DB;


class UserController extends Controller
{

    public function index(Request $request)
    {

        $checkMethode = $request->input('methodType');

        if ($request->isMethod('post')) {
            switch ($checkMethode) {
                case 'login':
                    return $this->login($request);
                case 'captcha':
                    return $this->captcha($request);
                case 'getUser':
                    return $this->getUser($request);
                case 'getAlluser':
                    return $this->getAlluser();
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

        if ($request->hasFile('fileKtp')) {
            $fileName = $request->file('fileKtp')->getClientOriginalName();
            $fileExplode = explode('.', $fileName);
            $fileExt = '.' . end($fileExplode);
            $path = storage_path('userData');
            $image = 'Data-KTP' . time();
            $request->file('fileKtp')->move($path, ($image . $fileExt));
        }

        $doInsert = User::create([
            'userName' => $request->input('userName'),
            'password' => Hash::make($request->input('password')),
            'firstName' => $request->input('firstName'),
            'lastName' => $request->input('lastName'),
            'age' => $request->input('age'),
            'idEducation' => $request->input('idEducation'),
            'fileKtp' => isset($image) ?$image : null,
            'fileKtpExt' => isset($fileExt) ?$fileExt : null
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

    public function captcha(Request $request)
    {

        $secretKey = '6LeIxAcTAAAAAGG-vFI1TnRWxMZNFuojJ4WifJWe'; // Ganti dengan secret key reCAPTCHA Anda
        $url = 'https://www.google.com/recaptcha/api/siteverify';

        $client = new Client();

        $reponse = $client->post($url, [
            'form_params' => [
                'secret' => $secretKey,
                'response' => $request->response
            ]
        ]);

        $body = json_decode($reponse->getBody());

        return $body->success;
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

    public function getAlluser()
    {
        $findAllUser = DB::select("SELECT A.firstName,A.lastName,A.userName,A.age,B.educationGrade FROM users AS A JOIN educations AS B ON A.idEducation = B.id ");
        return $this->successResponse($findAllUser);
    }

    public function getUser(Request $request)
    {
        $findUser = User::where('id', $request->id)->first();
        return $this->successResponse($findUser);
    }

    public function getFileKtp(Request $request)
    {

        $ktpPath = storage_path('userData') . '/' . $request->fileName . $request->fileKtpExt;

        if (file_exists($ktpPath)) {
            $file = file_get_contents($ktpPath);
            return response($file, 200)->header('Content-Type', 'image/jpeg');
        }
    }
}
