<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
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
        'user_registered',
        'user_phone_number',
        'user_type',
        'user_pass'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'user_pass',
    ];


    /**
     * Get the address record associated with the user.
     */
    public function address()
    {
        return $this->belongsToMany(WpUserAddress::class, 'wp_user_addresses', 'user_id', 'ID')->withPivot('id', 'created_at', 'updated_at');

    }

}
