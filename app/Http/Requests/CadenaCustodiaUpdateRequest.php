<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CadenaCustodiaUpdateRequest extends FormRequest
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
            "evidencia_id" => "required",
            "responsable" => "required",
            "cargo" => "required",
            "accion" => "required",
            "destino" => "required",
            "fecha" => "required",
            "hora" => "required",
            "observaciones" => "required",
        ];
    }

    public function messages(): array
    {
        return [
            "evidencia_id.required" => "Debes completar este campo",
            "responsable.required" => "Debes completar este campo",
            "cargo.required" => "Debes completar este campo",
            "accion.required" => "Debes completar este campo",
            "destino.required" => "Debes completar este campo",
            "fecha.required" => "Debes completar este campo",
            "hora.required" => "Debes completar este campo",
            "observaciones.required" => "Debes completar este campo",
        ];
    }
}
