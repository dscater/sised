<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;

class PermisoService
{
    protected $arrayPermisos = [
        "ADMINISTRADOR" => [
            "usuarios.api",
            "usuarios.index",
            "usuarios.create",
            "usuarios.edit",
            "usuarios.destroy",

            "evidencias.api",
            "evidencias.index",
            "evidencias.create",
            "evidencias.edit",
            "evidencias.destroy",

            "configuracions.index",
            "configuracions.create",
            "configuracions.edit",
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
