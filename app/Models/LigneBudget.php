<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LigneBudget extends Model
{
    protected $guarded = [];
    protected $table = 'lignes_budget';

    public function budgetAnnuel()
    {
        return $this->belongsTo(BudgetAnnuel::class);
    }
}
