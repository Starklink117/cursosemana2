<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Estudiante extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function user(){
        return $this->belongsTo(User::class, 'id_usuario');
    }

    public function carrera(){
        return $this->belongsTo(Carrera::class, 'id_carrera');
    }
}
