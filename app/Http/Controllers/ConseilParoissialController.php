<?php

namespace App\Http\Controllers;

use App\Models\ConseilParoissial;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class ConseilParoissialController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $membres = ConseilParoissial::all();
        return view('conseil-paroissial.index', compact('membres'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('conseil-paroissial.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'role' => 'required|string|max:255',
            'telephone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'description' => 'nullable|string',
            'photo' => 'nullable|image|max:2048',
            'actif' => 'boolean',
        ]);

        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')->store('conseil', 'public');
        }

        ConseilParoissial::create($validated);

        return redirect()->route('conseil-paroissial.index')->with('ok', 'Membre du conseil ajouté avec succès.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ConseilParoissial $conseilParoissial)
    {
        return view('conseil-paroissial.edit', compact('conseilParoissial'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ConseilParoissial $conseilParoissial)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'role' => 'required|string|max:255',
            'telephone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'description' => 'nullable|string',
            'photo' => 'nullable|image|max:2048',
            'actif' => 'boolean',
        ]);

        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')->store('conseil', 'public');
        }

        $conseilParoissial->update($validated);

        return redirect()->route('conseil-paroissial.index')->with('ok', 'Membre du conseil modifié avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ConseilParoissial $conseilParoissial)
    {
        $conseilParoissial->delete();
        return redirect()->route('conseil-paroissial.index')->with('ok', 'Membre du conseil supprimé avec succès.');
    }

    /**
     * Export the list to PDF.
     */
    public function exportPdf()
    {
        $membres = ConseilParoissial::all();
        return Pdf::loadView('pdf.conseil-paroissial', compact('membres'))->stream('conseil-paroissial.pdf');
    }
}
