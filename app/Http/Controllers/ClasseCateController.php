<?php
namespace App\Http\Controllers;
use App\Models\ClasseCate;
class ClasseCateController extends CrudController {
    protected string $model = ClasseCate::class; protected string $route = 'classes-cate';
    protected string $titre = 'Classes de catéchèse'; protected string $singulier = 'Classe';
    protected array $searchable = ['niveau', 'code', 'section'];
    protected array $with = ['catechistes', 'anneeCatechetique'];
    protected function fields(): array {
        $niveaux = ClasseCate::getNiveauxAvecCode();
        return [
            'annee_catechetique_id' => ['Année catéchétique', 'select', true, \App\Models\AnneeCatechetique::options()],
            'niveau_complet' => ['Niveau', 'select', true, $niveaux],
            'section' => ['Section', 'select', true, ClasseCate::getSections()],
            'catechistes' => ['Catéchistes', 'checkbox', false, \App\Models\Catechiste::options()]
        ];
    }
    
    protected function prepare(array $data, $item = null): array {
        if (isset($data['niveau_complet'])) {
            $niveauxBase = ClasseCate::getNiveaux();
            $niveauComplet = $data['niveau_complet'];

            // Trouver le niveau de base qui correspond
            $niveau = null;
            $code = null;

            foreach ($niveauxBase as $niveauBase) {
                if (strpos($niveauComplet, $niveauBase) === 0) {
                    $niveau = $niveauBase;
                    $reste = trim(substr($niveauComplet, strlen($niveauBase)));
                    $code = $reste ?: null;
                    break;
                }
            }

            $data['niveau'] = $niveau;
            $data['code'] = $code;
            unset($data['niveau_complet']);
        }

        if (isset($data['catechistes'])) {
            $catechistes = $data['catechistes'];
            unset($data['catechistes']);
        }

        return $data;
    }

    protected function after($item, bool $created): void {
        if (request()->has('catechistes')) {
            $item->catechistes()->sync(request()->input('catechistes', []));
        }
    }
    
    public function create() {
        $item = new ($this->model)();
        $item->niveau_complet = '';
        $item->catechistes = [];
        return $this->view('crud.form', ['item' => $item]);
    }
    
    public function edit($id) {
        $item = ($this->model)::with('catechistes')->findOrFail($id);
        $item->niveau_complet = $item->niveau . ($item->code ? " {$item->code}" : '');
        $item->catechistes = $item->catechistes->pluck('id')->toArray();
        return $this->view('crud.form', ['item' => $item]);
    }
    protected function columns(): array {
        return [
            'Année' => fn ($c) => $c->anneeCatechetique ? $c->anneeCatechetique->libelle : '—',
            'Niveau' => fn ($c) => $c->niveau . ($c->code ? " {$c->code}" : ''),
            'Section' => fn ($c) => ClasseCate::getSections()[$c->section] ?? $c->section,
            'Catéchistes' => fn ($c) => $c->catechistes->count() > 0 ? implode(', ', $c->catechistes->map(fn ($cat) => $cat->nom . ' ' . $cat->prenoms)->toArray()) : '—',
            'Inscrits' => fn ($c) => $c->catechumenes()->count()
        ];
    }
}
