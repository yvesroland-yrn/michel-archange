<?php
namespace App\Http\Controllers;
use App\Models\{Catechumene, ClasseCate, Fidele};
use Barryvdh\DomPDF\Facade\Pdf;
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
}
