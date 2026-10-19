<?php

namespace App\Http\Controllers;

use App\Models\{BudgetAnnuel, Recette, Depense, LigneBudget};
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;

class BudgetController extends Controller
{
    public function index()
    {
        $budgets = BudgetAnnuel::orderBy('annee', 'desc')->get();

        foreach ($budgets as $budget) {
            $budget->calculerDepuisLignes();
        }

        return view('budget.dashboard', compact('budgets'));
    }

    public function tableauDeBord()
    {
        $budgets = BudgetAnnuel::orderBy('annee', 'desc')->get();

        foreach ($budgets as $budget) {
            $budget->calculerDepuisLignes();
        }

        $totalRecettes = $budgets->sum('recettes_totales');
        $totalDepenses = $budgets->sum('depenses_totales');
        $soldeGlobal = $budgets->sum('solde');

        $budgetsParAnnee = $budgets->map(function($budget) {
            return [
                'annee' => $budget->annee,
                'recettes' => $budget->recettes_totales,
                'depenses' => $budget->depenses_totales,
                'solde' => $budget->solde
            ];
        });

        return view('budget.tableau-de-bord', compact('budgets', 'totalRecettes', 'totalDepenses', 'soldeGlobal', 'budgetsParAnnee'));
    }

    public function liste()
    {
        $budgets = BudgetAnnuel::orderBy('annee', 'desc')->get();

        foreach ($budgets as $budget) {
            $budget->calculerDepuisLignes();
        }

        return view('budget.liste', compact('budgets'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'annee' => 'required|string|max:20|unique:budget_annuels,annee',
            'notes' => 'nullable|string'
        ]);

        $budget = BudgetAnnuel::create([
            'annee' => $request->annee,
            'notes' => $request->notes
        ]);

        return redirect()->route('budget.show', $budget->annee)->with('ok', 'Budget créé avec succès.');
    }

    public function storeLigne(Request $request)
    {
        $request->validate([
            'annee' => 'required|string',
            'nom' => 'required|string|max:255',
            'montant' => 'required|numeric|min:0',
            'type' => 'required|in:recette,depense',
            'realise' => 'nullable|boolean'
        ]);

        $budget = BudgetAnnuel::where('annee', $request->annee)->firstOrFail();

        LigneBudget::create([
            'budget_annuel_id' => $budget->id,
            'nom' => $request->nom,
            'montant' => $request->montant,
            'type' => $request->type,
            'realise' => $request->has('realise')
        ]);

        $budget->calculerDepuisLignes();

        return back()->with('ok', 'Ligne de budget ajoutée avec succès.');
    }

    public function destroyLigne($id)
    {
        $ligne = LigneBudget::findOrFail($id);
        $budget = $ligne->budgetAnnuel;
        $ligne->delete();
        $budget->calculerDepuisLignes();

        return back()->with('ok', 'Ligne de budget supprimée avec succès.');
    }

    public function toggleRealiseLigne($id)
    {
        $ligne = LigneBudget::findOrFail($id);
        $ligne->realise = !$ligne->realise;
        $ligne->save();

        return back()->with('ok', 'Statut de réalisation mis à jour.');
    }

    public function destroy($annee)
    {
        $budget = BudgetAnnuel::where('annee', $annee)->firstOrFail();
        $budget->lignes()->delete();
        $budget->delete();

        return redirect()->route('budget.liste')->with('ok', 'Budget supprimé avec succès.');
    }

    public function update(Request $request, $annee)
    {
        $request->validate([
            'notes' => 'nullable|string'
        ]);

        $budget = BudgetAnnuel::where('annee', $annee)->firstOrFail();
        $budget->update(['notes' => $request->notes]);

        return back()->with('ok', 'Budget mis à jour avec succès.');
    }

    public function show($annee)
    {
        $budget = BudgetAnnuel::getOrCreateForYear($annee);
        $budget->calculerDepuisLignes();

        return view('budget.show', compact('budget'));
    }

    public function exportPdf($annee)
    {
        $budget = BudgetAnnuel::getOrCreateForYear($annee);
        $budget->calculerDepuisLignes();

        $logoPath = public_path('images/logo-sanctuaire.jpg');
        $logoData = base64_encode(file_get_contents($logoPath));
        $logoSrc = 'data:image/jpeg;base64,' . $logoData;

        $pdf = Pdf::loadView('pdf.budget-annuel', compact('budget', 'logoSrc'));
        return $pdf->stream("budget-sanctuaire-{$annee}.pdf");
    }

    public function exportWord($annee)
    {
        $budget = BudgetAnnuel::getOrCreateForYear($annee);
        $budget->calculerDepuisLignes();

        $phpWord = new PhpWord();

        $section = $phpWord->addSection();

        $section->addText('Budget Annuel du Sanctuaire Marial Notre-Dame de Cana Sassako', ['bold' => true, 'size' => 16], ['alignment' => 'center']);
        $section->addText("Année {$annee}", ['size' => 14], ['alignment' => 'center']);
        $section->addTextBreak();

        $section->addText('Résumé Financier', ['bold' => true, 'size' => 14]);
        $section->addText("Total Entrées: " . number_format($budget->recettes_totales, 0, ',', ' ') . ' FCFA');
        $section->addText("Total Sorties: " . number_format($budget->depenses_totales, 0, ',', ' ') . ' FCFA');
        $section->addText("Solde: " . number_format($budget->solde, 0, ',', ' ') . ' FCFA');
        $section->addTextBreak();

        $section->addText('Détail du Budget', ['bold' => true, 'size' => 14]);
        $table = $section->addTable(['borderSize' => 6]);
        $table->addRow();
        $table->addCell(3000)->addText('Nom', ['bold' => true]);
        $table->addCell(2000)->addText('Type', ['bold' => true]);
        $table->addCell(3000)->addText('Montant (FCFA)', ['bold' => true]);
        $table->addCell(1500)->addText('Réalisé', ['bold' => true]);

        foreach ($budget->lignes as $ligne) {
            $table->addRow();
            $table->addCell(3000)->addText($ligne->nom);
            $table->addCell(2000)->addText($ligne->type === 'recette' ? 'Entrée' : 'Sortie');
            $table->addCell(3000)->addText(number_format($ligne->montant, 0, ',', ' '));
            $table->addCell(1500)->addText($ligne->realise ? 'Oui' : 'Non');
        }

        $fileName = "budget-sanctuaire-{$annee}.docx";
        $objWriter = IOFactory::createWriter($phpWord, 'Word2007');
        $objWriter->save(storage_path('app/temp/' . $fileName));

        return response()->download(storage_path('app/temp/' . $fileName))->deleteFileAfterSend(true);
    }

    public function updateNotes(Request $request, $annee)
    {
        $budget = BudgetAnnuel::getOrCreateForYear($annee);
        $budget->update(['notes' => $request->notes]);
        return back()->with('ok', 'Notes mises à jour.');
    }
}
