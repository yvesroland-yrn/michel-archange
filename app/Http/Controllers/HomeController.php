<?php
namespace App\Http\Controllers;
use App\Models\{Annonce, Evenement};
class HomeController extends Controller {
    public function __invoke() {
        // Rediriger vers la nouvelle structure de pages
        return redirect()->route('home');
    }
}
