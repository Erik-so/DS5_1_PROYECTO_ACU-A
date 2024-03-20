<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Publication;
use App\Models\Hashtag;
use App\Models\Comment;
use App\Models\Sponsor;
use App\Models\User;
use App\Models\PublicationComment;


class PublicationController extends Controller
{
    public function item($id) {

        $publications = Publication::where('id','=',$id)->first();

        $object = [
            "id" => $publications->id,
            "publication" =>$publications->publication,
            "user" =>$publications->user_id,
            "like" => $publications->like,
            "saved" => $publications->saved,
            "hashtag" => $publications->hashtag_id,
            "images" => $publications->images,
            "comment" => $publications->comment_id,
            "sponsor" => $publications->sponsor_id,
            "created" => $publications->created_at,
            "updated" => $publications->updated_at
        ];

        return response()->json($object);
    }

    public function list() {

        $publications = Publication::all();
        $list = [];

        foreach($publications as $publication) {
            $object = [
                "id" => $publication->id,
                "user" =>$publications->user_id,
                "like" => $publications->like,
                "like" => $publication->like,
                "saved" => $publication->saved,
                "hashtag" => $publication->hashtag_id,
                "images" => $publication->images,
                "comment" => $publication->comment_id,
                "sponsor" => $publication->sponsor_id,
                "created" => $publication->created_at,
                "updated" => $publication->updated_at
            ];
            array_push($list, $object);
        }

        return response()->json($list);
    }
//funcion para agergar publicacion en PublicationAdd
    public function create(Request $request)
    {
        $data = $request->validate([
            'user_id' => 'required | numeric',
            'publication' => 'required',
            'images' => 'required',
            'hashtag' => 'required'
        ]);

        $hashtag = Hashtag::create([
            'hashtag' => $data['hashtag']
        ]);

        if ($hashtag) {

            $hashtagId = $hashtag->id;

            $publicationHastag = Publication::create([
                'hashtag_id' => $hashtagId,
                'publication' => $request->publication,
                'user_id' => $request->user_id,
                'images' => $request->images,
            ]);

            if ($publicationHastag) {
                return response()->json([
                    'message' => 'Su consulta es la siguiente: ',
                    'info' => $publicationHastag
                ]);
            } else {
                return response()->json([
                    'message' => 'Error al crear los datos de Publications'
                ]);
            }
        } else {
            return response()->json([
                'message' => 'Error al crear los datos de Hashtags'
            ]);
        }
    }

    //funcion para vista de Publication
    public function search_all()
    {
        $publications = Publication::with('hashtag', 'sponsor', 'user')->orderBy('created_at', 'desc')->get();
        
        if ($publications->isEmpty()) {
            return response()->json(['message' => 'No se encontraron publicaciones.']);
        }
        
        $publicationData = [];
        
        foreach ($publications as $publication) {
            $publicationData[] = [
                "id" => $publication->id,
                "publication" => $publication->publication,
                "name" => $publication->user->name,
                'image' => $publication->user->image,
                "like" => $publication->like,
                "saved" => $publication->saved,
                "images" => $publication->images,
                "hashtag" => $publication->hashtag->hashtag,
                "created" => $publication->created_at,
                "updated" => $publication->updated_at,
            ];
        }
        
        return response()->json($publicationData);
    }



    public function search_one($searched)
    {
        $publications = Publication::with('hashtag', 'user')
            ->whereHas('user', function ($query) use ($searched) {
                $query->where('name', 'like', '%' . $searched . '%');
            })
            ->orWhere('publication', 'like', '%' . $searched . '%')
            ->get();
    
        if ($publications->isEmpty()) {
            return response()->json(['message' => 'No se encontraron publicaciones que coincidan con el texto proporcionado.'], 404);
        }
    
        $publicationsData = [];
    
        foreach ($publications as $publication) {
            $publicationData = [
                "id" => $publication->id,
                "publication" => $publication->publication,
                "email" => $publication->user->email,
                "name" => $publication->user->name,
                "image" => $publication->user->image,
                "like" => $publication->like,
                "saved" => $publication->saved,
                "hashtag" => $publication->hashtag->hashtag,
                "images" => $publication->images,
                "created" => $publication->created_at,
                "updated" => $publication->updated_at,
            ];
    
            $publicationsData[] = $publicationData;
        }
    
        return response()->json($publicationsData);
    }
    
//funcion para sumar un 1 al campo likep
public function sum_like($id, Request $request) {
    $publication = Publication::find($id);

    if (!$publication) {
        return response()->json(['error' => 'Publicación no encontrada'], 404);
    }
    
    $ifsum = $request->input('ifsum');

    if ($ifsum === true) {
        $publication->like += 1;
    } else {
        $publication->like -= 1;
    }

    $publication->save();

    $object = [
        "id" => $publication->id,
        "like" => $publication->like
    ];

    return response()->json($object);
}


