<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class PolicyInsuredLifeInformation extends Model
{
    use SoftDeletes, \App\Traits\Draftable;

    protected $guarded = [];
}
