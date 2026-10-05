<?php
namespace App\Http\Controllers;
use App\Models\{AnneeCatechetique, ClasseCate, Catechumene};
class CatecheseDashboardController extends Controller {
    public function index() {
        $anneeActive = AnneeCatechetique::getActive();
        $annees = AnneeCatechetique::orderByDesc('date_debut')->get();
        
        $stats = [];
        if ($anneeActive) {
            $classes = $anneeActive->classes()->with('catechumenes')->get();
            $totalInscrits = 0;
            $parNiveauComplet = [];
            
            foreach ($classes as $classe) {
                $count = $classe->catechumenes()->count();
                $totalInscrits += $count;
                
                // Regrouper par niveau complet (avec code)
                $niveauComplet = $classe->niveau . ($classe->code ? " {$classe->code}" : '');
                if (!isset($parNiveauComplet[$niveauComplet])) {
                    $parNiveauComplet[$niveauComplet] = 0;
                }
                $parNiveauComplet[$niveauComplet] += $count;
            }
            
            // Trier par niveau
            uksort($parNiveauComplet, function($a, $b) {
                $niveaux = ClasseCate::getNiveaux();
                $indexA = array_search(explode(' ', $a)[0], $niveaux);
                $indexB = array_search(explode(' ', $b)[0], $niveaux);
                return $indexA - $indexB;
            });
            
            $stats = [
                'annee' => $anneeActive->libelle,
                'total_inscrits' => $totalInscrits,
                'total_classes' => $classes->count(),
                'par_niveau' => $parNiveauComplet,
                'classes' => $classes
            ];
        }
        
        return view('catechese.dashboard', compact('anneeActive', 'annees', 'stats'));
    }
}
