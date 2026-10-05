<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Mouvement extends Model {
    protected $guarded = [];
    protected $casts = ['date_creation' => 'date'];
    public function membres() { return $this->belongsToMany(Fidele::class)->withPivot('fonction')->orderBy('nom'); }
    public static function options(): array { return static::orderBy('nom')->get()->mapWithKeys(fn ($m) => [$m->id => $m->nom])->all(); }
}
