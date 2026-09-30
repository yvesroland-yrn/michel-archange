<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Ceb extends Model {
    protected $guarded = [];
    public function fideles() { return $this->hasMany(Fidele::class); }
}
