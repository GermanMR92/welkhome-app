<?php

namespace App\Http\Controllers;

use App\Models\Restaurante;
use Illuminate\Http\Request;

class RestauranteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $restaurantes = Restaurante::all();
        return view('home', compact('restaurantes'));
    }

    public function new() {
        return view('formulario');
    }
    
    public function edit($id) {
        $restaurante = Restaurante::where('id', $id)->first();
        return view('formulario', compact('restaurante'));
    }

    public function store(Request $request, $id = null) {
        // dd($request->all(), $id);
        try {
            if(is_null($id)) {
                $action = "creado";
                $restaurante = new Restaurante();
            }else {
                $action = "actualizado";
                $restaurante = Restaurante::where('id', $id)->first();
            }
            
            $fields = $request->only($restaurante->getFillable());
            $restaurante->fill($fields);
    
            is_null($id) ? $restaurante->save() : $restaurante->update();

            // return redirect()->route('home');
            return response()->json([
                'title' => ucfirst($action),
                'message' => 'Se ha '. $action .' el registro correctamente'
            ], 200);
            
        } catch (\Exception $e) {
            return response()->json([
                'title' => 'Error',
                'message' => 'Ha ocurrido un error'
            ], 500);
        }
    }

    public function destroy($id) {
        try {
            $restaurante = Restaurante::find($id);

            if(is_null($restaurante)) {
                return response()->json([
                    'title' => 'Error',
                    'error' => 'No se ha encontrado el restaurante'
                ], 404);
            }

            $restaurante->delete();

            return response()->json([
                'title' => '¡Eliminado!',
                'message' => 'Se ha eliminado el registro correctamente'
            ], 200);
            
        } catch (\Exception $e) {
            return response()->json([
                'title' => 'Error',
                'error' => 'Ha ocurrido un error'
            ], 500);
        }
    }
}
