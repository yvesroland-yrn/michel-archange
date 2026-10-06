<?php
namespace App\Http\Controllers;
use App\Models\{Catechumene, ClasseCate, Fidele, AnneeCatechetique};
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;
class CatechumeneController extends CrudController {
    protected string $model = Catechumene::class; protected string $route = 'catechumenes';
    protected string $titre = 'Catéchumènes'; protected string $singulier = 'Inscription';
    protected array $with = ['fidele', 'classe', 'mouvement'];
    protected function fields(): array {
        return [
            'fidele_id' => ['Fidèle existant', 'select', false, [null => '—'] + Fidele::options()],
            'nom' => ['Nom', 'text', false],
            'prenoms' => ['Prénoms', 'text', false],
            'profession' => ['Profession', 'text', false],
            'situation' => ['Situation', 'select', false, ['eleve' => 'Élève', 'etudiant' => 'Étudiant', 'travailleur' => 'Travailleur']],
            'classe_etude' => ['Classe (si élève/étudiant)', 'text', false],
            'telephone' => ['Téléphone', 'text', false],
            'telephone_parent' => ['Téléphone des parents', 'text', false],
            'nom_urgence' => ['Nom du contact urgence', 'text', false],
            'contact_urgence' => ['Contact urgence', 'text', false],
            'parrain' => ['Parrain', 'text', false],
            'marraine' => ['Marraine', 'text', false],
            'annee_cate' => ['Année catéchèse souhaitée', 'text', false],
            'ceb' => ['CEB', 'select', false, [null => '—'] + \App\Models\Ceb::options()],
            'mouvement_id' => ['Mouvement', 'select', false, [null => '—'] + \App\Models\Mouvement::options()],
            'bapte' => ['Baptisé', 'checkbox', false],
            'montant_a_payer' => ['Montant à payer', 'number', false],
            'classe_cate_id' => ['Classe', 'select', true, ClasseCate::options()],
            'statut' => ['Statut', 'select', true, ['inscrit' => 'Inscrit', 'admis' => 'Admis', 'ajourne' => 'Ajourné']],
            'observation' => ['Observation', 'textarea', false]
        ];
    }
    protected function columns(): array {
        return [
            'Catéchumène' => fn ($c) => $c->fidele ? $c->fidele->nom . ' ' . $c->fidele->prenoms : ($c->nom . ' ' . $c->prenoms),
            'Classe' => fn ($c) => $c->classe ? $c->classe->niveau . ($c->classe->code ? " {$c->classe->code}" : '') : '—',
            'Année' => fn ($c) => $c->annee_cate ?? '—',
            'Mouvement' => fn ($c) => $c->mouvement ? $c->mouvement->nom : '—',
            'Montant payé' => fn ($c) => $c->montant_a_payer ? number_format($c->montant_a_payer, 0, '', ' ') . ' FCFA' : '—',
            'Statut' => fn ($c) => $c->statut === 'inscrit' ? '<span class="badge bg-primary">Inscrit</span>' : ($c->statut === 'admis' ? '<span class="badge bg-success">Admis</span>' : '<span class="badge bg-warning">Ajourné</span>'),
            'Baptisé' => fn ($c) => $c->bapte ? '<span class="badge bg-success">Oui</span>' : '<span class="badge bg-secondary">Non</span>'
        ];
    }

    protected function links($item): array {
        return [
            'Reçu' => route('catechumenes.recu', $item->id)
        ];
    }

    protected function extraRules($item = null): array {
        return [
            'fidele_id' => 'nullable|exists:fideles,id',
            'nom' => 'nullable|required_without:fidele_id|string|max:255',
            'prenoms' => 'nullable|required_without:fidele_id|string|max:255',
        ];
    }

    protected function prepare(array $data, $item = null): array {
        if (!empty($data['fidele_id'])) {
            unset($data['nom'], $data['prenoms'], $data['profession'], $data['situation'], $data['classe_etude'],
                  $data['telephone'], $data['telephone_parent'], $data['nom_urgence'], $data['contact_urgence'],
                  $data['parrain'], $data['marraine'], $data['annee_cate'], $data['ceb'], $data['bapte'], $data['montant_a_payer']);
        }
        $data['bapte'] = isset($data['bapte']) ? true : false;
        return $data;
    }

    protected function after($item, bool $created): void {
        if ($item->mouvement_id) {
            if ($item->fidele_id) {
                // Si un fidèle existe, l'ajouter au mouvement
                $item->fidele->mouvements()->syncWithoutDetaching([$item->mouvement_id => ['fonction' => 'Membre']]);
            } elseif ($item->nom && $item->prenoms) {
                // Si pas de fidèle mais nom/prénoms, créer un fidèle et l'ajouter au mouvement
                $fidele = \App\Models\Fidele::create([
                    'nom' => $item->nom,
                    'prenoms' => $item->prenoms,
                    'sexe' => 'M',
                    'telephone' => $item->telephone,
                    'profession' => $item->profession,
                    'statut' => 'actif'
                ]);
                $item->fidele_id = $fidele->id;
                $item->save();
                $fidele->mouvements()->syncWithoutDetaching([$item->mouvement_id => ['fonction' => 'Membre']]);
            }
        }
    }

