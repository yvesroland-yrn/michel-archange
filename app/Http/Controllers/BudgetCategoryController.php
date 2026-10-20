<?php

namespace App\Http\Controllers;

use App\Models\BudgetCategory;
use Illuminate\Http\Request;

class BudgetCategoryController extends Controller
{
    public function index()
    {
        $categories = BudgetCategory::orderBy('type')->orderBy('nom')->get();
        return view('budget.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('budget.categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'type' => 'required|in:depense,recette',
            'description' => 'nullable|string',
            'actif' => 'nullable|boolean',
        ]);

        BudgetCategory::create([
            'nom' => $request->nom,
            'type' => $request->type,
            'description' => $request->description,
            'actif' => $request->has('actif'),
        ]);

        return redirect()->route('budget.categories.index')
            ->with('ok', 'Catégorie créée avec succès.');
    }

    public function edit(BudgetCategory $category)
    {
        return view('budget.categories.edit', compact('category'));
    }

    public function update(Request $request, BudgetCategory $category)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'type' => 'required|in:depense,recette',
            'description' => 'nullable|string',
            'actif' => 'nullable|boolean',
        ]);

        $category->update([
            'nom' => $request->nom,
            'type' => $request->type,
            'description' => $request->description,
            'actif' => $request->has('actif'),
        ]);

        return redirect()->route('budget.categories.index')
            ->with('ok', 'Catégorie mise à jour avec succès.');
    }

    public function destroy(BudgetCategory $category)
    {
        if ($category->lignes()->count() > 0) {
            return back()->with('error', 'Impossible de supprimer cette catégorie car elle contient des lignes budgétaires.');
        }

        $category->delete();

        return redirect()->route('budget.categories.index')
            ->with('ok', 'Catégorie supprimée avec succès.');
    }
}
