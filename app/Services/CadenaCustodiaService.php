<?php

namespace App\Services;

use App\Services\HistorialAccionService;
use App\Models\CadenaCustodia;
use App\Models\Evidencia;
use App\Models\Producto;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class CadenaCustodiaService
{
    private $modulo = "CADENA DE CUSTODIA";

    public function __construct(private HistorialAccionService $historialAccionService) {}

    public function listado(): Collection
    {
        $cadena_custodias = CadenaCustodia::select("cadena_custodias.*")->where("status", 1)->get();
        return $cadena_custodias;
    }

    public function listadoDataTable(int $length, int $start, int $page, string $search): LengthAwarePaginator
    {
        // $cadena_custodias = CadenaCustodia::with(["evidencia"])->select("cadena_custodias.*")
        //     ->join("evidencias", "evidencias.id", "=", "cadena_custodias.evidencia_id");
        // if ($search && trim($search) != '') {
        //     $cadena_custodias->where(function ($query) use ($search) {
        //         $query->where("evidencias.codigo", "LIKE", "%$search%")
        //             ->orWhere("cadena_custodias.responsable", "LIKE", "%$search%")
        //             ->orWhere("cadena_custodias.cargo", "LIKE", "%$search%")
        //             ->orWhere("cadena_custodias.accion", "LIKE", "%$search%")
        //             ->orWhere("cadena_custodias.destino", "LIKE", "%$search%")
        //             ->orWhere("cadena_custodias.observaciones", "LIKE", "%$search%");
        //     });
        // }
        // $cadena_custodias->where("evidencias.status", 1);
        // $cadena_custodias = $cadena_custodias->paginate($length, ['*'], 'page', $page);

        $evidencias = Evidencia::with(["cadena_custodias"])->select("evidencias.*")
            ->join("cadena_custodias", "cadena_custodias.evidencia_id", "=", "evidencias.id");
        if ($search && trim($search) != '') {
            $evidencias->where("evidencias.codigo", "LIKE", "%$search%");
        }
        $evidencias->where("evidencias.status", 1);
        $evidencias->distinct("evidencias.id");
        $evidencias = $evidencias->paginate($length, ['*'], 'page', $page);
        return $evidencias;
    }

    public function listadoDataTablePorEvidencia(int $evidencia_id, int $length, int $start, int $page, string $search): LengthAwarePaginator
    {
        $cadena_custodias = CadenaCustodia::with(["evidencia"])->select("cadena_custodias.*")
            ->join("evidencias", "evidencias.id", "=", "cadena_custodias.evidencia_id");
        if ($search && trim($search) != '') {
            $cadena_custodias->where(function ($query) use ($search) {
                $query->where("evidencias.codigo", "LIKE", "%$search%")
                    ->orWhere("cadena_custodias.responsable", "LIKE", "%$search%")
                    ->orWhere("cadena_custodias.cargo", "LIKE", "%$search%")
                    ->orWhere("cadena_custodias.accion", "LIKE", "%$search%")
                    ->orWhere("cadena_custodias.destino", "LIKE", "%$search%")
                    ->orWhere("cadena_custodias.observaciones", "LIKE", "%$search%");
            });
        }
        $cadena_custodias->where("evidencias.id", $evidencia_id);
        $cadena_custodias->where("cadena_custodias.status", 1);
        $cadena_custodias = $cadena_custodias->paginate($length, ['*'], 'page', $page);

        return $cadena_custodias;
    }

    /**
     * Crear cadena_custodia
     *
     * @param array $datos
     * @return CadenaCustodia
     */
    public function crear(array $datos): CadenaCustodia
    {

        $cadena_custodia = CadenaCustodia::create([
            "evidencia_id" => $datos["evidencia_id"],
            "responsable" => mb_strtoupper($datos["responsable"]),
            "cargo" => mb_strtoupper($datos["cargo"]),
            "accion" => mb_strtoupper($datos["accion"]),
            "destino" => mb_strtoupper($datos["destino"]),
            "fecha" => $datos["fecha"],
            "hora" => $datos["hora"],
            "observaciones" => mb_strtoupper($datos["observaciones"]),
            "fecha_registro" => date("Y-m-d")
        ]);
        // registrar accion
        $this->historialAccionService->registrarAccion($this->modulo, "CREACIÓN", "REGISTRO UNA CADENA DE CUSTODIA", $cadena_custodia);

        return $cadena_custodia;
    }

    /**
     * Actualizar cadena_custodia
     *
     * @param array $datos
     * @param CadenaCustodia $cadena_custodia
     * @return CadenaCustodia
     */
    public function actualizar(array $datos, CadenaCustodia $cadena_custodia): CadenaCustodia
    {
        $old_cadena_custodia = CadenaCustodia::find($cadena_custodia->id);
        $cadena_custodia->update([
            "evidencia_id" => $datos["evidencia_id"],
            "responsable" => mb_strtoupper($datos["responsable"]),
            "cargo" => mb_strtoupper($datos["cargo"]),
            "accion" => mb_strtoupper($datos["accion"]),
            "destino" => mb_strtoupper($datos["destino"]),
            "fecha" => $datos["fecha"],
            "hora" => $datos["hora"],
            "observaciones" => mb_strtoupper($datos["observaciones"]),
        ]);
        // registrar accion
        $this->historialAccionService->registrarAccion($this->modulo, "MODIFICACIÓN", "ACTUALIZÓ UNA CADENA DE CUSTODIA", $old_cadena_custodia, $cadena_custodia);

        return $cadena_custodia;
    }

    /**
     * Eliminar cadena_custodia
     *
     * @param CadenaCustodia $cadena_custodia
     * @return boolean
     */
    public function eliminar(CadenaCustodia $cadena_custodia): bool
    {
        // no eliminar cadena_custodias predeterminados para el funcionamiento del sistema
        $old_cadena_custodia = clone $cadena_custodia;
        $cadena_custodia->status = 0;
        $cadena_custodia->save();

        // registrar accion
        $this->historialAccionService->registrarAccion($this->modulo, "ELIMINACIÓN", "ELIMINÓ UNA CADENA DE CUSTODIA", $old_cadena_custodia);

        return true;
    }
}
