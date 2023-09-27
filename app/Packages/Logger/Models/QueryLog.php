<?php

namespace App\Packages\Logger\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QueryLog extends Model
{
    use HasFactory;

    protected $fillable = ['entity_method_id', 'time_exec', 'data'];

    public function entityMethod()
    {
        return $this->belongsTo(EntityMethod::class);
    }
}
