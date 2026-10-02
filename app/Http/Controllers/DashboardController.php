<?php
namespace App\Http\Controllers;
use App\Models\{Fidele, Bapteme, Recette, Depense, Evenement, Intention, Catechumene, Contact, MouvementParoissial};
class DashboardController extends Controller {
    public function __invoke() {
        $financeVisible = auth()->user()->hasPermission('finances');
        
        $stats = ['Fidèles actifs' => Fidele::where('statut', 'actif')->count(), 'Baptêmes de l\'année' => Bapteme::whereYear('date_bapteme', now()->year)->count(),
            'Catéchumènes inscrits' => Catechumene::where('statut', 'inscrit')->count(), 'Intentions à célébrer' => Intention::where('statut', 'recue')->count()];
        
        $finances = [];
        if ($financeVisible) {
            $rec = Recette::whereYear('date', now()->year)->sum('montant');
            $dep = Depense::whereYear('date', now()->year)->sum('montant');
            $finances = ['Recettes (FCFA)' => $rec, 'Dépenses (FCFA)' => $dep, 'Solde (FCFA)' => $rec - $dep];
            
            // Statistiques par catégorie
            $categoryStats = [
                'don' => Recette::whereYear('date', now()->year)->whereIn('type', Recette::CATEGORY_TYPES['don'])->sum('montant'),
                'dime' => Recette::whereYear('date', now()->year)->whereIn('type', Recette::CATEGORY_TYPES['dime'])->sum('montant'),
                'quete' => Recette::whereYear('date', now()->year)->whereIn('type', Recette::CATEGORY_TYPES['quete'])->sum('montant'),
                'offrande' => Recette::whereYear('date', now()->year)->whereIn('type', Recette::CATEGORY_TYPES['offrande'])->sum('montant'),
            ];
        }
        
        return view('dashboard', [
            'stats' => $stats,
            'finances' => $finances,
            'categoryStats' => $categoryStats ?? [],
            'evenements' => Evenement::where('date_heure', '>=', now())->orderBy('date_heure')->take(5)->get(),
            'fideles' => Fidele::where('statut', 'actif')->orderBy('created_at', 'desc')->take(10)->get(),
            'mouvements' => MouvementParoissial::where('actif', true)->orderBy('nom')->get(),
            'financeVisible' => $financeVisible,
        ]);
    }
}
