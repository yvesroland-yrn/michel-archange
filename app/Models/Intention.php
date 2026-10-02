<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Intention extends Model {
    protected $guarded = [];
    protected $casts = ['date_messe' => 'date', 'date_tirage' => 'date', 'offrande' => 'integer'];

    const TYPES = [
        'action_grace' => 'Action de grâce',
        'repos_eternel' => 'Repos éternel',
        'autre' => 'Autre',
    ];

    const JOURS_MESSE = [
        'samedi' => 'Samedi',
        'dimanche' => 'Dimanche',
    ];

    const JOURS_MESSE_DETAILLES = [
        'lundi' => 'Lundi',
        'mardi' => 'Mardi',
        'mercredi' => 'Mercredi',
        'jeudi' => 'Jeudi',
        'vendredi' => 'Vendredi',
        'samedi' => 'Samedi',
        'dimanche_7h' => 'Dimanche 7h',
        'dimanche_9h' => 'Dimanche 9h',
    ];

    const STATUTS = [
        'en_attente' => 'En attente de tirage',
        'tiree' => 'Tirée',
        'celebree' => 'Célébrée',
    ];

    public function user() { return $this->belongsTo(User::class); }

    public static function prochainRecu(): string {
        $year = now()->year;
        $lastNumero = static::whereYear('created_at', $year)
            ->orderBy('id', 'desc')
            ->value('recu_numero');

        if ($lastNumero) {
            // Extraire le numéro séquentiel du dernier reçu
            $parts = explode('-', $lastNumero);
            $lastSequence = (int) end($parts);
            $newSequence = $lastSequence + 1;
        } else {
            $newSequence = 1;
        }

        return sprintf('I-%d-%05d', $year, $newSequence);
    }

    // Obtenir le numéro de semaine actuel
    public static function getNumeroSemaine(): string {
        return now()->format('o-\WW');
    }

    // Obtenir les intentions en attente pour une semaine donnée
    public static function getIntentionsEnAttente(?string $numeroSemaine = null): \Illuminate\Database\Eloquent\Collection
    {
        $numeroSemaine = $numeroSemaine ?? self::getNumeroSemaine();
        return self::where('statut', 'en_attente')
            ->where('numero_semaine', $numeroSemaine)
            ->orderBy('created_at', 'asc')
            ->get();
    }

    // Obtenir les intentions tirées pour une semaine donnée
    public static function getIntentionsTirees(?string $numeroSemaine = null): \Illuminate\Database\Eloquent\Collection
    {
        $numeroSemaine = $numeroSemaine ?? self::getNumeroSemaine();
        return self::where('statut', 'tiree')
            ->where('numero_semaine', $numeroSemaine)
            ->orderBy('jour_messe', 'asc')
            ->orderBy('created_at', 'asc')
            ->get();
    }

    // Tirer les intentions pour une semaine (utiliser les jours détaillés si spécifiés)
    public static function tirerIntentions(?string $numeroSemaine = null): array
    {
        $numeroSemaine = $numeroSemaine ?? self::getNumeroSemaine();
        $intentions = self::getIntentionsEnAttente($numeroSemaine);
        $tirees = [];

        if ($intentions->isEmpty()) {
            return $tirees;
        }

        // Répartir en utilisant les jours détaillés spécifiés ou répartition automatique
        foreach ($intentions as $intention) {
            $jourDetaille = $intention->jour_messe_detaille;

            // Si un jour détaillé est spécifié, l'utiliser
            if ($jourDetaille) {
                $jourMesse = str_starts_with($jourDetaille, 'dimanche') ? 'dimanche' : $jourDetaille;
            } else {
                // Répartition automatique entre samedi et dimanche
                $countSamedi = self::where('statut', 'tiree')
                    ->where('numero_semaine', $numeroSemaine)
                    ->where('jour_messe', 'samedi')
                    ->count();
                $countDimanche = self::where('statut', 'tiree')
                    ->where('numero_semaine', $numeroSemaine)
                    ->where('jour_messe', 'dimanche')
                    ->count();

                $jourMesse = $countSamedi <= $countDimanche ? 'samedi' : 'dimanche';
                $jourDetaille = $jourMesse === 'samedi' ? 'samedi' : 'dimanche_9h';
            }

            $intention->update([
                'statut' => 'tiree',
                'date_tirage' => now(),
                'jour_messe' => $jourMesse,
                'jour_messe_detaille' => $jourDetaille,
                'numero_semaine' => $numeroSemaine,
            ]);
            $tirees[] = $intention;
        }

        return $tirees;
    }

    // Marquer une intention comme célébrée
    public function marquerCelebree(): void
    {
        $this->update(['statut' => 'celebree']);
    }

    // Obtenir le type d'intention formaté
    public function getTypeLibelleAttribute(): string
    {
        return self::TYPES[$this->type] ?? 'Autre';
    }

    // Obtenir le jour de messe formaté
    public function getJourMesseLibelleAttribute(): string
    {
        return self::JOURS_MESSE[$this->jour_messe] ?? '-';
    }

    // Obtenir le jour de messe détaillé formaté
    public function getJourMesseDetailleLibelleAttribute(): string
    {
        return self::JOURS_MESSE_DETAILLES[$this->jour_messe_detaille] ?? '-';
    }

    // Obtenir le statut formaté
    public function getStatutLibelleAttribute(): string
    {
        return self::STATUTS[$this->statut] ?? $this->statut;
    }
}
