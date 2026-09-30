<?php
namespace App\Http\Controllers;
use App\Models\{Sacrement, Fidele};
use Barryvdh\DomPDF\Facade\Pdf;
class SacrementController extends CrudController {
    protected string $model = Sacrement::class; protected string $route = 'sacrements';
    protected string $titre = 'Sacrements (hors baptême)'; protected string $singulier = 'Sacrement';
    protected array $with = ['fidele', 'conjoint'];
    protected function fields(): array {
        $f = Fidele::options();
        return ['type' => ['Sacrement', 'select', true, Sacrement::TYPES], 'fidele_id' => ['Fidèle (époux pour un mariage)', 'select', true, $f],
            'conjoint_id' => ['Épouse (mariage uniquement)', 'select', false, $f], 'date_celebration' => ['Date de célébration', 'date', true],
            'lieu' => ['Lieu', 'text'], 'ministre' => ['Ministre / célébrant', 'text'], 'temoin1' => ['Témoin 1', 'text'], 'temoin2' => ['Témoin 2', 'text'],
            'observations' => ['Observations', 'textarea']];
    }
    protected function columns(): array {
        return ['N° acte' => 'numero_acte', 'Sacrement' => fn ($s) => Sacrement::TYPES[$s->type] ?? $s->type, 'Fidèle' => fn ($s) => $s->fidele?->nom_complet.($s->conjoint ? ' & '.$s->conjoint->nom_complet : ''), 'Date' => 'date_celebration'];
    }
    protected function links($item): array { return ['Certificat PDF' => route('sacrements.certificat', $item->id)]; }
    protected function prepare(array $d, $item = null): array {
        if (! $item) $d['numero_acte'] = Sacrement::prochainNumero($d['type']);
        if ($d['type'] !== 'mariage') $d['conjoint_id'] = null;
        return $d;
    }
    public function certificat(Sacrement $sacrement) {
        return Pdf::loadView('pdf.sacrement', ['s' => $sacrement->load('fidele', 'conjoint'), 'libelle' => Sacrement::TYPES[$sacrement->type]])->stream("certificat-{$sacrement->numero_acte}.pdf");
    }
}
