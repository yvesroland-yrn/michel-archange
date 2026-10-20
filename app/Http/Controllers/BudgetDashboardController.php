<?php

namespace App\Http\Controllers;

use App\Models\BudgetCategory;
use App\Models\BudgetLigne;
use Illuminate\Http\Request;

class BudgetDashboardController extends Controller
{
    public function index(Request $request)
    {
        $annee = $request->get('annee', date('Y'));
        $mois = $request->get('mois');

        $query = BudgetLigne::with('category')->where('annee', $annee);

        if ($mois) {
            $query->where('mois', $mois);
        }

        $lignes = $query->get();

        // Calculs globaux
        $totalPrevu = $lignes->sum('montant_prevu');
        $totalRealise = $lignes->sum(function ($ligne) {
            return $ligne->montant_realise;
        });
        $totalReste = $lignes->sum(function ($ligne) {
            return $ligne->reste;
        });
        $tauxGlobal = $totalPrevu > 0 ? ($totalRealise / $totalPrevu) * 100 : 0;

        // Lignes dépassées
        $lignesDepassees = $lignes->filter(function ($ligne) {
            return $ligne->taux > 100 && $ligne->category->type === 'depense';
        });

        // Lignes presque atteintes
        $lignesPresqueAtteintes = $lignes->filter(function ($ligne) {
            return $ligne->taux >= 90 && $ligne->taux < 100 && $ligne->category->type === 'depense';
        });

        // Données pour les graphiques
        $categories = BudgetCategory::actif()->orderBy('nom')->get();
        $parMois = [];
        for ($i = 1; $i <= 12; $i++) {
            $lignesMois = BudgetLigne::with('category')
                ->where('annee', $annee)
                ->where('mois', $i)
                ->get();

            $parMois[$i] = [
                'prevu' => $lignesMois->sum('montant_prevu'),
                'realise' => $lignesMois->sum(function ($ligne) {
                    return $ligne->montant_realise;
                }),
            ];
        }

        // Répartition par catégorie
        $parCategorie = [];
        foreach ($categories as $category) {
            $lignesCat = $lignes->where('budget_category_id', $category->id);
            $parCategorie[$category->nom] = [
                'prevu' => $lignesCat->sum('montant_prevu'),
                'realise' => $lignesCat->sum(function ($ligne) {
                    return $ligne->montant_realise;
                }),
                'type' => $category->type,
            ];
        }

        $anneesDisponibles = BudgetLigne::select('annee')
            ->distinct()
            ->orderBy('annee', 'desc')
            ->pluck('annee')
            ->toArray();

        // Si aucune année n'est disponible, ajouter l'année courante
        if (empty($anneesDisponibles)) {
            $anneesDisponibles = [date('Y')];
        }

        return view('budget.dashboard', compact(
            'annee',
            'mois',
            'lignes',
            'totalPrevu',
            'totalRealise',
            'totalReste',
            'tauxGlobal',
            'lignesDepassees',
            'lignesPresqueAtteintes',
            'parMois',
            'parCategorie',
            'anneesDisponibles',
        ));
    }
}
