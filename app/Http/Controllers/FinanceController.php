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
        $d = $r->validate(['date'=>'required|date','type'=>'required|in:'.implode(',', array_keys(Recette::TYPES)),'montant'=>'required|integer|min:1','fidele_id'=>'nullable|exists:fideles,id','note'=>'nullable|string|max:255']);
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
        return Pdf::loadView('pdf.recu', [
            'numero' => $recette->recu_numero,
            'date' => $recette->date,
            'de' => $recette->fidele?->nom_complet ?? 'Anonyme',
            'motif' => Recette::TYPES[$recette->type] ?? $recette->type,
            'montant' => $recette->montant,
            'logoSrc' => $logoSrc
        ])->stream("recu-{$recette->recu_numero}.pdf");
    }
    public function bilan(Request $r) {
        [$mois, $rec, $dep] = $this->periode($r);
        return Pdf::loadView('pdf.bilan', compact('mois', 'rec', 'dep'))->stream("bilan-$mois.pdf");
    }
}
