<?php
namespace App\Http\Controllers;
use App\Models\Evenement;
class EvenementController extends CrudController {
    protected string $model = Evenement::class; protected string $route = 'evenements';
    protected string $titre = 'Messes et calendrier paroissial'; protected string $singulier = 'Événement';
    protected array $searchable = ['titre', 'celebrant', 'lieu']; protected string $order = 'date_heure';
    protected function fields(): array {
        return ['titre' => ['Titre', 'text', true], 'type' => ['Type', 'select', true, Evenement::TYPES], 'date_heure' => ['Date et heure', 'datetime', true],
            'lieu' => ['Lieu', 'text'], 'celebrant' => ['Célébrant', 'text'], 'description' => ['Description', 'textarea']];
    }
    protected function columns(): array { return ['Date' => 'date_heure', 'Titre' => 'titre', 'Type' => fn ($e) => Evenement::TYPES[$e->type] ?? $e->type, 'Lieu' => 'lieu', 'Célébrant' => 'celebrant']; }
}
