<?php
namespace App\Http\Controllers;
use App\Models\{Catechiste, ClasseCate, AnneeCatechetique};
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;
class CatechisteController extends CrudController {
    protected string $model = Catechiste::class; protected string $route = 'catechistes';
    protected string $titre = 'Catéchistes/Animateurs'; protected string $singulier = 'Catéchiste';
    protected array $searchable = ['nom', 'prenoms', 'telephone'];
    protected array $with = ['classes'];
    protected function fields(): array {
        return [
            'nom' => ['Nom', 'text', true],
            'prenoms' => ['Prénoms', 'text', true],
            'telephone' => ['Téléphone', 'text', false],
            'section' => ['Section', 'select', true, Catechiste::getSections()],
            'statut' => ['Statut', 'select', true, Catechiste::getStatuts()],
            'classes' => ['Classes', 'checkbox', false, \App\Models\ClasseCate::options()],
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
            'Classes' => fn ($c) => $c->classes->count() > 0 ? '<span class="badge bg-info">' . $c->classes->count() . '</span>' : '—'
        ];
    }

    protected function prepare(array $data, $item = null): array {
        if (isset($data['classes'])) {
            $classes = $data['classes'];
            unset($data['classes']);
        }
        return $data;
    }

    protected function after($item, bool $created): void {
        if (request()->has('classes')) {
            $item->classes()->sync(request()->input('classes', []));
        }
    }

    public function edit($id) {
        $item = ($this->model)::with('classes')->findOrFail($id);
        $item->classes = $item->classes->pluck('id')->toArray();
        return $this->view('crud.form', ['item' => $item]);
    }

    public function create() {
        $item = new ($this->model)();
        $item->classes = [];
        return $this->view('crud.form', ['item' => $item]);
    }

    // Export PDF par classe
    public function exportPdfParClasse(Request $request) {
        $classeId = $request->get('classe_id');
        
        if (!$classeId) {
            return back()->with('error', 'Veuillez sélectionner une classe.');
        }

        $classe = ClasseCate::with('anneeCatechetique')->findOrFail($classeId);
        $catechistes = $classe->catechistes;

        $logoPath = public_path('images/saint.jpg');
        $logoData = base64_encode(file_get_contents($logoPath));
        $logoSrc = 'data:image/jpeg;base64,' . $logoData;

        return Pdf::loadView('pdf.catechistes-par-classe', compact(
            'catechistes',
            'classe',
            'logoSrc'
        ))->stream("catechistes-classe-{$classe->id}.pdf");
    }

    // Export PDF par année catéchétique
    public function exportPdfParAnnee(Request $request) {
        $anneeId = $request->get('annee_id');
        
        if (!$anneeId) {
            return back()->with('error', 'Veuillez sélectionner une année catéchétique.');
        }

        $annee = AnneeCatechetique::findOrFail($anneeId);
        $classes = ClasseCate::where('annee_catechetique_id', $anneeId)
            ->with('catechistes')
            ->orderBy('niveau')
            ->orderBy('code')
            ->get();

        $logoPath = public_path('images/saint.jpg');
        $logoData = base64_encode(file_get_contents($logoPath));
        $logoSrc = 'data:image/jpeg;base64,' . $logoData;

        return Pdf::loadView('pdf.catechistes-par-annee', compact(
            'classes',
            'annee',
            'logoSrc'
        ))->stream("catechistes-annee-{$annee->id}.pdf");
    }

    // Export PDF par section
    public function exportPdfParSection(Request $request) {
        $section = $request->get('section');
        
        if (!$section) {
            return back()->with('error', 'Veuillez sélectionner une section.');
        }

        $catechistes = Catechiste::where('section', $section)
            ->orderBy('nom')
            ->get();

        $logoPath = public_path('images/saint.jpg');
        $logoData = base64_encode(file_get_contents($logoPath));
        $logoSrc = 'data:image/jpeg;base64,' . $logoData;

        return Pdf::loadView('pdf.catechistes-par-section', compact(
            'catechistes',
            'section',
            'logoSrc'
        ))->stream("catechistes-section-{$section}.pdf");
    }

