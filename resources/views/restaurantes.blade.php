<table class="table align-middle mb-0 bg-white">
    <thead class="bg-light">
        <tr>
            <th>Título</th>
            <th>Dirección</th>
            <th>Telefono</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($restaurantes as $restaurante)
            <tr id="table-row-{{$restaurante->id}}">
                <td>
                    <p class="fw-normal mb-1">{{$restaurante->nombre}}</p>
                </td>
                <td>
                    <p class="fw-normal mb-1">{{$restaurante->direccion}}</p>
                </td>
                <td>
                    <p class="fw-normal mb-1">{{$restaurante->telefono}}</p>
                </td>
                <td> 
                    {{-- Edit --}}
                    <a href="{{ route('editForm', ['id' => $restaurante->id]) }}"><svg xmlns="http://www.w3.org/2000/svg" height="22" viewBox="0 -960 960 960" width="22"><path d="M180-180h44l443-443-44-44-443 443v44Zm614-486L666-794l42-42q17-17 42-17t42 17l44 44q17 17 17 42t-17 42l-42 42Zm-42 42L248-120H120v-128l504-504 128 128Zm-107-21-22-22 44 44-22-22Z"/></svg></a>
                    {{-- Delete --}}
                    <a href="javascript:void(0)" onclick="deleteRecord({{$restaurante->id}})" class="delete-record">
                        <svg xmlns="http://www.w3.org/2000/svg" height="22" viewBox="0 -960 960 960" width="22">
                            <path d="M261-120q-24.75 0-42.375-17.625T201-180v-570h-41v-60h188v-30h264v30h188v60h-41v570q0 24-18 42t-42 18H261Zm438-630H261v570h438v-570ZM367-266h60v-399h-60v399Zm166 0h60v-399h-60v399ZM261-750v570-570Z"/>
                        </svg>
                    </a>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>