<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Sacrement extends Model {
    public const TYPES = ['communion' => 'Première communion', 'profession_foi' => 'Profession de foi', 'confirmation' => 'Confirmation', 'mariage' => 'Mariage', 'onction' => 'Onction des malades', 'deces' => 'Funérailles'];
    protected $guarded = [];
    protected $casts = ['date_celebration' => 'date'];
    public function fidele() { return $this->belongsTo(Fidele::class); }
    public function conjoint() { return $this->belongsTo(Fidele::class, 'conjoint_id'); }
    public static function prochainNumero(string $type): string {
        $an = now()->year; $p = strtoupper(substr($type, 0, 3));
        return sprintf('%s-%d-%04d', $p, $an, static::where('type', $type)->whereYear('created_at', $an)->count() + 1);
    }
}
