<?php

namespace App\Http\Controllers;

use App\Models\Carrera;
use Illuminate\Http\Request;

//Agregamos el modelo de Divisione
use App\Models\Divisione;


class CarreraController extends Controller
{

    //El controlador verifica  si el usuario tiene los permisos adecuados para realizar esas acciones.
    public function __construct()
    {
        $this->middleware('permission:ver-carrera|crear-carrera|editar-carrera|borrar-carrera', ['only'=>['index']]);
        $this->middleware('permission:crear-carrera', ['only'=>['create','store']]);
        $this->middleware('permission:editar-carrera',['only'=>['edit','update']]);
        $this->middleware('permission:borrar-carrera',  ['only'=>['destroy']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Obtiene todas las carreras de la base de datos
        $carreras = Carrera::all();
        // Retorna la vista 'carreras.index' y pasa las carreras como datos
        return view('carreras.index', compact('carreras'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Obtiene todas las divisiones para usarlas en el formulario de creación
        $division = Divisione::pluck('nombre', 'id')->all();
        // Retorna la vista 'carreras.create' y pasa las divisiones como datos
        return view('carreras.create', compact('division'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validar el formulario de entrada, asegurando que el campo 'nombre' sea requerido y único en la tabla 'carreras'.
        request()->validate([
            'nombre' => 'required|unique:carreras,nombre',
            'id_division' => 'required',
        ]);
        // Crear un nuevo registro de 'Carrera' con los datos proporcionados en la solicitud.
        Carrera::create($request->all());
        // Redirigir al usuario a la vista de índice de carreras después de crear con éxito.
        return redirect()->route('carreras.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Carrera $carrera)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Carrera $carrera)
    {
        // Obtiene todas las divisiones para usarlas en el formulario de edición
        $division = Divisione::pluck('nombre', 'id')->all();
        // Retorna la vista 'carreras.edit' y pasa la carrera a editar y las divisiones como datos
        return view('carreras.edit', compact('carrera', 'division'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Carrera $carrera)
    {
        // Validar el formulario de entrada, asegurando que el campo 'nombre' sea requerido y único en la tabla 'carreras', excluyendo la carrera actual.
        request()->validate([
            'nombre' => 'required|unique:carreras,nombre,' .$carrera->id,
            'id_division' => 'required',
        ]);
        // Actualizar los datos de la carrera actual con los datos proporcionados en la solicitud.
        $carrera->update($request->all());
    
        // Redirigir al usuario a la vista de índice de carreras después de la actualización exitosa.
        return redirect()->route('carreras.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Carrera $carrera)
    {
        // Elimina la instancia de 'Carrera' proporcionada como argumento.
        $carrera->delete();
        // Redirige al usuario a la vista de índice de carreras después de la eliminación exitosa.
        return redirect()->route('carreras.index');
    }
    
}
