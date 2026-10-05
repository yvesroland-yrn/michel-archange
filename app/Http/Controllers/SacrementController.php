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
    protected function links($item): array {
        $links = [];
        if ($item->type === 'confirmation') {
            $links['Certificat PDF'] = route('sacrements.certificat-confirmation', $item->id);
        } elseif ($item->type === 'mariage') {
            $links['Certificat PDF'] = route('sacrements.certificat-mariage', $item->id);
        } else {
            $links['Certificat PDF'] = route('sacrements.certificat', $item->id);
        }
        return $links;
    }
    protected function prepare(array $d, $item = null): array {
        if (! $item) $d['numero_acte'] = Sacrement::prochainNumero($d['type']);
        if ($d['type'] !== 'mariage') $d['conjoint_id'] = null;
        return $d;
    }
    public function certificat(Sacrement $sacrement) {
        return Pdf::loadView('pdf.sacrement', ['s' => $sacrement->load('fidele', 'conjoint'), 'libelle' => Sacrement::TYPES[$sacrement->type]])->stream("certificat-{$sacrement->numero_acte}.pdf");
    }

    public function certificatConfirmation(Sacrement $sacrement) {
        abort_if($sacrement->type !== 'confirmation', 404, 'Ce sacrement n\'est pas une confirmation.');
        return Pdf::loadView('sacrements.certificat-confirmation', ['s' => $sacrement->load('fidele')])->stream("certificat-confirmation-{$sacrement->numero_acte}.pdf");
    }

    public function certificatMariage(Sacrement $sacrement) {
        abort_if($sacrement->type !== 'mariage', 404, 'Ce sacrement n\'est pas un mariage.');
        return Pdf::loadView('sacrements.certificat-mariage', ['s' => $sacrement->load('fidele', 'conjoint')])->stream("certificat-mariage-{$sacrement->numero_acte}.pdf");
    }
}
