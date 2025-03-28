@extends('layout')

@section('title')
    - @yield('forName')
@endsection

@section('body')
    @if($errors->any())        
    <div class="row">
        <div class="col-md-12">
            <div class="alert alert-danger">
                <p><b><i class="fa-solid fa-times"></i> Errores </b></p>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
    @endif

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">@yield('forName')</div>
                <div class="card-body">
                    <form @yield('action') enctype="multipart/form-data">
                        @csrf
                        @yield('method')
                        <div class="input-group mb-3">
                            <span class="input-group-text"><i class="fa-solid fa-gamepad"></i></span>
                                <input type="text" name="name" class="form-control" placeholder="Nombre" value="{{ old('name', $game->name ?? '') }}" required>
                        </div>
                        <div class="input-group mb-3">
                            <span class="input-group-text"><i class="fa-solid fa-trophy"></i></span>
                                <input type="text" name="levels" class="form-control" placeholder="niveles" value="{{ old('name', $game->levels ?? '') }}" required>
                        </div>
                        <div class="input-group mb-3">
                            <span class="input-group-text"><i class="fa-solid fa-calendar"></i></span>
                                <input type="date" name="release" class="form-control" placeholder="Lanzamiento" value="{{ old('name', $game->release ?? '') }}" required>
                        </div>
                        <div class="input-group mb-3">
                            <span class="input-group-text"><i class="fa-solid fa-image"></i></span>
                                <input type="file" name="image" class="form-control" @if(!isset($game)) required @endif accept="image/*">
                        </div>
                        <button class='btn btn-success' type="submit"> Guardar </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
