<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Depense extends Model {
    public const CATEGORIES = ['entretien' => 'Entretien', 'electricite' => 'Électricité', 'eau' => 'Eau', 'liturgie' => 'Liturgie', 'salaires' => 'Salaires', 'projets' => 'Projets', 'travaux_eglise' => 'Travaux église', 'autre' => 'Autre'];
    protected $guarded = [];
    protected $casts = ['date' => 'date'];
}
