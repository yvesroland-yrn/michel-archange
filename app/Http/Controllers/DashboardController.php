<?php
namespace App\Http\Controllers;
use App\Models\{Fidele, Bapteme, Recette, Depense, Evenement, Intention, Catechumene, Contact};
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
        }
        
        return view('dashboard', [
            'stats' => $stats,
            'finances' => $finances,
            'evenements' => Evenement::where('date_heure', '>=', now())->orderBy('date_heure')->take(5)->get(),
            'fideles' => Fidele::where('statut', 'actif')->orderBy('created_at', 'desc')->take(10)->get(),
            'financeVisible' => $financeVisible,
        ]);
    }
}
