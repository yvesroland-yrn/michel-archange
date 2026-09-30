<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MouvementParoissial extends Model
{
    protected $guarded = [];

    public const ICONES = [
        'bi-music-note-beamed' => 'Chorale',
        'bi-flower1' => 'Légion de Marie',
        'bi-bell' => "Serviteurs de l'Autel",
        'bi-people' => 'CEB',
        'bi-heart' => 'Charité',
        'bi-book' => 'Catéchèse',
        'bi-calendar-event' => 'Jeunesse',
        'bi-gear' => 'Autre',
    ];
}
