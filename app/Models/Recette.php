<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Recette extends Model {
    public const TYPES = [
        'quete_ordinaire' => 'Quête ordinaire',
        'quete_speciale' => 'Quête spéciale',
        'quete_imperative' => 'Quête impérative',
        'quete_semaine' => 'Quête en semaine',
        'denier_culte' => 'Denier du culte',
        'dime' => 'Dîme',
        'don' => 'Don',
        'offrande_messe' => 'Offrande de messe',
        'autre' => 'Autre'
    ];

    public const CATEGORIES = [
        'don' => 'Dons',
        'dime' => 'Dîmes',
        'quete' => 'Quêtes',
        'offrande' => 'Offrandes',
        'autre' => 'Autre'
    ];

    public const CATEGORY_TYPES = [
        'don' => ['don'],
        'dime' => ['dime'],
        'quete' => ['quete_ordinaire', 'quete_speciale', 'quete_imperative', 'quete_semaine', 'denier_culte'],
        'offrande' => ['offrande_messe'],
        'autre' => ['autre']
    ];

    protected $guarded = [];
    protected $casts = ['date' => 'date'];
    public function fidele() { return $this->belongsTo(Fidele::class); }

    public function getDonateurNomAttribute(): string
    {
        return $this->fidele?->nom_complet ?? ($this->attributes['donateur_nom'] ?? 'Anonyme');
    }

    public static function prochainRecu(): string {
        $year = now()->year;
        $lastNumero = static::whereYear('created_at', $year)
            ->orderBy('id', 'desc')
            ->value('recu_numero');

        if ($lastNumero) {
            $parts = explode('-', $lastNumero);
            $lastSequence = (int) end($parts);
            $newSequence = $lastSequence + 1;
        } else {
            $newSequence = 1;
        }

        return sprintf('R-%d-%05d', $year, $newSequence);
    }

    public function getCategoryAttribute(): string
    {
        foreach (self::CATEGORY_TYPES as $category => $types) {
            if (in_array($this->type, $types)) {
                return $category;
            }
        }
        return 'autre';
    }

    public function getCategoryLibelleAttribute(): string
    {
        return self::CATEGORIES[$this->category] ?? 'Autre';
    }
}
