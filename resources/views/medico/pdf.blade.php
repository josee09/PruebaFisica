<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>EVALUACIÓN-MÉDICA-{{\Carbon\Carbon::parse($medico->create_at)->format('d-m-Y')}}</title>
    <style>
        body {
            position: relative;
        }

        body::after {
            content: ' ';
            display: block;
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            opacity: 0.2;
            background-image: url("{{ public_path('images/img.png') }}");
            background-repeat: no-repeat;
            background-position: center;
        }
    </style>
</head>

<body>

<div class="row">

    <div style="text-align: center; font-size: 14px;">
        <P><strong> HOJA DE CONTENIDO DE GRASA EN EL CUERPO<br>
    </div>
    <div class="row" id="evaluacion">
        <table id="fechas" cellspacing="0" width="100%">
            <thead>
            <tr>
                <td scope="col" style="text-align: center; font-size: 12px;"><strong>LUGAR:</strong>
                    {{ $lugarEvalucion->descripcion }}</td>
                <td scope="col" style="text-align: center; font-size: 12px;"><strong>DÍA:</strong>
                    {{ \Carbon\Carbon::parse($date)->format('d') }}</td>
                <td scope="col" style="text-align: center; font-size: 12px;"><strong>MES:</strong>
                    {{ \Carbon\Carbon::parse($date)->format('m') }}</td>
                <td scope="col" style="text-align: center; font-size: 12px;"><strong>AÑO:</strong>
                    {{ \Carbon\Carbon::parse($date)->format('Y') }}</td>
                <td scope="col" style="text-align: center; font-size: 12px;"><strong>EQUIPO EVALUADOR
                        #:</strong>
                    {{ $medico->equipo }}</td>
            </tr>
            </thead>
        </table>
        <table id="datos1" cellspacing="0" width="100%" style="margin: 0 auto; border: 1px solid black;">
            <thead>
            <tr>
                <th scope="col"
                    style="width: 40%; text-align: center; border: 1px solid black; font-size: 12px;">NOMBRES Y
                    APELLIDOS
                </th>
                <th scope="col"
                    style="width: 30%; text-align: center; border: 1px solid black; font-size: 12px;">
                    GRADO-POLICIAL
                </th>
                <th scope="col"
                    style="width: 30%; text-align: center; border: 1px solid black; font-size: 12px;">SERIE
                </th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td style="width: 40%; text-align: center; border: 1px solid black; font-size: 12px;">
                    {{ $evaluado->nombre }} {{ $evaluado->apellido }}</td>
                <td style="width: 30%; text-align: center; border: 1px solid black; font-size: 12px;">
                    {{ strtoupper($evaluado->grado) }}
                </td>
                <td style="width: 30%; text-align: center; border: 1px solid black; font-size: 12px;">
                    {{ strtoupper($evaluado->chapa) }}
                </td>

            </tr>
            </tbody>
        </table>
        <table id="datos2" cellspacing="0" width="100%" style="margin: 0 auto; border: 1px solid black;">
            <thead>
            <tr>
                <td scope="col"
                    style="width: 40%; text-align: center; border: 1px solid black; font-size: 12px;">
                    No. IDENTIDAD: {{ $evaluado->dni }}</td>
                <td style="width: 60%; text-align: center; border: 1px solid black; font-size: 12px;">
                    PERIODO: {{strtoupper($medico->periodo) }}</td>
            </tr>
            </thead>
        </table>
        <br>
        <table id="medidas" cellspacing="0" width="100%">
            <thead>
            <tr>
                <td scope="col" style="width: 30%; text-align: center; font-size: 12px;"><strong>PRESIÓN
                        ARTERIAL:</strong>
                    {{ $medico->presion }} {{ $medico->presion2 != ''? ', '.$medico->presion2 : '' }} {{ $medico->presion3 != ''? ', '.$medico->presion3 : '' }}
                </td>
                <td scope="col" style="width: 25%; text-align: center; font-size: 12px;"><strong>ALTURA
                        MTS:</strong>
                    {{ $medico->altura }}</td>
                <td scope="col" style="width: 25%;text-align: center; font-size: 12px;"><strong>PESO
                        LB:</strong>
                    {{ $medico->pesoreal }}</td>
                <td scope="col" style="width: 25%; text-align: center; font-size: 12px;"><strong>EDAD:</strong>
                    {{ \Carbon\Carbon::parse($evaluado->fechanac)->age }} AÑOS
                </td>
            </tr>
            </thead>
        </table>
        <table id="datos4" cellspacing="0" width="100%" style="margin: 0 auto; border: 1px solid black;">
            <thead>
            <tr>
                <th style="width: 40%; text-align: center; border: 1px solid black; font-size: 12px;">
                    PASOS
                </th>
                <th style="width: 10%; text-align: center; border: 1px solid black; font-size: 12px;">
                    PRIMERO
                </th>
                <th style="width: 10%; text-align: center; border: 1px solid black; font-size: 12px;">
                    SEGUNDO
                </th>
                <th style="width: 10%; text-align: center; border: 1px solid black; font-size: 12px;">
                    TERCERO
                </th>
                <th style="width: 30%; text-align: center; border: 1px solid black; font-size: 12px;">
                    PROMEDIO 0.25 PULGADAS MÁS CERCANAS
                </th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td style="width: 40%; text-align: left; border: 1px solid black; font-size: 12px;">
                    <strong>1 MEDIDA DEL ABDOMEN</strong><br>(AL NIVEL DEL OBLIGO, 0.25 PULGADAS MÁS CERCANO)
                </td>
                <td style="width:10%; text-align: center; border: 1px solid black; font-size: 12px;"> {{
                            $medico->abdomen }}</td>
                <td style="width:10%; text-align: center; border: 1px solid black; font-size: 12px;"></td>
                <td style="width:10%; text-align: center; border: 1px solid black; font-size: 12px;"></td>
                <td style="width:30%; text-align: center; border: 1px solid black; font-size: 12px;"></td>
            </tr>
            </tbody>
            <tbody>
            <tr>
                <td style="width: 40%; text-align: left; border: 1px solid black; font-size: 12px;">
                    <strong>2 MEDIDA DEL CUELLO</strong><br>(BAJO LA MANZANA DE ADAN AL 0.25 PULGADAS MÁS
                    CERCANA)
                </td>
                <td style="width:10%; text-align: center; border: 1px solid black; font-size: 12px;">{{
                            $medico->cuello }}</td>
                <td style="width:10%; text-align: center; border: 1px solid black; font-size: 12px;"></td>
                <td style="width:10%; text-align: center; border: 1px solid black; font-size: 12px;"></td>
                <td style="width:30%; text-align: center; border: 1px solid black; font-size: 12px;"></td>
            </tr>
            </tbody>
            <tbody>
            <tr>
                <td style="width: 40%; text-align: left; border: 1px solid black; font-size: 12px;">
                    <strong>3 MEDIDA DEL ABDOMEN-CUELLO</strong><br>(CON RESULTADO DEL PASO 3 VAYA AL ANEXO " "
                    Y OBTENGA EL FACTOR)
                </td>
                <td style="width:10%; text-align: center; border: 1px solid black; font-size: 12px;">{{
                            $medico->mediabocue }}</td>
                <td style="width:10%; text-align: center; border: 1px solid black; font-size: 12px;"></td>
                <td style="width:10%; text-align: center; border: 1px solid black; font-size: 12px;"></td>
                <td style="width:30%; text-align: center; border: 1px solid black; font-size: 12px;"></td>
            </tr>
            </tbody>
            <tbody>
            <tr>
                <td style="width: 40%; text-align: left; border: 1px solid black; font-size: 12px;">
                    <strong>4 FACTOR ABDOMEN-CUELLO</strong><br>(CON ESTE RESULTADO DEL PASO 3 VAYA AL ANEXO " "
                    Y OBTENGA EL FACTOR)
                </td>
                <td style="width:10%; text-align: center; border: 1px solid black; font-size: 12px;">{{
                            $medico->factoabdocue }}</td>
                <td style="width:10%; text-align: center; border: 1px solid black; font-size: 12px;"></td>
                <td style="width:10%; text-align: center; border: 1px solid black; font-size: 12px;"></td>
                <td style="width:30%; text-align: center; border: 1px solid black; font-size: 12px;"></td>
            </tr>
            </tbody>
            <tbody>
            <tr>
                <td style="width: 40%; text-align: left; border: 1px solid black; font-size: 12px;">
                    <strong>5 FACTOR ALTURA</strong><br>(CON LA ALTURA MEDIDAA VAYA AL ANEXO " " Y OBTENGA EL
                    FACTOR)
                </td>
                <td style="width:10%; text-align: center; border: 1px solid black; font-size: 12px;">{{
                            $medico->factoaltu }}</td>
                <td style="width:10%; text-align: center; border: 1px solid black; font-size: 12px;"></td>
                <td style="width:10%; text-align: center; border: 1px solid black; font-size: 12px;"></td>
                <td style="width:30%; text-align: center; border: 1px solid black; font-size: 12px;"></td>
            </tr>
            </tbody>
            <tbody>
            <tr>
                <td style="width: 40%; text-align: left; border: 1px solid black; font-size: 12px;">
                    <strong>5 PORCENTAJE DE GRASA EN EL CUELLO</strong><br>(RESTE EL PASO 5 DEL 4, COMPARE EL
                    RESULTADO DE LOS ESTANDARES)
                </td>
                <td style="width:10%; text-align: center; border: 1px solid black; font-size: 12px;">{{
                            $medico->grasa }}</td>
                <td style="width:10%; text-align: center; border: 1px solid black; font-size: 12px;"></td>
                <td style="width:10%; text-align: center; border: 1px solid black; font-size: 12px;"></td>
                <td style="width:30%; text-align: center; border: 1px solid black; font-size: 12px;"></td>
            </tr>
            </tbody>
        </table>
        <br>


        <table id="BIOIMPEDANCIA" cellspacing="0" width="100%"
               style="border-collapse: collapse; border: 1px solid black;">
            <thead>
            <tr>
                <th colspan="3"
                    style="text-align: center; font-size: 14px; font-weight: bold; border: 1px solid black;">
                    DATOS DE BIOIMPEDANCIA
                </th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td style="width: 25%; text-align: center; font-size: 12px; border: 1px solid black;">
                    <strong>SOBREPESO ACTUAL</strong><br>{{ $medico->sa }}
                </td>
                <td style="width: 25%; text-align: center; font-size: 12px; border: 1px solid black;">
                    <strong>SOBREPESO MASA MAGRA</strong><br>{{ $medico->smm }}
                </td>
                <td style="width: 25%; text-align: center; font-size: 12px; border: 1px solid black;">
                    <strong>SOBREPESO REAL POR MASA GRASA </strong><br>{{ $medico->srmg }}
                </td>
                {{--                            <td style="width: 25%; text-align: center; font-size: 12px; border: 1px solid black;">--}}
                {{--                                <strong>GRASA VISCERAL</strong><br>{{ $medico->grasa_visceral }}--}}
                {{--                            </td>--}}
            </tr>
            </tbody>
        </table>
        <br>
        <table id="datos5" cellspacing="0" width="100%" style="margin: 0 auto; border: 1px solid black;">
            <thead>
            <tr>
                <td scope="col"
                    style="width: 70%; text-align: left; border: 1px solid black; font-size: 12px;">
                    <strong>OBSERVACIONES: </strong> CONDICION: {{ $medico->condicion }}
                </td>
                <td scope="col"
                    style="width: 30%; text-align: left; border: 1px solid black; font-size: 12px;">
                    <strong>PESO REAL: </strong>{{ $medico->pesoreal }}
                </td>
            </thead>
            <tbody>
            <tr>
                <td scope="col"
                    style="width: 70%; text-align: left; border: 1px solid black; font-size: 12px;">
                    {{ $medico->observaciones }}
                </td>
                <td scope="col"
                    style="width: 30%; text-align: left; border: 1px solid black; font-size: 12px;">
                    <strong>PESO IDEAL:</strong> {{ $medico->pesoideal }}
                </td>
            </tr>
            </tbody>
            <tbody>
            <tr>
                <td scope="col"
                    style="width: 70%; text-align: left; border: 1px solid black; font-size: 12px;">
                </td>
                <td scope="col"
                    style="width: 30%; text-align: left; border: 1px solid black; font-size: 12px;">
                    @if ($medico->exceso >= 0)
                        <strong>EXCESO DE PESO:</strong> {{ $medico->exceso }}
                    @else
                        <strong>DÉFICIT DE PESO:</strong> {{ ($medico->exceso * -1) }}
                    @endif
                </td>
            </tr>
            <tr>
                <td style="width: 70%; text-align: left; border: 1px solid black; font-size: 12px;">
                </td>
                <td style="width: 30%; text-align: left; font-size: 12px; border: 1px solid rgb(14, 13, 13);">
                    <strong>SOBREPESO REAL GRASA:</strong> {{ $medico->sobrepeso_masa_grasa }}
                </td>
            </tr>
            </tbody>
        </table>


        <p style="font-size: 12px;">ESTOY DE ACUERDO CON MI PESO CORPORAL, REALIZADO ATRAVES DEL MANUAL DE PRUEBA
            FÍSICA VIGENTE PARA EL PERSONAL OPERATIVO DE LA POLICÍA NACIONAL, LA CUAL SUSTENTO CON MI FIRMA
            <strong>(FIRMA DEL EVALUADO)</strong> ___________________________________
        </p>
        <p style="text-align: left;"><strong>EVALUADOR</strong></p>
        <table id="datos5" cellspacing="0" width="100%" style="margin: 0 auto; border: 1px solid black;">
            <thead>
            <tr>
                <th scope="col"
                    style="width: 70%; text-align: center; border: 1px solid black; font-size: 12px;">
                    NOMBRE DEL MÉDICO EVALUADOR
                </th>
                <th scope="col"
                    style="width: 30%; text-align: center; border: 1px solid black; font-size: 12px;">
                    GRADO:
                </th>
                <th scope="col"
                    style="width: 30%; text-align: center; border: 1px solid black; font-size: 12px;">
                    FIRMA Y SELLO:
                </th>
            </thead>
            <tbody>
            <tr>
                <td scope="col"
                    style="width: 70%; text-align: center; border: 1px solid black; font-size: 12px;">{{
                            $medico->medico }}</td>
                <td scope="col"
                    style="width: 30%; text-align: center; border: 1px solid black; font-size: 12px;">
                    {{strtoupper
                    ($medico->grado_policial) }}</td>
                <td scope="col"
                    style="width: 30%; text-align: center; border: 1px solid black; font-size: 12px;"><br><br>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</body>

</html>
