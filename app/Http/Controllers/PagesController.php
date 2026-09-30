<?php
namespace App\Http\Controllers;
use App\Models\{Annonce, Evenement, Clerge, ConseilParoissial, MouvementParoissial};

class PagesController extends Controller
{
    public function accueil()
    {
        return view('pages.accueil', [
            'annonces_avec_images' => Annonce::actives()->avecImages()->latest('publie_le')->take(6)->get(),
            'annonces_sans_images' => Annonce::actives()->sansImages()->latest('publie_le')->take(6)->get(),
            'evenements' => Evenement::where('date_heure', '>=', now())->orderBy('date_heure')->take(8)->get(),
            'clerge' => Clerge::where('actif', true)->get(),
            'conseil' => ConseilParoissial::where('actif', true)->get(),
            'mouvements' => MouvementParoissial::where('actif', true)->get(),
        ]);
    }

    public function apropos()
    {
        return view('pages.apropos', [
            'clerge' => Clerge::where('actif', true)->get(),
            'conseil' => ConseilParoissial::where('actif', true)->get(),
            'mouvements' => MouvementParoissial::where('actif', true)->get(),
        ]);
    }

    public function annonces()
    {
        return view('pages.annonces', [
            'annonces_avec_images' => Annonce::actives()->avecImages()->latest('publie_le')->take(6)->get(),
            'annonces_sans_images' => Annonce::actives()->sansImages()->latest('publie_le')->take(6)->get(),
            'evenements' => Evenement::where('date_heure', '>=', now())->orderBy('date_heure')->take(8)->get(),
        ]);
    }

    public function contact()
    {
        return view('pages.contact');
    }
}