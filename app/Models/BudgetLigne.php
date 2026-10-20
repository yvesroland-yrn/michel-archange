<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BudgetLigne extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'budget_category_id',
        'libelle',
        'annee',
        'mois',
        'montant_prevu',
        'note',
        'created_by',
    ];

    protected $casts = [
        'montant_prevu' => 'integer',
        'annee' => 'string',
        'mois' => 'integer',
    ];

    public function category()
    {
        return $this->belongsTo(BudgetCategory::class, 'budget_category_id');
    }

    public function mouvements()
    {
        return $this->hasMany(BudgetMouvement::class, 'budget_ligne_id');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Accesseur pour le montant réalisé
    public function getMontantRealiseAttribute()
    {
        return $this->mouvements()->sum('montant');
    }

    // Accesseur pour le reste
    public function getResteAttribute()
    {
        $montantRealise = $this->montant_realise;
        $type = $this->category->type ?? 'depense';

        if ($type === 'recette') {
            // Pour les recettes, le reste est réalisé - prévu
            return $montantRealise - $this->montant_prevu;
        }

        // Pour les dépenses, le reste est prévu - réalisé
        return $this->montant_prevu - $montantRealise;
    }

    // Accesseur pour le taux de consommation
    public function getTauxAttribute()
    {
        if ($this->montant_prevu == 0) {
            return 0;
        }

        $montantRealise = $this->montant_realise;
        $type = $this->category->type ?? 'depense';

        if ($type === 'recette') {
            // Pour les recettes
            return ($montantRealise / $this->montant_prevu) * 100;
        }

        // Pour les dépenses
        return ($montantRealise / $this->montant_prevu) * 100;
    }

    // Accesseur pour le statut
    public function getStatutAttribute()
    {
        $taux = $this->taux;
        $type = $this->category->type ?? 'depense';

        if ($type === 'recette') {
            // Logique inversée pour les recettes
            if ($taux == 0) {
                return 'Non entamé';
            } elseif ($taux < 90) {
                return 'En cours';
            } elseif ($taux < 100) {
                return 'Presque atteint';
            } elseif ($taux == 100) {
                return 'Atteint';
            } else {
                return 'Dépassé';
            }
        }

        // Logique pour les dépenses
        if ($taux == 0) {
            return 'Non entamé';
        } elseif ($taux < 90) {
            return 'En cours';
        } elseif ($taux < 100) {
            return 'Presque atteint';
        } elseif ($taux == 100) {
            return 'Atteint';
        } else {
            return 'Dépassé';
        }
    }

    // Scope pour filtrer par année
    public function scopeAnnee($query, $annee)
    {
        return $query->where('annee', $annee);
    }

    // Scope pour filtrer par mois
    public function scopeMois($query, $mois)
    {
        return $query->where('mois', $mois);
    }

    // Scope pour les lignes annuelles
    public function scopeAnnuel($query)
    {
        return $query->whereNull('mois');
    }

    // Scope pour les lignes mensuelles
    public function scopeMensuel($query)
    {
        return $query->whereNotNull('mois');
    }

    // Scope pour les lignes dépassées
    public function scopeDepasse($query)
    {
        return $query->whereHas('category', function ($q) {
            $q->where('type', 'depense');
        });
    }
}
