<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;

class ReservationController extends Controller
{
    public function index(Request $request)
    {
        // Récupérer toutes les réservations pour les filtres
        $allReservations = Reservation::orderBy('created_at', 'desc')->get();

        // Appliquer les filtres pour l'affichage
        $query = Reservation::orderBy('created_at', 'desc');

        if ($request->filled('statut')) {
            $query->where('statut', $request->statut);
        }
        if ($request->filled('paroisse')) {
            $query->where('paroisse', $request->paroisse);
        }
        if ($request->filled('diocese')) {
            $query->where('diocese_vicariat', $request->diocese);
        }
        if ($request->filled('date_debut')) {
            $query->where('date_reservation', '>=', $request->date_debut);
        }
        if ($request->filled('date_fin')) {
            $query->where('date_reservation', '<=', $request->date_fin);
        }

        $reservations = $query->get();

        // Statistiques par paroisse
        $statsParParoisse = $reservations->groupBy('paroisse')->map(function ($group) {
            return [
                'total' => $group->count(),
                'en_attente' => $group->where('statut', 'en_attente')->count(),
                'confirmee' => $group->where('statut', 'confirmee')->count(),
                'annulee' => $group->where('statut', 'annulee')->count(),
                'total_personnes' => $group->sum('nombre_personnes'),
            ];
        })->sortByDesc('total');

        // Statistiques par diocèse/vicariat
        $statsParDiocese = $reservations->whereNotNull('diocese_vicariat')->groupBy('diocese_vicariat')->map(function ($group) {
            return [
                'total' => $group->count(),
                'en_attente' => $group->where('statut', 'en_attente')->count(),
                'confirmee' => $group->where('statut', 'confirmee')->count(),
                'annulee' => $group->where('statut', 'annulee')->count(),
                'total_personnes' => $group->sum('nombre_personnes'),
            ];
        })->sortByDesc('total');

        return view('reservations.index', compact('reservations', 'allReservations', 'statsParParoisse', 'statsParDiocese'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'paroisse' => 'required|string|max:255',
            'diocese_vicariat' => 'nullable|string|max:255',
            'telephone' => 'required|string|max:20',
            'date_reservation' => 'required|date|after:today',
            'nombre_personnes' => 'required|integer|min:1|max:500',
            'message' => 'nullable|string|max:1000'
        ]);

        Reservation::create([
            'nom' => $request->nom,
            'paroisse' => $request->paroisse,
            'diocese_vicariat' => $request->diocese_vicariat,
            'telephone' => $request->telephone,
            'date_reservation' => $request->date_reservation,
            'nombre_personnes' => $request->nombre_personnes,
            'message' => $request->message,
            'statut' => 'en_attente'
        ]);

        return back()->with('ok', 'Votre réservation a été envoyée avec succès. Nous vous contacterons bientôt.');
    }

    public function updateStatut(Request $request, $id)
    {
        $request->validate([
            'statut' => 'required|in:en_attente,confirmee,annulee'
        ]);

        $reservation = Reservation::findOrFail($id);
        $reservation->statut = $request->statut;
        $reservation->save();

        return back()->with('ok', 'Statut de la réservation mis à jour.');
    }

    public function destroy($id)
    {
        $reservation = Reservation::findOrFail($id);
        $reservation->delete();

        return back()->with('ok', 'Réservation supprimée avec succès.');
    }

