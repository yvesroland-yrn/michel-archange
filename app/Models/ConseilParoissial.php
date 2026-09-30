<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConseilParoissial extends Model
{
    protected $guarded = [];

    public function getNomCompletAttribute()
    {
        return $this->prenom . ' ' . $this->nom;
    }
}
