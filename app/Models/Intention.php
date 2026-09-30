<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Intention extends Model {
    protected $guarded = [];
    protected $casts = ['date_messe' => 'date'];
    public function evenement() { return $this->belongsTo(Evenement::class); }
    public static function prochainRecu(): string { return sprintf('I-%d-%05d', now()->year, static::whereYear('created_at', now()->year)->count() + 1); }
}
