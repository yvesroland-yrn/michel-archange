<?php
namespace App\Http\Controllers;
use App\Models\{Fidele, Bapteme};
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
class BaptemeController extends Controller {
    public function create(Fidele $fidele) {
        abort_if($fidele->bapteme, 409, 'Ce fidèle a déjà un acte de baptême.');
        return view('baptemes.form', ['fidele' => $fidele, 'numero' => Bapteme::prochainNumero()]);
    }
    public function store(Request $r, Fidele $fidele) {
        abort_if($fidele->bapteme, 409, 'Ce fidèle a déjà un acte de baptême.');
        $d = $r->validate(['date_bapteme'=>'required|date','lieu'=>'nullable|string','ministre'=>'required|string','parrain'=>'nullable|string',
            'marraine'=>'nullable|string','pere'=>'nullable|string','mere'=>'nullable|string','livre'=>'nullable|string','folio'=>'nullable|string','numero_carnet_bapteme'=>'nullable|string|max:100']);
        $fidele->bapteme()->create($d + ['numero_acte' => Bapteme::prochainNumero()]);
        return redirect()->route('fideles.show', $fidele)->with('ok', 'Baptême enregistré.');
    }
    public function certificat(Bapteme $bapteme) {
        return Pdf::loadView('baptemes.certificat', ['b' => $bapteme->load('fidele')])->stream("certificat-{$bapteme->numero_acte}.pdf");
    }
}
