<?php

namespace App\Http\Controllers;

use App\Models\Empleado;
use Illuminate\Http\Request;

class EmpleadoController extends Controller
{
   
    public function index()
    {
        $empleados = Empleado::latest()->paginate(10);
        return view('empleados.index', compact('empleados'));
    }

    public function create()
    {
        return view('empleados.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'identidad'     => 'required|digits:13|unique:empleados,identidad',
            'nombre'        => 'required|string|max:255',
            'cargo'         => 'required|string|max:100',
            'salario'       => 'required|numeric|min:0',
            'fecha_ingreso' => 'required|date',
        ]);

        Empleado::create($request->all());

        return redirect()->route('empleados.index')
                         ->with('success', '¡Empleado registrado exitosamente en Ferretería La Bendición!');
    }

    public function show(Empleado $empleado)
    {
        return redirect()->route('empleados.edit', $empleado);
    }

    public function edit(Empleado $empleado)
    {
        return view('empleados.edit', compact('empleado'));
    }

    public function update(Request $request, Empleado $empleado)
    {
        $request->validate([
            'identidad'     => 'required|digits:13|unique:empleados,identidad,' . $empleado->id,
            'nombre'        => 'required|string|max:255',
            'cargo'         => 'required|string|max:100',
            'salario'       => 'required|numeric|min:0',
            'fecha_ingreso' => 'required|date',
        ]);

        $empleado->update($request->all());

        return redirect()->route('empleados.index')
                         ->with('success', '¡Expediente de empleado actualizado correctamente!');
    }

    public function destroy(Empleado $empleado)
    {
        $empleado->delete();

        return redirect()->route('empleados.index')
                         ->with('success', '¡Empleado retirado de la nómina oficial!');
    }

}
