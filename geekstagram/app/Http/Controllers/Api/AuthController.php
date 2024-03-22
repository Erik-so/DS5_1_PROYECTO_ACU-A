<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller {

    public function register(Request $request) {

        $validatedData = $request->validate([
            'name' => 'required|max:55',
            'email' => 'required',
            'password' => 'required',
        ]);

        $validatedData['password'] = bcrypt($request->password);
        $user = User::create($validatedData);
        $accessToken = $user->createToken('authToken')->accessToken;

        return response([ 'profile' => $user, 'access_token' => $accessToken]);
    }


    public function login(Request $request){
    
        $loginData = $request->validate([
            'email' => 'email|required',
            'password' => 'required'
        ]);
    
        if (!Auth::attempt($loginData)) {
            return response([
                'response' => 'Invalid Credentials',
                'message' => 'error'
            ]);
        }
    
        $accessToken = auth()->user()->createToken('authToken')->accessToken;
    
        return response([
            'profile' => auth()->user(),
            'access_token' => $accessToken,
            'message' => 'success'
        ]);
    }

    public function logout(Request $request) {

        $request->user()->token()->revoke();

        return response()->json([

            'message' => 'Successfully logged out'
        ]);
    }

    public function user(Request $request) {

        $user->$request->user();
        $profile = Profile::where('user_id', '=', $user->id);

        return response()->json([$user, $profile]);
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json([
                'message' => 'Usuario no autenticado',
            ], 401); // Código de estado 401 (No autorizado)
        }
        $validatedData = $request->validate([
            'name' => 'nullable|max:55',
            'email' => 'nullable|email',
            'password' => 'nullable|min:8',
        ]);
    
        $updated = false;
    
        if ($request->filled('name')) {
            $user->name = $validatedData['name'];
            $updated = true;
        }
    
        if ($request->filled('email')) {
            $user->email = $validatedData['email'];
            $updated = true;
        }
    
        if ($request->filled('password')) {
            $user->password = bcrypt($validatedData['password']);
            $updated = true;
        }
    
        if ($updated) {
            $user->save();
        }
    
        return response()->json([
            'message' => $updated ? 'Perfil actualizado correctamente' : 'No se realizaron cambios',
            'profile' => $user,
        ]);
    }

}