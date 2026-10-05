<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Ceb extends Model {
    protected $guarded = [];
    public function fideles() { return $this->hasMany(Fidele::class); }
    public static function options(): array { return static::orderBy('nom')->get()->mapWithKeys(fn ($c) => [$c->id => $c->nom])->all(); }
}
