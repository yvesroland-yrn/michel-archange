<?php
namespace App\Http\Controllers;
use App\Models\AnneeCatechetique;
class AnneeCatechetiqueController extends CrudController {
    protected string $model = AnneeCatechetique::class; protected string $route = 'annees-catechetiques';
    protected string $titre = 'Années catéchétiques'; protected string $singulier = 'Année catéchétique';
    protected array $searchable = ['libelle'];
    protected array $with = ['classes'];
    protected function fields(): array {
        return [
            'libelle' => ['Libellé (ex. 2026-2027)', 'text', true],
            'date_debut' => ['Date de début', 'date', true],
            'date_fin' => ['Date de fin', 'date', true],
            'statut' => ['Statut', 'select', true, AnneeCatechetique::getStatuts()],
            'observations' => ['Observations', 'textarea', false]
        ];
    }
    protected function columns(): array {
        return [
            'Libellé' => 'libelle',
            'Date de début' => fn ($a) => $a->date_debut->format('d/m/Y'),
            'Date de fin' => fn ($a) => $a->date_fin->format('d/m/Y'),
            'Statut' => fn ($a) => $a->statut === 'actif' ? '<span class="badge bg-success">Actif</span>' : '<span class="badge bg-secondary">Clôturé</span>',
            'Classes' => fn ($a) => $a->classes()->count()
        ];
    }
}
