<?php

namespace App\Http\Controllers;

use App\Models\CadenaCustodia;
use App\Models\ControlIntegridad;
use App\Models\Evidencia;
use App\Models\Publicacion;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{

    public function permisosUsuario(Request $request)
    {
        return response()->JSON([
            "permisos" => Auth::user()->permisos
        ]);
    }

    public function getUser()
    {
        return response()->JSON([
            "user" => Auth::user()
        ]);
    }

    public static function getInfoBoxUser()
    {
        $permisos = [];
        $array_infos = [];
        if (Auth::check()) {
            $oUser = new User();
            $permisos = $oUser->permisos;
            if ($permisos == '*' || (is_array($permisos) && in_array('usuarios.index', $permisos))) {
                $array_infos[] = [
                    'label' => 'USUARIOS',
                    'cantidad' => User::where('id', '!=', 1)->count(),
                    'color' => 'bg-principal',
                    'icon' => "fa-users",
                    "url" => "usuarios.index"
                ];
            }

            if ($permisos == '*' || (is_array($permisos) && in_array('evidencias.index', $permisos))) {
                $evidencias = Evidencia::select("evidencias.id");
                $evidencias->where("status", 1);
                $evidencias = $evidencias->count();

                $array_infos[] = [
                    'label' => 'EVIDENCIAS',
                    'cantidad' => $evidencias,
                    'color' => 'bg-principal',
                    'icon' => "fa-list",
                    "url" => "evidencias.index"
                ];
            }

            if ($permisos == '*' || (is_array($permisos) && in_array('cadena_custodias.index', $permisos))) {
                $cadena_custodias = CadenaCustodia::select("cadena_custodias.id");
                $cadena_custodias->where("status", 1);
                $cadena_custodias = $cadena_custodias->count();

                $array_infos[] = [
                    'label' => 'CADENA DE CUSTODIA',
                    'cantidad' => $cadena_custodias,
                    'color' => 'bg-principal',
                    'icon' => "fa-list",
                    "url" => "cadena_custodias.index"
                ];
            }

            if ($permisos == '*' || (is_array($permisos) && in_array('control_integridads.index', $permisos))) {
                $control_integridads = ControlIntegridad::select("control_integridads.id");
                $control_integridads = $control_integridads->count();

                $array_infos[] = [
                    'label' => 'CONTROL DE INTEGRIDAD',
                    'cantidad' => $control_integridads,
                    'color' => 'bg-principal',
                    'icon' => "fa-list",
                    "url" => "control_integridads.index"
                ];
            }
        }


        return $array_infos;
    }
}
