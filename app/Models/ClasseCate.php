<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class ClasseCate extends Model {
    protected $table = 'classes_cate';
    protected $guarded = [];
    protected $casts = ['section' => 'string'];
    public function catechumenes() { return $this->hasMany(Catechumene::class); }
    public function catechiste() { return $this->belongsTo(Catechiste::class); }
    public function anneeCatechetique() { return $this->belongsTo(AnneeCatechetique::class); }
    public static function options(): array {
        return static::with('anneeCatechetique')->orderByDesc('id')->get()->mapWithKeys(fn ($c) => [
            $c->id => ($c->anneeCatechetique ? $c->anneeCatechetique->libelle : '—') . ' — ' . $c->niveau . ($c->code ? " ({$c->code})" : '') . " ({$c->section})"
        ])->all();
    }
    public static function getNiveaux(): array { return ['1ère année', '2ème année', '3ème année', '4ème année', '5ème année']; }
    public static function getSections(): array { return ['ENFANT' => 'Enfant', 'JEUNE' => 'Jeune', 'ADULTE' => 'Adulte']; }
}
