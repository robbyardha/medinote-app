<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ApiAuthController extends Controller
{
    public function login(Request $request): JsonResponse
    {
        $currentApiKey = env('SECRET_KEY_APP');

        $validator = Validator::make($request->all(), [
            'api_key' => ['required'],
            'username_or_email' => ['required'],
            'password' => ['required'],
        ], [
            'api_key.required' => ':attribute is required',
            'username_or_email.required' => ':attribute is required',
            'password.required' => ':attribute is required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validasi Gagal',
                'errors' => $validator->errors(),
            ], 422);
        }

        $api_key = $request->api_key;
        if ($api_key != $currentApiKey) {
            return response()->json([
                'status' => false,
                'message' => 'API Key Tidak Sesuai',
                'errors' => 'API Key Tidak Sesuai'
            ], 401);
        } else {

            $usernameOrEmail = $request->username_or_email;


            $user = null;
            $typeLogin = '';
            if (filter_var($usernameOrEmail, FILTER_VALIDATE_EMAIL)) {
                $user = User::where('email', $usernameOrEmail)->first();
                $typeLogin = 'email';
            } else {
                $user = User::where('username', $usernameOrEmail)->first();
                $typeLogin = 'username';
            }

            if ($user) {
                if (Auth::attempt(['email' => $user->email, 'password' => $request->password])) {
                    $userNew = User::get_user_roles($user->id);

                    $mobile_api_token = Str::random(15);

                    $getCurrentUser = User::find($user->id);

                    $dataToken = [
                        'mobile_api_token' => $mobile_api_token,
                    ];
                    $getCurrentUser->update($dataToken);

                    return response()->json([
                        'status' => true,
                        'message' => 'Login Successfull.',
                        'user_data' => [
                            'iduser' => $user->id,
                            'name' => $user->name,
                            'email' => $user->email,
                            'username' => $user->username,
                            'permission_roles' => $userNew,
                            'mobile_api_token' => $mobile_api_token,
                        ]
                    ], 200);
                }
            }

            return response()->json([
                'status' => false,
                'message' => 'Invalid credentials.',
                'errors' => 'Invalid credentials.'
            ], 401);
        }
    }

    /**
     * Logout and revoke token.
     */
    public function logout(Request $request): JsonResponse
    {

        $validator = Validator::make($request->all(), [
            'api_key' => ['required'],
            'iduser.required' => ':attribute is required',
        ], [
            'api_key.required' => ':attribute is required',
            'iduser.required' => ':attribute is required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validasi Gagal',
                'errors' => $validator->errors(),
            ], 422);
        }


        $currentApiKey = env('SECRET_KEY_APP');
        $api_key = $request->api_key;

        if ($api_key != $currentApiKey) {
            return response()->json([
                'status' => false,
                'message' => 'API Key Tidak Sesuai',
                'errors' => 'API Key Tidak Sesuai'
            ], 401);
        } else {
            $iduser = $request->iduser;
            $user = User::find($iduser);

            if ($user) {
                // set mobile_api_token menjadi null pada saat logout
                $user->mobile_api_token = null;
                $user->save();

                return response()->json([
                    'status' => true,
                    'message' => 'Logout successful.',
                ], 200);
            }

            return response()->json([
                'status' => false,
                'message' => 'User not authenticated.',
            ], 401);
        }
    }
}
