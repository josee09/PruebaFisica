<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>EVALUACIÓN-{{ $resultado->evaluacion }}-{{ $resultado->fecha }}</title>
    <style>
        body {
            position: relative;
        }

        {{--        @if($resultado->npesoexc == 'REPROBADO')--}}
        {{--     body::after {--}}
        {{--    content: ' ';--}}
        {{--    display: block;--}}
        {{--    position: absolute;--}}
        {{--    left: 0;--}}
        {{--    top: 0;--}}
        {{--    width: 100%;--}}
        {{--    height: 100%;--}}
        {{--    opacity: 0.2;--}}
        {{--    background-image: url("{{ public_path('images/REPROBADOS.jpg') }}");--}}
        {{--    background-repeat: no-repeat;--}}
        {{--    background-position: center;--}}
        {{--    background-size: cover;--}}
        {{--}--}}
{{--        @else--}}
{{--            body::after {--}}
{{--            content: ' ';--}}
{{--            display: block;--}}
{{--            position: absolute;--}}
{{--            left: 0;--}}
{{--            top: 0;--}}
{{--            width: 100%;--}}
{{--            height: 100%;--}}
{{--            opacity: 0.2;--}}
{{--            background-image: url("{{ public_path('images/img.png') }}");--}}
{{--            background-repeat: no-repeat;--}}
{{--            background-position: center;--}}
{{--        }--}}

{{--        @endif--}}

        .showcase {
            position: relative;
        }

        @if($resultado->npesoexc == 'REPROBADO' || $resultado->estado == 'INCAPACIDAD')
        .bg-image {
            opacity: 0.7;
            width: 100%;
            height: 100%;
            background-size: cover;
        }

        @else
        .bg-image {
            opacity: 0.2;
            width: 100%;
            height: 90%;
            background-repeat: no-repeat;
            background-position: center;
            background-size: contain;
        }

        @endif
        .bg-img-title {
            position: absolute;
            top: 0px;
            left: 0px;
        }
    </style>

</head>

