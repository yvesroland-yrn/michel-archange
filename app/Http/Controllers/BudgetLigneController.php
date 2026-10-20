<?php

namespace App\Http\Controllers;

use App\Models\BudgetCategory;
use App\Models\BudgetLigne;
use Illuminate\Http\Request;

class BudgetLigneController extends Controller
{
    public function index(Request $request)
    {
        $query = BudgetLigne::with('category');

        // Filtres
        if ($request->filled('annee')) {
            $query->where('annee', $request->annee);
        }
        if ($request->filled('mois')) {
            $query->where('mois', $request->mois);
        }
        if ($request->filled('category')) {
            $query->where('budget_category_id', $request->category);
        }
        if ($request->filled('statut')) {
            // Filtrer par statut (nécessite de charger les lignes et filtrer après)
        }

        $lignes = $query->orderBy('annee', 'desc')
            ->orderBy('mois')
            ->orderBy('created_at', 'desc')
            ->get();

        // Filtrage par statut (après chargement)
        if ($request->filled('statut')) {
            $lignes = $lignes->filter(function ($ligne) use ($request) {
                return $ligne->statut === $request->statut;
            });
        }

        $categories = BudgetCategory::actif()->orderBy('nom')->get();
        $annees = BudgetLigne::select('annee')->distinct()->orderBy('annee', 'desc')->pluck('annee');

        return view('budget.lignes.index', compact('lignes', 'categories', 'annees'));
    }

    public function create()
    {
        $categories = BudgetCategory::actif()->orderBy('type')->orderBy('nom')->get();
        return view('budget.lignes.create', compact('categories'));
    }

    public function store(Request $request)
    {
        // Si une nouvelle catégorie est créée
        if ($request->filled('new_category_nom')) {
            $category = BudgetCategory::create([
                'nom' => $request->new_category_nom,
                'type' => $request->new_category_type,
                'description' => $request->new_category_description,
                'actif' => true,
            ]);
            $categoryId = $category->id;
        } else {
            $request->validate([
                'budget_category_id' => 'required|exists:budget_categories,id',
            ]);
            $categoryId = $request->budget_category_id;
        }

        $request->validate([
            'libelle' => 'required|string|max:255',
            'annee' => 'required|string|max:20',
            'mois' => 'nullable|integer|min:1|max:12',
            'montant_prevu' => 'required|integer|min:0',
            'note' => 'nullable|string',
        ]);

        BudgetLigne::create([
            'budget_category_id' => $categoryId,
            'libelle' => $request->libelle,
            'annee' => $request->annee,
            'mois' => $request->mois,
            'montant_prevu' => $request->montant_prevu,
            'note' => $request->note,
            'created_by' => auth()->id(),
        ]);

        return redirect()->route('budget.lignes.index')
            ->with('ok', 'Ligne budgétaire créée avec succès.');
    }

    public function show(BudgetLigne $ligne)
    {
        $ligne->load('category', 'mouvements');
        return view('budget.lignes.show', compact('ligne'));
    }

    public function edit(BudgetLigne $ligne)
    {
        $categories = BudgetCategory::actif()->orderBy('type')->orderBy('nom')->get();
        return view('budget.lignes.edit', compact('ligne', 'categories'));
    }

    public function update(Request $request, BudgetLigne $ligne)
    {
        $request->validate([
            'budget_category_id' => 'required|exists:budget_categories,id',
            'libelle' => 'required|string|max:255',
            'annee' => 'required|string|max:20',
            'mois' => 'nullable|integer|min:1|max:12',
            'montant_prevu' => 'required|integer|min:0',
            'note' => 'nullable|string',
        ]);

        $ligne->update([
            'budget_category_id' => $request->budget_category_id,
            'libelle' => $request->libelle,
            'annee' => $request->annee,
            'mois' => $request->mois,
            'montant_prevu' => $request->montant_prevu,
            'note' => $request->note,
        ]);

        return redirect()->route('budget.lignes.index')
            ->with('ok', 'Ligne budgétaire mise à jour avec succès.');
    }

    public function destroy(BudgetLigne $ligne)
    {
        if ($ligne->mouvements()->count() > 0) {
            return back()->with('error', 'Impossible de supprimer cette ligne car elle contient des mouvements.');
        }

        $ligne->delete();

        return redirect()->route('budget.lignes.index')
            ->with('ok', 'Ligne budgétaire supprimée avec succès.');
    }

    public function duplicate(Request $request, BudgetLigne $ligne)
    {
        $request->validate([
            'annee' => 'required|string|max:20',
            'mois' => 'nullable|integer|min:1|max:12',
            'dupliquer_tous_les_mois' => 'boolean',
        ]);

        if ($request->dupliquer_tous_les_mois) {
            // Créer pour les 12 mois
            for ($i = 1; $i <= 12; $i++) {
                BudgetLigne::create([
                    'budget_category_id' => $ligne->budget_category_id,
                    'libelle' => $ligne->libelle,
                    'annee' => $request->annee,
                    'mois' => $i,
                    'montant_prevu' => $ligne->montant_prevu,
                    'note' => $ligne->note,
                    'created_by' => auth()->id(),
                ]);
            }
            return back()->with('ok', 'Ligne dupliquée pour les 12 mois de l\'année ' . $request->annee . '.');
        } else {
            // Créer pour un seul mois/année
            BudgetLigne::create([
                'budget_category_id' => $ligne->budget_category_id,
                'libelle' => $ligne->libelle,
                'annee' => $request->annee,
                'mois' => $request->mois,
                'montant_prevu' => $ligne->montant_prevu,
                'note' => $ligne->note,
                'created_by' => auth()->id(),
            ]);
            return back()->with('ok', 'Ligne dupliquée avec succès.');
        }
    }
}
