<?php

namespace App\Services;

use App\Models\CadenaCustodia;
use App\Models\ControlIntegridad;
use App\Models\Preventa;
use App\Services\HistorialAccionService;
use App\Models\Evidencia;
use App\Models\EvidenciaArchivo;
use App\Models\Venta;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class EvidenciaService
{
    private $modulo = "EVIDENCIAS";

    public function __construct(private HistorialAccionService $historialAccionService, private EvidenciaArchivoService $evidenciaArchivoService) {}

    public function listado(): Collection
    {
        $evidencias = Evidencia::with(["archivos"])
            ->select("evidencias.*")
            ->where("status", 1)
            ->get();
        return $evidencias;
    }

    /**
     * Lista de evidencias paginado con filtros
     *
     * @param integer $length
     * @param integer $page
     * @param string $search
     * @param array $columnsSerachLike
     * @param array $columnsFilter
     * @return LengthAwarePaginator
     */
    public function listadoPaginado(int $length, int $page, string $search, array $columnsSerachLike = [], array $columnsFilter = [], array $columnsBetweenFilter = [], array $orderBy = []): LengthAwarePaginator
    {
        $evidencias = Evidencia::with(["archivos"])
            ->select("evidencias.*");

        $evidencias->where("status", 1);

        // Filtros exactos
        foreach ($columnsFilter as $key => $value) {
            if (!is_null($value)) {
                $evidencias->where("evidencias.$key", $value);
            }
        }

        // Filtros por rango
        foreach ($columnsBetweenFilter as $key => $value) {
            if (isset($value[0], $value[1])) {
                $evidencias->whereBetween("evidencias.$key", $value);
            }
        }

        // Búsqueda en múltiples columnas con LIKE
        if (!empty($search) && !empty($columnsSerachLike)) {
            $evidencias->where(function ($query) use ($search, $columnsSerachLike) {
                foreach ($columnsSerachLike as $col) {
                    $query->orWhere("evidencias.$col", "LIKE", "%$search%");
                }
            });
        }

        // Ordenamiento
        foreach ($orderBy as $value) {
            if (isset($value[0], $value[1])) {
                $evidencias->orderBy($value[0], $value[1]);
            }
        }


        $evidencias = $evidencias->paginate($length, ['*'], 'page', $page);
        return $evidencias;
    }


    public function listadoDataTable(int $length, int $start, int $page, string $search): LengthAwarePaginator
    {
        $evidencias = Evidencia::with(["archivos"])->select("evidencias.*");
        if ($search && trim($search) != '') {
            $evidencias->where("nombre", "LIKE", "%$search%");
        }
        $evidencias->where("status", 1);

        $evidencias = $evidencias->paginate($length, ['*'], 'page', $page);
        return $evidencias;
    }

    /**
     * Crear evidencia
     *
     * @param array $datos
     * @return Evidencia
     */
    public function crear(array $datos): Evidencia
    {

        $evidencia = Evidencia::create([
            "codigo" => mb_strtoupper($datos["codigo"]),
            "descripcion" => mb_strtoupper($datos["descripcion"]),
            "nombre_creador" => mb_strtoupper($datos["nombre_creador"]),
            "fecha_creacion" => $datos["fecha_creacion"],
            "hora_creacion" => $datos["hora_creacion"],
            "origen_archivo" => mb_strtoupper($datos["origen_archivo"]),
            "fecha_hallazgo" => $datos["fecha_hallazgo"],
            "hora_hallazgo" => $datos["hora_hallazgo"],
            "lugar_recoleccion" => mb_strtoupper($datos["lugar_recoleccion"]),
            "persona_recolector" => mb_strtoupper($datos["persona_recolector"]),
            "herramienta_utilizada" => mb_strtoupper($datos["herramienta_utilizada"]),
            "fecha_registro" => date("Y-m-d")
        ]);

        // registrar archivos
        if (!empty($datos["archivos"])) {
            $this->evidenciaArchivoService->guardarArchivosEvidencia($datos["archivos"], $evidencia);
        }

        // registrar accion
        $this->historialAccionService->registrarAccion($this->modulo, "CREACIÓN", "REGISTRO UNA EVIDENCIA", $evidencia, null, ["archivos"]);

        return $evidencia;
    }

    /**
     * Actualizar evidencia
     *
     * @param array $datos
     * @param Evidencia $evidencia
     * @return Evidencia
     */
    public function actualizar(array $datos, Evidencia $evidencia): Evidencia
    {
        $old_evidencia = clone $evidencia;
        $evidencia->update([
            "codigo" => mb_strtoupper($datos["codigo"]),
            "descripcion" => mb_strtoupper($datos["descripcion"]),
            "nombre_creador" => mb_strtoupper($datos["nombre_creador"]),
            "fecha_creacion" => $datos["fecha_creacion"],
            "hora_creacion" => $datos["hora_creacion"],
            "origen_archivo" => mb_strtoupper($datos["origen_archivo"]),
            "fecha_hallazgo" => $datos["fecha_hallazgo"],
            "hora_hallazgo" => $datos["hora_hallazgo"],
            "lugar_recoleccion" => mb_strtoupper($datos["lugar_recoleccion"]),
            "persona_recolector" => mb_strtoupper($datos["persona_recolector"]),
            "herramienta_utilizada" => mb_strtoupper($datos["herramienta_utilizada"]),
        ]);

        // actualizar archivos
        if (!empty($datos["archivos"])) {
            foreach ($datos["archivos"] as $key => $imagen) {
                if ($imagen["id"] == 0) {
                    $this->evidenciaArchivoService->guardarArchivoEvidencia($evidencia, $imagen["file"], $key);
                }
            }
        }

        // archivos eliminados
        if (!empty($datos["eliminados"])) {
            foreach ($datos["eliminados"] as $key => $eliminado) {
                $evidenciaArchivo = EvidenciaArchivo::find($eliminado);
                if ($evidenciaArchivo) {
                    $this->evidenciaArchivoService->eliminarArchivoEvidencia($evidenciaArchivo);
                }
            }
        }

        // registrar accion
        $this->historialAccionService->registrarAccion($this->modulo, "MODIFICACIÓN", "ACTUALIZÓ UNA EVIDENCIA", $evidencia, $old_evidencia, ["archivos"]);

        return $evidencia;
    }

    /**
     * Eliminar evidencia
     *
     * @param Evidencia $evidencia
     * @return boolean
     */
    public function eliminar(Evidencia $evidencia): bool
    {
        // verificar usos
        $usos = CadenaCustodia::where("evidencia_id", $evidencia->id)->get();
        if (count($usos) > 0) {
            throw ValidationException::withMessages([
                'error' =>  "No es posible eliminar este registro porque esta siendo utilizado por otros registros",
            ]);
        }
        $usos = ControlIntegridad::where("evidencia_id", $evidencia->id)->get();
        if (count($usos) > 0) {
            throw ValidationException::withMessages([
                'error' =>  "No es posible eliminar este registro porque esta siendo utilizado por otros registros",
            ]);
        }

        $old_evidencia = clone $evidencia;
        $evidencia->status = 0;
        $evidencia->save();

        // registrar accion
        $this->historialAccionService->registrarAccion($this->modulo, "ELIMINACIÓN", "ELIMINÓ UNA EVIDENCIA", $evidencia, $old_evidencia, ["archivos"]);

        return true;
    }
}
