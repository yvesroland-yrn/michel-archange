<?php
namespace App\Http\Controllers;
use App\Models\{DenierCulte, Fidele};
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
class DenierCulteController extends Controller {
    public function index(Request $request) {
        $query = DenierCulte::with('fidele');
        
        // Filtrer par mois si spécifié
        $mois = $request->get('mois');
        if ($mois && preg_match('/^\d{4}-\d{2}$/', $mois)) {
            [$y, $m] = explode('-', $mois);
            $query->whereYear('date_paiement', $y)->whereMonth('date_paiement', $m);
        }
        
        // Recherche
        if ($request->filled('q')) {
            $query->where(function($q) use ($request) {
                $q->where('donateur_nom', 'like', "%{$request->q}%")
                    ->orWhere('numero_carnet_bapteme', 'like', "%{$request->q}%")
                    ->orWhereHas('fidele', function($f) use ($request) {
                        $f->where('nom', 'like', "%{$request->q}%")
                            ->orWhere('prenoms', 'like', "%{$request->q}%");
                    });
            });
        }
        
        $deniers = $query->orderByDesc('date_paiement')->paginate(20);
        $total = $deniers->sum('montant');
        
        return view('deniers-culte.index', compact('deniers', 'total', 'mois') + ['fideles' => Fidele::options()]);
    }
    
    public function store(Request $request) {
        $data = $request->validate([
            'fidele_id' => 'nullable|exists:fideles,id',
            'donateur_nom' => 'nullable|required_without:fidele_id|string|max:255',
            'numero_carnet_bapteme' => 'nullable|string|max:100',
            'date_paiement' => 'required|date',
            'montant' => 'required|integer|min:1',
            'periode' => 'required|in:mensuelle,trimestrielle,annuelle,ponctuelle',
            'note' => 'nullable|string|max:255'
        ]);
        
        DenierCulte::create($data + ['user_id' => auth()->id()]);
        return back()->with('ok', 'Denier du culte enregistré avec succès.');
    }
    
    public function update(Request $request, DenierCulte $denier) {
        $data = $request->validate([
            'fidele_id' => 'nullable|exists:fideles,id',
            'donateur_nom' => 'nullable|required_without:fidele_id|string|max:255',
            'numero_carnet_bapteme' => 'nullable|string|max:100',
            'date_paiement' => 'required|date',
            'montant' => 'required|integer|min:1',
            'periode' => 'required|in:mensuelle,trimestrielle,annuelle,ponctuelle',
            'note' => 'nullable|string|max:255'
        ]);
        
        $denier->update($data);
        return back()->with('ok', 'Denier du culte modifié avec succès.');
    }
    
    public function destroy(DenierCulte $denier) {
        $denier->delete();
        return back()->with('ok', 'Denier du culte supprimé avec succès.');
    }
    
    public function recu(DenierCulte $denier) {
        $logoPath = public_path('images/saint.jpg');
        $logoData = base64_encode(file_get_contents($logoPath));
        $logoSrc = 'data:image/jpeg;base64,' . $logoData;
        
        $donateur = $denier->fidele ? $denier->fidele->nom_complet : $denier->donateur_nom;
        $periode = DenierCulte::getPeriodes()[$denier->periode] ?? $denier->periode;
        
        return Pdf::loadView('pdf.recu-denier-culte', [
            'numero' => 'DC-' . str_pad($denier->id, 6, '0', STR_PAD_LEFT),
            'date' => $denier->date_paiement,
            'donateur' => $donateur,
            'periode' => $periode,
            'montant' => $denier->montant,
            'numero_carnet' => $denier->numero_carnet_bapteme,
            'note' => $denier->note,
            'logoSrc' => $logoSrc
        ])->stream("recu-denier-culte-{$denier->id}.pdf");
    }
    
    public function exportPdf(Request $request) {
        $query = DenierCulte::with('fidele');
        
        $mois = $request->get('mois');
        if ($mois && preg_match('/^\d{4}-\d{2}$/', $mois)) {
            [$y, $m] = explode('-', $mois);
            $query->whereYear('date_paiement', $y)->whereMonth('date_paiement', $m);
        }
        
        $deniers = $query->orderBy('date_paiement')->get();
        $total = $deniers->sum('montant');
        
        $logoPath = public_path('images/saint.jpg');
        $logoData = base64_encode(file_get_contents($logoPath));
        $logoSrc = 'data:image/jpeg;base64,' . $logoData;
        
        return Pdf::loadView('pdf.deniers-culte', compact('deniers', 'total', 'mois', 'logoSrc'))
            ->stream("deniers-culte" . ($mois ? "-{$mois}" : "") . ".pdf");
    }
}