    public function exportPdf(Request $request)
    {
        $query = Reservation::orderBy('created_at', 'desc');

        // Filtres
        if ($request->filled('statut')) {
            $query->where('statut', $request->statut);
        }
        if ($request->filled('paroisse')) {
            $query->where('paroisse', $request->paroisse);
        }
        if ($request->filled('diocese')) {
            $query->where('diocese_vicariat', $request->diocese);
        }
        if ($request->filled('date_debut')) {
            $query->where('date_reservation', '>=', $request->date_debut);
        }
        if ($request->filled('date_fin')) {
            $query->where('date_reservation', '<=', $request->date_fin);
        }

        $reservations = $query->get();

        // Statistiques par paroisse
        $statsParParoisse = $reservations->groupBy('paroisse')->map(function ($group) {
            return [
                'total' => $group->count(),
                'en_attente' => $group->where('statut', 'en_attente')->count(),
                'confirmee' => $group->where('statut', 'confirmee')->count(),
                'annulee' => $group->where('statut', 'annulee')->count(),
                'total_personnes' => $group->sum('nombre_personnes'),
            ];
        })->sortByDesc('total');

        // Statistiques par diocèse/vicariat
        $statsParDiocese = $reservations->whereNotNull('diocese_vicariat')->groupBy('diocese_vicariat')->map(function ($group) {
            return [
                'total' => $group->count(),
                'en_attente' => $group->where('statut', 'en_attente')->count(),
                'confirmee' => $group->where('statut', 'confirmee')->count(),
                'annulee' => $group->where('statut', 'annulee')->count(),
                'total_personnes' => $group->sum('nombre_personnes'),
            ];
        })->sortByDesc('total');

        $logoPath = public_path('images/logo-sanctuaire.jpg');
        $logoData = base64_encode(file_get_contents($logoPath));
        $logoSrc = 'data:image/jpeg;base64,' . $logoData;

        $pdf = Pdf::loadView('pdf.reservations', compact('reservations', 'statsParParoisse', 'statsParDiocese', 'logoSrc'));
        return $pdf->stream('rapport-reservations.pdf');
    }

