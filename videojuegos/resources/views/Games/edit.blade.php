@extends('Games.form')

@section('forName')
    Editar
@endsection

@section('action')
    action="{{ route('games.update', $game->id) }}" method="POST"
@endsection

@section('method')
    @method('PUT')
@endsection