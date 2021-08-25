<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WpUser extends Model
{
    use HasFactory;
    // use SoftDeletes;

    protected $primaryKey = 'ID';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'display_name',
        'user_picture_url',
        'user_email',
        'user_phone_number',
        'user_type',
        'password',
        'user_nicename',
        'user_login',
        'user_registered',
        'company_name',
        'user_status',
        'deleted_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'user_pass', 'password', 'user_activation_key', 'user_url', 'deleted_at'
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
        return url('/') .'/'. $this->attributes['user_picture_url'];
    }
}
