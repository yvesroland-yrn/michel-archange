<?php

namespace App\Http\Controllers;

use App\Models\BudgetLigne;
use App\Models\BudgetMouvement;
use Illuminate\Http\Request;

class BudgetMouvementController extends Controller
{
    public function index(Request $request)
    {
        $query = BudgetMouvement::with('ligne.category', 'createdBy');

        // Filtres
        if ($request->filled('date_debut')) {
            $query->where('date_operation', '>=', $request->date_debut);
        }
        if ($request->filled('date_fin')) {
            $query->where('date_operation', '<=', $request->date_fin);
        }
        if ($request->filled('category')) {
            $query->whereHas('ligne.category', function ($q) use ($request) {
                $q->where('id', $request->category);
            });
        }
        if ($request->filled('ligne')) {
            $query->where('budget_ligne_id', $request->ligne);
        }

        $mouvements = $query->orderBy('date_operation', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(50);

        $categories = \App\Models\BudgetCategory::actif()->orderBy('nom')->get();

        return view('budget.mouvements.index', compact('mouvements', 'categories'));
    }

    public function create()
    {
        $lignes = BudgetLigne::with('category')
            ->orderBy('annee', 'desc')
            ->orderBy('mois')
            ->get();

        return view('budget.mouvements.create', compact('lignes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'budget_ligne_id' => 'required|exists:budget_lignes,id',
            'date_operation' => 'required|date',
            'montant' => 'required|integer|min:0',
            'description' => 'required|string|max:500',
            'reference' => 'nullable|string|max:255',
            'justificatif' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'beneficiaire' => 'nullable|string|max:255',
        ]);

        $ligne = BudgetLigne::findOrFail($request->budget_ligne_id);
        $montantTotal = $ligne->montant_realise + $request->montant;

        // Vérifier si le mouvement fera dépasser le budget
        $alerteDepassement = false;
        if ($ligne->category->type === 'depense' && $montantTotal > $ligne->montant_prevu) {
            $alerteDepassement = true;
        }

        $justificatifPath = null;
        if ($request->hasFile('justificatif')) {
            $justificatifPath = $request->file('justificatif')->store('justificatifs', 'public');
        }

        BudgetMouvement::create([
            'budget_ligne_id' => $request->budget_ligne_id,
            'date_operation' => $request->date_operation,
            'montant' => $request->montant,
            'description' => $request->description,
            'reference' => $request->reference,
            'justificatif' => $justificatifPath,
            'beneficiaire' => $request->beneficiaire,
            'created_by' => auth()->id(),
        ]);

        if ($alerteDepassement) {
            return redirect()->route('budget.mouvements.index')
                ->with('warning', 'Mouvement enregistré mais attention : le budget est dépassé !');
        }

        return redirect()->route('budget.mouvements.index')
            ->with('ok', 'Mouvement enregistré avec succès.');
    }

    public function show(BudgetMouvement $mouvement)
    {
        $mouvement->load('ligne.category', 'createdBy');
        return view('budget.mouvements.show', compact('mouvement'));
    }

    public function edit(BudgetMouvement $mouvement)
    {
        $mouvement->load('ligne');
        $lignes = BudgetLigne::with('category')
            ->orderBy('annee', 'desc')
            ->orderBy('mois')
            ->get();

        return view('budget.mouvements.edit', compact('mouvement', 'lignes'));
    }

    public function update(Request $request, BudgetMouvement $mouvement)
    {
        $request->validate([
            'budget_ligne_id' => 'required|exists:budget_lignes,id',
            'date_operation' => 'required|date',
            'montant' => 'required|integer|min:0',
            'description' => 'required|string|max:500',
            'reference' => 'nullable|string|max:255',
            'justificatif' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'beneficiaire' => 'nullable|string|max:255',
        ]);

        $justificatifPath = $mouvement->justificatif;
        if ($request->hasFile('justificatif')) {
            // Supprimer l'ancien fichier
            if ($mouvement->justificatif) {
                \Storage::disk('public')->delete($mouvement->justificatif);
            }
            $justificatifPath = $request->file('justificatif')->store('justificatifs', 'public');
        }

        $mouvement->update([
            'budget_ligne_id' => $request->budget_ligne_id,
            'date_operation' => $request->date_operation,
            'montant' => $request->montant,
            'description' => $request->description,
            'reference' => $request->reference,
            'justificatif' => $justificatifPath,
            'beneficiaire' => $request->beneficiaire,
        ]);

        return redirect()->route('budget.mouvements.index')
            ->with('ok', 'Mouvement mis à jour avec succès.');
    }

    public function destroy(BudgetMouvement $mouvement)
    {
        // Supprimer le justificatif
        if ($mouvement->justificatif) {
            \Storage::disk('public')->delete($mouvement->justificatif);
        }

        $mouvement->delete();

        return redirect()->route('budget.mouvements.index')
            ->with('ok', 'Mouvement supprimé avec succès.');
    }
}
