<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class ClasseCate extends Model {
    protected $table = 'classes_cate';
    protected $guarded = [];
    public function catechumenes() { return $this->hasMany(Catechumene::class); }
    public static function options(): array { return static::orderByDesc('annee')->get()->mapWithKeys(fn ($c) => [$c->id => "{$c->annee} — {$c->niveau}"])->all(); }
}
