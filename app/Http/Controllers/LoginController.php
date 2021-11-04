<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;

use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        // grab credentials from the request
        $credentials = $request->only('usuario', 'contraseña');

        try {
            // attempt to verify the credentials and create a token for the user
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json([
                    "error" => "invalid_credentials",
                    "message" => "The user credentials were incorrect. "
                ], 401);
            }
        } catch (JWTException $e) {
            // something went wrong whilst attempting to encode the token
            return response()->json([
                "error" => "could_not_create_token",
                "message" => "Enable to process request."
            ], 422);
        }

        // all good so return the token
        $usuario =  Usuario::where('usuario', $request->get('usuario'))->get();
        return response()->json([
            'user'  => $usuario,
            'token' => $token,
        ],200);

    }
}
