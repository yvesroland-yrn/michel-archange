<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Depense extends Model {
    public const CATEGORIES = ['entretien' => 'Entretien', 'energie' => 'Électricité / Eau', 'liturgie' => 'Liturgie', 'salaires' => 'Salaires', 'projets' => 'Projets', 'autre' => 'Autre'];
    protected $guarded = [];
    protected $casts = ['date' => 'date'];
}
