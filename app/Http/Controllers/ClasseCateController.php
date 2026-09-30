<?php
namespace App\Http\Controllers;
use App\Models\ClasseCate;
class ClasseCateController extends CrudController {
    protected string $model = ClasseCate::class; protected string $route = 'classes-cate';
    protected string $titre = 'Classes de catéchèse'; protected string $singulier = 'Classe';
    protected array $searchable = ['annee', 'niveau', 'catechiste'];
    protected function fields(): array { return ['annee' => ['Année catéchétique (ex. 2026-2027)', 'text', true], 'niveau' => ['Niveau', 'text', true], 'catechiste' => ['Catéchiste', 'text']]; }
    protected function columns(): array { return ['Année' => 'annee', 'Niveau' => 'niveau', 'Catéchiste' => 'catechiste', 'Inscrits' => fn ($c) => $c->catechumenes()->count()]; }
}