    public function create() {
        $item = new ($this->model)();
        $anneeCourante = date('Y');
        $anneeSuivante = $anneeCourante + 1;
        $item->annee_cate = $anneeCourante . '-' . $anneeSuivante;
        return $this->view('crud.form', ['item' => $item]);
    }

    public function recu(Catechumene $catechumene) {
        $logoPath = public_path('images/saint.jpg');
        $logoData = base64_encode(file_get_contents($logoPath));
        $logoSrc = 'data:image/jpeg;base64,' . $logoData;

        $nom = $catechumene->fidele ? $catechumene->fidele->nom . ' ' . $catechumene->fidele->prenoms : ($catechumene->nom . ' ' . $catechumene->prenoms);
        $classe = $catechumene->classe ? $catechumene->classe->niveau . ($catechumene->classe->code ? " {$catechumene->classe->code}" : '') : '—';
        $mouvement = $catechumene->mouvement ? $catechumene->mouvement->nom : '—';

        return Pdf::loadView('pdf.recu-catechumene', [
            'numero' => 'CAT-' . str_pad($catechumene->id, 6, '0', STR_PAD_LEFT),
            'date' => $catechumene->created_at,
            'nom' => $nom,
            'annee_cate' => $catechumene->annee_cate ?? '—',
            'classe' => $classe,
            'mouvement' => $mouvement,
            'montant' => $catechumene->montant_a_payer ?? 0,
            'logoSrc' => $logoSrc,
            'categorie' => 'Inscription Catéchèse'
        ])->stream("recu-catechumene-{$catechumene->id}.pdf");
    }

    // Export PDF par classe
    public function exportPdfParClasse(Request $request) {
        $classeId = $request->get('classe_id');
        
        if (!$classeId) {
            return back()->with('error', 'Veuillez sélectionner une classe.');
        }

        $classe = ClasseCate::with('anneeCatechetique')->findOrFail($classeId);
        $catechumenes = Catechumene::with('fidele', 'mouvement')
            ->where('classe_cate_id', $classeId)
            ->orderBy('created_at')
            ->get();

        $logoPath = public_path('images/saint.jpg');
        $logoData = base64_encode(file_get_contents($logoPath));
        $logoSrc = 'data:image/jpeg;base64,' . $logoData;

        return Pdf::loadView('pdf.catechumenes-par-classe', compact(
            'catechumenes',
            'classe',
            'logoSrc'
        ))->stream("catechumenes-classe-{$classe->id}.pdf");
    }

    // Export PDF par année catéchétique
    public function exportPdfParAnnee(Request $request) {
        $anneeId = $request->get('annee_id');
        
        if (!$anneeId) {
            return back()->with('error', 'Veuillez sélectionner une année catéchétique.');
        }

        $annee = AnneeCatechetique::findOrFail($anneeId);
        $classes = ClasseCate::where('annee_catechetique_id', $anneeId)
            ->with('catechumenes.fidele', 'catechumenes.mouvement')
            ->orderBy('niveau')
            ->orderBy('code')
            ->get();

        $logoPath = public_path('images/saint.jpg');
        $logoData = base64_encode(file_get_contents($logoPath));
        $logoSrc = 'data:image/jpeg;base64,' . $logoData;

        return Pdf::loadView('pdf.catechumenes-par-annee', compact(
            'classes',
            'annee',
            'logoSrc'
        ))->stream("catechumenes-annee-{$annee->id}.pdf");
    }

