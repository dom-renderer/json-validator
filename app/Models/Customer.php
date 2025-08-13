<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;
use App\Traits\Draftable;

class Customer extends Model
{
    use SoftDeletes, HasRoles, Draftable;

    protected $guarded = [];

    protected $fillable = [
        'type', 'name', 'email', 
        'dial_code', 'phone_number', 'gender', 'dob', 'place_of_birth',
        'address_line_1', 'address_line_2', 'country_id', 'state_id', 
        'city_id', 'zipcode', 'status', 'status_name'
    ];

    protected $casts = [
        'dob' => 'date',
    ];

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function state()
    {
        return $this->belongsTo(State::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function getFullNameAttribute()
    {
        return $this->name;
    }

    public function getFullPhoneAttribute()
    {
        return '+' . $this->dial_code . ' ' . $this->phone_number;
    }

    public function getUserProfileAttribute() {
        if (!empty(trim($this->profile)) && file_exists(public_path("storage/customers/profile/{$this->profile}"))) {
            return asset("storage/customers/profile/{$this->profile}");
        }

        return asset('assets/images/profile.png');
    }
}
