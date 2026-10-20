<?php
use App\Http\Controllers\{AuthController, HomeController, DashboardController, FideleController, BaptemeController, SacrementController, CebController,
    MouvementController, ClasseCateController, CatechumeneController, CatechisteController, AnneeCatechetiqueController, CatecheseDashboardController, EvenementController, IntentionController, AnnonceController, FinanceController, UserController, PagesController, ClergeController, ConseilParoissialController, MouvementParoissialController, ContactController, DenierCulteController, CasuelController, StockController, StockReportController, ReservationController, BudgetCategoryController, BudgetLigneController, BudgetMouvementController, BudgetDashboardController, BudgetRapportController};
use Illuminate\Support\Facades\Route;

Route::get('/', [PagesController::class, 'accueil'])->name('home');
Route::post('/reservation', [ReservationController::class, 'store'])->name('reservation.store');
Route::get('apropos', [PagesController::class, 'apropos'])->name('apropos');
Route::get('actualites', [PagesController::class, 'annonces'])->name('annonces');
Route::get('contact', [PagesController::class, 'contact'])->name('contact');
Route::post('contact/envoyer', [ContactController::class, 'envoyer'])->name('contact.envoyer');
Route::get('connexion', [AuthController::class, 'form'])->name('login')->middleware('guest');
Route::post('connexion', [AuthController::class, 'login'])->middleware(['guest', 'throttle:6,1']);
Route::post('deconnexion', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

Route::middleware('auth')->group(function () {
    Route::get('tableau-de-bord', DashboardController::class)->name('dashboard');

    Route::middleware('permission:fideles')->group(function () {
        Route::get('fideles/export', [FideleController::class, 'export'])->name('fideles.export');
        Route::resource('fideles', FideleController::class)->parameters(['fideles' => 'fidele']);
        Route::get('fideles/{fidele}/bapteme/creer', [BaptemeController::class, 'create'])->name('baptemes.create');
        Route::post('fideles/{fidele}/bapteme', [BaptemeController::class, 'store'])->name('baptemes.store');
        Route::get('baptemes/{bapteme}/certificat', [BaptemeController::class, 'certificat'])->name('baptemes.certificat');
    });

    Route::middleware('permission:fideles')->group(function () {
        Route::get('deniers-culte', [DenierCulteController::class, 'index'])->name('deniers-culte.index');
        Route::post('deniers-culte', [DenierCulteController::class, 'store'])->name('deniers-culte.store');
        Route::put('deniers-culte/{denier}', [DenierCulteController::class, 'update'])->name('deniers-culte.update');
        Route::delete('deniers-culte/{denier}', [DenierCulteController::class, 'destroy'])->name('deniers-culte.destroy');
        Route::get('deniers-culte/{denier}/recu', [DenierCulteController::class, 'recu'])->name('deniers-culte.recu');
        Route::get('deniers-culte/export-pdf', [DenierCulteController::class, 'exportPdf'])->name('deniers-culte.export-pdf');
    });

    Route::middleware('permission:fideles')->group(function () {
        Route::get('casuels', [CasuelController::class, 'index'])->name('casuels.index');
        Route::post('casuels', [CasuelController::class, 'store'])->name('casuels.store');
        Route::delete('casuels/{casuel}', [CasuelController::class, 'destroy'])->name('casuels.destroy');
        Route::get('casuels/{casuel}/recu', [CasuelController::class, 'recu'])->name('casuels.recu');
        Route::get('casuels/export-pdf', [CasuelController::class, 'exportPdf'])->name('casuels.export-pdf');
    });

    Route::middleware('permission:sacrements')->group(function () {
        Route::get('sacrements/{sacrement}/certificat', [SacrementController::class, 'certificat'])->name('sacrements.certificat');
        Route::get('sacrements/{sacrement}/certificat-confirmation', [SacrementController::class, 'certificatConfirmation'])->name('sacrements.certificat-confirmation');
        Route::get('sacrements/{sacrement}/certificat-mariage', [SacrementController::class, 'certificatMariage'])->name('sacrements.certificat-mariage');
        Route::resource('sacrements', SacrementController::class)->except('show');
    });

    Route::middleware('permission:cebs')->group(function () {
        Route::resource('cebs', CebController::class)->except('show');
        Route::get('cebs/pdf', [CebController::class, 'exportPdf'])->name('cebs.pdf');
    });

    Route::middleware('permission:mouvements')->group(function () {
        Route::get('mouvements/{mouvement}/membres', [MouvementController::class, 'membres'])->name('mouvements.membres');
        Route::post('mouvements/{mouvement}/membres', [MouvementController::class, 'ajouterMembre'])->name('mouvements.membres.ajouter');
        Route::delete('mouvements/{mouvement}/membres/{fidele}', [MouvementController::class, 'retirerMembre'])->name('mouvements.membres.retirer');
        Route::resource('mouvements', MouvementController::class)->except('show');
    });

    Route::middleware('permission:clerge')->group(function () {
        Route::resource('clerge', ClergeController::class)->except('show');
    });

    Route::middleware('permission:conseil_paroissial')->group(function () {
        Route::resource('conseil-paroissial', ConseilParoissialController::class)->except('show');
        Route::get('conseil-paroissial/pdf', [ConseilParoissialController::class, 'exportPdf'])->name('conseil-paroissial.pdf');
    });

    Route::middleware('permission:mouvement_paroissial')->group(function () {
        Route::resource('mouvement-paroissial', MouvementParoissialController::class)->except('show');
        Route::get('mouvement-paroissial/pdf', [MouvementParoissialController::class, 'exportPdf'])->name('mouvement-paroissial.pdf');
    });

    Route::middleware('permission:evenements')->group(function () {
        Route::resource('evenements', EvenementController::class)->except('show');
        Route::get('evenements/pdf', [EvenementController::class, 'exportPdf'])->name('evenements.pdf');
    });

    Route::middleware('permission:intentions')->group(function () {
        Route::get('intentions/{intention}/recu', [IntentionController::class, 'recu'])->name('intentions.recu');
        Route::get('intentions/{intention}/celebrer', [IntentionController::class, 'celebrer'])->name('intentions.celebrer');
        Route::get('intentions/tirage', [IntentionController::class, 'tirage'])->name('intentions.tirage');
        Route::post('intentions/tirage', [IntentionController::class, 'effectuerTirage'])->name('intentions.effectuer-tirage');
        Route::get('intentions/liste', [IntentionController::class, 'listeSemaine'])->name('intentions.liste');
        Route::get('intentions/export', [IntentionController::class, 'exportListe'])->name('intentions.export');
        Route::get('intentions/export-pdf', [IntentionController::class, 'exportPdf'])->name('intentions.export-pdf');
        Route::get('intentions/export-word', [IntentionController::class, 'exportWord'])->name('intentions.export-word');
        Route::resource('intentions', IntentionController::class)->except('show');
    });

    Route::middleware('permission:annonces')->group(function () {
        Route::resource('annonces', AnnonceController::class)->except('show');
    });

    Route::middleware('permission:stock')->group(function () {
        Route::get('stock/dashboard', [StockController::class, 'dashboard'])->name('stock.dashboard');
        Route::get('stock/rapport', [StockReportController::class, 'index'])->name('stock.rapport');
        Route::get('stock/rapport/pdf', [StockReportController::class, 'exportPdf'])->name('stock.rapport.pdf');
        Route::get('stock/produits/pdf', [StockReportController::class, 'exportProduitsPdf'])->name('stock.produits.pdf');
        Route::post('stock/{produit}/add', [StockController::class, 'addStock'])->name('stock.add');
        Route::post('stock/{produit}/remove', [StockController::class, 'removeStock'])->name('stock.remove');
        Route::resource('stock', StockController::class)->except('show');
    });

    Route::middleware('permission:classes_cate')->group(function () {
        Route::get('catechese/tableau-de-bord', [CatecheseDashboardController::class, 'index'])->name('catechese.dashboard');
    });

    Route::middleware('permission:annees_catechetiques')->group(function () {
        Route::resource('annees-catechetiques', AnneeCatechetiqueController::class)->except('show');
    });

    Route::middleware('permission:classes_cate')->group(function () {
        Route::resource('classes-cate', ClasseCateController::class)->except('show')->parameters(['classes-cate' => 'classes_cate']);
    });

    Route::middleware('permission:catechistes')->group(function () {
        Route::get('catechistes/export-pdf-par-classe', [CatechisteController::class, 'exportPdfParClasse'])->name('catechistes.export-pdf-par-classe');
        Route::get('catechistes/export-pdf-par-annee', [CatechisteController::class, 'exportPdfParAnnee'])->name('catechistes.export-pdf-par-annee');
        Route::get('catechistes/export-pdf-par-section', [CatechisteController::class, 'exportPdfParSection'])->name('catechistes.export-pdf-par-section');
        Route::get('catechistes/export-word-par-classe', [CatechisteController::class, 'exportWordParClasse'])->name('catechistes.export-word-par-classe');
        Route::get('catechistes/export-word-par-annee', [CatechisteController::class, 'exportWordParAnnee'])->name('catechistes.export-word-par-annee');
        Route::get('catechistes/export-word-par-section', [CatechisteController::class, 'exportWordParSection'])->name('catechistes.export-word-par-section');
        Route::resource('catechistes', CatechisteController::class)->except('show');
    });

    Route::middleware('permission:catechumenes')->group(function () {
        Route::get('catechumenes/{catechumene}/recu', [CatechumeneController::class, 'recu'])->name('catechumenes.recu');
        Route::get('catechumenes/export-pdf-par-classe', [CatechumeneController::class, 'exportPdfParClasse'])->name('catechumenes.export-pdf-par-classe');
        Route::get('catechumenes/export-pdf-par-annee', [CatechumeneController::class, 'exportPdfParAnnee'])->name('catechumenes.export-pdf-par-annee');
        Route::get('catechumenes/export-word-par-classe', [CatechumeneController::class, 'exportWordParClasse'])->name('catechumenes.export-word-par-classe');
        Route::get('catechumenes/export-word-par-annee', [CatechumeneController::class, 'exportWordParAnnee'])->name('catechumenes.export-word-par-annee');
        Route::resource('catechumenes', CatechumeneController::class)->except('show');
    });

    Route::middleware('permission:finances')->prefix('finances')->name('finance.')->group(function () {
        Route::get('/', [FinanceController::class, 'index'])->name('index');
        Route::get('dons', [FinanceController::class, 'dons'])->name('dons');
        Route::get('dimes', [FinanceController::class, 'dimes'])->name('dimes');
        Route::get('offrandes', [FinanceController::class, 'offrandes'])->name('offrandes');
        Route::get('quetes', [FinanceController::class, 'quetes'])->name('quetes');
        Route::get('denier-culte', [FinanceController::class, 'denierCulte'])->name('denier-culte');
        Route::post('recettes', [FinanceController::class, 'storeRecette'])->name('recettes.store');
        Route::post('depenses', [FinanceController::class, 'storeDepense'])->name('depenses.store');
        Route::get('recettes/{recette}/recu', [FinanceController::class, 'recu'])->name('recu');
        Route::get('bilan', [FinanceController::class, 'bilan'])->name('bilan');
    });

    Route::middleware('permission:finances')->prefix('budget')->name('budget.')->group(function () {
        // Nouveau système de budget
        Route::get('/dashboard', [BudgetDashboardController::class, 'index'])->name('dashboard');

        Route::prefix('categories')->name('categories.')->group(function () {
            Route::get('/', [BudgetCategoryController::class, 'index'])->name('index');
            Route::get('/create', [BudgetCategoryController::class, 'create'])->name('create');
            Route::post('/', [BudgetCategoryController::class, 'store'])->name('store');
            Route::get('/{category}/edit', [BudgetCategoryController::class, 'edit'])->name('edit');
            Route::put('/{category}', [BudgetCategoryController::class, 'update'])->name('update');
            Route::delete('/{category}', [BudgetCategoryController::class, 'destroy'])->name('destroy');
        });

        Route::prefix('lignes')->name('lignes.')->group(function () {
            Route::get('/', [BudgetLigneController::class, 'index'])->name('index');
            Route::get('/create', [BudgetLigneController::class, 'create'])->name('create');
            Route::post('/', [BudgetLigneController::class, 'store'])->name('store');
            Route::get('/{ligne}', [BudgetLigneController::class, 'show'])->name('show');
            Route::get('/{ligne}/edit', [BudgetLigneController::class, 'edit'])->name('edit');
            Route::put('/{ligne}', [BudgetLigneController::class, 'update'])->name('update');
            Route::delete('/{ligne}', [BudgetLigneController::class, 'destroy'])->name('destroy');
            Route::post('/{ligne}/duplicate', [BudgetLigneController::class, 'duplicate'])->name('duplicate');
        });

        Route::prefix('mouvements')->name('mouvements.')->group(function () {
            Route::get('/', [BudgetMouvementController::class, 'index'])->name('index');
            Route::get('/create', [BudgetMouvementController::class, 'create'])->name('create');
            Route::post('/', [BudgetMouvementController::class, 'store'])->name('store');
            Route::get('/{mouvement}', [BudgetMouvementController::class, 'show'])->name('show');
            Route::get('/{mouvement}/edit', [BudgetMouvementController::class, 'edit'])->name('edit');
            Route::put('/{mouvement}', [BudgetMouvementController::class, 'update'])->name('update');
            Route::delete('/{mouvement}', [BudgetMouvementController::class, 'destroy'])->name('destroy');
        });

        Route::prefix('rapport')->name('rapport.')->group(function () {
            Route::get('/', [BudgetRapportController::class, 'index'])->name('index');
            Route::get('/export-pdf', [BudgetRapportController::class, 'exportPdf'])->name('export-pdf');
            Route::get('/export-excel', [BudgetRapportController::class, 'exportExcel'])->name('export-excel');
        });
    });

    Route::middleware('permission:users')->group(function () {
        Route::resource('users', UserController::class)->except('show');
    });

    Route::middleware('permission:contacts')->group(function () {
        Route::get('contacts', [ContactController::class, 'index'])->name('contacts.index');
        Route::get('contacts/{contact}', [ContactController::class, 'show'])->name('contacts.show');
        Route::post('contacts/{contact}/marquer-lu', [ContactController::class, 'marquerLu'])->name('contacts.marquer-lu');
        Route::delete('contacts/{contact}', [ContactController::class, 'destroy'])->name('contacts.destroy');
    });

    Route::get('reservations', [ReservationController::class, 'index'])->name('reservation.index');
    Route::put('reservations/{id}/statut', [ReservationController::class, 'updateStatut'])->name('reservation.update-statut');
    Route::delete('reservations/{id}', [ReservationController::class, 'destroy'])->name('reservation.destroy');
    Route::get('reservations/export-pdf', [ReservationController::class, 'exportPdf'])->name('reservation.export-pdf');
    Route::get('reservations/export-word', [ReservationController::class, 'exportWord'])->name('reservation.export-word');
});
