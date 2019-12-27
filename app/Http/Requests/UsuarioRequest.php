<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UsuarioRequest extends BaseFormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    public function withValidator($validation)
    {
        // se crea la url del tweet a partir de la informacion recibida
        $this->merge([
            "id" =>isset($this['id'])? $this['id'] : null,
            'tipo' =>"tecnico",
            "password" => bcrypt($this->password)
        ]);

    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'nombre' => 'required',
            'apellido' => 'required',
            'cedula'  => 'required',
            'usuario'  => 'required',
            'password'  => 'required',
        ];
    }

    public function messages()
    {
        return [
            'nombre.required' => 'El nombre es obligatorio.',
            'apellido.required' => 'El apellido es obligatorio.',
            'cedula.required' => 'La cedula es obligatoria.',
            'usuario.required' => 'El nombre de usuario es obligatorio.',
            'password.required' => 'El password es obligatorio.',
        ];
    }
}
