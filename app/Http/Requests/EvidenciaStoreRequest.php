<?php

namespace App\Http\Requests;

use App\Rules\EvidenciaArchivosRule;
use Illuminate\Foundation\Http\FormRequest;

class EvidenciaStoreRequest extends FormRequest
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
            "codigo" => "required",
            "descripcion" => "required",
            "nombre_creador" => "nullable|string",
            "fecha_creacion" => "required",
            "hora_creacion" => "required",
            "origen_archivo" => "required",
            "fecha_hallazgo" => "required",
            "hora_hallazgo" => "required",
            "lugar_recoleccion" => "required",
            "persona_recolector" => "required",
            "herramienta_utilizada" => "required",
            "archivos" => ["required", new EvidenciaArchivosRule]
        ];
    }

    public function messages(): array
    {
        return [
            "codigo.requried" => "Debes completar este campo",
            "descripcion.requried" => "Debes completar este campo",
            "nombre_creador.requried" => "Debes completar este campo",
            "fecha_creacion.requried" => "Debes completar este campo",
            "hora_creacion.requried" => "Debes completar este campo",
            "origen_archivo.requried" => "Debes completar este campo",
            "fecha_hallazgo.requried" => "Debes completar este campo",
            "hora_hallazgo.requried" => "Debes completar este campo",
            "lugar_recoleccion.requried" => "Debes completar este campo",
            "persona_recolector.requried" => "Debes completar este campo",
            "herramienta_utilizada.requried" => "Debes completar este campo",
            "archivos.required" => "Debes cargar al menos 1 archivo",
        ];
    }
}
