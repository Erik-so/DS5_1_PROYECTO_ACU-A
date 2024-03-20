<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PublicationComment;

class PublicationsCommentsController extends Controller
{
    public function create(Request $request)
    {
        $data = $request->validate([
            'comment_id' => 'required|numeric',
            'publication_id' => 'required|numeric',
        ]);
        
        $publicationComment = PublicationComment::create([
            'comment_id' => $data['comment_id'],
            'publication_id' => $data['publication_id'],

        ]);

        if ($publicationComment) {
            return response()->json([
                'message' => 'Los datos ingresados son los siguientes:',
                'info' => $publicationComment
            ]);
        } else {
            return response()->json([
                'message' => 'Error al crear los datos'
            ]);
        }
    }
}
