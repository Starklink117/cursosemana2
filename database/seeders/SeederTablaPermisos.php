<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

//Spatie Modelo d Permisos
use Spatie\Permission\Models\Permission;

class SeederTablaPermisos extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
        //Este arreglo contiene todos los permisos
        $permisos = [
                    'ver-usuario','crear-usuario','editar-usuario','borrar-usuario',
                    'ver-rol','crear-rol','editar-rol','borrar-rol',
                    'ver-division','crear-division','editar-division','borrar-division',
                    'ver-carrera','crear-carrera','editar-carrera','borrar-carrera',
                    'ver-estudiante','crear-estudiante','editar-estudiante','borrar-estudiante'
            ];

        //Este foreach agrega todos los permisos de la cadena a la tabla Permission
        foreach($permisos as $permiso){
            Permission::create(['name'=>$permiso]);
        }
    }
}
