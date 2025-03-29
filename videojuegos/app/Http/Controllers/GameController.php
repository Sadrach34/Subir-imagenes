<?php

namespace App\Http\Controllers;

use App\Models\Game;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage; // Importa la clase Storage

class GameController extends Controller
{
    public function index(){
        $games = Game::all();
        return view('Games.index', compact('games'));
    }

    public function create(){
        return view('Games.create');
    }

    public function store(Request $request){
        $request->validate([
            'name' => 'required',
            'levels' => 'required|numeric',
            'release' => 'required|date',
            'image' => 'required|image',
        ],[
            'name.required' => 'El nombre del juego es obligatorio.',
            'levels.required' => 'El número de niveles es obligatorio.',
            'levels.numeric' => 'El número de niveles debe ser un número.',
            'release.required' => 'La fecha de lanzamiento es obligatoria.',
            'release.date' => 'La fecha de lanzamiento debe ser una fecha válida.',
            'image.required' => 'La imagen del juego es obligatoria.',
            'image.image' => 'El archivo subido debe ser una imagen.',
        ]);

        try {
            // Primero, crea el registro sin la imagen para obtener el ID
            $game = Game::create([
                'name' => $request->name,
                'levels' => $request->levels,
                'release' => $request->release,
                'image' => '', // Temporalmente vacío
            ]);

            // Renombra la imagen con el ID del registro
            $imageName = $game->id . '.' . $request->file('image')->extension();

            // Guarda la imagen en la carpeta 'img' dentro de 'public/storage'
            $imagePath = $request->file('image')->storeAs('img', $imageName, 'public');

            // Actualiza el registro con la ruta de la imagen
            $game->update([
                'image' => $imagePath,
            ]);

            return redirect()->route('games.index')->with('success', 'Game created successfully.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Error al guardar el juego: ' . $e->getMessage()]);
        }
    }

    public function show(Game $game){
        //
    }

    public function edit($id){
        $game = Game::findOrFail($id); // Encuentra el juego o lanza un error 404 si no existe
        return view('Games.edit', compact('game')); // Pasa el modelo único a la vista
    }

    public function update(Request $request, Game $game){
        $request->validate([
            'name' => 'required',
            'levels' => 'required|numeric',
            'release' => 'required|date',
            'image' => 'nullable|image',
        ]);

        try {
            // Actualiza los datos básicos
            $game->update([
                'name' => $request->name,
                'levels' => $request->levels,
                'release' => $request->release,
            ]);

            // Si se proporciona una nueva imagen
            if ($request->hasFile('image')) {
                // Elimina la imagen anterior si existe
                if ($game->image && Storage::disk('public')->exists($game->image)) {
                    Storage::disk('public')->delete($game->image);
                }

                // Renombra la nueva imagen con el ID del registro
                $imageName = $game->id . '.' . $request->file('image')->extension();

                // Guarda la nueva imagen en la carpeta 'img' dentro de 'public/storage'
                $imagePath = $request->file('image')->storeAs('img', $imageName, 'public');

                // Actualiza el registro con la nueva ruta de la imagen
                $game->update([
                    'image' => $imagePath,
                ]);
            }

            return redirect()->route('games.index')->with('success', 'Game updated successfully.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Error al actualizar el juego: ' . $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id){
        try {
            // Encuentra el registro del juego por su ID
            $game = Game::findOrFail($id);

            // Elimina la imagen asociada si existe
            if ($game->image && Storage::disk('public')->exists($game->image)) {
                Storage::disk('public')->delete($game->image);
            }

            // Elimina el registro del juego
            $game->delete();

            return redirect()->route('games.index')->with('success', 'Game deleted successfully.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Error al eliminar el juego: ' . $e->getMessage()]);
        }
    }
}
