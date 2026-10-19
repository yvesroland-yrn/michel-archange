<?php
namespace App\Http\Controllers;
use App\Models\{Produit, MouvementStock};
use Illuminate\Http\Request;
class StockController extends CrudController {
    protected string $model = Produit::class;
    protected string $route = 'stock';
    protected string $titre = 'Gestion du stock boutique';
    protected string $singulier = 'Produit';
    protected array $searchable = ['nom', 'categorie', 'description'];
    protected string $order = 'nom';
    protected string $dir = 'asc';

    protected function fields(): array {
        return [
            'nom' => ['Nom du produit', 'text', true],
            'description' => ['Description', 'textarea'],
            'categorie' => ['Catégorie', 'text'],
            'prix' => ['Prix (FCFA)', 'number'],
            'quantite' => ['Quantité en stock', 'number'],
            'seuil_alerte' => ['Seuil d\'alerte', 'number'],
            'actif' => ['Actif', 'checkbox'],
        ];
    }

    protected function columns(): array {
        return [
            'Nom' => 'nom',
            'Catégorie' => 'categorie',
            'Prix' => fn ($p) => number_format($p->prix, 0, ',', ' ') . ' FCFA',
            'Quantité' => fn ($p) => $p->quantite,
            'Statut' => fn ($p) => $p->estEnRupture()
                ? '<span class="badge bg-danger">Stock bas (' . $p->quantite . ')</span>'
                : '<span class="badge bg-success">En stock (' . $p->quantite . ')</span>',
            'Actif' => fn ($p) => $p->actif ? '<span class="badge bg-success">Oui</span>' : '<span class="badge bg-secondary">Non</span>',
        ];
    }

    protected function extraRules($item = null): array {
        return [
            'nom' => 'required|string|max:255',
            'prix' => 'required|numeric|min:0',
            'quantite' => 'required|integer|min:0',
            'seuil_alerte' => 'required|integer|min:0',
        ];
    }

    protected function prepare(array $data, $item = null): array {
        $data['prix'] = str_replace(',', '.', $data['prix'] ?? 0);
        return $data;
    }

    protected function links($item): array {
        return [
            ['label' => '<i class="bi bi-plus"></i> Ajouter', 'route' => route('stock.add', $item), 'color' => 'success'],
            ['label' => '<i class="bi bi-dash"></i> Retirer', 'route' => route('stock.remove', $item), 'color' => 'warning'],
        ];
    }

    public function addStock(Request $r, $id) {
        $item = ($this->model)::findOrFail($id);
        $validated = $r->validate(['quantite' => 'required|integer|min:1', 'raison' => 'nullable|string|max:255']);
        $item->increment('quantite', $validated['quantite']);

        MouvementStock::create([
            'produit_id' => $item->id,
            'type' => 'entree',
            'quantite' => $validated['quantite'],
            'raison' => $validated['raison'] ?? 'Ajout manuel',
            'date' => now(),
            'user_id' => auth()->id(),
        ]);

        return back()->with('ok', $validated['quantite'] . ' unité(s) ajoutée(s) au stock.');
    }

    public function removeStock(Request $r, $id) {
        $item = ($this->model)::findOrFail($id);
        $validated = $r->validate(['quantite' => 'required|integer|min:1', 'raison' => 'nullable|string|max:255']);
        if ($item->quantite < $validated['quantite']) {
            return back()->withErrors('Quantité insuffisante en stock.');
        }
        $item->decrement('quantite', $validated['quantite']);

        MouvementStock::create([
            'produit_id' => $item->id,
            'type' => 'sortie',
            'quantite' => $validated['quantite'],
            'raison' => $validated['raison'] ?? 'Retrait manuel',
            'date' => now(),
            'user_id' => auth()->id(),
        ]);

        return back()->with('ok', $validated['quantite'] . ' unité(s) retirée(s) du stock.');
    }

    public function index(Request $r) {
        $q = ($this->model)::with($this->with);
        if ($r->filled('q') && $this->searchable) {
            $q->where(fn ($w) => collect($this->searchable)->each(fn ($c) => $w->orWhere($c, 'like', '%'.$r->q.'%')));
        }
        $items = $q->orderBy($this->order, $this->dir)->paginate(20)->withQueryString();
        return $this->view('stock.index', ['items' => $items, 'columns' => $this->columns(), 'controller' => $this, 'searchable' => (bool) $this->searchable]);
    }

    public function dashboard() {
        $totalProduits = Produit::count();
        $totalStock = Produit::sum('quantite');
        $stockBas = Produit::whereColumn('quantite', '<=', 'seuil_alerte')->count();
        $valeurStock = Produit::selectRaw('SUM(prix * quantite) as total')->value('total') ?? 0;
        $produitsEnRupture = Produit::whereColumn('quantite', '<=', 'seuil_alerte')->orderBy('quantite', 'asc')->take(5)->get();
        $derniersProduits = Produit::orderBy('created_at', 'desc')->take(5)->get();

        return view('stock.dashboard', compact(
            'totalProduits',
            'totalStock',
            'stockBas',
            'valeurStock',
            'produitsEnRupture',
            'derniersProduits'
        ));
    }
}
