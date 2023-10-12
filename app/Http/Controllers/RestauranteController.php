<?php

namespace App\Http\Controllers;

use App\Models\Restaurante;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RestauranteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // Redireccion al listado de restaurantes
    public function index()
    {
        $restaurantes = Restaurante::all();
        return view('home', compact('restaurantes'));
    }

    // Redireccion al formulario
    public function new() {
        return view('formulario');
    }
    
    // Redireccion al formulario con la instacia del restaurante
    public function edit($id) {
        $restaurante = Restaurante::where('id', $id)->first();
        return view('formulario', compact('restaurante'));
    }

    // Creacion o edicion de un restaurante
    public function store(Request $request, $id = null) {
        // Manejo de errores
        $messages = [
            'nombre.required' => 'El campo nombre es obligatorio',
            'nombre.max' => 'El campo nombre no debe superar los :max caracteres',
            'nombre.min' => 'El campo nombre no debe ser inferior a :min caracteres',

            'direccion.required' => 'El campo dirección es obligatorio',
            'direccion.max' => 'El campo dirección no debe superar los :max caracteres',
            'direccion.min' => 'El campo dirección no debe ser inferior a :min caracteres',

            'telefono.max' => 'El campo teléfono no debe superar los :max caracteres',
        ];

        $validator = Validator::make($request->all(), [
            'nombre' => 'required|max:75|min:3',
            'direccion' => 'required|max:150|min:3',
            'telefono' => 'max:15',
        ]);

        $validator->setCustomMessages($messages);

        if ($validator->fails()) {
            return response()->json([
                'title' => 'Error',
                'error' => $validator->errors()
            ], 400);
        }
     
        try {
            // En caso de que el id sea nula creamos una instancia, de lo contrario buscamos en la BBDD el registro
            if(is_null($id)) {
                $action = "creado";
                $restaurante = new Restaurante();
            }else {
                $action = "actualizado";
                $restaurante = Restaurante::where('id', $id)->first();
            }

            if(is_null($restaurante)) {
                return response()->json([
                    'title' => 'Error',
                    'error' => 'No se ha encontrado el restaurante'
                ], 404);
            }
            
            // Rellenamos los campos 
            $fields = $request->only($restaurante->getFillable());
            $restaurante->fill($fields);
    
            is_null($id) ? $restaurante->save() : $restaurante->update();

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

    // Eliminacion de un restaurante
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