    // Export Word par classe
    public function exportWordParClasse(Request $request) {
        $classeId = $request->get('classe_id');
        
        if (!$classeId) {
            return back()->with('error', 'Veuillez sélectionner une classe.');
        }

        $classe = ClasseCate::with('anneeCatechetique')->findOrFail($classeId);
        $catechumenes = Catechumene::with('fidele', 'mouvement')
            ->where('classe_cate_id', $classeId)
            ->orderBy('created_at')
            ->get();

        $phpWord = new PhpWord();
        $section = $phpWord->addSection();

        // Titre
        $section->addText('Liste des Catéchumènes', ['bold' => true, 'size' => 16], ['alignment' => 'center']);
        $section->addTextBreak();

        // Détails de la classe
        $section->addText('Année catéchétique : ' . ($classe->anneeCatechetique ? $classe->anneeCatechetique->libelle : '—'), ['size' => 12]);
        $section->addText('Classe : ' . $classe->niveau . ($classe->code ? " {$classe->code}" : '') . ' - ' . ClasseCate::getSections()[$classe->section] ?? $classe->section, ['size' => 12]);
        $section->addText('Total : ' . $catechumenes->count() . ' catéchumène(s)', ['size' => 12]);
        $section->addTextBreak();

        // Tableau
        $table = $section->addTable(['borderSize' => 6, 'borderColor' => '000000', 'cellMargin' => 80]);

        // En-têtes
        $table->addRow();
        $table->addCell(3000)->addText('Nom & Prénoms', ['bold' => true]);
        $table->addCell(2000)->addText('Téléphone', ['bold' => true]);
        $table->addCell(2000)->addText('Statut', ['bold' => true]);
        $table->addCell(2000)->addText('Montant payé', ['bold' => true]);

        // Données
        foreach ($catechumenes as $catechumene) {
            $nom = $catechumene->fidele ? $catechumene->fidele->nom . ' ' . $catechumene->fidele->prenoms : ($catechumene->nom . ' ' . $catechumene->prenoms);
            $telephone = $catechumene->fidele ? $catechumene->fidele->telephone : $catechumene->telephone;
            $statut = ucfirst($catechumene->statut);
            $montant = $catechumene->montant_a_payer ? number_format($catechumene->montant_a_payer, 0, '', ' ') . ' FCFA' : '—';

            $table->addRow();
            $table->addCell(3000)->addText($nom);
            $table->addCell(2000)->addText($telephone ?? '—');
            $table->addCell(2000)->addText($statut);
            $table->addCell(2000)->addText($montant);
        }

        // Sauvegarder
        $filename = "catechumenes-classe-{$classe->id}.docx";
        $tempPath = storage_path('app/temp/' . $filename);

        if (!file_exists(storage_path('app/temp'))) {
            mkdir(storage_path('app/temp'), 0755, true);
        }

        $objWriter = IOFactory::createWriter($phpWord, 'Word2007');
        $objWriter->save($tempPath);

        return response()->download($tempPath, $filename)->deleteFileAfterSend();
    }

    // Export Word par année catéchétique
    public function exportWordParAnnee(Request $request) {
        $anneeId = $request->get('annee_id');
        
        if (!$anneeId) {
            return back()->with('error', 'Veuillez sélectionner une année catéchétique.');
        }

        $annee = AnneeCatechetique::findOrFail($anneeId);
        $classes = ClasseCate::where('annee_catechetique_id', $anneeId)
            ->with('catechumenes.fidele', 'catechumenes.mouvement')
            ->orderBy('niveau')
            ->orderBy('code')
            ->get();

        $phpWord = new PhpWord();
        $section = $phpWord->addSection();

        // Titre
        $section->addText('Liste des Catéchumènes par Année Catéchétique', ['bold' => true, 'size' => 16], ['alignment' => 'center']);
        $section->addTextBreak();

        // Détails de l'année
        $section->addText('Année catéchétique : ' . $annee->libelle, ['size' => 12], ['alignment' => 'center']);
        $section->addText('Total : ' . $classes->sum(function($classe) { return $classe->catechumenes->count(); }) . ' catéchumène(s)', ['size' => 12], ['alignment' => 'center']);
        $section->addTextBreak();

        // Grouper par classe
        foreach ($classes as $classe) {
            if ($classe->catechumenes->isEmpty()) continue;

            $section->addText($classe->niveau . ($classe->code ? " {$classe->code}" : '') . ' - ' . ClasseCate::getSections()[$classe->section] ?? $classe->section, ['bold' => true, 'size' => 12]);
            $section->addText('Effectif : ' . $classe->catechumenes->count(), ['size' => 10]);
            $section->addTextBreak();

            // Tableau pour cette classe
            $table = $section->addTable(['borderSize' => 6, 'borderColor' => '000000', 'cellMargin' => 80]);

            // En-têtes
            $table->addRow();
            $table->addCell(3000)->addText('Nom & Prénoms', ['bold' => true]);
            $table->addCell(2000)->addText('Téléphone', ['bold' => true]);
            $table->addCell(2000)->addText('Statut', ['bold' => true]);
            $table->addCell(2000)->addText('Montant payé', ['bold' => true]);

            // Données
            foreach ($classe->catechumenes as $catechumene) {
                $nom = $catechumene->fidele ? $catechumene->fidele->nom . ' ' . $catechumene->fidele->prenoms : ($catechumene->nom . ' ' . $catechumene->prenoms);
                $telephone = $catechumene->fidele ? $catechumene->fidele->telephone : $catechumene->telephone;
                $statut = ucfirst($catechumene->statut);
                $montant = $catechumene->montant_a_payer ? number_format($catechumene->montant_a_payer, 0, '', ' ') . ' FCFA' : '—';

                $table->addRow();
                $table->addCell(3000)->addText($nom);
                $table->addCell(2000)->addText($telephone ?? '—');
                $table->addCell(2000)->addText($statut);
                $table->addCell(2000)->addText($montant);
            }

            $section->addTextBreak(2);
        }

        // Sauvegarder
        $filename = "catechumenes-annee-{$annee->id}.docx";
        $tempPath = storage_path('app/temp/' . $filename);

        if (!file_exists(storage_path('app/temp'))) {
            mkdir(storage_path('app/temp'), 0755, true);
        }

        $objWriter = IOFactory::createWriter($phpWord, 'Word2007');
        $objWriter->save($tempPath);

        return response()->download($tempPath, $filename)->deleteFileAfterSend();
    }
}
