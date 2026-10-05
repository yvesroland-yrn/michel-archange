<?php
namespace App\Http\Controllers;
use App\Models\{Intention, Evenement};
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;
class IntentionController extends CrudController {
    protected string $model = Intention::class; protected string $route = 'intentions';
    protected string $titre = 'Intentions de messe'; protected string $singulier = 'Intention';
    protected array $with = ['user']; protected array $searchable = ['demandeur', 'intention', 'recu_numero'];

    protected function fields(): array {
        return [
            'demandeur' => ['Demandeur', 'text', true],
            'telephone' => ['Téléphone', 'text'],
            'type' => ['Type d\'intention', 'select', true, Intention::TYPES],
            'intention' => ['Intention', 'textarea', true],
            'offrande' => ['Offrande (FCFA)', 'number', true],
            'date_messe' => ['Date souhaitée', 'date', true],
            'jour_messe_detaille' => ['Jour de messe', 'select', false, Intention::JOURS_MESSE_DETAILLES],
            'statut' => ['Statut', 'select', true, Intention::STATUTS],
        ];
    }

    protected function columns(): array {
        return [
            'Reçu' => 'recu_numero',
            'Demandeur' => 'demandeur',
            'Type' => fn ($i) => $i->type_libelle,
            'Intention' => fn ($i) => str($i->intention)->limit(50),
            'Offrande' => fn ($i) => number_format($i->offrande, 0, ',', ' '),
            'Date' => 'date_messe',
        ];
    }

    protected function links($item): array {
        $links = ['Reçu PDF' => route('intentions.recu', $item->id)];
        if ($item->statut === 'tiree') {
            $links['Marquer célébrée'] = route('intentions.celebrer', $item->id);
        }
        return $links;
    }

    protected function prepare(array $d, $item = null): array {
        if (!$item) {
            $d += [
                'recu_numero' => Intention::prochainRecu(),
                'user_id' => auth()->id(),
                'statut' => 'en_attente',
                'numero_semaine' => Intention::getNumeroSemaine(),
            ];
        }
        return $d;
    }

    public function recu(Intention $intention) {
        $logoPath = public_path('images/saint.jpg');
        $logoData = base64_encode(file_get_contents($logoPath));
        $logoSrc = 'data:image/jpeg;base64,' . $logoData;

        return Pdf::loadView('pdf.recu', [
            'numero' => $intention->recu_numero,
            'date' => $intention->created_at,
            'de' => $intention->demandeur,
            'motif' => 'Offrande de messe — ' . $intention->intention,
            'montant' => $intention->offrande,
            'logoSrc' => $logoSrc,
            'categorie' => 'Intention de messe'
        ])->stream("recu-{$intention->recu_numero}.pdf");
    }

    // Marquer une intention comme célébrée
    public function celebrer(Intention $intention) {
        $intention->marquerCelebree();
        return back()->with('ok', 'Intention marquée comme célébrée.');
    }

    // Page de tirage des intentions
    public function tirage() {
        $numeroSemaine = request()->get('semaine', Intention::getNumeroSemaine());
        $intentionsEnAttente = Intention::getIntentionsEnAttente($numeroSemaine);
        $intentionsTirees = Intention::getIntentionsTirees($numeroSemaine);

        // Séparer par jour
        $samediIntentions = $intentionsTirees->where('jour_messe', 'samedi');
        $dimancheIntentions = $intentionsTirees->where('jour_messe', 'dimanche');

        return view('intentions.tirage', compact(
            'numeroSemaine',
            'intentionsEnAttente',
            'intentionsTirees',
            'samediIntentions',
            'dimancheIntentions'
        ));
    }

    // Effectuer le tirage des intentions
    public function effectuerTirage(Request $request) {
        $numeroSemaine = $request->get('semaine', Intention::getNumeroSemaine());
        $tirees = Intention::tirerIntentions($numeroSemaine);

        return redirect()->route('intentions.tirage', ['semaine' => $numeroSemaine])
            ->with('ok', count($tirees) . ' intention(s) tirée(s) pour la semaine ' . $numeroSemaine);
    }

    // Générer la liste des intentions pour impression
    public function listeSemaine(Request $request) {
        $numeroSemaine = $request->get('semaine', Intention::getNumeroSemaine());
        $intentionsTirees = Intention::getIntentionsTirees($numeroSemaine);

        $samediIntentions = $intentionsTirees->where('jour_messe', 'samedi');
        $dimancheIntentions = $intentionsTirees->where('jour_messe', 'dimanche');

        return Pdf::loadView('intentions.liste-pdf', compact(
            'numeroSemaine',
            'samediIntentions',
            'dimancheIntentions'
        ))->stream("intentions-semaine-{$numeroSemaine}.pdf");
    }

