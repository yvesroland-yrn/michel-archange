<?php
namespace App\Http\Controllers;
use App\Models\{Recette, Depense, Fidele};
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
class FinanceController extends Controller {
    private function periode(Request $r): array {
        $vue = $r->get('vue', 'mois');
        if ($vue === 'tout') {
            return ['tout', Recette::orderBy('date')->get(), Depense::orderBy('date')->get()];
        }
        $mois = preg_match('/^\d{4}-\d{2}$/', (string) $r->get('mois')) ? $r->get('mois') : now()->format('Y-m');
        [$y, $m] = explode('-', $mois);
        return [$mois, Recette::whereYear('date', $y)->whereMonth('date', $m)->orderBy('date')->get(), Depense::whereYear('date', $y)->whereMonth('date', $m)->orderBy('date')->get()];
    }
    public function index(Request $r) {
        [$mois, $rec, $dep] = $this->periode($r);
        return view('finance.index', compact('rec', 'dep', 'mois') + ['solde' => $rec->sum('montant') - $dep->sum('montant'), 'fideles' => Fidele::options()]);
    }
    public function storeRecette(Request $r) {
        $isOffrande = $r->get('type') === 'offrande_messe';
        $montantRule = $isOffrande ? 'nullable|integer|min:0' : 'required|integer|min:1';
        $noteRule = $isOffrande ? 'required_without:montant|string|max:255' : 'nullable|string|max:255';
        $d = $r->validate(['date'=>'required|date','type'=>'required|in:'.implode(',', array_keys(Recette::TYPES)),'montant'=>$montantRule,'fidele_id'=>'nullable|exists:fideles,id','donateur_nom'=>'nullable|string|max:255','note'=>$noteRule,'type_offrande'=>'nullable|string|max:50','jour_semaine'=>'nullable|string|max:50','numero_carnet_bapteme'=>'nullable|string|max:100']);
        
        // Combiner le type d'offrande avec la note si applicable
        if ($isOffrande && $r->get('type_offrande')) {
            $typeOffrandeLabels = [
                'argent' => 'Argent',
                'nature' => 'Nature',
                'vivre' => 'Vivre',
                'autre' => 'Autre'
            ];
            $typeOffrande = $typeOffrandeLabels[$r->get('type_offrande')] ?? $r->get('type_offrande');
            $d['note'] = $typeOffrande . ($d['note'] ? ' - ' . $d['note'] : '');
        }
        
        // Combiner le jour de la semaine avec la note si applicable (pour les quêtes)
        if ($r->get('jour_semaine')) {
            $jourLabels = [
                'lundi' => 'Lundi',
                'mardi' => 'Mardi',
                'mercredi' => 'Mercredi',
                'jeudi' => 'Jeudi',
                'vendredi' => 'Vendredi',
                'samedi' => 'Samedi',
                'dimanche_7h' => 'Dimanche 7h',
                'dimanche_9h' => 'Dimanche 9h'
            ];
            $jour = $jourLabels[$r->get('jour_semaine')] ?? $r->get('jour_semaine');
            $d['note'] = $jour . ($d['note'] ? ' - ' . $d['note'] : '');
        }
        
        // Retirer les champs temporaires avant insertion
        unset($d['type_offrande'], $d['jour_semaine']);
        
        // Mettre 0 par défaut si le montant est null ou vide
        if (!isset($d['montant']) || $d['montant'] === '') {
            $d['montant'] = 0;
        }
        
        Recette::create($d + ['recu_numero' => Recette::prochainRecu(), 'user_id' => $r->user()->id]);
        return back()->with('ok', 'Recette enregistrée.');
    }
    public function storeDepense(Request $r) {
        $d = $r->validate(['date'=>'required|date','categorie'=>'required|in:'.implode(',', array_keys(Depense::CATEGORIES)),'libelle'=>'required|string|max:255','montant'=>'required|integer|min:1']);
        Depense::create($d + ['user_id' => $r->user()->id]);
        return back()->with('ok', 'Dépense enregistrée.');
    }
    public function recu(Recette $recette) {
        $logoPath = public_path('images/saint.jpg');
        $logoData = base64_encode(file_get_contents($logoPath));
        $logoSrc = 'data:image/jpeg;base64,' . $logoData;
        
        $motif = Recette::TYPES[$recette->type] ?? $recette->type;
        if ($recette->note) {
            $motif .= ' - ' . $recette->note;
        }
        
        return Pdf::loadView('pdf.recu', [
            'numero' => $recette->recu_numero,
            'date' => $recette->date,
            'de' => $recette->donateur_nom,
            'motif' => $motif,
            'montant' => $recette->montant,
            'logoSrc' => $logoSrc,
            'categorie' => $recette->category_libelle
        ])->stream("recu-{$recette->recu_numero}.pdf");
    }
    public function bilan(Request $r) {
        [$mois, $rec, $dep] = $this->periode($r);
        
        // Filtrer par catégorie si spécifié
        $category = $r->get('category');
        if ($category && $category !== 'tous' && isset(Recette::CATEGORY_TYPES[$category])) {
            $types = Recette::CATEGORY_TYPES[$category];
            $rec = $rec->whereIn('type', $types);
        }
        
        return Pdf::loadView('pdf.bilan', compact('mois', 'rec', 'dep'))->stream("bilan-$mois" . ($category && $category !== 'tous' ? "-$category" : "") . ".pdf");
    }

    public function dons(Request $r) {
        [$mois, $rec, $dep] = $this->periode($r);
        $types = Recette::CATEGORY_TYPES['don'];
        $rec = $rec->whereIn('type', $types);
        return view('finance.dons', compact('rec', 'mois') + ['solde' => $rec->sum('montant'), 'fideles' => Fidele::options()]);
    }

    public function dimes(Request $r) {
        [$mois, $rec, $dep] = $this->periode($r);
        $types = Recette::CATEGORY_TYPES['dime'];
        $rec = $rec->whereIn('type', $types);
        return view('finance.dimes', compact('rec', 'mois') + ['solde' => $rec->sum('montant'), 'fideles' => Fidele::options()]);
    }

    public function offrandes(Request $r) {
        [$mois, $rec, $dep] = $this->periode($r);
        $types = Recette::CATEGORY_TYPES['offrande'];
        $rec = $rec->whereIn('type', $types);
        return view('finance.offrandes', compact('rec', 'mois') + ['solde' => $rec->sum('montant'), 'fideles' => Fidele::options()]);
    }

    public function quetes(Request $r) {
        [$mois, $rec, $dep] = $this->periode($r);
        $types = Recette::CATEGORY_TYPES['quete'];
        $rec = $rec->whereIn('type', $types);
        return view('finance.quetes', compact('rec', 'mois') + ['solde' => $rec->sum('montant'), 'fideles' => Fidele::options()]);
    }

    public function denierCulte(Request $r) {
        [$mois, $rec, $dep] = $this->periode($r);
        $rec = $rec->where('type', 'denier_culte');
        if ($r->q) {
            $rec = $rec->where(function($query) use ($r) {
                $query->where('donateur_nom', 'like', "%{$r->q}%")
                    ->orWhere('numero_carnet_bapteme', 'like', "%{$r->q}%")
                    ->orWhereHas('fidele', function($q) use ($r) {
                        $q->where('nom', 'like', "%{$r->q}%")
                            ->orWhere('prenoms', 'like', "%{$r->q}%");
                    });
            });
        }
        return view('finance.denier-culte', compact('rec', 'mois') + ['solde' => $rec->sum('montant'), 'fideles' => Fidele::options()]);
    }
}
