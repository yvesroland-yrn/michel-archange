<?php
namespace App\Http\Controllers;
use App\Models\ClasseCate;
class ClasseCateController extends CrudController {
    protected string $model = ClasseCate::class; protected string $route = 'classes-cate';
    protected string $titre = 'Classes de catéchèse'; protected string $singulier = 'Classe';
    protected array $searchable = ['niveau', 'code', 'section'];
    protected array $with = ['catechiste', 'anneeCatechetique'];
    protected function fields(): array {
        return [
            'annee_catechetique_id' => ['Année catéchétique', 'select', true, \App\Models\AnneeCatechetique::options()],
            'niveau' => ['Niveau', 'select', true, ClasseCate::getNiveaux()],
            'code' => ['Code (ex. A, B, C)', 'text', false],
            'section' => ['Section', 'select', true, ClasseCate::getSections()],
            'catechiste_id' => ['Catéchiste', 'select', false, [null => '—'] + \App\Models\Catechiste::options()]
        ];
    }
    protected function columns(): array {
        return [
            'Année' => fn ($c) => $c->anneeCatechetique ? $c->anneeCatechetique->libelle : '—',
            'Niveau' => fn ($c) => $c->niveau . ($c->code ? " ({$c->code})" : ''),
            'Section' => fn ($c) => ClasseCate::getSections()[$c->section] ?? $c->section,
            'Catéchiste' => fn ($c) => $c->catechiste ? $c->catechiste->nom . ' ' . $c->catechiste->prenoms : '—',
            'Inscrits' => fn ($c) => $c->catechumenes()->count()
        ];
    }
}
