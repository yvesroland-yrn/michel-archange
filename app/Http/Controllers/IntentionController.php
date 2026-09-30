<?php
namespace App\Http\Controllers;
use App\Models\{Intention, Evenement};
use Barryvdh\DomPDF\Facade\Pdf;
class IntentionController extends CrudController {
    protected string $model = Intention::class; protected string $route = 'intentions';
    protected string $titre = 'Intentions de messe'; protected string $singulier = 'Intention';
    protected array $with = ['evenement']; protected array $searchable = ['demandeur', 'intention', 'recu_numero'];
    protected function fields(): array {
        return ['demandeur' => ['Demandeur', 'text', true], 'telephone' => ['Téléphone', 'text'], 'intention' => ['Intention', 'textarea', true],
            'offrande' => ['Offrande (FCFA)', 'number', true], 'date_messe' => ['Date souhaitée', 'date', true],
            'evenement_id' => ['Messe programmée', 'select', false, Evenement::options()], 'statut' => ['Statut', 'select', true, ['recue' => 'Reçue', 'celebree' => 'Célébrée']]];
    }
    protected function columns(): array { return ['Reçu' => 'recu_numero', 'Demandeur' => 'demandeur', 'Intention' => fn ($i) => str($i->intention)->limit(50), 'Offrande' => fn ($i) => number_format($i->offrande, 0, ',', ' '), 'Date' => 'date_messe', 'Statut' => 'statut']; }
    protected function links($item): array { return ['Reçu PDF' => route('intentions.recu', $item->id)]; }
    protected function prepare(array $d, $item = null): array {
        if (! $item) $d += ['recu_numero' => Intention::prochainRecu(), 'user_id' => auth()->id()];
        return $d;
    }
    public function recu(Intention $intention) {
        return Pdf::loadView('pdf.recu', ['numero' => $intention->recu_numero, 'date' => $intention->created_at, 'de' => $intention->demandeur,
            'motif' => 'Offrande de messe — '.$intention->intention, 'montant' => $intention->offrande])->stream("recu-{$intention->recu_numero}.pdf");
    }
}
