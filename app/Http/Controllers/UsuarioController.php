<?php
namespace App\Http\Controllers;


use App\Http\Requests\UsuarioRequest;
use App\Http\Requests\LoginRequest;

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
        if(Usuario::where('usuario',$request['usuario'])->first()){
            return response()->json(["mensaje"=>"Nombre de usuario no disponible, elija otro","guardado" => 0],200);
        }
        try{
            DB::beginTransaction();
            // se guarda o actualiza el tweet si existe
            Usuario::updateOrCreate(['id'=>$request['id']],$request->all());
            // se guardan los cambios en la base de datos por medio del commit
            DB::commit();
            return response()->json(["mensaje"=>"usuario guardado exitosamente","guardado" => 1],200);
        }catch(\Exception $e){
            DB::rollback();
            return response()->json("Error al guardar el usuario en la base de datos",422);
        }
    }

    /**
     * consultar usuario
     */
    public function consultarUsuario(LoginRequest $request)
    {
        try{
            $registro = Usuario::where('usuario',$request['usuario'])->first(['id','nombre','apellido','password']);
            if (\Hash::check($request['password'], $registro['password']))
            {
                $datos = [
                    "id" => $registro->id,
                    "nombre" => $registro->nombre,
                    "apellido" => $registro->apellido
                ];
                return response()->json(array_merge($datos,["usuario" =>1]),200);
            }
            return response()->json(["usuario" => 0, "mensaje" => "No se encontro usuario"],200);
        }catch(\Exception $e){
            return response()->json("Error al consultar el usuario",422);
        }
    }
}
