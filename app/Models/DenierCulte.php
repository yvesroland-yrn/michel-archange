<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class DenierCulte extends Model {
    protected $table = 'deniers_culte';
    protected $guarded = [];
    protected $casts = ['date_paiement' => 'date', 'montant' => 'integer'];
    public function fidele() { return $this->belongsTo(Fidele::class); }
    public static function getPeriodes(): array {
        return [
            'mensuelle' => 'Mensuelle',
            'trimestrielle' => 'Trimestrielle',
            'annuelle' => 'Annuelle',
            'ponctuelle' => 'Ponctuelle'
        ];
    }
    public static function options(): array {
        return static::with('fidele')->orderByDesc('date_paiement')->get()->mapWithKeys(fn ($d) => [
            $d->id => ($d->fidele ? $d->fidele->nom_complet : $d->donateur_nom) . ' - ' . $d->date_paiement->format('d/m/Y') . ' - ' . number_format($d->montant, 0, '', ' ') . ' FCFA'
        ])->all();
    }
}
