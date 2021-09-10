<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory;

    protected $primaryKey = 'ID';

    protected $table = 'wp_users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'display_name',
        'user_picture_url',
        'user_email',
        'user_login',
        'user_registered',
        'user_phone_number',
        'user_type',
        'password'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'user_pass','password'
    ];


    /**
     * Get the address record associated with the user.
     */
    public function address()
    {
        return $this->belongsToMany(WpUserAddress::class, 'wp_user_addresses', 'user_id', 'ID')->withPivot('id', 'created_at', 'updated_at');

    }

    public function getUserPictureUrlAttribute()
    {
        if ($this->attributes['user_type'] == "customer" && strpos($this->attributes['user_picture_url'], "http") !== false)
            return $this->attributes['user_picture_url'];
        else if ($this->attributes['user_type'] == "admin")
            return url('/') . '/images/img-logo-mitra-ruma.jpeg';
        else if ($this->attributes['user_type'] == "vendor")
            return url('/') . '/images/img-applicator.png';
        else if ($this->attributes['user_picture_url'] != null && $this->attributes['user_type'] == "customer")
            return url('/') . '/' . $this->attributes['user_picture_url'];
        else
            return url('/') . '/images/img-customer.png';
    }

}
