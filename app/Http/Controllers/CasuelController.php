<?php
namespace App\Http\Controllers;
use App\Models\{Casuel, Fidele};
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
class CasuelController extends Controller {
    public function index(Request $request) {
        $type = $request->get('type', 'bapteme');
        $query = Casuel::with('fidele')->where('type', $type);
        
        // Filtrer par mois si spécifié
        $mois = $request->get('mois');
        if ($mois && preg_match('/^\d{4}-\d{2}$/', $mois)) {
            [$y, $m] = explode('-', $mois);
            $query->whereYear('date_paiement', $y)->whereMonth('date_paiement', $m);
        }
        
        // Recherche
        if ($request->filled('q')) {
            $query->where(function($q) use ($request) {
                $q->where('nom', 'like', "%{$request->q}%")
                    ->orWhere('prenoms', 'like', "%{$request->q}%")
                    ->orWhere('numero', 'like', "%{$request->q}%")
                    ->orWhereHas('fidele', function($f) use ($request) {
                        $f->where('nom', 'like', "%{$request->q}%")
                            ->orWhere('prenoms', 'like', "%{$request->q}%");
                    });
            });
        }
        
        $casuels = $query->orderByDesc('date_paiement')->paginate(20);
        $total = $casuels->sum('montant');
        
        return view('casuels.index', compact('casuels', 'total', 'type', 'mois') + ['fideles' => Fidele::options()]);
    }
    
    public function store(Request $request) {
        $data = $request->validate([
            'type' => 'required|in:bapteme,confirmation,mariage,deces',
            'fidele_id' => 'nullable|exists:fideles,id',
            'nom' => 'nullable|required_without:fidele_id|string|max:255',
            'prenoms' => 'nullable|required_without:fidele_id|string|max:255',
            'date_naissance' => 'nullable|date',
            'profession' => 'nullable|string|max:255',
            'fidele_id_2' => 'nullable|exists:fideles,id',
            'nom_2' => 'nullable|required_without:fidele_id_2|string|max:255',
            'prenoms_2' => 'nullable|required_without:fidele_id_2|string|max:255',
            'date_naissance_2' => 'nullable|date',
            'profession_2' => 'nullable|string|max:255',
            'numero' => 'nullable|string|max:100',
            'montant' => 'required|integer|min:1',
            'date_paiement' => 'nullable|date',
            'note' => 'nullable|string|max:255'
        ]);

        $fideleId = null;
        $fideleId2 = null;

        // Si un fidèle est sélectionné, l'utiliser
        if (!empty($data['fidele_id'])) {
            $fideleId = $data['fidele_id'];
        }
        // Sinon, créer un nouveau fidèle
        elseif (!empty($data['nom']) && !empty($data['prenoms'])) {
            $fidele = Fidele::create([
                'nom' => $data['nom'],
                'prenoms' => $data['prenoms'],
                'date_naissance' => $data['date_naissance'] ?? null,
                'profession' => $data['profession'] ?? null,
                'sexe' => 'M', // Par défaut
                'statut' => 'actif'
            ]);
            $fideleId = $fidele->id;
        }

        // Pour les mariages, gérer la deuxième personne
        if ($data['type'] === 'mariage') {
            if (!empty($data['fidele_id_2'])) {
                $fideleId2 = $data['fidele_id_2'];
            }
            elseif (!empty($data['nom_2']) && !empty($data['prenoms_2'])) {
                $fidele2 = Fidele::create([
                    'nom' => $data['nom_2'],
                    'prenoms' => $data['prenoms_2'],
                    'date_naissance' => $data['date_naissance_2'] ?? null,
                    'profession' => $data['profession_2'] ?? null,
                    'sexe' => 'F', // Par défaut pour le deuxième époux
                    'statut' => 'actif'
                ]);
                $fideleId2 = $fidele2->id;
            }
        }

        // Créer le casuel
        Casuel::create([
            'type' => $data['type'],
            'fidele_id' => $fideleId,
            'nom' => $data['nom'] ?? null,
            'prenoms' => $data['prenoms'] ?? null,
            'date_naissance' => $data['date_naissance'] ?? null,
            'profession' => $data['profession'] ?? null,
            'fidele_id_2' => $fideleId2,
            'nom_2' => $data['nom_2'] ?? null,
            'prenoms_2' => $data['prenoms_2'] ?? null,
            'date_naissance_2' => $data['date_naissance_2'] ?? null,
            'profession_2' => $data['profession_2'] ?? null,
            'numero' => $data['numero'] ?? null,
            'montant' => $data['montant'],
            'date_paiement' => $data['date_paiement'] ?? now()->toDateString(),
            'note' => $data['note'] ?? null,
            'user_id' => auth()->id()
        ]);

        return back()->with('ok', 'Casuel enregistré avec succès.');
    }
    
    public function destroy(Casuel $casuel) {
        $casuel->delete();
        return back()->with('ok', 'Casuel supprimé avec succès.');
    }
    
    public function recu(Casuel $casuel) {
        $logoPath = public_path('images/saint.jpg');
        $logoData = base64_encode(file_get_contents($logoPath));
        $logoSrc = 'data:image/jpeg;base64,' . $logoData;

        $personne = $casuel->fidele ? $casuel->fidele->nom_complet : ($casuel->nom . ' ' . $casuel->prenoms);
        $personne2 = null;
        if ($casuel->type === 'mariage') {
            $personne2 = $casuel->fidele2 ? $casuel->fidele2->nom_complet : ($casuel->nom_2 . ' ' . $casuel->prenoms_2);
        }
        $typeLabel = Casuel::getTypes()[$casuel->type] ?? $casuel->type;

        return Pdf::loadView('pdf.recu-casuel', [
            'numero' => 'CS-' . str_pad($casuel->id, 6, '0', STR_PAD_LEFT),
            'date' => $casuel->date_paiement,
            'personne' => $personne,
            'personne2' => $personne2,
            'type' => $typeLabel,
            'montant' => $casuel->montant,
            'numero_reference' => $casuel->numero,
            'note' => $casuel->note,
            'logoSrc' => $logoSrc
        ])->stream("recu-casuel-{$casuel->id}.pdf");
    }
    
    public function exportPdf(Request $request) {
        $type = $request->get('type', 'bapteme');
        $query = Casuel::with('fidele')->where('type', $type);
        
        $mois = $request->get('mois');
        if ($mois && preg_match('/^\d{4}-\d{2}$/', $mois)) {
            [$y, $m] = explode('-', $mois);
            $query->whereYear('date_paiement', $y)->whereMonth('date_paiement', $m);
        }
        
        $casuels = $query->orderBy('date_paiement')->get();
        $total = $casuels->sum('montant');
        
        $logoPath = public_path('images/saint.jpg');
        $logoData = base64_encode(file_get_contents($logoPath));
        $logoSrc = 'data:image/jpeg;base64,' . $logoData;
        
        return Pdf::loadView('pdf.casuels', compact('casuels', 'total', 'type', 'mois', 'logoSrc'))
            ->stream("casuels-{$type}" . ($mois ? "-{$mois}" : "") . ".pdf");
    }
}
