<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Clerge extends Model
{
    protected $guarded = [];

    public const ROLES = [
        'cure' => 'Curé',
        'vicaire' => 'Vicaire',
        'resident' => 'Résident',
    ];

    public function getNomCompletAttribute()
    {
        return $this->prenom . ' ' . $this->nom;
    }
}
