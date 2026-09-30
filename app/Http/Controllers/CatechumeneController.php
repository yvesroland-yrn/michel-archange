<?php
namespace App\Http\Controllers;
use App\Models\{Catechumene, ClasseCate, Fidele};
class CatechumeneController extends CrudController {
    protected string $model = Catechumene::class; protected string $route = 'catechumenes';
    protected string $titre = 'Catéchumènes'; protected string $singulier = 'Inscription';
    protected array $with = ['fidele', 'classe'];
    protected function fields(): array {
        return ['fidele_id' => ['Fidèle', 'select', true, Fidele::options()], 'classe_cate_id' => ['Classe', 'select', true, ClasseCate::options()],
            'statut' => ['Statut', 'select', true, ['inscrit' => 'Inscrit', 'admis' => 'Admis', 'ajourne' => 'Ajourné']], 'observation' => ['Observation', 'text']];
    }
    protected function columns(): array { return ['Catéchumène' => fn ($c) => $c->fidele?->nom_complet, 'Classe' => fn ($c) => $c->classe?->annee.' — '.$c->classe?->niveau, 'Statut' => 'statut']; }
}
