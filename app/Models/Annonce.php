<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Annonce extends Model {
    protected $guarded = [];
    protected $casts = ['publie_le' => 'date', 'expire_le' => 'date', 'avec_image' => 'boolean'];
    public function scopeActives($q) { return $q->where('publie_le', '<=', now()->toDateString())->where(fn ($w) => $w->whereNull('expire_le')->orWhere('expire_le', '>=', now()->toDateString())); }
    public function scopeAvecImages($q) { return $q->where('avec_image', true)->whereNotNull('image'); }
    public function scopeSansImages($q) { return $q->where(function($q) { return $q->where('avec_image', false)->orWhereNull('image'); }); }
}
