<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Casuel extends Model {
    protected $guarded = [];
    protected $casts = ['date_naissance' => 'date', 'date_naissance_2' => 'date', 'date_paiement' => 'date', 'montant' => 'integer'];
    public function fidele() { return $this->belongsTo(Fidele::class); }
    public function fidele2() { return $this->belongsTo(Fidele::class, 'fidele_id_2'); }
    public static function getTypes(): array {
        return [
            'bapteme' => 'Baptême',
            'confirmation' => 'Confirmation',
            'mariage' => 'Mariage',
            'deces' => 'Décès'
        ];
    }
    public static function options(): array {
        return static::with('fidele')->orderByDesc('date_paiement')->get()->mapWithKeys(fn ($c) => [
            $c->id => self::getTypes()[$c->type] . ' - ' . ($c->fidele ? $c->fidele->nom_complet : $c->nom . ' ' . $c->prenoms) . ' - ' . $c->date_paiement->format('d/m/Y')
        ])->all();
    }
}
