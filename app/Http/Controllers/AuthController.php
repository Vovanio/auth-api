<?php

namespace App\Http\Controllers;

use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\User;


class AuthController extends Controller
{

    public function Registration(Request $request){
        $validator = Validator::make($request->all(), [
            'login' => 'required|string|max:255',
            'email' => 'required|email|string',
            'password' => 'required|string|max:64|min:6'
        ]);

        if($validator->fails()){
            return response()->json([
                'error' => [
                    'code' => 422,
                    'message' => 'Validation error',
                    'errors' => $validator->errors(),
                ]
            ],422);
        }

        $userWithEmail = User::where('email', $request->email)
            ->first();

        if($userWithEmail !== null){
            response()->json([
                'error' => [
                    'code' => 422,
                    'message' => 'User with that email does exist'
                ]
            ],422);
        }

        $user = new User();
        $user->login = $request->login;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->save();

        return response()->json([], 204);
    }

    public function Login(Request $request){
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|string',
            'password' => 'required|string|max:64'
        ]);

        if($validator->fails()){
            return response()->json([
                'error' => [
                    'code' => 422,
                    'message' => 'Validation error',
                    'errors' => $validator->errors(),
                ]
            ],422);
        }

        $credentials = $request->only('email', 'password');

        if(!$token = auth()->attempt($credentials)){
            return response()->json([
                'error' => [
                    'code' => 401,
                    'message' => 'Email or password is incorrect'
                ]
            ], 401);
        }

        return $this->respondWithToken($token);
    }

    public function Logout(){
        auth()->logout();

        return response()->json([], 204);
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function respondWithToken($token){
        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
        ],200);
    }
}
