<?php

namespace App\Services;

use App\Models\HistorialAccion;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Jenssegers\Agent\Agent;

class HistorialAccionService
{
    private $descripcion = "EL USUARIO ";
    /**
     * Registrar historial de accion
     *
     * @param string $modulo
     * @param string $accion
     * @param string $descripcion
     * @return void
     */
    public function registrarAccion(string $modulo, string $accion, string $descripcion = "", Model $modelo, Model $modelo_update = null, array $relaciones = []): void
    {
        $user = Auth::user();
        $user_id = $user->id;
        $this->descripcion .= $user->usuario . " " . $descripcion;

        if (!empty($relaciones)) {
            $datos_original = $modelo->loadMissing($relaciones)->makeHidden($modelo->getAppends())->toArray();
        } else {
            $datos_original = $modelo->makeHidden($modelo->getAppends())->toArray();
        }

        $datos = [
            "user_id" => $user_id,
            "accion" => $accion,
            "descripcion" => $this->descripcion,
            'datos_original' => $datos_original,
            'datos_nuevo' => null,
            'modulo' => $modulo
        ];

        if ($modelo_update) {
            $existe_cambios = false;
            //cambios en el modelo
            if ($modelo_update->wasChanged()) {
                $existe_cambios = true;
            }

            //cambios en sus relaciones
            foreach ($relaciones as $relacion) {
                if ($modelo[$relacion]) {
                    $antes = $modelo[$relacion]->toArray();
                    $despues = $modelo_update[$relacion]->toArray();
                    // Log::debug($antes);
                    // Log::debug($despues);
                    if ($antes !== $despues) {
                        $existe_cambios = true;
                        break;
                    }
                }
            }

            // Log::debug($existe_cambios);
            if ($existe_cambios && $modelo_update) {
                // actualizacion
                if (!empty($relaciones)) {
                    $datos["datos_nuevo"] = $modelo_update->loadMissing($relaciones)->makeHidden($modelo_update->getAppends())->toArray();
                } else {
                    $datos["datos_nuevo"] = $modelo_update->makeHidden($modelo_update->getAppends())->toArray();
                }
                $this->crearAccion($datos);
            }
        } else {
            $this->crearAccion($datos);
        }
    }

    private function crearAccion(array $datos): void
    {
        $agent = new Agent();

        $dispositivo = $agent->isMobile() ? 'Móvil' : 'Escritorio'; // Detectar si es móvil o escritorio
        $sistemaOperativo = $agent->platform(); // Obtener el sistema operativo (Ej: Windows, Linux, macOS, iOS, Android)
        $navegador = $agent->browser(); // Obtener el navegador (Ej: Chrome, Firefox, Safari)
        $ip = request()->ip(); // Obtener la IP del usuario

        $desc_sistema = "Equipo " . $dispositivo;
        $desc_sistema .= " - S.O. " . $sistemaOperativo;
        $desc_sistema .= " - Navegador " . $navegador;


        HistorialAccion::create([
            "user_id" => $datos["user_id"],
            "accion" => $datos["accion"],
            "descripcion" => $datos["descripcion"],
            'datos_original' => $datos["datos_original"],
            'datos_nuevo' => $datos["datos_nuevo"],
            'modulo' => $datos["modulo"],
            'fecha' => date('Y-m-d'),
            'hora' => date('H:i:s'),
            "sistema" => $desc_sistema,
            "ip" => $ip
        ]);
    }
}
