<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tutos;
use Validator;
use Illuminate\Support\Facades\DB;

class TutosController extends Controller
{
    //
    public function store(Request $request, $id)
    {
        $validator = Validator::make($request->all(),[
            "titre" => "required|string",
            "contenu" => "required|string|regex:#[a-z]#"
            ]
        );

        if($validator->fails()){
            return response()->json($validator->errors(), 401);       
        }

        $tutos = Tutos::create([
            "user_id" => $id,
            "titre" => $request->input("titre"),
            "contenu" => $request->input("contenu")
        ]);
        return response()->json(["message" => "tuto cree"], 201);;
    }

    public function index()
    {
        return Tutos::all();
    }

    public function search(Request $request, $search)
    {
        if($search !== "-"){
            if($request->input("date") === "croissant"){
                return DB::select("SELECT * FROM `tutos` WHERE filtre_recherche(REPLACE('$search', '-', ' '), CONCAT(`titre`, ' ', transformation_objet(`contenu`))) = 10 ORDER BY `created_at` ASC ");
            }else if($request->input("date") === "decroissant"){
                return DB::select("SELECT * FROM `tutos` WHERE filtre_recherche(REPLACE('$search', '-', ' '), CONCAT(`titre`, ' ', transformation_objet(`contenu`))) = 10 ORDER BY `created_at` DESC ");
            }else{
                return DB::select("SELECT * FROM `tutos` WHERE filtre_recherche(REPLACE('$search', '-', ' '), CONCAT(`titre`, ' ', transformation_objet(`contenu`))) = 10 ");
            }
        }else{
            if($request->input("date") === "croissant"){
                return DB::select("SELECT * FROM `tutos` ORDER BY `created_at` ASC ");
            }else if($request->input("date") === "decroissant"){
                return DB::select("SELECT * FROM `tutos` ORDER BY `created_at` DESC ");
            }else{
                return DB::select("SELECT * FROM `tutos` ");
            }
        }
    }

    public function show($id)
    {
        $tutos = Tutos::findOrFail($id);
        return $tutos;
    }

    public function update(Request $request, $id)
    {
        $userIdRequete = intval($request->input("user_id"));

        $tutos = Tutos::firstWhere('id','=',$id);

        $userIdUpdate = $tutos->user_id;

        $validator = Validator::make($request->all(),[
            "titre" => "required|string",
            "contenu" => "required|string|regex:#[a-z]#"
            ]
        );

        if($validator->fails()){
            return response()->json($validator->errors(), 401);       
        }

        if($userIdRequete === $userIdUpdate){
            $tutos->update([
                "titre" => $request->input("titre"),
                "contenu" => $request->input("contenu")
            ]);
            return response()->json(["message" => "modifier"], 201);  
        }else{
            return response()->json(["message" => "echec modification"], 401);  
        }

    }

    public function destroy(Request $request, $id)
    {
        $userIdRequete = intval($request->input("user_id"));
        $tutos = Tutos::firstWhere('id','=',$id);
        $userIdUpdate = $tutos->user_id;

        if($userIdRequete === $userIdUpdate){
            $tutos->delete();
            return response()->json(["message" => "supprimer"], 201);  
        }else{
            return response()->json(["message" => "echec suppression"], 401);  
        }
    }

    public function mesTutos($id)
    {
        return DB::select("SELECT * FROM `tutos` WHERE `user_id` = '$id' ");
    }
}
