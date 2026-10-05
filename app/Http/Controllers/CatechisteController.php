<?php
namespace App\Http\Controllers;
use App\Models\Catechiste;
class CatechisteController extends CrudController {
    protected string $model = Catechiste::class; protected string $route = 'catechistes';
    protected string $titre = 'Catéchistes/Animateurs'; protected string $singulier = 'Catéchiste';
    protected array $searchable = ['nom', 'prenoms', 'telephone'];
    protected array $with = ['classes'];
    protected function fields(): array {
        return [
            'nom' => ['Nom', 'text', true],
            'prenoms' => ['Prénoms', 'text', true],
            'telephone' => ['Téléphone', 'text', false],
            'section' => ['Section', 'select', true, Catechiste::getSections()],
            'statut' => ['Statut', 'select', true, Catechiste::getStatuts()],
            'classes' => ['Classes', 'checkbox', false, \App\Models\ClasseCate::options()],
            'observations' => ['Observations', 'textarea', false]
        ];
    }
    protected function columns(): array {
        return [
            'Nom' => 'nom',
            'Prénoms' => 'prenoms',
            'Téléphone' => 'telephone',
            'Section' => fn ($c) => Catechiste::getSections()[$c->section] ?? $c->section,
            'Statut' => fn ($c) => $c->statut === 'actif' ? '<span class="badge bg-success">Actif</span>' : '<span class="badge bg-secondary">Inactif</span>',
            'Classes' => fn ($c) => $c->classes->count() > 0 ? '<span class="badge bg-info">' . $c->classes->count() . '</span>' : '—'
        ];
    }

    protected function prepare(array $data, $item = null): array {
        if (isset($data['classes'])) {
            $classes = $data['classes'];
            unset($data['classes']);
        }
        return $data;
    }

    protected function after($item, bool $created): void {
        if (request()->has('classes')) {
            $item->classes()->sync(request()->input('classes', []));
        }
    }

    public function edit($id) {
        $item = ($this->model)::with('classes')->findOrFail($id);
        $item->classes = $item->classes->pluck('id')->toArray();
        return $this->view('crud.form', ['item' => $item]);
    }

    public function create() {
        $item = new ($this->model)();
        $item->classes = [];
        return $this->view('crud.form', ['item' => $item]);
    }
}
