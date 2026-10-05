<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Catechiste extends Model {
    protected $guarded = [];
    protected $casts = ['section' => 'string', 'statut' => 'string'];
    public function fidele() { return $this->belongsTo(Fidele::class); }
    public static function getSections(): array { return ['ENFANT' => 'Enfant', 'JEUNE' => 'Jeune', 'ADULTE' => 'Adulte']; }
    public static function getStatuts(): array { return ['actif' => 'Actif', 'inactif' => 'Inactif']; }
    public static function options(): array { return static::where('statut', 'actif')->orderBy('nom')->get()->mapWithKeys(fn ($c) => [$c->id => "{$c->nom} {$c->prenoms}"])->all(); }
}
