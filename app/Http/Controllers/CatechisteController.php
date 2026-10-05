<?php
namespace App\Http\Controllers;
use App\Models\Catechiste;
class CatechisteController extends CrudController {
    protected string $model = Catechiste::class; protected string $route = 'catechistes';
    protected string $titre = 'Catéchistes/Animateurs'; protected string $singulier = 'Catéchiste';
    protected array $searchable = ['nom', 'prenoms', 'telephone'];
    protected array $with = ['fidele'];
    protected function fields(): array {
        return [
            'nom' => ['Nom', 'text', true],
            'prenoms' => ['Prénoms', 'text', true],
            'telephone' => ['Téléphone', 'text', false],
            'section' => ['Section', 'select', true, Catechiste::getSections()],
            'statut' => ['Statut', 'select', true, Catechiste::getStatuts()],
            'fidele_id' => ['Fidèle associé (optionnel)', 'select', false, [null => '—'] + \App\Models\Fidele::orderBy('nom')->orderBy('prenoms')->pluck('id', \DB::raw("CONCAT(nom, ' ', prenoms)"))->toArray()],
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
            'Fidèle' => fn ($c) => $c->fidele ? "<a href='".route('fideles.show', $c->fidele_id)."'>{$c->fidele->nom} {$c->fidele->prenoms}</a>" : '—'
        ];
    }
}
