<?php

namespace App\Http\Controllers;

use App\Models\Game;
use Illuminate\Http\Request;

class GameController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $games = Game::all();
        return view('Games.index', compact('games'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('Games.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'levels' => 'required|numeric',
            'release' => 'required|date',
            'image' => 'required|image',
        ]);
    
        $game = new Game();
        $game->name = $request->input('name');
        $game->levels = $request->input('levels');
        $game->release = $request->input('release');
    
        if ($request->hasFile('image')) {
            // Generar un nombre único para la imagen
            $nombre = uniqid() . '.' . $request->file('image')->getClientOriginalExtension();
            // Guardar la imagen en 'storage/app/public/img'
            $img = $request->file('image')->storeAs('public/img', $nombre);
            // Guardar la ruta relativa en la base de datos
            $game->image = 'img/' . $nombre;
        }
    
        $game->save();
    
        return redirect()->route('games.index')->with('success', 'Game created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Game $game)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $game = Game::findOrFail($id); // Encuentra el juego o lanza un error 404 si no existe
        return view('Games.edit', compact('game')); // Pasa el modelo único a la vista
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Game $game)
    {

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($request)
    {
        // Validate the request
        $request->validate([
            'id' => 'required|exists:games,id',
        ]);
        // Find the game by ID
        $game = Game::find($request->id);
        if (!$game) {
            return redirect()->route('games.index')->with('error', 'Game not found.');
        }else{
            return redirect()->route('games.index')->with('success', 'Game deleted successfully.');
        }}
}
