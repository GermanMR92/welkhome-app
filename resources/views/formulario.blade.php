@extends('layouts.app')

@section('content')
    <div class="container">
        <form action="/restaurante/store/{{ $restaurante->id }}" method="put">
            @csrf
            @method('PUT')
            
            <div class="form-group mb-3">
                <label class="" for="nombre">Nombre:</label>
                <input class="form-control" type="text" id="nombre" name="nombre" value="{{ $restaurante->nombre }}" required>
            </div>
            
            <div class="form-group mb-3">
                <label class="" for="direccion">Dirección:</label>
                <input class="form-control" type="text" id="direccion" name="direccion" value="{{ $restaurante->direccion }}" required>
            </div>

            <div class="form-group mb-3">
                <label class="" for="telefono">Teléfono:</label>
                <input class="form-control" type="tel" id="telefono" name="telefono" value="{{ $restaurante->telefono }}" required>
            </div>

            <button class="btn btn-primary" type="submit">Actualizar</button>
        </form>
    </div>
@endsection