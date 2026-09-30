<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Recette extends Model {
    public const TYPES = ['quete_ordinaire' => 'Quête ordinaire', 'quete_speciale' => 'Quête spéciale', 'quete_imperative' => 'Quête impérative', 'quete_semaine' => 'Quête en semaine', 'denier_culte' => 'Denier du culte', 'dime' => 'Dîme', 'don' => 'Don', 'offrande_messe' => 'Offrande de messe', 'autre' => 'Autre'];
    protected $guarded = [];
    protected $casts = ['date' => 'date'];
    public function fidele() { return $this->belongsTo(Fidele::class); }
    public static function prochainRecu(): string { return sprintf('R-%d-%05d', now()->year, static::whereYear('created_at', now()->year)->count() + 1); }
}
