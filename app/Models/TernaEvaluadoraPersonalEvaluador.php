<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 *
 */
class TernaEvaluadoraPersonalEvaluador extends Model
{
    use HasFactory;

    protected $table = 'evaluadores_ternas';

    protected $fillable = [
        "evaluado_id",
        'ternas_evaluadoras_id',
        'tipo_evaluador'
    ];
}
