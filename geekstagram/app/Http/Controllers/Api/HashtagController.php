<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Hashtag;

class HashtagController extends Controller
{
    public function item($id) {

        $hashtags = Hashtag::where('id','=',$id)->first();

        $object = [
            "id" => $hashtags->id,
            "hashtag" => $hashtags->hashtag,
            "created" => $hashtags->created_at,
            "updated" => $hashtags->updated_at
        ];

        return response()->json($object);
    }

    public function list() {

        $hashtags = Hashtag::all();
        $list = [];

        foreach($hashtags as $hashtag) {
            $object = [
                "id" => $hashtag->id,
                "hashtag" => $hashtag->hashtag,
                "created" => $hashtag->created_at,
                "updated" => $hashtag->updated_at
            ];
            array_push($list, $object);
        }

        return response()->json($list);
    }

    public function create(Request $request){

        $data = $request->validate([
            'hashtag' => 'required | min:1 | max:20',
        ]);

        $hashtag = Hashtag::create([
            'hashtag'=> $data['hashtag']
        ]);

        if($hashtag){
            return response()->json([
                'message' => 'Su consulta es la siguiente: ',
                'info' => $hashtag
            ]);
        }else{
            return response()->json([
                'message' => 'Error al crear los datos'
            ]);
        }
    }

    public function update(Request $request) {
        
        $data = $request->validate([
            'hashtag' => 'required | min:1 | max:20',
        ]);

        $hashtag = Hashtag::where('id', '=', $request->id)->first();

        if($hashtag) {

            $old = $hashtag;
            
            $hashtag-> hashtag = $data['hashtag'];

            if($hashtag->save()){

                $object = [

                    "response" => 'El item ha sido modificado correctamente.',
                    "old" => $old,
                    "new" => $brand
                ];

                return response()->json($object);
            }
        else {

            $object = [

                "response" => 'Error: Ocurrió un error, prueba de nuevo.',
            ];

            return response()->json($object);
        }
        } else {

            $object = [

                "response" => 'Error. Elemento no encontrado.',
            ];

            return response()->json($object);
        }
    }
//Funcion para buscar los datos del usuario logeado
    public function search($searched) {

        $hashtags = Hashtag::where('hashtag', 'like', '%' . $searched . '%')->get();
    
        if ($hashtags->isEmpty()) {
            return response()->json(['message' => 'No se encontraron hashtags que coincidan con el término de búsqueda proporcionado.']);
        }

        $resultArray = [];
    
        foreach ($hashtags as $hashtag) {
            $object = [
                "id" => $hashtag->id,
                "hashtag" => $hashtag->hashtag,
                "created" => $hashtag->created_at,
                "updated" => $hashtag->updated_at
            ];
            $resultArray[] = $object;
        }
        return response()->json($resultArray);
    }

//Busca un perfil específico con un nombre dado
    public function search_g($searched) {

        $hashtags = Hashtag::where('hashtag', 'like', '%' . $searched . '%')->get();
    
        if ($hashtags->isEmpty()) {
            return response()->json(['message' => 'No se encontraron hashtags que coincidan con el término de búsqueda proporcionado.']);
        }
        
        $resultArray = [];
    
        foreach ($hashtags as $hashtag) {
            $object = [
                "id" => $hashtag->id,
                "hashtag" => $hashtag->hashtag,
                "created" => $hashtag->created_at,
                "updated" => $hashtag->updated_at
            ];
            $resultArray[] = $object;
        }
        return response()->json($resultArray);
    }
}