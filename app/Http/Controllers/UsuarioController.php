<?php
namespace App\Http\Controllers;


use App\Http\Requests\UsuarioRequest;
use DB;

// Modelos
use App\Models\Usuario;

class UsuarioController extends Controller
{
    /**
     * guarda y modifica los datos del usuario
     */
    public function store(UsuarioRequest $request)
    {
        try{
            DB::beginTransaction();
            // se guarda o actualiza el tweet si existe
            Usuario::updateOrCreate(['id'=>$request['id']],$request->all());
            // se guardan los cambios en la base de datos por medio del commit
            DB::commit();

        }catch(\Exception $e){
            DB::rollback();
            return response()->json("Error al guardar el usuario en la base de datos",422);
        }
    }

    /**
     * consultar usuario
     */
    public function consultarUsuario($id)
    {
        dd($id);
        try{
            $registro = Usuario::find($id);
            return ($registro)? response()->json($registro->toArray(),200): response()->json("No se encontro usuario",200);
        }catch(\Exception $e){
            return response()->json("Error al consultar el usuario",422);
        }
    }
}
