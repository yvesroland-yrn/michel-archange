<?php

namespace App\Http\Controllers;

use App\Models\MouvementParoissial;
use Illuminate\Http\Request;

class MouvementParoissialController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $mouvements = MouvementParoissial::all();
        return view('mouvement-paroissial.index', compact('mouvements'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('mouvement-paroissial.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'icone' => 'required|string|max:50',
            'responsable' => 'nullable|string|max:255',
            'telephone_responsable' => 'nullable|string|max:20',
            'description' => 'nullable|string',
            'photo' => 'nullable|image|max:2048',
            'actif' => 'boolean',
        ]);

        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')->store('mouvements', 'public');
        }

        MouvementParoissial::create($validated);

        return redirect()->route('mouvement-paroissial.index')->with('ok', 'Mouvement ajouté avec succès.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MouvementParoissial $mouvementParoissial)
    {
        return view('mouvement-paroissial.edit', compact('mouvementParoissial'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, MouvementParoissial $mouvementParoissial)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'icone' => 'required|string|max:50',
            'responsable' => 'nullable|string|max:255',
            'telephone_responsable' => 'nullable|string|max:20',
            'description' => 'nullable|string',
            'photo' => 'nullable|image|max:2048',
            'actif' => 'boolean',
        ]);

        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')->store('mouvements', 'public');
        }

        $mouvementParoissial->update($validated);

        return redirect()->route('mouvement-paroissial.index')->with('ok', 'Mouvement modifié avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MouvementParoissial $mouvementParoissial)
    {
        $mouvementParoissial->delete();
        return redirect()->route('mouvement-paroissial.index')->with('ok', 'Mouvement supprimé avec succès.');
    }
}