    // Export Word par classe
    public function exportWordParClasse(Request $request) {
        $classeId = $request->get('classe_id');
        
        if (!$classeId) {
            return back()->with('error', 'Veuillez sélectionner une classe.');
        }

        $classe = ClasseCate::with('anneeCatechetique')->findOrFail($classeId);
        $catechistes = $classe->catechistes;

        $phpWord = new PhpWord();
        $section = $phpWord->addSection();

        // Titre
        $section->addText('Liste des Catéchistes/Animateurs', ['bold' => true, 'size' => 16], ['alignment' => 'center']);
        $section->addTextBreak();

        // Détails de la classe
        $section->addText('Année catéchétique : ' . ($classe->anneeCatechetique ? $classe->anneeCatechetique->libelle : '—'), ['size' => 12]);
        $section->addText('Classe : ' . $classe->niveau . ($classe->code ? " {$classe->code}" : '') . ' - ' . ClasseCate::getSections()[$classe->section] ?? $classe->section, ['size' => 12]);
        $section->addText('Total : ' . $catechistes->count() . ' catéchiste(s)', ['size' => 12]);
        $section->addTextBreak();

        // Tableau
        $table = $section->addTable(['borderSize' => 6, 'borderColor' => '000000', 'cellMargin' => 80]);

        // En-têtes
        $table->addRow();
        $table->addCell(3000)->addText('Nom & Prénoms', ['bold' => true]);
        $table->addCell(2000)->addText('Téléphone', ['bold' => true]);
        $table->addCell(2000)->addText('Section', ['bold' => true]);
        $table->addCell(2000)->addText('Statut', ['bold' => true]);

        // Données
        foreach ($catechistes as $catechiste) {
            $nom = $catechiste->nom . ' ' . $catechiste->prenoms;
            $sectionLabel = Catechiste::getSections()[$catechiste->section] ?? $catechiste->section;
            $statut = ucfirst($catechiste->statut);

            $table->addRow();
            $table->addCell(3000)->addText($nom);
            $table->addCell(2000)->addText($catechiste->telephone ?? '—');
            $table->addCell(2000)->addText($sectionLabel);
            $table->addCell(2000)->addText($statut);
        }

        // Sauvegarder
        $filename = "catechistes-classe-{$classe->id}.docx";
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
            ->with('catechistes')
            ->orderBy('niveau')
            ->orderBy('code')
            ->get();

        $phpWord = new PhpWord();
        $section = $phpWord->addSection();

        // Titre
        $section->addText('Liste des Catéchistes/Animateurs par Année Catéchétique', ['bold' => true, 'size' => 16], ['alignment' => 'center']);
        $section->addTextBreak();

        // Détails de l'année
        $section->addText('Année catéchétique : ' . $annee->libelle, ['size' => 12], ['alignment' => 'center']);
        $section->addText('Total : ' . $classes->sum(function($classe) { return $classe->catechistes->count(); }) . ' catéchiste(s)', ['size' => 12], ['alignment' => 'center']);
        $section->addTextBreak();

        // Grouper par classe
        foreach ($classes as $classe) {
            if ($classe->catechistes->isEmpty()) continue;

            $section->addText($classe->niveau . ($classe->code ? " {$classe->code}" : '') . ' - ' . ClasseCate::getSections()[$classe->section] ?? $classe->section, ['bold' => true, 'size' => 12]);
            $section->addText('Effectif : ' . $classe->catechistes->count(), ['size' => 10]);
            $section->addTextBreak();

            // Tableau pour cette classe
            $table = $section->addTable(['borderSize' => 6, 'borderColor' => '000000', 'cellMargin' => 80]);

            // En-têtes
            $table->addRow();
            $table->addCell(3000)->addText('Nom & Prénoms', ['bold' => true]);
            $table->addCell(2000)->addText('Téléphone', ['bold' => true]);
            $table->addCell(2000)->addText('Section', ['bold' => true]);
            $table->addCell(2000)->addText('Statut', ['bold' => true]);

            // Données
            foreach ($classe->catechistes as $catechiste) {
                $nom = $catechiste->nom . ' ' . $catechiste->prenoms;
                $sectionLabel = Catechiste::getSections()[$catechiste->section] ?? $catechiste->section;
                $statut = ucfirst($catechiste->statut);

                $table->addRow();
                $table->addCell(3000)->addText($nom);
                $table->addCell(2000)->addText($catechiste->telephone ?? '—');
                $table->addCell(2000)->addText($sectionLabel);
                $table->addCell(2000)->addText($statut);
            }

            $section->addTextBreak(2);
        }

        // Sauvegarder
        $filename = "catechistes-annee-{$annee->id}.docx";
        $tempPath = storage_path('app/temp/' . $filename);

        if (!file_exists(storage_path('app/temp'))) {
            mkdir(storage_path('app/temp'), 0755, true);
        }

        $objWriter = IOFactory::createWriter($phpWord, 'Word2007');
        $objWriter->save($tempPath);

        return response()->download($tempPath, $filename)->deleteFileAfterSend();
    }

    // Export Word par section
    public function exportWordParSection(Request $request) {
        $section = $request->get('section');
        
        if (!$section) {
            return back()->with('error', 'Veuillez sélectionner une section.');
        }

        $catechistes = Catechiste::where('section', $section)
            ->orderBy('nom')
            ->get();

        $phpWord = new PhpWord();
        $section = $phpWord->addSection();

        // Titre
        $section->addText('Liste des Catéchistes/Animateurs par Section', ['bold' => true, 'size' => 16], ['alignment' => 'center']);
        $section->addTextBreak();

        // Détails de la section
        $sectionLabel = Catechiste::getSections()[$section] ?? $section;
        $section->addText('Section : ' . $sectionLabel, ['size' => 12], ['alignment' => 'center']);
        $section->addText('Total : ' . $catechistes->count() . ' catéchiste(s)', ['size' => 12], ['alignment' => 'center']);
        $section->addTextBreak();

        // Tableau
        $table = $section->addTable(['borderSize' => 6, 'borderColor' => '000000', 'cellMargin' => 80]);

        // En-têtes
        $table->addRow();
        $table->addCell(3000)->addText('Nom & Prénoms', ['bold' => true]);
        $table->addCell(2000)->addText('Téléphone', ['bold' => true]);
        $table->addCell(2000)->addText('Statut', ['bold' => true]);
        $table->addCell(4000)->addText('Observations', ['bold' => true]);

        // Données
        foreach ($catechistes as $catechiste) {
            $nom = $catechiste->nom . ' ' . $catechiste->prenoms;
            $statut = ucfirst($catechiste->statut);

            $table->addRow();
            $table->addCell(3000)->addText($nom);
            $table->addCell(2000)->addText($catechiste->telephone ?? '—');
            $table->addCell(2000)->addText($statut);
            $table->addCell(4000)->addText($catechiste->observations ?? '—');
        }

        // Sauvegarder
        $filename = "catechistes-section-{$section}.docx";
        $tempPath = storage_path('app/temp/' . $filename);

        if (!file_exists(storage_path('app/temp'))) {
            mkdir(storage_path('app/temp'), 0755, true);
        }

        $objWriter = IOFactory::createWriter($phpWord, 'Word2007');
        $objWriter->save($tempPath);

        return response()->download($tempPath, $filename)->deleteFileAfterSend();
    }
}