    //funcion para sumar un 1 al campo saved
    public function sum_saved($id, Request $request) {
        $publication = Publication::find($id);
    
        if (!$publication) {
            return response()->json(['error' => 'Publicación no encontrada'], 404);
        }
        
        $ifsum = $request->input('ifsum');

        if ($ifsum === true) {
            $publication->saved += 1;
        } else {
            $publication->saved -= 1;
        }
    
        $publication->save();
    
        $object = [
            "id" => $publication->id,
            "saved" => $publication->saved
        ];
    
        return response()->json($object);
    }
    
    

    //funcion para buscar en la pantalla PublicationItem
    public function search_one_p($id)
    {
        $publication = Publication::with('hashtag', 'comment', 'sponsor', 'user')->find($id);
        
        if (!$publication) {
            return response()->json(['message' => 'No se encontró la publicación con el ID proporcionado.'], 404);
        }
        
        $publicationData = [
            "id" => $publication->id,
            "publication" => $publication->publication,
            "email" => $publication->user->email,
            "name" => $publication->user->name,
            "like" => $publication->like,
            "saved" => $publication->saved,
            "images" => $publication->images,
            "comment" => $publication->comment->comment,
            "name_comment" => $publication->comment->user->name,
            "image_comment" => $publication->comment->image,
            "hashtag" => $publication->hashtag->hashtag,
            "created" => $publication->created_at,
            "updated" => $publication->updated_at,
        ];
        
        return response()->json($publicationData);
    }

    //buscar todos los comentarios de la publicacion:
    
    public function search_pub_comment($id)
    {
        $publication = Publication::with('hashtag', 'sponsor', 'user', 'publicationComments')->find($id);
    
        if (!$publication) {
            return response()->json(['message' => 'No se encontró la publicación con el ID proporcionado.'], 404);
        }
    
        $publicationData = [
            "id" => $publication->id,
            "publication" => $publication->publication,
            "name" => $publication->user->name,
            "image" => $publication->user->image,
            "like" => $publication->like,
            "saved" => $publication->saved,
            "images" => $publication->images,
            "hashtag" => $publication->hashtag->hashtag,
            "created" => $publication->created_at,
            "updated" => $publication->updated_at,
        ];
    

        if ($publication->publicationComments->isNotEmpty()) {

            $publicationData["comments"] = $publication->publicationComments->map(function ($publicationComment) {
                return [
                    "comment" => $publicationComment->comment->comment,
                    "name_comment" => $publicationComment->comment->user->name,
                    "user_image_comment" => $publicationComment->comment->user->image,
                    "image_comment" => $publicationComment->comment->image,
                ];
            });
        }
    
        return response()->json($publicationData);
    }
    

    public function getCommentsForPublication($publicationId)
    {
        $publication = Publication::findOrFail($publicationId);
        $comments = $publication->publicationComments()->with('comment.user')->get()->pluck('comment');

        return response()->json($comments);
    }

    //funcion para buscar publicaciones en perfil
    public function search_pub_profile($userId)
    {
        $publications = Publication::with('hashtag', 'user')
                                ->where('user_id', $userId)->orderBy('created_at', 'desc')
                                ->get();

        if ($publications->isEmpty()) {
            return response()->json(['message' => 'No se encontraron publicaciones para el usuario proporcionado.'], 404);
        }

        $publicationsData = [];

        foreach ($publications as $publication) {
            $publicationData = [
                "id" => $publication->id,
                "publication" => $publication->publication,
                "hashtag" => $publication->hashtag->hashtag,
                "images" => $publication->images,
                "created" => $publication->created_at,
            ];

            $publicationsData[] = $publicationData;
        }

        return response()->json($publicationsData);
    }

//eliminar una publicación
    public function deletePublication($id)
    {

        $comments = PublicationComment::where('publication_id', $id)->get();
        foreach ($comments as $comment) {
            $comment->delete();
        }

        $publication = Publication::findOrFail($id);
        $publication->delete();

        return response()->json([
            'message' => 'Publicación eliminada correctamente'
        ], 200);
    }
}

