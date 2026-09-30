<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Fidele extends Model {
    protected $guarded = [];
    protected $casts = ['date_naissance' => 'date', 'baptise' => 'boolean', 'confirme' => 'boolean', 'marie' => 'boolean'];
    public function ceb() { return $this->belongsTo(Ceb::class); }
    public function bapteme() { return $this->hasOne(Bapteme::class); }
    public function sacrements() { return $this->hasMany(Sacrement::class); }
    public function mouvements() { return $this->belongsToMany(Mouvement::class)->withPivot('fonction'); }
    public function getNomCompletAttribute(): string { return strtoupper($this->nom).' '.$this->prenoms; }
    public static function options(): array { return static::orderBy('nom')->get()->pluck('nom_complet', 'id')->all(); }
}
