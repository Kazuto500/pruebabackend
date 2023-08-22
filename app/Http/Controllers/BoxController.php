<?php

namespace App\Http\Controllers;

use App\Models\Box;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class BoxController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user(); // Obtener el usuario autenticado
        $boxes = Box::where('user_id', $user->id)->get();
        return response()->json(['data' => $boxes]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function store(Request $request)
    {
        // Acceder al usuario autenticado
        $user = Auth::user();

        // Crear una nueva instancia de Box
        $newBox = new Box();
        $newBox->image = $request->input('image');
        $newBox->name = $request->input('name');
        $newBox->description = $request->input('description');

        // Asignar el ID del usuario actual al campo user_id
        $newBox->user_id = $user->id;

        // Guardar la nueva caja en la base de datos
        $newBox->save();

        return response()
            ->json(['data' => $newBox]);
    }

    /**
     * Store a newly created resource in storage.
     */

    public function create()
    {
    }

    /**
     * Display the specified resource.
     */
    public function show(Box $box)
    {
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Box $box)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Box $box)
    {
        // Acceder al usuario autenticado
        $user = Auth::user();

        // Verificar si el box pertenece al usuario autenticado
        if ($box->user_id === $user->id) {
            // Validar los datos recibidos en la solicitud
            $request->validate([
                'image' => 'required',
                'name' => 'required',
                'description' => 'required',
            ]);

            // Actualizar los atributos del box con los datos recibidos
            $box->image = $request->input('image');
            $box->name = $request->input('name');
            $box->description = $request->input('description');

            // Guardar los cambios en la base de datos
            $box->save();

            return response()->json(['data' => $box]);
        } else {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Box $box)
    {
        $box->delete();

        return
            [
                'message' => 'The box was succesfully deleted',
                response()->json(['data' => $box])

            ];
    }
}
