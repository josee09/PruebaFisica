<?php

namespace App\Imports;

use App\Models\Evaluado;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\ToModel;

class ExcelImportEvaluado implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Evaluado([
                'nombre' => $row['nombre'],
                'apellido' => $row['apellido'],
                'dni' => $row['dni'],
                'lugarasig' => $row['lugarasig'],
                'serie' => $row['serie'],
                'grado' => $row['grado'],
                'fechanac' => $row['fechanac'],
                'promocion' => $row['promocion'],
                'sexo' => $row['sexo'],
                'categoria' => $row['categoria'],
                'user_id' => $row ['user_id'],
        ]);
    }
}
