<?php
namespace App\Http\Controllers;
use App\Models\{Mouvement, Fidele};
use Illuminate\Http\Request;
class MouvementController extends CrudController {
    protected string $model = Mouvement::class; protected string $route = 'mouvements';
    protected string $titre = 'Mouvements, chorales et groupes'; protected string $singulier = 'Mouvement';
    protected array $searchable = ['nom', 'responsable']; protected string $order = 'nom'; protected string $dir = 'asc';
    protected function fields(): array { return ['nom' => ['Nom', 'text', true], 'responsable' => ['Responsable', 'text'], 'date_creation' => ['Date de création', 'date'], 'description' => ['Description', 'textarea']]; }
    protected function columns(): array { return ['Nom' => 'nom', 'Responsable' => 'responsable', 'Membres' => fn ($m) => $m->membres()->count()]; }
    protected function links($item): array { return ['Membres' => route('mouvements.membres', $item->id)]; }
    protected function extraRules($item = null): array { return ['nom' => 'required|string|max:255|unique:mouvements,nom,'.($item?->id ?? 'NULL')]; }

    public function membres(Mouvement $mouvement) {
        return view('mouvements.membres', ['mouvement' => $mouvement->load('membres'), 'fideles' => Fidele::options()]);
    }
    public function ajouterMembre(Request $r, Mouvement $mouvement) {
        $d = $r->validate(['fidele_id' => 'required|exists:fideles,id', 'fonction' => 'nullable|string|max:100']);
        $mouvement->membres()->syncWithoutDetaching([$d['fidele_id'] => ['fonction' => $d['fonction'] ?: 'Membre']]);
        return back()->with('ok', 'Membre ajouté.');
    }
    public function retirerMembre(Mouvement $mouvement, Fidele $fidele) { $mouvement->membres()->detach($fidele->id); return back()->with('ok', 'Membre retiré.'); }
}
