<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Evenement extends Model {
    public const TYPES = ['messe' => 'Messe', 'adoration' => 'Adoration', 'retraite' => 'Retraite', 'reunion' => 'Réunion', 'fete' => 'Fête / Solennité', 'autre' => 'Autre'];
    protected $guarded = [];
    protected $casts = ['date_heure' => 'datetime'];
    public static function options(): array { return static::where('date_heure', '>=', now()->subDays(7))->orderBy('date_heure')->get()->mapWithKeys(fn ($e) => [$e->id => $e->date_heure->format('d/m/Y H:i').' — '.$e->titre])->all(); }
}
