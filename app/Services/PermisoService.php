<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;

class PermisoService
{
    protected $arrayPermisos = [
        "ADMINISTRADOR" => [
            "notificacions.listadoPorUsuario",
            "notificacions.api",
            "notificacions.index",
            "notificacions.listado",
            "notificacions.show",

            "usuarios.api",
            "municipios.listado",
            "usuarios.index",
            "usuarios.create",
            "usuarios.store",
            "usuarios.edit",
            "usuarios.show",
            "usuarios.update",
            "usuarios.destroy",
            "usuarios.password",

            "evidencias.visualizar",
            "evidencias.api",
            "evidencias.listado",
            "evidencias.show",
            "evidencias.index",

            "cadena_custodias.api",
            "cadena_custodias.listado",
            "cadena_custodias.index",
            "cadena_custodias.show",
            "cadena_custodias.pdf",
            "cadena_custodias.apiporEvidencia",
            "cadena_custodias.porEvidencia",

            "control_integridads.api",
            "control_integridads.listado",
            "control_integridads.index",
            "control_integridads.create",
            "control_integridads.store",
            "control_integridads.edit",
            "control_integridads.show",
            "control_integridads.ver",
            "control_integridads.update",
            "control_integridads.destroy",

            "configuracions.index",
            "configuracions.create",
            "configuracions.edit",
            "configuracions.update",
            "configuracions.destroy",

            "reportes.usuarios",
            "reportes.r_usuarios",
            "reportes.evidencias",
            "reportes.r_evidencias",
            "reportes.cadena_custodias",
            "reportes.r_cadena_custodias",
            "reportes.control_integridads",
            "reportes.r_control_integridads",
        ],
        "FORENSE" => [
            "notificacions.listadoPorUsuario",
            "notificacions.api",
            "notificacions.index",
            "notificacions.listado",
            "notificacions.show",

            "evidencias.visualizar",
            "evidencias.api",
            "evidencias.listado",
            "evidencias.index",
            "evidencias.create",
            "evidencias.store",
            "evidencias.edit",
            "evidencias.show",
            "evidencias.update",
            "evidencias.destroy",

            "cadena_custodias.api",
            "cadena_custodias.listado",
            "cadena_custodias.index",
            "cadena_custodias.create",
            "cadena_custodias.store",
            "cadena_custodias.edit",
            "cadena_custodias.show",
            "cadena_custodias.pdf",
            "cadena_custodias.update",
            "cadena_custodias.destroy",
            "cadena_custodias.apiporEvidencia",
            "cadena_custodias.porEvidencia",

            "control_integridads.api",
            "control_integridads.listado",
            "control_integridads.index",
            "control_integridads.create",
            "control_integridads.store",
            "control_integridads.edit",
            "control_integridads.show",
            "control_integridads.ver",
            "control_integridads.update",
            "control_integridads.destroy",

            "reportes.evidencias",
            "reportes.r_evidencias",
            "reportes.cadena_custodias",
            "reportes.r_cadena_custodias",
            "reportes.control_integridads",
            "reportes.r_control_integridads",
        ],
        "PERITO" => [
            "notificacions.listadoPorUsuario",
            "notificacions.api",
            "notificacions.index",
            "notificacions.listado",
            "notificacions.show",

            "evidencias.visualizar",
            "evidencias.api",
            "evidencias.listado",
            "evidencias.show",

            "cadena_custodias.api",
            "cadena_custodias.listado",
            "cadena_custodias.index",
            "cadena_custodias.show",
            "cadena_custodias.pdf",
            "cadena_custodias.apiporEvidencia",
            "cadena_custodias.porEvidencia",

            "control_integridads.api",
            "control_integridads.listado",
            "control_integridads.index",
            "control_integridads.create",
            "control_integridads.store",
            "control_integridads.edit",
            "control_integridads.show",
            "control_integridads.ver",
            "control_integridads.update",
            "control_integridads.destroy",

            "reportes.evidencias",
            "reportes.r_evidencias",
            "reportes.cadena_custodias",
            "reportes.r_cadena_custodias",
            "reportes.control_integridads",
            "reportes.r_control_integridads",
        ],
        "AUDITOR" => [
            "notificacions.listadoPorUsuario",
            "notificacions.api",
            "notificacions.index",
            "notificacions.listado",
            "notificacions.show",

            "evidencias.visualizar",
            "evidencias.api",
            "evidencias.listado",
            "evidencias.show",

            "cadena_custodias.api",
            "cadena_custodias.listado",
            "cadena_custodias.index",
            "cadena_custodias.show",
            "cadena_custodias.pdf",
            "cadena_custodias.apiporEvidencia",
            "cadena_custodias.porEvidencia",

            "control_integridads.api",
            "control_integridads.listado",
            "control_integridads.index",
            "control_integridads.create",
            "control_integridads.store",
            "control_integridads.edit",
            "control_integridads.show",
            "control_integridads.ver",
            "control_integridads.update",
            "control_integridads.destroy",

            "reportes.evidencias",
            "reportes.r_evidencias",
            "reportes.cadena_custodias",
            "reportes.r_cadena_custodias",
            "reportes.control_integridads",
            "reportes.r_control_integridads",
        ],
        "OBSERVADOR" => [
            "notificacions.listadoPorUsuario",
            "notificacions.api",
            "notificacions.index",
            "notificacions.listado",
            "notificacions.show",

            "evidencias.visualizar",
            "evidencias.api",
            "evidencias.listado",
            "evidencias.show",

            "control_integridads.api",
            "control_integridads.listado",
            "control_integridads.index",
            "control_integridads.create",
            "control_integridads.store",
            "control_integridads.edit",
            "control_integridads.show",
            "control_integridads.ver",
            "control_integridads.update",
            "control_integridads.destroy",

            "reportes.evidencias",
            "reportes.r_evidencias",
            "reportes.cadena_custodias",
            "reportes.r_cadena_custodias",
            "reportes.control_integridads",
            "reportes.r_control_integridads",
        ],
    ];

    public function getPermisosUser()
    {
        $user = Auth::user();
        $permisos = [];
        if ($user) {
            return $this->arrayPermisos[$user->tipo] ?? [];
        }

        return $permisos;
    }
}
