<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrdenRequest extends BaseFormRequest
{

    public function withValidator($validation)
    {
        $this->merge([
            "id" =>isset($this['id'])? $this['id'] : null,
            "articulos"=>json_encode($this->items)
        ]);

    }
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'orden' => 'required',
            'cliente' => 'required',
            'usuario_id'  => 'required',
        ];
    }

    public function messages()
    {
        return [
            'orden.required' => 'El numero de orden es requerido.',
            'cliente.required' => 'La identificacion del cliente es requerida.',
            'usuario_id.required' => 'El tecnico asociado a la orden es requerido .',
        ];
    }
}
