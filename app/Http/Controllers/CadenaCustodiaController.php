<?php

namespace App\Http\Controllers;

use App\Http\Requests\CadenaCustodiaStoreRequest;
use App\Http\Requests\CadenaCustodiaUpdateRequest;
use App\Models\CadenaCustodia;
use App\Models\Evidencia;
use App\Services\CadenaCustodiaService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use Inertia\Response as InertiaResponse;
use PDF;

class CadenaCustodiaController extends Controller
{
    public function __construct(private CadenaCustodiaService $cadena_custodiaService) {}

    /**
     * Página index
     *
     * @return Response
     */
    public function index(): InertiaResponse
    {
        return Inertia::render("Admin/CadenaCustodias/Index");
    }

    /**
     * Página porEvidencia
     *
     * @return Response
     */
    public function porEvidencia(Evidencia $evidencia): InertiaResponse
    {
        $evidencia = $evidencia->load(["cadena_custodias"]);
        return Inertia::render("Admin/CadenaCustodias/PorEvidencia", compact("evidencia"));
    }

    /**
     * Listado de cadena_custodias
     *
     * @return JsonResponse
     */
    public function listado(): JsonResponse
    {
        return response()->JSON([
            "cadena_custodias" => $this->cadena_custodiaService->listado()
        ]);
    }

    /**
     * Listado de cadena_custodias para portal
     *
     * @return JsonResponse
     */
    public function listadoPortal(): JsonResponse
    {
        return response()->JSON([
            "cadena_custodias" => $this->cadena_custodiaService->listado()
        ]);
    }

    /**
     * Endpoint para obtener la lista de cadena_custodias paginado para datatable
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

        $evidencias = $this->cadena_custodiaService->listadoDataTable($length, $start, $page, $search);

        return response()->JSON([
            'data' => $evidencias->items(),
            'recordsTotal' => $evidencias->total(),
            'recordsFiltered' => $evidencias->total(),
            'draw' => intval($request->input('draw')),
        ]);
    }

    /**
     * Endpoint para obtener la lista de cadena_custodias paginado para datatable
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function apiporEvidencia(Request $request, Evidencia $evidencia): JsonResponse
    {

        $length = (int)$request->input('length', 10); // Valor de `length` enviado por DataTable
        $start = (int)$request->input('start', 0); // Índice de inicio enviado por DataTable
        $page = (int)(($start / $length) + 1); // Cálculo de la página actual
        $search = (string)$request->input('search', '');

        $evidencias = $this->cadena_custodiaService->listadoDataTablePorEvidencia($evidencia->id, $length, $start, $page, $search);

        return response()->JSON([
            'data' => $evidencias->items(),
            'recordsTotal' => $evidencias->total(),
            'recordsFiltered' => $evidencias->total(),
            'draw' => intval($request->input('draw')),
        ]);
    }

    /**
     * Registrar un nuevo cadena_custodia
     *
     * @param CadenaCustodiaStoreRequest $request
     * @return RedirectResponse|Response
     */
    public function store(CadenaCustodiaStoreRequest $request): RedirectResponse|Response
    {
        DB::beginTransaction();
        try {
            // crear el CadenaCustodia
            $this->cadena_custodiaService->crear($request->validated());
            DB::commit();
            return redirect()->route("cadena_custodias.index")->with("bien", "Registro realizado");
        } catch (\Exception $e) {
            DB::rollBack();
            throw ValidationException::withMessages([
                'error' =>  $e->getMessage(),
            ]);
        }
    }

    /**
     * Mostrar un cadena_custodia
     *
     * @param CadenaCustodia $cadena_custodia
     * @return JsonResponse
     */
    public function show(CadenaCustodia $cadena_custodia): JsonResponse
    {
        return response()->JSON($cadena_custodia);
    }

    public function pdf(Evidencia $evidencia)
    {
        $pdf = PDF::loadView('reportes.cadena_custodia', compact('evidencia'))->setPaper('letter', 'portrait');

        // ENUMERAR LAS PÁGINAS USANDO CANVAS
        $pdf->output();
        $dom_pdf = $pdf->getDomPDF();
        $canvas = $dom_pdf->get_canvas();
        $alto = $canvas->get_height();
        $ancho = $canvas->get_width();
        $canvas->page_text($ancho - 90, $alto - 25, "Página {PAGE_NUM} de {PAGE_COUNT}", null, 9, array(0, 0, 0));

        return $pdf->stream('cadena_custodia.pdf');
    }

    public function update(CadenaCustodia $cadena_custodia, CadenaCustodiaUpdateRequest $request)
    {
        DB::beginTransaction();
        try {
            // actualizar cadena_custodia
            $this->cadena_custodiaService->actualizar($request->validated(), $cadena_custodia);
            DB::commit();
            return redirect()->route("cadena_custodias.index")->with("bien", "Registro actualizado");
        } catch (\Exception $e) {
            DB::rollBack();
            // Log::debug($e->getMessage());
            throw ValidationException::withMessages([
                'error' =>  $e->getMessage(),
            ]);
        }
    }

    /**
     * Eliminar cadena_custodia
     *
     * @param CadenaCustodia $cadena_custodia
     * @return JsonResponse|Response
     */
    public function destroy(CadenaCustodia $cadena_custodia): JsonResponse|Response
    {
        DB::beginTransaction();
        try {
            $this->cadena_custodiaService->eliminar($cadena_custodia);
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
