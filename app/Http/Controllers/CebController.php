<?php
namespace App\Http\Controllers;
use App\Models\Ceb;
class CebController extends CrudController {
    protected string $model = Ceb::class; protected string $route = 'cebs';
    protected string $titre = 'Communautés ecclésiales de base (CEB)'; protected string $singulier = 'CEB';
    protected array $searchable = ['nom', 'responsable', 'numero_responsable', 'zone_couverture']; protected string $order = 'nom'; protected string $dir = 'asc';
    protected function fields(): array { return ['nom' => ['Nom', 'text', true], 'responsable' => ['Responsable', 'text'], 'numero_responsable' => ['Numéro du responsable', 'text'], 'zone_couverture' => ['Zone de couverture', 'text']]; }
    protected function columns(): array { return ['Nom' => 'nom', 'Responsable' => 'responsable', 'Numéro' => 'numero_responsable', 'Zone de couverture' => 'zone_couverture', 'Fidèles' => fn ($c) => $c->fideles()->count()]; }
    protected function extraRules($item = null): array { return ['nom' => 'required|string|max:255|unique:cebs,nom,'.($item?->id ?? 'NULL')]; }
}
