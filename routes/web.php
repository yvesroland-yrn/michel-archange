<?php
use App\Http\Controllers\{AuthController, HomeController, DashboardController, FideleController, BaptemeController, SacrementController, CebController,
    MouvementController, ClasseCateController, CatechumeneController, EvenementController, IntentionController, AnnonceController, FinanceController, UserController, PagesController, ClergeController, ConseilParoissialController, MouvementParoissialController, ContactController};
use Illuminate\Support\Facades\Route;

Route::get('/', [PagesController::class, 'accueil'])->name('home');
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

    Route::middleware('permission:sacrements')->group(function () {
        Route::get('sacrements/{sacrement}/certificat', [SacrementController::class, 'certificat'])->name('sacrements.certificat');
        Route::resource('sacrements', SacrementController::class)->except('show');
    });

    Route::middleware('permission:cebs')->group(function () {
        Route::resource('cebs', CebController::class)->except('show');
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
    });

    Route::middleware('permission:mouvement_paroissial')->group(function () {
        Route::resource('mouvement-paroissial', MouvementParoissialController::class)->except('show');
    });

    Route::middleware('permission:evenements')->group(function () {
        Route::resource('evenements', EvenementController::class)->except('show');
    });

    Route::middleware('permission:intentions')->group(function () {
        Route::get('intentions/{intention}/recu', [IntentionController::class, 'recu'])->name('intentions.recu');
        Route::resource('intentions', IntentionController::class)->except('show');
    });

    Route::middleware('permission:annonces')->group(function () {
        Route::resource('annonces', AnnonceController::class)->except('show');
    });

    Route::middleware('permission:classes_cate')->group(function () {
        Route::resource('classes-cate', ClasseCateController::class)->except('show')->parameters(['classes-cate' => 'classes_cate']);
    });

    Route::middleware('permission:catechumenes')->group(function () {
        Route::resource('catechumenes', CatechumeneController::class)->except('show');
    });

    Route::middleware('permission:finances')->prefix('finances')->name('finance.')->group(function () {
        Route::get('/', [FinanceController::class, 'index'])->name('index');
        Route::post('recettes', [FinanceController::class, 'storeRecette'])->name('recettes.store');
        Route::post('depenses', [FinanceController::class, 'storeDepense'])->name('depenses.store');
        Route::get('recettes/{recette}/recu', [FinanceController::class, 'recu'])->name('recu');
        Route::get('bilan', [FinanceController::class, 'bilan'])->name('bilan');
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
});
