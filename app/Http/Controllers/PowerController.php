<?php

namespace App\Http\Controllers;

use App\Models\Power;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PowerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($box)
    {
        $user = Auth::user(); // Obtener el usuario autenticado
        $powers = Power::where('user_id', $user->id)->where('box_id', $box)->get();
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
    public function store(Request $request, $box)
    {
        // Obtener el ID del usuario autenticado
        $user = Auth::user();

        // Crear una nueva instancia de Power
        $newPower = new Power();
        $newPower->image = $request->input('image');
        $newPower->name = $request->input('name');
        $newPower->description = $request->input('description');
        $newPower->user_id = $user->id; // Asignar el ID del usuario
        $newPower->box_id = $box;     // ID del box capturado de la ruta
        $newPower->created_date = now()->toDateString();
        $newPower->save();

        return response()->json(['data' => $newPower]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Power $power)
    {
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Power $power)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $box, $power)
    {
        // Obtener el ID del usuario autenticado
        $user = Auth::user();

        // Buscar el Power que se va a actualizar
        $powerToUpdate = Power::where('box_id', $box)
            ->where('id', $power)
            ->where('user_id', $user->id)
            ->first();

        if (!$powerToUpdate) {
            return response()->json(['message' => 'Power not found'], 404);
        }

        // Actualizar los campos del Power
        $powerToUpdate->image = $request->input('image');
        $powerToUpdate->name = $request->input('name');
        $powerToUpdate->description = $request->input('description');
        $powerToUpdate->save();

        return response()->json(['data' => $powerToUpdate]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($box, $power)
    {
        // Obtener el ID del usuario autenticado
        $user = Auth::user();

        // Buscar el Power que se va a eliminar
        $powerToDelete = Power::where('box_id', $box)
            ->where('id', $power)
            ->where('user_id', $user->id)
            ->first();

        if (!$powerToDelete) {
            return response()->json(['message' => 'Power not found'], 404);
        }

        // Eliminar el Power
        $powerToDelete->delete();

        return response()->json(['message' => 'Power deleted']);
    }
}
