@extends('layout')

@section('title')
    - Listado
@endsection

@section('body')
    @if($msj = Session::get('success'))
    <div class="row" id="alerta">
        <div class="col-md-4 offset-md-4">
            <div class="alert alert-success">
                <p><b><i class="fa-solid fa-check"></i> {{$msj}} </b></p>
            </div>
        </div>
    </div>
    @endif
    <div class="row">
        <div class="col-12">
            <div class="table-response">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>NOMBRE</th>
                            <th>NIVELES</th>
                            <th>LANZAMIENTO</th>
                            <th>IMAGEN</th>
                            <th></th>
                            <th></th>
                        </tr>
                    </thead>
                    @foreach($games as $i => $row)
                    <tbody>
                        <tr>
                            <td>{{ ($i+1) }}</td>
                            <td>{{ $row->name }}</td>
                            <td>{{ $row->levels }}</td>
                            <td>{{ $row->release }}</td>
                            <td>
                                <img class='img-fluid' width="120" src="/storage/{{ $row->image }}" alt="portada del juego {{ $row->name }}">
                            </td>
                            <td>
                                <a class="btn btn-warning"  href="{{ route('games.edit', ['id' => $row->id]) }}">
                                    <i class="fa-solid fa-edit"></i>
                                </a>
                            </td>
                            <td>
                                <form action="{{ route('games.destroy', ['id' => $row->id]) }}" method="POST" id="frm_{{ $row->id }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modalConfirmacion"
                                    onclick="setinfo({{ $row->id }}, '{{ $row->name }}')">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    </tbody>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
    <div class="modal" tabindex="-1" id="modalConfirmacion">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">¿Seguro que quieres sarle kranky?</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p><i class="fa-solid fa-warning fs-3 text-warning"></i></p>
                <label id="lbl_nombre"></label>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal"> cacelar </button>
                <button type="button" id="btnEliminar" class="btn btn-success"> Eliminar </button>
            </div>
        </div>
        </div>
    </div>
@endsection

@section('js')
    @vite('resources/js/index.js')
@endsection