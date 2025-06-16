<?php

namespace App\Http\Controllers;

use App\Models\CadenaCustodia;
use App\Models\Cliente;
use App\Models\Configuracion;
use App\Models\ControlIntegridad;
use App\Models\Evidencia;
use App\Models\HistorialOferta;
use App\Models\Publicacion;
use App\Models\PublicacionDetalle;
use App\Models\SubastaCliente;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use PDF;
use Carbon\Carbon;

class ReporteController extends Controller
{
    public function usuarios()
    {
        return Inertia::render("Admin/Reportes/Usuarios");
    }

    public function r_usuarios(Request $request)
    {
        $tipo =  $request->tipo;
        $sucursal_id =  $request->sucursal_id;
        $usuarios = User::select("users.*")
            ->where('id', '!=', 1);

        if ($tipo != 'todos') {
            $request->validate([
                'tipo' => 'required',
            ]);
            $usuarios->where('tipo', $tipo);
        }
        $usuarios = $usuarios->orderBy("paterno", "ASC")->get();

        $pdf = PDF::loadView('reportes.usuarios', compact('usuarios'))->setPaper('legal', 'landscape');

        // ENUMERAR LAS PÁGINAS USANDO CANVAS
        $pdf->output();
        $dom_pdf = $pdf->getDomPDF();
        $canvas = $dom_pdf->get_canvas();
        $alto = $canvas->get_height();
        $ancho = $canvas->get_width();
        $canvas->page_text($ancho - 90, $alto - 25, "Página {PAGE_NUM} de {PAGE_COUNT}", null, 9, array(0, 0, 0));

        return $pdf->stream('usuarios.pdf');
    }

    public function evidencias()
    {
        return Inertia::render("Admin/Reportes/Evidencias");
    }

    public function r_evidencias(Request $request)
    {
        $fecha_ini =  $request->fecha_ini;
        $fecha_fin =  $request->fecha_fin;
        $evidencias = Evidencia::select("evidencias.*");
        if ($fecha_ini && $fecha_fin) {
            $evidencias->whereBetween("fecha_registro", [$fecha_ini, $fecha_fin]);
        }
        $evidencias = $evidencias->orderBy("codigo", "ASC")->get();

        $pdf = PDF::loadView('reportes.evidencias', compact('evidencias'))->setPaper('legal', 'landscape');

        // ENUMERAR LAS PÁGINAS USANDO CANVAS
        $pdf->output();
        $dom_pdf = $pdf->getDomPDF();
        $canvas = $dom_pdf->get_canvas();
        $alto = $canvas->get_height();
        $ancho = $canvas->get_width();
        $canvas->page_text($ancho - 90, $alto - 25, "Página {PAGE_NUM} de {PAGE_COUNT}", null, 9, array(0, 0, 0));

        return $pdf->stream('evidencias.pdf');
    }

    public function cadena_custodias()
    {
        return Inertia::render("Admin/Reportes/CadenaCustodias");
    }

    public function r_cadena_custodias(Request $request)
    {
        $evidencia_id =  $request->evidencia_id;
        $fecha_ini =  $request->fecha_ini;
        $fecha_fin =  $request->fecha_fin;
        $cadena_custodias = CadenaCustodia::select("cadena_custodias.*");

        if ($evidencia_id != 'todos') {
            $request->validate([
                'evidencia_id' => 'required',
            ]);
            $cadena_custodias->where('evidencia_id', $evidencia_id);
        }

        if ($fecha_ini && $fecha_fin) {
            $cadena_custodias->whereBetween("fecha_registro", [$fecha_ini, $fecha_fin]);
        }

        $cadena_custodias = $cadena_custodias->get();

        $pdf = PDF::loadView('reportes.cadena_custodias', compact('cadena_custodias'))->setPaper('legal', 'landscape');

        // ENUMERAR LAS PÁGINAS USANDO CANVAS
        $pdf->output();
        $dom_pdf = $pdf->getDomPDF();
        $canvas = $dom_pdf->get_canvas();
        $alto = $canvas->get_height();
        $ancho = $canvas->get_width();
        $canvas->page_text($ancho - 90, $alto - 25, "Página {PAGE_NUM} de {PAGE_COUNT}", null, 9, array(0, 0, 0));

        return $pdf->stream('cadena_custodias.pdf');
    }

    public function control_integridads()
    {
        return Inertia::render("Admin/Reportes/ControlIntegridads");
    }

    public function r_control_integridads(Request $request)
    {
        $evidencia_id =  $request->evidencia_id;
        $fecha_ini =  $request->fecha_ini;
        $fecha_fin =  $request->fecha_fin;
        $control_integridads = ControlIntegridad::select("control_integridads.*");

        if ($evidencia_id != 'todos') {
            $request->validate([
                'evidencia_id' => 'required',
            ]);
            $control_integridads->where('evidencia_id', $evidencia_id);
        }

        if ($fecha_ini && $fecha_fin) {
            $control_integridads->whereBetween("fecha_registro", [$fecha_ini, $fecha_fin]);
        }

        $control_integridads = $control_integridads->get();

        $pdf = PDF::loadView('reportes.control_integridads', compact('control_integridads'))->setPaper('legal', 'landscape');

        // ENUMERAR LAS PÁGINAS USANDO CANVAS
        $pdf->output();
        $dom_pdf = $pdf->getDomPDF();
        $canvas = $dom_pdf->get_canvas();
        $alto = $canvas->get_height();
        $ancho = $canvas->get_width();
        $canvas->page_text($ancho - 90, $alto - 25, "Página {PAGE_NUM} de {PAGE_COUNT}", null, 9, array(0, 0, 0));

        return $pdf->stream('control_integridads.pdf');
    }
}
