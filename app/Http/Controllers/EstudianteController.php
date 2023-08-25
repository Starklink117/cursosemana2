<?php

namespace App\Http\Controllers;


use App\Models\Estudiante;
use Illuminate\Http\Request;

//Agreagmos el Modelo de Usuario y Carrera
use App\Models\User;
use App\Models\Carrera;

class EstudianteController extends Controller
{


    public function __construct()
    {
        $this->middleware('permission:ver-estudiante|crear-estudiante|editar-estudiante|borrar-estudiante')->only('index');
        $this->middleware('permission:crear-estudiante', ['only'=>['create','store']]);
        $this->middleware('permission:editar-estudiante', ['only'=>['edit','update']]);
        $this->middleware('permission:borrar-estudiante',  ['only'=>['destroy']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Obtiene todos los estudiantes de la base de datos
        $estudiantes = Estudiante::all();
        // Retorna la vista 'estudiante.index' y pasa los estudiantes como datos
        return view('estudiante.index', compact('estudiantes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Obtiene todos los usuarios y carreras para usarlos en el formulario de creación
        $usuario = User::pluck('name', 'id')->all();
        $carrera = Carrera::pluck('nombre', 'id')->all();
        // Retorna la vista 'estudiante.create' y pasa usuarios y carreras como datos
        return view('estudiante.create', compact('usuario', 'carrera'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validar el formulario de entrada, asegurando que varios campos sean requeridos y únicos en la tabla 'estudiantes'.
        request()->validate([
            'nombre' => 'required',
            'matricula' => 'required|unique:estudiantes,nombre',
            'apellidopaterno' => 'required',
            'apellidomaterno' => 'required',
            'correo' => 'required|email|unique:estudiantes,correo',
            'id_usuario' => 'required',
            'id_carrera' => 'required'
        ]);
        // Crear un nuevo registro de 'Estudiante' con los datos proporcionados en la solicitud.
        Estudiante::create($request->all());
        // Redirigir al usuario a la vista de índice de profesores después de crear con éxito.
        return redirect()->route('profesores.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Estudiante $estudiante)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Estudiante $estudiante)
    {
        // Obtiene todos los usuarios y carreras para usarlos en el formulario de edición
        $usuario = User::pluck('name', 'id')->all();
        $carrera = Carrera::pluck('nombre', 'id')->all();
        // Retorna la vista 'estudiante.create' y pasa el estudiante a editar, usuarios y carreras como datos
        return view('estudiante.create', compact('estudiante', 'usuario', 'carrera'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Estudiante $estudiante)
    {
        // Validar el formulario de entrada, asegurando que varios campos sean requeridos y únicos en la tabla 'estudiantes', excluyendo el estudiante actual.
        request()->validate([
            'nombre' => 'required',
            'matricula' => 'required|unique:estudiantes,nombre,' . $estudiante->id,
            'apellidopaterno' => 'required',
            'apellidomaterno' => 'required',
            'correo' => 'required|email|unique:estudiantes,correo,' . $estudiante->id,
            'id_usuario' => 'required',
            'id_carrera' => 'required'
        ]);
        // Actualizar los datos del estudiante actual con los datos proporcionados en la solicitud.
        $estudiante->update($request->all());
        // Redirigir al usuario a la vista de índice de estudiantes después de la actualización exitosa.
        return redirect()->route('estudiante.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Estudiante $estudiante)
    {
        // Elimina la instancia de 'Estudiante' proporcionada como argumento.
        $estudiante->delete();
        // Redirige al usuario a la vista de índice de estudiantes después de la eliminación exitosa.
        return redirect()->route('estudiante.index');
    }
}
