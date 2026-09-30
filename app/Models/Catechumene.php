<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Catechumene extends Model {
    protected $guarded = [];
    public function fidele() { return $this->belongsTo(Fidele::class); }
    public function classe() { return $this->belongsTo(ClasseCate::class, 'classe_cate_id'); }
}
