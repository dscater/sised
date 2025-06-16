<?php

namespace App\Services;

use App\Models\ControlIntegridad;
use App\Models\EvidenciaArchivo;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Pagination\LengthAwarePaginator;

class ControlIntegridadService
{
    public function __construct() {}

    public function listado(): Collection
    {
        $control_integridads = ControlIntegridad::with(["evidencia"])->select("control_integridads.*")->get();
        return $control_integridads;
    }

    public function listadoDataTable(int $length, int $start, int $page, string $search): LengthAwarePaginator
    {
        $control_integridads = ControlIntegridad::with(["evidencia"])->select("control_integridads.*")
            ->join("evidencias", "evidencias.id", "=", "control_integridads.evidencia_id");
        if ($search && trim($search) != '') {
            $control_integridads->where(function ($query) use ($search) {
                $query->where("evidencias.codigo", "LIKE", "%$search%")
                    ->orWhere("control_integridads.encriptado_original", "LIKE", "%$search%")
                    ->orWhere("control_integridads.encriptado_alteracion", "LIKE", "%$search%");
            });
        }
        $control_integridads = $control_integridads->paginate($length, ['*'], 'page', $page);
        return $control_integridads;
    }
}
