<?php

namespace App\Http\Controllers;

use App\Models\ControlIntegridad;
use App\Services\ControlIntegridadService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

use Inertia\Inertia;
use Inertia\Response as InertiaResponse;

class ControlIntegridadController extends Controller
{

    public function __construct(private ControlIntegridadService $controlIntegridadService) {}

    /**
     * Listado de controlIntegridads
     *
     * @return JsonResponse
     */
    public function listado(): JsonResponse
    {
        return response()->JSON([
            "controlIntegridads" => $this->controlIntegridadService->listado()
        ]);
    }
    /**
     * Endpoint para obtener la lista de controlIntegridads paginado para datatable
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

        $controlIntegridads = $this->controlIntegridadService->listadoDataTable($length, $start, $page, $search);

        return response()->JSON([
            'data' => $controlIntegridads->items(),
            'recordsTotal' => $controlIntegridads->total(),
            'recordsFiltered' => $controlIntegridads->total(),
            'draw' => intval($request->input('draw')),
        ]);
    }

    /**
     * Página index
     *
     * @return Response
     */
    public function index(): InertiaResponse
    {
        return Inertia::render("Admin/ControlIntegridads/Index");
    }


    /**
     * Página Ver
     *
     * @return Response
     */
    public function ver(ControlIntegridad $control_integridad): InertiaResponse
    {
        return Inertia::render("Admin/ControlIntegridads/Show", compact("control_integridad"));
    }

    /**
     * Página Show
     *
     * @return JsonResponse
     */
    public function show(ControlIntegridad $controlIntegridad): JsonResponse
    {
        return response()->JSON($controlIntegridad->load(["evidencia", "evidencia_archivo"]));
    }
}
