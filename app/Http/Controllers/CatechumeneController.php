<?php
namespace App\Http\Controllers;
use App\Models\{Catechumene, ClasseCate, Fidele};
class CatechumeneController extends CrudController {
    protected string $model = Catechumene::class; protected string $route = 'catechumenes';
    protected string $titre = 'Catéchumènes'; protected string $singulier = 'Inscription';
    protected array $with = ['fidele', 'classe'];
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
            'ceb' => ['CEB', 'text', false],
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
            'Statut' => fn ($c) => $c->statut === 'inscrit' ? '<span class="badge bg-primary">Inscrit</span>' : ($c->statut === 'admis' ? '<span class="badge bg-success">Admis</span>' : '<span class="badge bg-warning">Ajourné</span>'),
            'Baptisé' => fn ($c) => $c->bapte ? '<span class="badge bg-success">Oui</span>' : '<span class="badge bg-secondary">Non</span>'
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
}
