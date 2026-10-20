<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BudgetMouvement extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'budget_ligne_id',
        'date_operation',
        'montant',
        'description',
        'reference',
        'justificatif',
        'beneficiaire',
        'created_by',
    ];

    protected $casts = [
        'montant' => 'integer',
        'date_operation' => 'date',
    ];

    public function ligne()
    {
        return $this->belongsTo(BudgetLigne::class, 'budget_ligne_id');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Scope pour filtrer par période
    public function scopePeriode($query, $dateDebut, $dateFin)
    {
        return $query->whereBetween('date_operation', [$dateDebut, $dateFin]);
    }

    // Scope pour filtrer par année
    public function scopeAnnee($query, $annee)
    {
        return $query->whereYear('date_operation', $annee);
    }

    // Scope pour filtrer par mois
    public function scopeMois($query, $mois)
    {
        return $query->whereMonth('date_operation', $mois);
    }
}
