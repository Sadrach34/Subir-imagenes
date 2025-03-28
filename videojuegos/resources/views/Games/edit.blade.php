@extends('Games.form')

@section('forName')
    Editar
@endsection

@section('action')
    action="{{ route('games.update', ['game' => $game->id]) }}"
@endsection

@section('method')
    @method('PUT')
@endsection