<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Mouvement extends Model {
    protected $guarded = [];
    protected $casts = ['date_creation' => 'date'];
    public function membres() { return $this->belongsToMany(Fidele::class)->withPivot('fonction')->orderBy('nom'); }
}
