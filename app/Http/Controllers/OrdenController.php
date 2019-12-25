<?php

namespace App\Http\Controllers;


use DB;
use App\Http\Requests\OrdenRequest;

use App\Models\Orden;
use App\Models\Usuario;

class OrdenController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(OrdenRequest $request)
    {
        try{
            DB::beginTransaction();
            // se guarda o actualiza el tweet si existe
            Orden::updateOrCreate(['id'=>$request['id']],$request->all());
            // se guardan los cambios en la base de datos por medio del commit
            DB::commit();

        }catch(\Exception $e){
            DB::rollback();
            return response()->json("Error al guardar la orden.",422);
        }
    }
    public function listarOrdenes($id){
        try{
            $registro = Usuario::find($id)->ordenes;
            return ($registro)? response()->json($registro->toArray(),200, [], JSON_UNESCAPED_UNICODE): response()->json("No se encontraron ordenes para el usuario",200);
        }catch(\Exception $e){
            return response()->json("Error al listar las ordenes",422);
        }

    }
    public function search($id){
        try{
            $registro = Orden::find($id);
            return ($registro)? response()->json($registro->toArray(),200, [], JSON_UNESCAPED_UNICODE): response()->json("No se encontro la orden",200);
        }catch(\Exception $e){
            return response()->json("Error al buscar la orden",422);
        }
    }
}
