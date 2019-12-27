<?php

namespace App\Http\Controllers;


use DB;
use App\Http\Requests\OrdenRequest;
use Illuminate\Http\Request;

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
        if(Orden::where('orden',$request['orden'])->first() && !$request['id']){
            return response()->json(
                ["mensaje"=>"El numero de orden ya ha sido registrado,
                 por favor seleccione un numero de orden diferente",
                "guardado" => 0],200);
        }
        try{
            // dd($request->all());
            DB::beginTransaction();
            // se guarda o actualiza la orden si existe
            Orden::updateOrCreate(['id'=>$request['id']],$request->all());
            // se guardan los cambios en la base de datos por medio del commit
            DB::commit();
            return response()->json(["mensaje"=>"Orden guardada Exitosamente","guardado" => 1],200);
        }catch(\Exception $e){
            DB::rollback();
            return response()->json("Error al guardar la orden.",422);
        }
    }
    /**
     * funcion utilizada para listar todas las ordenes que tiene asociadas el usuario
     *
     * @param [numerico id del usuario] $id
     * @return void
     */
    public function listarOrdenes($id){
        try{
            $registro = Usuario::find($id)->ordenes;
            return ($registro)? response()->json($registro->toArray(),200, [], JSON_UNESCAPED_UNICODE): response()->json("No se encontraron ordenes para el usuario",200);
        }catch(\Exception $e){
            return response()->json("Error al listar las ordenes",422);
        }
    }
    /**
     * Funcion utilizada para buscar una orden en especifico
     *
     * @param [numerico id de la orden] $id
     * @return void
     */
    public function search($id){
        try{
            $registro = Orden::with('usuario:id,nombre')->find($id);
            return ($registro)? response()->json($registro->toArray(),200, [], JSON_UNESCAPED_UNICODE): response()->json("No se encontro la orden",200);
        }catch(\Exception $e){
            return response()->json("Error al buscar la orden",422);
        }
    }

    public function reporte(Request $request){
        $reporte = Orden::whereBetween('ordenes.created_at',[$request['fechaIni'],$request['fechaFin']])
                        ->join('usuarios', 'usuarios.id', '=', 'ordenes.usuario_id')
                        ->where('ordenes.cliente','LIKE','%'.$request['cliente'])
                        ->where('usuarios.nombre','like','%'.$request['tecnico'])->get();
        return response()->json($reporte->toArray(),200);
    }
}
