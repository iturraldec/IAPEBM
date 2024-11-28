<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmployeePoliceStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'cedula'                => 'required|min:7|max:15|unique:people',
            'rif'                   => 'required|max:20|unique:employees',
            'first_name'            => 'required|max:50',
            'second_name'           => 'max:50',
            'first_last_name'       => 'required|max:50',
            'second_last_name'      => 'max:50',
            'sex'                   => 'required|max:1',
            'birthday'              => 'required|date',
            'place_of_birth'        => 'required|max:255',
            'civil_status_id'       => 'required',
            'blood_type'            => 'required|max:5',
            'codigo_nomina'         => 'required|max:20',
            'fecha_ingreso'         => 'required|date',
            'cargo_id'              => 'required',
            'condicion_id'          => 'required',
            'tipo_id'               => 'required',
            'unidad_id'             => 'required',
            'codigo_patria'         => 'required|max:20',
            'serial_patria'         => 'required|max:20',
            'cta_bancaria_nro'      => 'required|max:30',
            'emails'                => 'required',
            'phones'                => 'required',
            'addresses'             => 'required',
            'family'                => 'required',
            'escuela'               => 'required|max:100',
            'fecha_graduacion'      => 'required|date',
            'curso'                 => 'required|max:10',
            'curso_duracion'        => 'required|max:50',
            'cup'                   => 'required|max:10',
            'rango_id'              => 'required',
            'rango_fecha'           => 'required',
        ];
    }
}