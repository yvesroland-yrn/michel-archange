<?php

namespace App\Http\Controllers;

use App\Models\BudgetCategory;
use App\Models\BudgetLigne;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class BudgetRapportController extends Controller
{
    public function index(Request $request)
    {
        $annee = $request->get('annee', date('Y'));
        $mois = $request->get('mois');
        $category = $request->get('category');

        $query = BudgetLigne::with('category')->where('annee', $annee);

        if ($mois) {
            $query->where('mois', $mois);
        }

        if ($category) {
            $query->where('budget_category_id', $category);
        }

        $lignes = $query->orderBy('mois')->get();

        // Grouper par catégorie
        $parCategorie = $lignes->groupBy('budget_category_id');

        // Statistiques
        $totalPrevu = $lignes->sum('montant_prevu');
        $totalRealise = $lignes->sum(function ($ligne) {
            return $ligne->montant_realise;
        });
        $lignesRespectees = $lignes->filter(function ($ligne) {
            return $ligne->taux <= 100 && $ligne->category->type === 'depense';
        })->count();
        $lignesDepassees = $lignes->filter(function ($ligne) {
            return $ligne->taux > 100 && $ligne->category->type === 'depense';
        })->count();
        $lignesNonConsommees = $lignes->filter(function ($ligne) {
            return $ligne->taux == 0;
        })->count();

        $categories = BudgetCategory::actif()->orderBy('nom')->get();
        $anneesDisponibles = BudgetLigne::select('annee')
            ->distinct()
            ->orderBy('annee', 'desc')
            ->pluck('annee');

        return view('budget.rapport', compact(
            'annee',
            'mois',
            'category',
            'lignes',
            'parCategorie',
            'totalPrevu',
            'totalRealise',
            'lignesRespectees',
            'lignesDepassees',
            'lignesNonConsommees',
            'categories',
            'anneesDisponibles',
        ));
    }

    public function exportPdf(Request $request)
    {
        $annee = $request->get('annee', date('Y'));
        $mois = $request->get('mois');
        $category = $request->get('category');

        $query = BudgetLigne::with('category')->where('annee', $annee);

        if ($mois) {
            $query->where('mois', $mois);
        }

        if ($category) {
            $query->where('budget_category_id', $category);
        }

        $lignes = $query->orderBy('mois')->get();
        $parCategorie = $lignes->groupBy('budget_category_id');

        $totalPrevu = $lignes->sum('montant_prevu');
        $totalRealise = $lignes->sum(function ($ligne) {
            return $ligne->montant_realise;
        });

        $logoPath = public_path('images/logo-sanctuaire.jpg');
        $logoData = base64_encode(file_get_contents($logoPath));
        $logoSrc = 'data:image/jpeg;base64,' . $logoData;

        $pdf = Pdf::loadView('pdf.budget-rapport', compact(
            'annee',
            'mois',
            'category',
            'lignes',
            'parCategorie',
            'totalPrevu',
            'totalRealise',
            'logoSrc',
        ));

        $filename = 'rapport-budget-' . $annee . ($mois ? '-' . $mois : '') . '.pdf';
        return $pdf->stream($filename);
    }

    public function exportExcel(Request $request)
    {
        $annee = $request->get('annee', date('Y'));
        $mois = $request->get('mois');
        $category = $request->get('category');

        $query = BudgetLigne::with('category')->where('annee', $annee);

        if ($mois) {
            $query->where('mois', $mois);
        }

        if ($category) {
            $query->where('budget_category_id', $category);
        }

        $lignes = $query->orderBy('mois')->get();

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="rapport-budget-' . $annee . '.csv"',
        ];

        $callback = function () use ($lignes) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['Catégorie', 'Libellé', 'Année', 'Mois', 'Prévu (FCFA)', 'Réalisé (FCFA)', 'Reste (FCFA)', 'Taux (%)', 'Statut']);

            foreach ($lignes as $ligne) {
                fputcsv($file, [
                    $ligne->category->nom,
                    $ligne->libelle,
                    $ligne->annee,
                    $ligne->mois ?? 'Annuel',
                    number_format($ligne->montant_prevu, 0, '', ''),
                    number_format($ligne->montant_realise, 0, '', ''),
                    number_format($ligne->reste, 0, '', ''),
                    number_format($ligne->taux, 2),
                    $ligne->statut,
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, $headers);
    }
}
