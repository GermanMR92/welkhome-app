@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <span>Restaurantes 👨🏻‍🍳 </span>
                        <span style="color:blue"><svg style="color:blue" xmlns="http://www.w3.org/2000/svg" height="22" viewBox="0 -960 960 960" width="22"><path d="M450-450H200v-60h250v-250h60v250h250v60H510v250h-60v-250Z"/></svg></span>
                    </div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        @include('restaurantes')
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection