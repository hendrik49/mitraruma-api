<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WpProject extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'vendor_user_id',
        'description',
        'images',
        'estimated_budget',
        'customer_name',
        'customer_contact',
        'province',
        'city',
        'district',
        'sub_district',
        'zipcode',
        'street',
        'status',
        'sub_status',
    ];


    protected $casts = [
        'images' => 'array'
    ];

}
