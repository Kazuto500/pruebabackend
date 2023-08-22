<?php

namespace App\Http\Controllers;

use App\Models\Steps;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StepsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($box, $power)
    {
        $user = Auth::user(); // Obtener el usuario autenticado
        $powers = Steps::where('user_id', $user->id)->where('box_id', $box)->where('power_id', $power)->get();
        return response()->json(['data' => $powers]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $box, $power)
    {
        // Obtener el ID del usuario autenticado
        $user = Auth::user();

        // Crear una nueva instancia de Power
        $newStep = new Steps();
        $newStep->name = $request->input('name');
        $newStep->description = $request->input('description');
        $newStep->user_id = $user->id; // Asignar el ID del usuario
        $newStep->box_id = $box;
        $newStep->power_id = $power;    // ID del box capturado de la ruta
        $newStep->save();

        return response()->json(['data' => $newStep]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Steps $steps)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Steps $steps)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $box, $power, $step)
    {
        // Obtener el ID del usuario autenticado
        $user = Auth::user();

        // Buscar el Step que se va a actualizar
        $stepToUpdate = Steps::where('box_id', $box)
            ->where('power_id', $power)
            ->where('id', $step)
            ->where('user_id', $user->id)
            ->first();

        if (!$stepToUpdate) {
            return response()->json(['message' => 'Step not found'], 404);
        }

        // Actualizar los campos del Step
        $stepToUpdate->name = $request->input('name');
        $stepToUpdate->description = $request->input('description');
        $stepToUpdate->save();

        return response()->json(['data' => $stepToUpdate]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($box, $power, $step)
    {
        // Obtener el ID del usuario autenticado
        $user = Auth::user();

        // Buscar el Step que se va a eliminar
        $stepToDelete = Steps::where('box_id', $box)
            ->where('power_id', $power)
            ->where('id', $step)
            ->where('user_id', $user->id)
            ->first();

        if (!$stepToDelete) {
            return response()->json(['message' => 'Step not found'], 404);
        }

        // Eliminar el Step
        $stepToDelete->delete();

        return response()->json(['message' => 'Step deleted']);
    }
}
