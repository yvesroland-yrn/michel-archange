<?php
namespace App\Http\Controllers;
use App\Models\{Produit, MouvementStock};
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
class StockReportController extends Controller
{
    private function periode(Request $r): array {
        $vue = $r->get('vue', 'mois');
        $produitId = $r->get('produit_id');

        $query = MouvementStock::with(['produit', 'user']);

        if ($produitId && $produitId !== 'tous') {
            $query->where('produit_id', $produitId);
        }

        if ($vue === 'tout') {
            return ['tout', $query->orderBy('date')->get(), Produit::all()];
        }

        if ($vue === 'semaine') {
            $startOfWeek = now()->startOfWeek();
            $endOfWeek = now()->endOfWeek();
            $query->whereBetween('date', [$startOfWeek, $endOfWeek]);
            return [$vue, $query->orderBy('date')->get(), Produit::all()];
        }

        if ($vue === 'annee') {
            $annee = preg_match('/^\d{4}$/', (string) $r->get('annee')) ? $r->get('annee') : now()->format('Y');
            $query->whereYear('date', $annee);
            return [$annee, $query->orderBy('date')->get(), Produit::all()];
        }

        $mois = preg_match('/^\d{4}-\d{2}$/', (string) $r->get('mois')) ? $r->get('mois') : now()->format('Y-m');
        [$y, $m] = explode('-', $mois);
        $query->whereYear('date', $y)->whereMonth('date', $m);
        return [$mois, $query->orderBy('date')->get(), Produit::all()];
    }

    public function index(Request $r) {
        [$periode, $mouvements, $produits] = $this->periode($r);

        $entrees = $mouvements->where('type', 'entree');
        $sorties = $mouvements->where('type', 'sortie');

        $stats = [
            'total_entrees' => $entrees->sum('quantite'),
            'total_sorties' => $sorties->sum('quantite'),
            'nb_entrees' => $entrees->count(),
            'nb_sorties' => $sorties->count(),
        ];

        return view('stock.rapport', compact('mouvements', 'produits', 'periode', 'stats'));
    }

    public function exportPdf(Request $r) {
        [$periode, $mouvements, $produits] = $this->periode($r);

        $entrees = $mouvements->where('type', 'entree');
        $sorties = $mouvements->where('type', 'sortie');

        $stats = [
            'total_entrees' => $entrees->sum('quantite'),
            'total_sorties' => $sorties->sum('quantite'),
            'nb_entrees' => $entrees->count(),
            'nb_sorties' => $sorties->count(),
        ];

        $periodeLabel = match($periode) {
            'tout' => 'Tout l\'historique',
            'semaine' => 'Cette semaine',
            default => $periode,
        };

        return Pdf::loadView('pdf.stock-rapport', compact('mouvements', 'produits', 'periode', 'periodeLabel', 'stats'))
            ->stream("rapport-stock-$periode.pdf");
    }

    public function exportProduitsPdf() {
        $produits = Produit::orderBy('nom')->get();
        $totalProduits = $produits->count();
        $totalStock = $produits->sum('quantite');
        $valeurStock = $produits->sum(function($p) { return $p->prix * $p->quantite; });
        $stockBas = $produits->filter(function($p) { return $p->estEnRupture(); })->count();

        return Pdf::loadView('pdf.stock-produits', compact('produits', 'totalProduits', 'totalStock', 'valeurStock', 'stockBas'))
            ->stream("inventaire-stock.pdf");
    }
}
