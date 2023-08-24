<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Divisione extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function carrera(){
        return $this->hasMany(Carrera::class, 'id');
    }
}
