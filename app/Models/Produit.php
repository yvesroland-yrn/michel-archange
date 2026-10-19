<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['nom', 'description', 'categorie', 'prix', 'quantite', 'seuil_alerte', 'actif'])]
class Produit extends Model
{
    protected $casts = [
        'prix' => 'decimal:2',
        'quantite' => 'integer',
        'seuil_alerte' => 'integer',
        'actif' => 'boolean',
    ];

    public function mouvements()
    {
        return $this->hasMany(MouvementStock::class);
    }

    public function estEnRupture(): bool
    {
        return $this->quantite <= $this->seuil_alerte;
    }
}
