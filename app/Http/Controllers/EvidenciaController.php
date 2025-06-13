<?php

namespace App\Http\Controllers;

use App\Http\Requests\EvidenciaStoreRequest;
use App\Http\Requests\EvidenciaUpdateRequest;
use App\Models\Evidencia;
use App\Services\EvidenciaService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use Inertia\Response as InertiaResponse;

class EvidenciaController extends Controller
{
    public function __construct(private EvidenciaService $evidenciaService) {}

    /**
     * Página index
     *
     * @return Response
     */
    public function index(): InertiaResponse
    {
        return Inertia::render("Admin/Evidencias/Index");
    }

    /**
     * Listado de evidencias
     *
     * @return JsonResponse
     */
    public function listado(): JsonResponse
    {
        return response()->JSON([
            "evidencias" => $this->evidenciaService->listado()
        ]);
    }

    /**
     * Listado de evidencias para portal
     *
     * @return JsonResponse
     */
    public function listadoPaginado(Request $request): JsonResponse
    {
        $perPage = $request->perPage;
        $page = (int)($request->input("page", 1));
        $search = (string)$request->input("search", "");
        $precioDesde = $request->precioDesde;
        $precioHasta = $request->precioHasta;
        $categoria_id = $request->categoria_id;
        $orderByCol = $request->orderByCol;
        $desc = $request->desc;

        $columnsSerachLike = ["nombre"];
        $columnsFilter = [
            "publicar" => "SI",
            "vendido" =>  0,
        ];
        $columnsBetweenFilter = [
            "costo_contado" => [$precioDesde, $precioHasta]
        ];

        $arrayOrderBy = [];
        if ($orderByCol && $desc) {
            $arrayOrderBy = [
                [$orderByCol, $desc]
            ];
        }

        $evidencias = $this->evidenciaService->listadoPaginado($perPage, $page, $search, $columnsSerachLike, $columnsFilter, $columnsBetweenFilter, $arrayOrderBy);
        return response()->JSON([
            "total" => $evidencias->total(),
            "evidencias" => $evidencias->items(),
            "lastPage" => $evidencias->lastPage()
        ]);
    }

    /**
     * Endpoint para obtener la lista de evidencias paginado para datatable
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function api(Request $request): JsonResponse
    {

        $length = (int)$request->input('length', 10); // Valor de `length` enviado por DataTable
        $start = (int)$request->input('start', 0); // Índice de inicio enviado por DataTable
        $page = (int)(($start / $length) + 1); // Cálculo de la página actual
        $search = (string)$request->input('search', '');

        $usuarios = $this->evidenciaService->listadoDataTable($length, $start, $page, $search);

        return response()->JSON([
            'data' => $usuarios->items(),
            'recordsTotal' => $usuarios->total(),
            'recordsFiltered' => $usuarios->total(),
            'draw' => intval($request->input('draw')),
        ]);
    }

    /**
     * Registrar un nuevo evidencia
     *
     * @param EvidenciaStoreRequest $request
     * @return RedirectResponse|Response
     */
    public function store(EvidenciaStoreRequest $request): RedirectResponse|Response
    {
        DB::beginTransaction();
        try {
            // crear el Evidencia
            $this->evidenciaService->crear($request->validated());
            DB::commit();
            return redirect()->route("evidencias.index")->with("bien", "Registro realizado");
        } catch (\Exception $e) {
            DB::rollBack();
            throw ValidationException::withMessages([
                'error' =>  $e->getMessage(),
            ]);
        }
    }

    /**
     * Mostrar un evidencia
     *
     * @param Evidencia $evidencia
     * @return JsonResponse
     */
    public function show(Evidencia $evidencia): JsonResponse
    {
        return response()->JSON($evidencia->load(["archivos"]));
    }

    public function update(Evidencia $evidencia, EvidenciaUpdateRequest $request)
    {
        DB::beginTransaction();
        try {
            // actualizar evidencia
            $this->evidenciaService->actualizar($request->validated(), $evidencia);
            DB::commit();
            return redirect()->route("evidencias.index")->with("bien", "Registro actualizado");
        } catch (\Exception $e) {
            DB::rollBack();
            // Log::debug($e->getMessage());
            throw ValidationException::withMessages([
                'error' =>  $e->getMessage(),
            ]);
        }
    }

    /**
     * Eliminar evidencia
     *
     * @param Evidencia $evidencia
     * @return JsonResponse|Response
     */
    public function destroy(Evidencia $evidencia): JsonResponse|Response
    {
        DB::beginTransaction();
        try {
            $this->evidenciaService->eliminar($evidencia);
            DB::commit();
            return response()->JSON([
                'sw' => true,
                'message' => 'El registro se eliminó correctamente'
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            throw ValidationException::withMessages([
                'error' =>  $e->getMessage(),
            ]);
        }
    }
}
