<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Cadena de Custodia</title>
    <style type="text/css">
        * {
            font-family: sans-serif;
        }

        @page {
            margin-top: 1.5cm;
            margin-bottom: 1.5cm;
            margin-left: 2cm;
            margin-right: 1.5cm;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
            margin-top: 20px;
            page-break-before: avoid;
        }

        table thead tr th,
        tbody tr td {
            padding: 3px;
            word-wrap: break-word;
        }

        table thead tr th {
            font-size: 8pt;
        }

        table tbody tr td {
            font-size: 7pt;
        }


        .encabezado {
            width: 100%;
        }

        .logo img {
            position: absolute;
            height: 80px;
            top: -20px;
            left: 0px;
        }

        h2.titulo {
            width: 450px;
            margin: auto;
            margin-top: 0PX;
            margin-bottom: 15px;
            text-align: center;
            font-size: 14pt;
        }

        .texto {
            width: 250px;
            text-align: center;
            margin: auto;
            margin-top: 15px;
            font-weight: bold;
            font-size: 1.1em;
        }

        .fecha {
            width: 250px;
            text-align: center;
            margin: auto;
            margin-top: 15px;
            font-weight: normal;
            font-size: 0.85em;
        }

        .total {
            text-align: right;
            padding-right: 15px;
            font-weight: bold;
        }

        table {
            width: 100%;
        }

        table thead {
            background: rgb(236, 236, 236)
        }

        tr {
            page-break-inside: avoid !important;
        }

        .centreado {
            padding-left: 0px;
            text-align: center;
        }

        .datos {
            margin-left: 15px;
            border-top: solid 1px;
            border-collapse: collapse;
            width: 250px;
        }

        .txt {
            font-weight: bold;
            text-align: right;
            padding-right: 5px;
        }

        .txt_center {
            font-weight: bold;
            text-align: center;
        }

        .cumplimiento {
            position: absolute;
            width: 150px;
            right: 0px;
            top: 86px;
        }

        .b_top {
            border-top: solid 1px black;
        }

        .gray {
            background: rgb(245, 245, 245);
            font-weight: bold;
        }

        .bg-principal {
            background: #153f59;
            color: white;
        }

        .txt_rojo {}

        .img_celda img {
            width: 45px;
        }
    </style>
</head>

<body>
    @inject('configuracion', 'App\Models\Configuracion')
    <div class="encabezado">
        <div class="logo">
            <img src="{{ $configuracion->first()->logo_b64 }}">
        </div>
        <h2 class="titulo">
            {{ $configuracion->first()->razon_social }}
        </h2>
        <h4 class="texto">CADENA DE CUSTODIA</h4>
        <h4 class="fecha">Expedido: {{ date('d-m-Y') }}</h4>
    </div>
    <table border="1" style="margin-top: 40px">
        <tbody>
            <tr>
                <td width="15%" class="gray">Código Evidencia</td>
                <td>{{ $evidencia->codigo }}</td>
            </tr>
            <tr>
                <td class="gray">Descripción evidencia</td>
                <td>{{ $evidencia->descripcion }}</td>
            </tr>
            <tr>
                <td class="gray">Nombre del creador</td>
                <td>{{ $evidencia->nombre_creador }}</td>
            </tr>
            <tr>
                <td class="gray">Fecha y hora de Creación</td>
                <td>{{ $evidencia->fecha_hora_creacion_t }}</td>
            </tr>
            <tr>
                <td class="gray">Origen del archivo </td>
                <td>{{ $evidencia->origen_archivo }}</td>
            </tr>
            <tr>
                <td class="gray">Fecha y hora de hallazgo</td>
                <td>{{ $evidencia->fecha_hora_hallazgo_t }}</td>
            </tr>
            <tr>
                <td class="gray">Lugar de recolección</td>
                <td>{{ $evidencia->lugar_recoleccion }}</td>
            </tr>
            <tr>
                <td class="gray">Persona que recolecto</td>
                <td>{{ $evidencia->persona_recolector }}</td>
            </tr>
            <tr>
                <td class="gray">Herramienta utilizada</td>
                <td>{{ $evidencia->herramienta_utilizada }}</td>
            </tr>
        </tbody>
    </table>
    <h4>Cadena de Custodia</h4>
    <table border="1">
        <thead>
            <tr>
                <th width="5%">Nro.</th>
                <th>Responsable</th>
                <th>Cargo</th>
                <th>Acción</th>
                <th>Destino</th>
                <th>Fecha</th>
                <th>Hora</th>
                <th>Observaciones</th>
                <th>Fecha de registro</th>
            </tr>
        </thead>
        <tbody>
            @php
                $cont = 1;
            @endphp
            @foreach ($evidencia->cadena_custodias as $cadena_custodia)
                <tr>
                    <td>{{ $cont++ }}</td>
                    <td>{{ $cadena_custodia->responsable }}</td>
                    <td>{{ $cadena_custodia->cargo }}</td>
                    <td>{{ $cadena_custodia->accion }}</td>
                    <td>{{ $cadena_custodia->destino }}</td>
                    <td>{{ $cadena_custodia->fecha_t }}</td>
                    <td>{{ $cadena_custodia->hora }}</td>
                    <td>{{ $cadena_custodia->observaciones }}</td>
                    <td>{{ $cadena_custodia->fecha_registro_t }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
