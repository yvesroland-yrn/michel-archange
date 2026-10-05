<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class AnneeCatechetique extends Model {
    protected $table = 'annees_catechetiques';
    protected $guarded = [];
    protected $casts = ['date_debut' => 'date', 'date_fin' => 'date', 'statut' => 'string'];
    public function classes() { return $this->hasMany(ClasseCate::class); }
    public static function getStatuts(): array { return ['actif' => 'Actif', 'cloture' => 'Clôturé']; }
    public static function options(): array { return static::orderByDesc('date_debut')->get()->mapWithKeys(fn ($a) => [$a->id => $a->libelle])->all(); }
    public static function getActive(): ?self { return static::where('statut', 'actif')->latest('date_debut')->first(); }
}
