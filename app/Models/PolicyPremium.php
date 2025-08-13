<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class PolicyPremium extends Model
{
    use SoftDeletes, \App\Traits\Draftable;

    protected $table = 'policy_premiums';

    protected $guarded = [];
}
