<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LugarAsignacion extends Model
{
    use HasFactory;

    protected $table = 'lugares_asignacion';

    protected $fillable = [
        "name",
        "regional_id"
    ];

    public function evaluados() {
        return $this->hasMany(Evaluado::class);
    }
}
