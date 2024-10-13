<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\AuthRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller {

    public function login(AuthRequest $request) {
        // Récupérer les informations validées
        $credentials = $request->only('email', 'password');

        // Vérifier les identifiants
        if (!Auth::attempt($credentials)) {
            return response()->json([
                'message' => 'Les identifiants ne sont pas corrects.',
            ], 401);
        }

        // Authentifier l'utilisateur
        $user = Auth::user();

        // Générer un token
        $token = $request->user()->createToken('APP_KEY')->plainTextToken;

        // Retourner une réponse JSON avec le token
        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'message' => 'Authentification réussie.',
        ]);
    }

    public function check(Request $request) {
        if ($request->user()) {
            return response()->json([
                'data'   => $request->user(),
                'status' => 200
            ],200);
        }

        return response()->json([
            'message' => 'Token is invalid'
        ], 401);
    }

     public function logout(Request $request){
         // Révoquer le token actuel de l'utilisateur
         $request->user()->currentAccessToken()->delete();
 
         return response()->json([
             'message' => 'Déconnexion réussie et token révoqué.'
         ]);
     }
}