    public function exportWord(Request $request)
    {
        $query = Reservation::orderBy('created_at', 'desc');

        // Filtres
        if ($request->filled('statut')) {
            $query->where('statut', $request->statut);
        }
        if ($request->filled('paroisse')) {
            $query->where('paroisse', $request->paroisse);
        }
        if ($request->filled('diocese')) {
            $query->where('diocese_vicariat', $request->diocese);
        }
        if ($request->filled('date_debut')) {
            $query->where('date_reservation', '>=', $request->date_debut);
        }
        if ($request->filled('date_fin')) {
            $query->where('date_reservation', '<=', $request->date_fin);
        }

        $reservations = $query->get();

        // Statistiques par paroisse
        $statsParParoisse = $reservations->groupBy('paroisse')->map(function ($group) {
            return [
                'total' => $group->count(),
                'en_attente' => $group->where('statut', 'en_attente')->count(),
                'confirmee' => $group->where('statut', 'confirmee')->count(),
                'annulee' => $group->where('statut', 'annulee')->count(),
                'total_personnes' => $group->sum('nombre_personnes'),
            ];
        })->sortByDesc('total');

        // Statistiques par diocèse/vicariat
        $statsParDiocese = $reservations->whereNotNull('diocese_vicariat')->groupBy('diocese_vicariat')->map(function ($group) {
            return [
                'total' => $group->count(),
                'en_attente' => $group->where('statut', 'en_attente')->count(),
                'confirmee' => $group->where('statut', 'confirmee')->count(),
                'annulee' => $group->where('statut', 'annulee')->count(),
                'total_personnes' => $group->sum('nombre_personnes'),
            ];
        })->sortByDesc('total');

        $phpWord = new PhpWord();

        $section = $phpWord->addSection();

        $section->addText('Rapport des Réservations - Sanctuaire Marial Notre-Dame de Cana Sassako', ['bold' => true, 'size' => 16], ['alignment' => 'center']);
        $section->addTextBreak();

        // Statistiques globales
        $section->addText('Statistiques Globales', ['bold' => true, 'size' => 14]);
        $section->addText("Total Réservations: {$reservations->count()}");
        $section->addText("En attente: {$reservations->where('statut', 'en_attente')->count()}");
        $section->addText("Confirmées: {$reservations->where('statut', 'confirmee')->count()}");
        $section->addText("Annulées: {$reservations->where('statut', 'annulee')->count()}");
        $section->addTextBreak();

        // Bilan par paroisse
        $section->addText('Bilan par Paroisse', ['bold' => true, 'size' => 14]);
        $table = $section->addTable(['borderSize' => 6]);
        $table->addRow();
        $table->addCell()->addText('Paroisse', ['bold' => true]);
        $table->addCell()->addText('Total', ['bold' => true]);
        $table->addCell()->addText('En attente', ['bold' => true]);
        $table->addCell()->addText('Confirmées', ['bold' => true]);
        $table->addCell()->addText('Annulées', ['bold' => true]);
        $table->addCell()->addText('Total Personnes', ['bold' => true]);

        foreach ($statsParParoisse as $paroisse => $stats) {
            $table->addRow();
            $table->addCell()->addText($paroisse);
            $table->addCell()->addText($stats['total']);
            $table->addCell()->addText($stats['en_attente']);
            $table->addCell()->addText($stats['confirmee']);
            $table->addCell()->addText($stats['annulee']);
            $table->addCell()->addText($stats['total_personnes']);
        }
        $section->addTextBreak();

        // Bilan par diocèse
        if ($statsParDiocese->count() > 0) {
            $section->addText('Bilan par Diocèse/Vicariat', ['bold' => true, 'size' => 14]);
            $table = $section->addTable(['borderSize' => 6]);
            $table->addRow();
            $table->addCell()->addText('Diocèse/Vicariat', ['bold' => true]);
            $table->addCell()->addText('Total', ['bold' => true]);
            $table->addCell()->addText('En attente', ['bold' => true]);
            $table->addCell()->addText('Confirmées', ['bold' => true]);
            $table->addCell()->addText('Annulées', ['bold' => true]);
            $table->addCell()->addText('Total Personnes', ['bold' => true]);

            foreach ($statsParDiocese as $diocese => $stats) {
                $table->addRow();
                $table->addCell()->addText($diocese);
                $table->addCell()->addText($stats['total']);
                $table->addCell()->addText($stats['en_attente']);
                $table->addCell()->addText($stats['confirmee']);
                $table->addCell()->addText($stats['annulee']);
                $table->addCell()->addText($stats['total_personnes']);
            }
            $section->addTextBreak();
        }

        // Liste des réservations
        $section->addText('Liste des Réservations', ['bold' => true, 'size' => 14]);
        $table = $section->addTable(['borderSize' => 6]);
        $table->addRow();
        $table->addCell()->addText('Date', ['bold' => true]);
        $table->addCell()->addText('Nom', ['bold' => true]);
        $table->addCell()->addText('Paroisse', ['bold' => true]);
        $table->addCell()->addText('Diocèse', ['bold' => true]);
        $table->addCell()->addText('Téléphone', ['bold' => true]);
        $table->addCell()->addText('Date Réservation', ['bold' => true]);
        $table->addCell()->addText('Personnes', ['bold' => true]);
        $table->addCell()->addText('Statut', ['bold' => true]);

        foreach ($reservations as $reservation) {
            $table->addRow();
            $table->addCell()->addText(date('d/m/Y H:i', strtotime($reservation->created_at)));
            $table->addCell()->addText($reservation->nom);
            $table->addCell()->addText($reservation->paroisse);
            $table->addCell()->addText($reservation->diocese_vicariat ?? '-');
            $table->addCell()->addText($reservation->telephone);
            $table->addCell()->addText(date('d/m/Y', strtotime($reservation->date_reservation)));
            $table->addCell()->addText($reservation->nombre_personnes);
            $statutText = $reservation->statut === 'en_attente' ? 'En attente' : ($reservation->statut === 'confirmee' ? 'Confirmée' : 'Annulée');
            $table->addCell()->addText($statutText);
        }

        $filename = 'rapport-reservations.docx';
        $objWriter = IOFactory::createWriter($phpWord, 'Word2007');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        $objWriter->save('php://output');
        exit;
    }
}
