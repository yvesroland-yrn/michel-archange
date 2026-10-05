<?php
namespace App\Http\Controllers;
use App\Models\{Sacrement, Fidele};
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
class SacrementController extends CrudController {
    protected string $model = Sacrement::class; protected string $route = 'sacrements';
    protected string $titre = 'Sacrements (hors baptême)'; protected string $singulier = 'Sacrement';
    protected array $with = ['fidele', 'conjoint'];
    protected function fields(): array {
        $f = Fidele::options();
        return ['type' => ['Sacrement', 'select', true, Sacrement::TYPES], 'fidele_id' => ['Fidèle (époux pour un mariage)', 'select', true, $f],
            'conjoint_id' => ['Épouse (mariage uniquement)', 'select', false, $f], 'nom_epouse' => ['Nom de l\'épouse (si non fidèle)', 'text', false], 'date_celebration' => ['Date de célébration', 'date', true],
            'lieu' => ['Lieu', 'text', false], 'ministre' => ['Ministre / célébrant', 'text', false], 'temoin1' => ['Témoin 1', 'text', false], 'temoin2' => ['Témoin 2', 'text', false],
            'numero_registre_mariage' => ['Numéro de registre de mariage', 'text', false], 'observations' => ['Observations', 'textarea', false]];
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
        if ($d['type'] !== 'mariage') {
            $d['conjoint_id'] = null;
            $d['nom_epouse'] = null;
            $d['numero_registre_mariage'] = null;
        }
        return $d;
    }

    protected function extraRules($item = null): array {
        $rules = [];
        if (request()->get('type') === 'mariage') {
            $rules['numero_registre_mariage'] = 'nullable|string|max:100';
            $rules['nom_epouse'] = 'nullable|string|max:255';
        }
        return $rules;
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

    public function create() {
        $item = new ($this->model)();
        if (request()->has('type')) {
            $item->type = request()->type;
        }
        if (request()->has('fidele_id')) {
            $item->fidele_id = request()->fidele_id;
        }
        return $this->view('crud.form', ['item' => $item]);
    }
}
