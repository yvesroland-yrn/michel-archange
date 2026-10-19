<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BudgetAnnuel extends Model
{
    protected $guarded = [];

    public function lignes()
    {
        return $this->hasMany(LigneBudget::class);
    }

    public function calculerDepuisLignes()
    {
        $recettesBudget = $this->lignes()->where('type', 'recette')->sum('montant');
        $depensesBudget = $this->lignes()->where('type', 'depense')->sum('montant');

        $this->recettes_totales = $recettesBudget;
        $this->depenses_totales = $depensesBudget;
        $this->solde = $recettesBudget - $depensesBudget;
        $this->save();
    }

    public static function getOrCreateForYear($year)
    {
        $budget = self::where('annee', $year)->first();
        if (!$budget) {
            $budget = self::create(['annee' => $year]);
        }
        return $budget;
    }
}
