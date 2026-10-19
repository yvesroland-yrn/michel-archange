<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    protected $fillable = [
        'nom',
        'paroisse',
        'diocese_vicariat',
        'telephone',
        'date_reservation',
        'nombre_personnes',
        'message',
        'statut'
    ];

    protected $casts = [
        'date_reservation' => 'date',
    ];

    const STATUTS = [
        'en_attente' => 'En attente',
        'confirmee' => 'Confirmée',
        'annulee' => 'Annulée'
    ];
}
