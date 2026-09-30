<?php

namespace App\Http\Controllers;

use App\Models\Clerge;
use Illuminate\Http\Request;

class ClergeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $clerges = Clerge::all();
        return view('clerge.index', compact('clerges'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('clerge.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'role' => 'required|in:cure,vicaire,resident',
            'telephone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'biographie' => 'nullable|string',
            'photo' => 'nullable|image|max:2048',
            'actif' => 'boolean',
        ]);

        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')->store('clerge', 'public');
        }

        Clerge::create($validated);

        return redirect()->route('clerge.index')->with('ok', 'Membre du clergé ajouté avec succès.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Clerge $clerge)
    {
        return view('clerge.edit', compact('clerge'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Clerge $clerge)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'role' => 'required|in:cure,vicaire,resident',
            'telephone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'biographie' => 'nullable|string',
            'photo' => 'nullable|image|max:2048',
            'actif' => 'boolean',
        ]);

        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')->store('clerge', 'public');
        }

        $clerge->update($validated);

        return redirect()->route('clerge.index')->with('ok', 'Membre du clergé modifié avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Clerge $clerge)
    {
        $clerge->delete();
        return redirect()->route('clerge.index')->with('ok', 'Membre du clergé supprimé avec succès.');
    }
}
