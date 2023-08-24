<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Carrera extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function estudiante(){
        return $this->hasMany(Estudiante::class, 'id');
    }

    public function division(){
        return $this->belongsTo(Divisione::class, 'id_division');
    }
}
