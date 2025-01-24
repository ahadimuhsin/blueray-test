<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Order extends Model
{
    protected $guarded = [];

    public function creator() :BelongsTo
    {
        return $this->belongsTo(User::class, "creator_id");
    }
}
