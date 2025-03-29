@extends('Games.form')
@section('forName')
    Crear
@endsection
@section('action')
    action="{{ route('games.store') }}" method="POST"
@endsection