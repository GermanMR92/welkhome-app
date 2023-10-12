@extends('layouts.app')

@section('content')
    <div class="container">
        {{-- <form action="/restaurante/store/{{ $restaurante->id }}" method="put"> --}}
        <form id="restaurante-form">

            <input type="hidden" id="restauranteId" value="{{@$restaurante->id}}">

            <div class="form-group mb-3">
                <label class="" for="nombre">Nombre:</label>
                <input class="form-control" type="text" id="nombre" name="nombre" value="{{ @$restaurante->nombre }}" >
            </div>
            
            <div class="form-group mb-3">
                <label class="" for="direccion">Dirección:</label>
                <input class="form-control" type="text" id="direccion" name="direccion" value="{{ @$restaurante->direccion }}" >
            </div>

            <div class="form-group mb-3">
                <label class="" for="telefono">Teléfono:</label>
                <input class="form-control" type="tel" id="telefono" name="telefono" value="{{ @$restaurante->telefono }}" >
            </div>

            <button type="submit" class="btn btn-primary" type="submit">Guardar</button>
        </form>
    </div>
@endsection