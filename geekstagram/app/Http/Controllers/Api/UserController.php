<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Publication;
use App\Models\Comment;

class UserController extends Controller
{
    public function item($id) {
        $user = User::findOrFail($id);
    
        $commentsCount = Comment::where('user_id', $id)->count();
        $publicationsCount = Publication::where('user_id', $id)->count();
        $totalLikes = Publication::where('user_id', $id)->sum('like');
        $totalsaves = Publication::where('user_id', $id)->sum('saved');
    
        $response = [
            "name" => $user->name,
            "email" => $user->email,
            "image" => $user->image,
            "comments_count" => $commentsCount,
            "publications_count" => $publicationsCount,
            "total_likes" => $totalLikes,
            "total_saves" => $totalsaves
        ];
    
        return response()->json($response);
    }
    

    public function list() {

        $users = User::all();
        $list = [];

        foreach($users as $user) {
            $object = [
                "id" => $user->id,
                "name" => $user->name,
                "email" => $user->email,
                "password" => $user->password,
                "created" => $user->created_at,
                "updated" => $user->updated_at
            ];
            array_push($list, $object);
        }

        return response()->json($list);
    }

    public function create(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|max:30',
            'email' => 'required',
            'password' => 'required|min:8'
        ]);
        
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $data['password'],

        ]);

        if ($user) {
            return response()->json([
                'message' => 'Los datos ingresados son los siguientes:',
                'info' => $user
            ]);
        } else {
            return response()->json([
                'message' => 'Error al crear los datos'
            ]);
        }
    }

//añade una imagen añ perfil del usuario
public function updateImage(Request $request)
{
    $userId = $request->input('id');
    $imageUrl = $request->input('image');

    $user = User::find($userId);
    if ($user) {
        $user->image = $imageUrl;
        $user->save();
        return response()->json(['message' => 'Imagen actualizada correctamente'], 200);
    } else {
        return response()->json(['message' => 'Usuario no encontrado'], 404);
    }
}
    
}