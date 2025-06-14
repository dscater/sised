<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;

class PermisoService
{
    protected $arrayPermisos = [
        "ADMINISTRADOR" => [
            "notificacions.listadoPorUsuario",
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

            "evidencias.api",
            "evidencias.listado",
            "evidencias.index",
            "evidencias.create",
            "evidencias.store",
            "evidencias.edit",
            "evidencias.show",
            "evidencias.update",
            "evidencias.destroy",

            "configuracions.index",
            "configuracions.create",
            "configuracions.edit",
            "configuracions.update",
            "configuracions.destroy",

            "reportes.usuarios",
        ],
        "FORENSE" => [],
        "PERITO" => [],
        "AUDITOR" => [],
        "OBSERVADOR" => [],
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
