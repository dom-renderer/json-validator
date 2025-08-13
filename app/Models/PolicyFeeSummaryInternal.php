<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class PolicyFeeSummaryInternal extends Model
{
    use SoftDeletes, \App\Traits\Draftable;

    protected $guarded = [];

    public function items() {
        return $this->hasMany(PolicyFeeSummaryInternalFee::class);
    }
}