<body>
<div class="showcase">
    @if($resultado->estado == 'REPROBADO')
        <img src="{{ public_path('images/REPROBADOS.jpg') }}" alt="REPROBADO" class="bg-image"/>
    @elseif($resultado->estado == 'INCAPACIDAD')
        <img src="{{ public_path('images/INCAPACIDAD-MEDICA.png') }}" alt="INCAPACIDAD MEDICA" class="bg-image"/>
    @else
{{--        <img src="{{ public_path('images/img.png') }}" alt="LOGO POLICIA" class="bg-image"/>--}}
    @endif
    <div class="row bg-img-title">
        <div style="text-align: center; font-size: 14px;">
            <p>
                <strong>REPÚBLICA DE HONDURAS<br>
                    SECRETARÍA DE ESTADO EN EL DESPACHO DE SEGURIDAD<br>
                    DIECCIÓN GENERAL POLICÍA NACIONAL<br>
                    DIRECCIÓN DE OPERACIONES</strong>
            </p>
            <p><strong> HOJA INDIVIDUAL DE EVALUACIÓN FÍSICA<br>
                    <u>{{ $resultado->evaluacion }}</u></strong></p><br>
        </div>
        <div class="row">
            <table id="fechas" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <td scope="col" style="text-align: center; font-size: 14px;"><strong>DÍA:</strong>
                        {{ \Carbon\Carbon::parse($date)->format('d') }}</td>
                    <td scope="col" style="text-align: center; font-size: 14px;"><strong>MES:</strong>
                        {{ \Carbon\Carbon::parse($date)->format('m') }}</td>
                    <td scope="col" style="text-align: center; font-size: 14px;"><strong>AÑO:</strong>
                        {{ \Carbon\Carbon::parse($date)->format('Y') }}</td>
                </tr>
                </thead>
            </table>
            <br>
            <table id="datos1" cellspacing="0" width="100%" style="margin: 0 auto; border: 1px solid black;">
                <thead>
                <tr>
                    <th scope="col"
                        style="width: 13%; text-align: center; border: 1px solid black; font-size: 14px;">GRADO-POLICIAL
                    </th>
                    <th scope="col"
                        style="width: 49%; text-align: center; border: 1px solid black; font-size: 12px;">NOMBRE
                        Y APELLIDO
                    </th>
                    <th scope="col"
                        style="width: 18%; text-align: center; border: 1px solid black; font-size: 12px;">SERIE
                    </th>
                    <th scope="col"
                        style="width: 10%; text-align: center; border: 1px solid black; font-size: 12px;">SEXO
                    </th>
                    <th scope="col"
                        style="width: 10%; text-align: center; border: 1px solid black; font-size: 12px;">EDAD
                    </th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td style="width: 40%; text-align: center; border: 1px solid black; font-size: 14px;">
                        {{ strtoupper($evaluado->grado) }}</td>
                    <td style="width: 40%; text-align: center; border: 1px solid black; font-size: 14px;">
                        {{ $evaluado->nombre }} {{ $evaluado->apellido }}</td>
                    <td style="width: 12%; text-align: center; border: 1px solid black; font-size: 14px;">
                        {{ strtoupper($evaluado->chapa) }}</td>
                    <td style="width: 12%; text-align: center; border: 1px solid black; font-size: 14px;">
                        {{ strtoupper($evaluado->sexo) }}</td>
                    <td style="width: 8%; text-align: center; border: 1px solid black; font-size: 14px;">
                        {{ \Carbon\Carbon::parse($evaluado->fechanac)->age }}</td>
                </tr>
                </tbody>
            </table>
            <table id="datos2" cellspacing="0" width="100%" style="margin: 0 auto; border: 1px solid black;">
                <thead>
                <tr>
                    <th scope="col"
                        style="width: 31%; text-align: center; border: 1px solid black; font-size: 14px;">UNIDAD
                        DE ASIGNACIÓN:
                    </th>
                    <td style="width: 52%; text-align: center; border: 1px solid black; font-size: 14px;">
                        {{ $evaluado->lugarAsignacion->LUGAR_ASIG ?? $evaluado->lugarasig }}</td>
                    <td style="width: 17%; text-align: center; border: 1px solid black; font-size: 14px;">
                        <strong>ID: </strong>{{ $evaluado->dni }}</td>
                </tr>
                </thead>
            </table>
            <table id="datos3" cellspacing="0" width="100%" style="margin: 0 auto; border: 1px solid black;">
                <thead>
                <tr>
                    <td scope="col"
                        style="width: 27%; text-align: center; border: 1px solid black; font-size: 14px;">
                        <strong>PERIODO: </strong> {{ strtoupper($resultado->periodo) }} </td>
                    <td scope="col"
                        style="width: 60%; text-align: center; border: 1px solid black; font-size: 14px;">
                        <strong>PRUEBA CORRESPONDIENTE AÑO: </strong>{{ $resultado->fecha }}</td>
                </tr>
                </thead>
            </table>
            <table id="datos4" cellspacing="0" width="100%" style="margin: 0 auto; border: 1px solid black;">
                <thead>
                <tr>
                    <th style="width: 36.41%; text-align: center; border: 1px solid black; font-size: 14px;">
                        EVENTOS
                    </th>
                    <th style="width: 60.59%; text-align: center; border: 1px solid black; font-size: 14px;">
                        CANTIDAD
                    </th>
                    <th style="width: 3%; text-align: center; border: 1px solid black; font-size: 14px;">%
                        OBTENIDO
                    </th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td style="width: 27%; text-align: left; border: 1px solid black; font-size: 14px;">
                        FLEXIONES DE BRAZO 2 MIN.
                    </td>
                    <td style="width: 40%; text-align: center; border: 1px solid black; font-size: 14px;">
                        {{ $principal->pechada }}</td>
                    <td style="width: 20%; text-align: center; border: 1px solid black; font-size: 14px;">
                        @if ($resultado->npechada === null)
                            {{-- Campo vacío --}}
                        @else
                            {{ $resultado->npechada }} %
                        @endif
                    </td>
                </tr>
                </tbody>
                <tbody>
                <tr>
                    <td style="width: 27%; text-align: left; border: 1px solid black; font-size: 14px;">
                        FLEXIONES DE ABDOMEN 2 MIN.
                    </td>
                    <td style="width: 40%; text-align: center; border: 1px solid black; font-size: 14px;">
                        {{ $principal->abdominal }}</td>
                    <td style="width: 20%; text-align: center; border: 1px solid black; font-size: 14px;">
                        @if ($resultado->nabdominal === null)
                            {{-- Campo vacío --}}
                        @else
                            {{ $resultado->nabdominal }} %
                        @endif
                    </td>
                </tr>
                </tbody>
                <tbody>
                <tr>
                    <td style="width: 27%; text-align: left; border: 1px solid black; font-size: 14px;">CARRERA
                        CONTINUA 3,200 MTS.
                    </td>
                    <td style="width: 40%; text-align: center; border: 1px solid black; font-size: 14px;">
                        {{ $principal->carrera }}</td>
                    <td style="width: 20%; text-align: center; border: 1px solid black; font-size: 14px;">
                        @if ($resultado->ncarrera === null)
                            {{-- Campo vacío --}}
                        @else
                            {{ $resultado->ncarrera }} %
                        @endif
                    </td>
                </tr>
                </tbody>
                <tbody>
                <tr>
                    <td style="width: 27%; text-align: left; border: 1px solid black; font-size: 14px;">NATACIÓN
                        400 MTS.
                    </td>
                    <td style="width: 40%; text-align: center; border: 1px solid black; font-size: 14px;">
                        @if ($alterno === null)
                            {{-- Campo vacío --}}
                        @elseif (!is_null($alterno))
                            {{ $alterno->natacion }}
                        @endif
                    </td>
                    <td style="width: 20%; text-align: center; border: 1px solid black; font-size: 14px;">
                        @if ($resultado->nnatacion === null)
                            {{-- Campo vacío --}}
                        @elseif (!is_null($resultado->nnatacion))
                            {{ $resultado->nnatacion }} %
                        @endif
                    </td>
                </tr>
                </tbody>
                <tbody>
                <tr>
                    <td style="width: 27%; text-align: left; border: 1px solid black; font-size: 14px;">CAMINATA
                        4,800 MTS.
                    </td>
                    <td style="width: 40%; text-align: center; border: 1px solid black; font-size: 14px;">
                        @if ($alterno === null)
                            {{-- Campo vacío --}}
                        @elseif (!is_null($alterno))
                            {{ $alterno->caminata }}
                        @endif
                    </td>
                    <td style="width: 20%; text-align: center; border: 1px solid black; font-size: 14px;">
                        @if ($resultado->ncaminata === null)
                            {{-- Campo vacío --}}
                        @else
                            {{ $resultado->ncaminata }} %
                        @endif
                    </td>
                </tr>
                </tbody>
                <tbody>
                <tr>
                    <td style="width: 27%; text-align: left; border: 1px solid black; font-size: 14px;">CICLISMO
                        10 KMS.
                    </td>
                    <td style="width: 40%; text-align: center; border: 1px solid black; font-size: 14px;">
                        @if ($alterno === null)
                            {{-- Campo vacío --}}
                        @elseif (!is_null($alterno))
                            {{ $alterno->ciclismo }}
                        @endif
                    </td>
                    <td style="width: 20%; text-align: center; border: 1px solid black; font-size: 14px;">
                        @if ($resultado->nciclismo === null)
                            {{-- Campo vacío --}}
                        @else
                            {{ $resultado->nciclismo }} %
                        @endif
                    </td>
                </tr>
                </tbody>
                <tbody>
                <tr>
                    <td style="width: 27%; text-align: left; border: 1px solid black; font-size: 14px;">BARRAS
                    </td>
                    <td style="width: 40%; text-align: center; border: 1px solid black; font-size: 14px;">
                        @if ($alterno === null)
                            {{-- Campo vacío --}}
                        @elseif (!is_null($alterno))
                            {{ $alterno->barra }}
                        @endif
                    </td>
                    <td style="width: 20%; text-align: center; border: 1px solid black; font-size: 14px;">
                        @if ($resultado->nbarra === null)
                            {{-- Campo vacío --}}
                        @else
                            {{ $resultado->nbarra }} %
                        @endif
                    </td>
                </tr>
                </tbody>
                <tbody>
                <tr>
                    <th scope="col"
                        style="width: 27%; text-align: left; border: 1px solid black; font-size: 14px;">
                        SUB-TOTAL
                    </th>
                    <td style="width: 40%; text-align: center; border: 1px solid black; font-size: 14px;"></td>
                    <td style="width: 20%; text-align: center; border: 1px solid black; font-size: 14px;">
                        {{ $resultado->npromedio }}</td>
                </tr>
                </tbody>
                <tbody>
                <tr>
                    <td style="width: 27%; text-align: left; border: 1px solid black; font-size: 14px;">MENOS
                        LIBRAS DE EXCESO
                    </td>
                    <td style="width: 40%; text-align: center; border: 1px solid black; font-size: 14px;"></td>
                    <td style="width: 20%; text-align: center; border: 1px solid black; font-size: 14px;">
                        {{ $resultado->pesoexc }}</td>
                </tr>
                </tbody>
                <tbody>
                <tr>
                    <th scope="col"
                        style="width: 27%; text-align: left; border: 1px solid black; font-size: 14px;">NOTA
                        FINAL
                    </th>
                    <td style="width: 40%; text-align: center; border: 1px solid black; font-size: 14px;"></td>
                    <td style="width: 20%; text-align: center; border: 1px solid black; font-size: 14px;">
                        {{ $resultado->npesoexc }}</td>
                </tr>
                </tbody>
                <tbody>
                <tr>
                    <th scope="col"
                        style="width: 27%; text-align: left; border: 1px solid black; font-size: 14px;">NOTA
                        FINAL EN LETRAS
                    </th>
                    <td colspan="2"  style="width: 20%; text-align: center; border: 1px solid black; font-size: 14px;">
                        {{ strtoupper(convertirNumeroLetras($resultado->npesoexc)) }}</td>
                </tr>
                </tbody>
            </table>
            <table id="datos5" cellspacing="0" width="100%" style="margin: 0 auto; border: 1px solid black;">
                <thead>
                <tr>
                    <th scope="col"
                        style="width: 40%; text-align: left; border: 1px solid black; font-size: 14px;">
                        OBSERVACIONES: (EN CASO DE PRESCRIPCIÓN MÉDICA, INDIQUE EL CASO Y ADJUNTE
                        DOCUMENTACIÓN)
                    </th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td style="width: 40%; text-align: left; border: 1px solid black; font-size: 14px;">
                        @if ($resultado->obs === null)
                            -
                        @else
                            {{ $resultado->obs }}
                        @endif
                    </td>
                </tr>
                </tbody>
            </table>
            <p style="font-size: 14px;">NOTA: LA EVALUACIÓN DE LOS EJERCICIOS ES INDIVIDUAL, SE APRUEBA CON LA NOTA
                MINIMA DE 70%.
                ESTOY DE ACUERDO CON LOS EJERCICIOS REALIZADOS, TABLA DE EVALUACIÓN, TABLA DE MEDICIÓN DE GRASA EN
                EL CUERPO,
                CON LA QUE ME SOMETÍ A ESTA EVALUACIÓN FÍSICA, PARA DAR FE DE LO MISMO, FIRMO LA PRESENTE.<br><br>
                <strong>(FIRMA DEL EVALUADO)</strong> ___________________________________
            </p><br>
            <p style="text-align: center;"><strong>EVALUADORES</strong></p>
            <table id="datos6" cellspacing="0" width="100%">
                <thead>
                <tr>

                    <th scope="col" style="width: 50%; text-align: center; font-size: 14px;">EVALUADOR
                        1<br><br><br></th>
                    @if ($resultado->evaluador2)
                        <th scope="col" style="width: 50%; text-align: center; font-size: 14px;">EVALUADOR
                            2<br><br><br></th>
                    @endif
                </tr>
                </thead>

                <tbody>
                <tr>

                    <td style="text-align: center; font-size: 14px;"><strong>
                            ______________________________________</strong></td>
                    @if ($resultado->evaluador2)
                        <td style="text-align: center; font-size: 14px;"><strong>
                                ______________________________________</strong></td>
                    @endif
                </tr>
                <tr>
                    <td style="text-align: center; font-size: 14px;">
                        <strong>{{ $resultado->evaluador1 }}</strong><br>
                        {{ $resultado->grado1 }} <!-- Asegúrate de usar la variable correcta para el grado del evaluador 1 -->
                    </td>
                    @if ($resultado->evaluador2)
                        <td style="text-align: center; font-size: 14px;">
                            <strong>{{ $resultado->evaluador2 }}</strong><br>
                            {{strtoupper ($resultado->grado2) }} <!-- Asegúrate de usar la variable correcta para el grado del evaluador 2 -->
                        </td>
                    @endif
                </tr>

                </tbody>
            </table>
            <br><br>
            <table id="datos6" cellspacing="0" width="100%">
                <thead>
                <tr>
                    @if ($resultado->evaluador3)
                        <th scope="col" style="width: 50%; text-align: center; font-size: 14px;">EVALUADOR
                            3<br><br><br></th>
                    @endif
                    @if ($resultado->evaluador4)
                        <th scope="col" style="width: 50%; text-align: center; font-size: 14px;">EVALUADOR
                            4<br><br><br></th>
                    @endif
                </tr>
                </thead>
                <tbody>
                <tr>
                    @if ($resultado->evaluador3)
                        <td style="text-align: center;  font-size: 14px;"><strong>
                                ______________________________________</strong></td>
                    @endif
                    @if ($resultado->evaluador4)
                        <td style="text-align: center; font-size: 14px;"><strong>
                                _______________________________________</strong></td>
                    @endif
                </tr>
                <tr>

                    @if ($resultado->evaluador3)
                        <td style="text-align: center; font-size: 14px;">
                            <strong>{{ $resultado->evaluador3 }}</strong><br>{{ $resultado->grado3 }}</td>
                        {{ $resultado->grado3 }}</td>
                    @endif
                    @if ($resultado->evaluador4)
                        <td style="text-align: center; font-size: 14px;">
                            <strong>{{ $resultado->evaluador4 }}</strong><br>{{ $resultado->grado4 }}</td>
                        {{ $resultado->grado4 }}</td>
                    @endif
                </tr>
                </tbody>
            </table>
            <br><br><br>
            <table id="datos7" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th scope="col" style="width: 100%; text-align: center; font-size: 14px;">OFICIAL JEFE
                        DE EQUIPO EVALUADOR<br><br></th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td style="text-align: center; font-size: 14px;"><strong>
                            ___________________________________</strong></td>
                </tr>
                <tr>
                    <td style="text-align: center; font-size: 14px;">
                        <strong>{{ $resultado->oficialjefe }}</strong><br>{{ $resultado->grado5 }}</td>

                </tr>
                </tbody>
            </table>
            <br>
            <p style="font-size: 14px; text-align: center;"><strong>NOTA: "ES DE CARÁCTER OBLIGATORIO EL NOMBRE Y FIRMA
                    DE
                    LOS MIEMBROS DEL EQUIPO EVALUADOR".</strong>
            </p>
        </div>
    </div>
</div>
</body>

</html>
