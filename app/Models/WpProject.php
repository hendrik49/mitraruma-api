<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WpProject extends Model
{
    use HasFactory;

    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [        
        'amount_spk_customer_gross',
        'amount_spk_customer',
        'amount_spk_vendor',
        'discount',
        'commision',
        'termin_customer_1',
        'termin_customer_2',
        'termin_customer_3',
        'termin_customer_4',
        'termin_customer_5',
        'termin_customer_1',
        'termin_customer_2',
        'termin_customer_3',
        'termin_customer_4',
        'termin_customer_5'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'deleted_at',
    ];
}
