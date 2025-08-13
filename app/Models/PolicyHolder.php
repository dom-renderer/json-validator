<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class PolicyHolder extends Model
{
    use SoftDeletes, \App\Traits\Draftable;

    protected $guarded = [];

    public function holder() {
        return $this->belongsTo(Customer::class, 'holder_id');
    }
}