    // Override index pour utiliser la vue personnalisée
    public function index(Request $r)
    {
        $q = ($this->model)::with($this->with);
        if ($r->filled('q') && $this->searchable) {
            $q->where(fn ($w) => collect($this->searchable)->each(fn ($c) => $w->orWhere($c, 'like', '%'.$r->q.'%')));
        }
        $items = $q->orderBy($this->order, $this->dir)->paginate(20)->withQueryString();
        return $this->view('intentions.index', ['items' => $items, 'columns' => $this->columns(), 'controller' => $this, 'searchable' => (bool) $this->searchable]);
    }

    // Exporter la liste simple (nom + intention) par type
    public function exportListe(Request $request) {
        $type = $request->get('type', 'tous'); // action_grace, repos_eternel, tous
        $numeroSemaine = $request->get('semaine', null);

        $query = Intention::query();

        // Filtrer par type si spécifié
        if ($type !== 'tous') {
            $query->where('type', $type);
        }

        // Filtrer par semaine si spécifié
        if ($numeroSemaine) {
            $query->where('numero_semaine', $numeroSemaine);
        }

        $intentions = $query->orderBy('created_at', 'desc')->get();

        // Créer un fichier CSV simple
        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=intentions-{$type}" . ($numeroSemaine ? "-{$numeroSemaine}" : "") . ".csv",
        ];

        $callback = function () use ($intentions) {
            $file = fopen('php://output', 'w');
            // Ajouter BOM pour UTF-8
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));

            // En-têtes
            fputcsv($file, ['Demandeur', 'Intention', 'Type', 'Offrande (FCFA)'], ';');

            // Données
            foreach ($intentions as $intention) {
                fputcsv($file, [
                    $intention->demandeur,
                    $intention->intention,
                    $intention->type_libelle,
                    $intention->offrande,
                ], ';');
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    // Exporter en PDF simple
    public function exportPdf(Request $request) {
        $type = $request->get('type', 'tous');
        $numeroSemaine = $request->get('semaine', null);

        $query = Intention::query();

        if ($type !== 'tous') {
            $query->where('type', $type);
        }

        if ($numeroSemaine) {
            $query->where('numero_semaine', $numeroSemaine);
        }

        $intentions = $query->orderBy('created_at', 'desc')->get();

        $logoPath = public_path('images/saint.jpg');
        $logoData = base64_encode(file_get_contents($logoPath));
        $logoSrc = 'data:image/jpeg;base64,' . $logoData;

        return Pdf::loadView('intentions.export-pdf', compact(
            'intentions',
            'type',
            'numeroSemaine',
            'logoSrc'
        ))->stream("intentions-{$type}" . ($numeroSemaine ? "-{$numeroSemaine}" : "") . ".pdf");
    }

    // Exporter en Word
    public function exportWord(Request $request) {
        $type = $request->get('type', 'tous');
        $numeroSemaine = $request->get('semaine', null);

        $query = Intention::query();

        if ($type !== 'tous') {
            $query->where('type', $type);
        }

        if ($numeroSemaine) {
            $query->where('numero_semaine', $numeroSemaine);
        }

        $intentions = $query->orderBy('created_at', 'desc')->get();

        $phpWord = new PhpWord();

        // Ajouter une section
        $section = $phpWord->addSection();

        // Titre
        $section->addText('Liste des Intentions de Messe', ['bold' => true, 'size' => 16], ['alignment' => 'center']);
        $section->addTextBreak();

        if ($numeroSemaine) {
            $section->addText('Semaine : ' . $numeroSemaine, ['size' => 12], ['alignment' => 'center']);
            $section->addTextBreak();
        }

        if ($type !== 'tous') {
            $typeLibelle = Intention::TYPES[$type] ?? 'Tous';
            $section->addText('Type : ' . $typeLibelle, ['size' => 12], ['alignment' => 'center']);
            $section->addTextBreak();
        }

        // Tableau
        $table = $section->addTable(['borderSize' => 6, 'borderColor' => '000000', 'cellMargin' => 80]);

        // En-têtes
        $table->addRow();
        $table->addCell(2000)->addText('Demandeur', ['bold' => true]);
        $table->addCell(5000)->addText('Intention', ['bold' => true]);
        $table->addCell(2000)->addText('Type', ['bold' => true]);

        // Données
        foreach ($intentions as $intention) {
            $table->addRow();
            $table->addCell(2000)->addText($intention->demandeur);
            $table->addCell(5000)->addText($intention->intention);
            $table->addCell(2000)->addText($intention->type_libelle);
        }

        // Sauvegarder
        $filename = "intentions-{$type}" . ($numeroSemaine ? "-{$numeroSemaine}" : "") . ".docx";
        $tempPath = storage_path('app/temp/' . $filename);

        if (!file_exists(storage_path('app/temp'))) {
            mkdir(storage_path('app/temp'), 0755, true);
        }

        $objWriter = IOFactory::createWriter($phpWord, 'Word2007');
        $objWriter->save($tempPath);

        return response()->download($tempPath, $filename)->deleteFileAfterSend();
    }
}
