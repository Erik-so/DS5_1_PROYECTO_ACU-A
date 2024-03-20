<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\PublicationComment;

class CommentController extends Controller
{
    public function item($id) {

        $comments = Comment::where('id','=',$id)->first();

        $object = [
            "id" => $comments->id,
            "user" => $comments->user_id,
            "image" => $comments->image,
            "comment" => $comments->comment,
            "updated" => $comments->updated_at
        ];

        return response()->json($object);
    }

    public function list() {

        $comments = Comment::all();
        $list = [];

        foreach($comments as $comment) {
            $object = [
                "id" => $comment->id,
                "user" => $comment->user_id,
                "image" => $comment->image,
                "comment" => $comment->comment,
                "updated" => $comment->updated_at
            ];
            array_push($list, $object);
        }

        return response()->json($list);
    }

    public function create(Request $request)
{
    $data = $request->validate([
        'user_id' => 'required | numeric',
        'image' => 'required',
        'comment' => 'required',
        'publication_id' => 'required|numeric'
    ]);

    $comment = Comment::create([
        'user_id' => $data['user_id'],
        'image' => $data['image'],
        'comment' => $data['comment']
    ]);

    if ($comment) {

        $commentId = $comment->id;


        $publicationComment = PublicationComment::create([
            'comment_id' => $commentId,
            'publication_id' => $request->publication_id
        ]);

        if ($publicationComment) {
            return response()->json([
                'message' => 'Su consulta es la siguiente: ',
                'info' => $comment
            ]);
        } else {
            return response()->json([
                'message' => 'Error al crear los datos de PublicationComment'
            ]);
        }
    } else {
        return response()->json([
            'message' => 'Error al crear los datos de Comment'
        ]);
    }
}
}
