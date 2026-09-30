<?php
namespace App\Http\Controllers;
use App\Models\{Fidele, Ceb};
use Illuminate\Http\Request;
class FideleController extends Controller {
    private function rules(): array {
        return ['nom'=>'required|string|max:100','prenoms'=>'required|string|max:150','sexe'=>'required|in:M,F',
            'date_naissance'=>'nullable|date','lieu_naissance'=>'nullable|string|max:100','telephone'=>'nullable|string|max:30',
            'email'=>'nullable|email','profession'=>'nullable|string|max:100','quartier'=>'nullable|string|max:100',
            'situation_matrimoniale'=>'nullable|string|max:50','ceb_id'=>'nullable|exists:cebs,id','statut'=>'required|in:actif,transfere,decede',
            'baptise'=>'nullable|boolean','confirme'=>'nullable|boolean','marie'=>'nullable|boolean'];
    }
    public function index(Request $r) {
        $q = Fidele::with('ceb', 'bapteme')->when($r->q, fn ($x) => $x->where(fn ($w) =>
            $w->where('nom', 'like', "%{$r->q}%")->orWhere('prenoms', 'like', "%{$r->q}%")->orWhere('telephone', 'like', "%{$r->q}%")))
            ->when($r->ceb_id, fn ($x) => $x->where('ceb_id', $r->ceb_id))->orderBy('nom')->paginate(20)->withQueryString();
        return view('fideles.index', ['fideles' => $q, 'cebs' => Ceb::orderBy('nom')->get()]);
    }
    public function create() { return view('fideles.form', ['fidele' => new Fidele(['statut' => 'actif']), 'cebs' => Ceb::orderBy('nom')->get()]); }
    public function store(Request $r) {
        $data = $r->validate($this->rules());
        $data['baptise'] = $r->has('baptise');
        $data['confirme'] = $r->has('confirme');
        $data['marie'] = $r->has('marie');
        Fidele::create($data);
        return redirect()->route('fideles.index')->with('ok', 'Fidèle enregistré.');
    }
    public function show(Fidele $fidele) { return view('fideles.show', ['f' => $fidele->load('ceb', 'bapteme', 'sacrements', 'mouvements')]); }
    public function edit(Fidele $fidele) { return view('fideles.form', ['fidele' => $fidele, 'cebs' => Ceb::orderBy('nom')->get()]); }
    public function update(Request $r, Fidele $fidele) {
        $data = $r->validate($this->rules());
        $data['baptise'] = $r->has('baptise');
        $data['confirme'] = $r->has('confirme');
        $data['marie'] = $r->has('marie');
        $fidele->update($data);
        return redirect()->route('fideles.index')->with('ok', 'Fidèle mis à jour.');
    }
    public function destroy(Fidele $fidele) { $fidele->delete(); return redirect()->route('fideles.index')->with('ok', 'Fidèle supprimé.'); }
    public function export() {
        return response()->streamDownload(function () {
            $o = fopen('php://output', 'w'); fwrite($o, "\xEF\xBB\xBF");
            fputcsv($o, ['Nom', 'Prénoms', 'Sexe', 'Naissance', 'Téléphone', 'Quartier', 'CEB', 'Statut', 'Baptisé', 'Confirmé', 'Marié'], ';');
            Fidele::with('ceb')->orderBy('nom')->chunk(200, fn ($c) => $c->each(fn ($f) => fputcsv($o, [$f->nom, $f->prenoms, $f->sexe, $f->date_naissance?->format('d/m/Y'), $f->telephone, $f->quartier, $f->ceb?->nom, $f->statut, $f->baptise ? 'Oui' : 'Non', $f->confirme ? 'Oui' : 'Non', $f->marie ? 'Oui' : 'Non'], ';')));
            fclose($o);
        }, 'fideles-'.now()->format('Ymd').'.csv', ['Content-Type' => 'text/csv']);
    }
}
