<?php
namespace App\Http\Controllers;
use App\Models\ClasseCate;
class ClasseCateController extends CrudController {
    protected string $model = ClasseCate::class; protected string $route = 'classes-cate';
    protected string $titre = 'Classes de catéchèse'; protected string $singulier = 'Classe';
    protected array $searchable = ['niveau', 'code', 'section'];
    protected array $with = ['catechiste', 'anneeCatechetique'];
    protected function fields(): array {
        $niveaux = ClasseCate::getNiveauxAvecCode();
        return [
            'annee_catechetique_id' => ['Année catéchétique', 'select', true, \App\Models\AnneeCatechetique::options()],
            'niveau_complet' => ['Niveau', 'select', true, $niveaux],
            'section' => ['Section', 'select', true, ClasseCate::getSections()],
            'catechiste_id' => ['Catéchiste', 'select', false, [null => '—'] + \App\Models\Catechiste::options()]
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
        return $data;
    }
    
    public function create() {
        $item = new ($this->model)();
        $item->niveau_complet = '';
        return $this->view('crud.form', ['item' => $item]);
    }
    
    public function edit($id) {
        $item = ($this->model)::findOrFail($id);
        $item->niveau_complet = $item->niveau . ($item->code ? " {$item->code}" : '');
        return $this->view('crud.form', ['item' => $item]);
    }
    protected function columns(): array {
        return [
            'Année' => fn ($c) => $c->anneeCatechetique ? $c->anneeCatechetique->libelle : '—',
            'Niveau' => fn ($c) => $c->niveau . ($c->code ? " {$c->code}" : ''),
            'Section' => fn ($c) => ClasseCate::getSections()[$c->section] ?? $c->section,
            'Catéchiste' => fn ($c) => $c->catechiste ? $c->catechiste->nom . ' ' . $c->catechiste->prenoms : '—',
            'Inscrits' => fn ($c) => $c->catechumenes()->count()
        ];
    }
}
