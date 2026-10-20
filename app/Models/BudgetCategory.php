<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BudgetCategory extends Model
{
    protected $fillable = ['nom', 'type', 'description', 'actif'];

    protected $casts = [
        'actif' => 'boolean',
    ];

    public function lignes()
    {
        return $this->hasMany(BudgetLigne::class);
    }

    public function scopeActif($query)
    {
        return $query->where('actif', true);
    }

    public function scopeDepense($query)
    {
        return $query->where('type', 'depense');
    }

    public function scopeRecette($query)
    {
        return $query->where('type', 'recette');
    }
}
