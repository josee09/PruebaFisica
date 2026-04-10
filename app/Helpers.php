<?php

function convertirNumeroLetras($numero)
{
    $numero = (float)$numero;
    $entero = (int)$numero;
    $decimal = round($numero - $entero, 2); // Redondear el decimal a dos lugares después del punto decimal
    $letras = '';

    if ($entero <= 100) {
        $letras .= numerosLetras($entero);
        if($decimal > 0.0){
            $letras .= ' punto ';
            $decimal *= 100;
            $decimal = (int)$decimal;
            $letras .= numerosLetras($decimal);
        }
        $letras .= ' PORCIENTO';
        return $letras;
    } else {
        return 'Número fuera de rango (0-100)';
    }
}

function numerosLetras($numero)
{
    $unidades = array(
        0 => 'cero', 1 => 'uno', 2 => 'dos', 3 => 'tres', 4 => 'cuatro', 5 => 'cinco',
        6 => 'seis', 7 => 'siete', 8 => 'ocho', 9 => 'nueve', 10 => 'diez',
        11 => 'once', 12 => 'doce', 13 => 'trece', 14 => 'catorce', 15 => 'quince',
        16 => 'dieciséis', 17 => 'diecisiete', 18 => 'dieciocho', 19 => 'diecinueve'
    );

    $decenas = array(
        20 => 'veinte', 30 => 'treinta', 40 => 'cuarenta', 50 => 'cincuenta',
        60 => 'sesenta', 70 => 'setenta', 80 => 'ochenta', 90 => 'noventa'
    );

    $centenas = array(
        100 => 'cien', 200 => 'doscientos', 300 => 'trescientos', 400 => 'cuatrocientos',
        500 => 'quinientos', 600 => 'seiscientos', 700 => 'setecientos', 800 => 'ochocientos',
        900 => 'novecientos'
    );

    if ($numero < 20) {
        return $unidades[$numero];
    } elseif ($numero < 100) {
        $unidad = $numero % 10;
        $decena = $numero - $unidad;
        if ($unidad == 0) {
            return $decenas[$decena];
        } else {
            return $decenas[$decena] . ' y ' . $unidades[$unidad];
        }
    } elseif ($numero < 1000) {
        $unidad = $numero % 10;
        $decena = ($numero % 100) - $unidad;
        $centena = $numero - $decena - $unidad;

        if ($decena == 0 && $unidad == 0) {
            return $centenas[$centena];
        } elseif ($decena == 0) {
            return $centenas[$centena] . ' ' . $unidades[$unidad];
        } elseif ($unidad == 0) {
            return $centenas[$centena] . ' ' . $decenas[$decena];
        } else {
            return $centenas[$centena] . ' ' . $decenas[$decena] . ' y ' . $unidades[$unidad];
        }
    } else {
        return 'Número fuera de rango';
    }
}
