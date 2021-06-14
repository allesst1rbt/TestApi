<?php

namespace App\Http\Controllers;

use App\Repositories\AuthRepositoryInterface;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use PHPUnit\Exception;

class AuthController extends Controller
{
    protected $authRepositoryInterface;
    public function __construct(AuthRepositoryInterface $authRepositoryInterface)
    {
        $this->authRepositoryInterface = $authRepositoryInterface;
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function signIn()
    {
        $credentials = request(['email', 'password']);

        if (! $token =Auth::attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }
    public function login(){
        return response()->json(['message'=>'Unauthorized, please singIn'],401);
    }

    public function signUp(Request $request)
    {
        try {
            $request->validate([
                "email"=> "Required|string",
                "password"=> "Required|string",
                "name"=> "Required|string"
            ]);
            $this->authRepositoryInterface->createUser($request);

            return response()->json(['message'=>"user $request->email criado com sucesso"]);
        }catch (Exception $exception){
            return response()->json(['error'=>$exception],502);
        }

    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }


}
