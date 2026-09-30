<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Bapteme extends Model {
    protected $guarded = [];
    protected $casts = ['date_bapteme' => 'date'];
    public function fidele() { return $this->belongsTo(Fidele::class); }
    public static function prochainNumero(): string {
        $an = now()->year; return sprintf('B-%d-%04d', $an, static::whereYear('created_at', $an)->count() + 1);
    }
}
