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
                <td>{{ $cadena_custodia->evidencia->codigo }}</td>
            </tr>
            <tr>
                <td class="gray">Descripción evidencia</td>
                <td>{{ $cadena_custodia->evidencia->descripcion }}</td>
            </tr>
            <tr>
                <td class="gray">Responsable</td>
                <td>{{ $cadena_custodia->responsable }}</td>
            </tr>
            <tr>
                <td class="gray">Cargo</td>
                <td>{{ $cadena_custodia->cargo }}</td>
            </tr>
            <tr>
                <td class="gray">Acción realizada</td>
                <td>{{ $cadena_custodia->accion }}</td>
            </tr>
            <tr>
                <td class="gray">Lugar/Destino</td>
                <td>{{ $cadena_custodia->destino }}</td>
            </tr>
            <tr>
                <td class="gray">Fecha y Hora</td>
                <td>{{ $cadena_custodia->fecha_hora_t }}</td>
            </tr>
            <tr>
                <td class="gray">Observaciones</td>
                <td>{{ $cadena_custodia->observaciones }}</td>
            </tr>
            <tr>
                <td class="gray">Fecha de registro</td>
                <td>{{ $cadena_custodia->fecha_registro_t }}</td>
            </tr>
        </tbody>
    </table>
</body>

</html>
