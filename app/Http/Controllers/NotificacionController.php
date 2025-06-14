<?php

namespace App\Http\Controllers;

use App\Models\Notificacion;
use App\Models\NotificacionUser;
use App\Services\NotificacionService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class NotificacionController extends Controller
{

    public function __construct(private NotificacionService $notificacionService) {}

    /**
     * Notificaciones por usuario
     *
     * @return JsonResponse
     */
    public function listadoPorUsuario(): JsonResponse
    {
        $user = Auth::user();
        $notificacion_users = $user->notificacions()
            ->wherePivot("visto", 0)
            ->orderBy("notificacions.created_at", "desc")
            ->get();
        $sin_ver = count($notificacion_users);
        return response()->JSON([
            "notificacion_users" => $notificacion_users,
            "sin_ver" => $sin_ver,
        ]);
    }

    /**
     * Página index
     *
     * @return Response
     */
    public function index(): InertiaResponse
    {
        return Inertia::render("Admin/Notificacions/Index");
    }

    /**
     * Listado de notificacions
     *
     * @return JsonResponse
     */
    public function listado(): JsonResponse
    {
        return response()->JSON([
            "notificacions" => $this->notificacionService->listado()
        ]);
    }
    /**
     * Endpoint para obtener la lista de notificacions paginado para datatable
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

        $notificacions = $this->notificacionService->listadoDataTable($length, $start, $page, $search);

        return response()->JSON([
            'data' => $notificacions->items(),
            'recordsTotal' => $notificacions->total(),
            'recordsFiltered' => $notificacions->total(),
            'draw' => intval($request->input('draw')),
        ]);
    }

    /**
     * Página Show
     *
     * @return Response
     */
    public function show(Notificacion $notificacion): InertiaResponse
    {
        $notificacionUser = NotificacionUser::where("notificacion_id", $notificacion->id)
            ->where("user_id", Auth::user()->id)
            ->get()->first();
        if ($notificacionUser) {
            $notificacionUser->visto = 1;
            $notificacionUser->save();
        }

        return Inertia::render("Admin/Notificacions/Show", compact($notificacion));
    }
}
