<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Sponsor;

class SponsorController extends Controller
{
    public function item($id) {

        $sponsors = Sponsor::where('id','=',$id)->first();

        $object = [
            "id" => $sponsors->id,
            "company" => $sponsors->company,
            "product_name" => $sponsors->product_name,
            "price" => $sponsors->price,
            "created" => $sponsors->created_at,
            "updated" => $sponsors->updated_at
        ];

        return response()->json($object);
    }

    public function list() {

        $sponsors = Sponsor::all();
        $list = [];

        foreach($sponsors as $sponsor) {
            $object = [
                "id" => $sponsors->id,
                "company" => $sponsors->company,
                "product_name" => $sponsors->product_name,
                "price" => $sponsors->price,
                "created" => $sponsors->created_at,
                "updated" => $sponsors->updated_at
            ];
            array_push($list, $object);
        }

        return response()->json($list);
    }

    public function create(Request $request){


        $data = $request->validate([
            'company' => 'required | min:2 | max:40',
            'product_name' => 'required | min:2 | max:40',
            'price' => 'required | min:0'
        ]);

        $sponsor = Sponsors::create([
            'company' => $data['company'],
            'product_name' => $data['product_name'],
            'price' => $data['price']
        ]);

        if($sponsor){
            return response()->json([
                'message' => 'Los datos ingresado son los siguientes: ',
                'info' => $sponsor
            ]);
        }else{
            return response()->json([
                'message' => 'Error al crear los datos'
            ]);
        }
    }
}
