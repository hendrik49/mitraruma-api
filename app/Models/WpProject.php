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
        'amount_spk_customer',
        'amount_spk_vendor',
        'amount_spk_vendor_net',
        'mitraruma_discount',
        'applicator_discount',
        'commision',
        'other_expanse',
        'total_expanse',
        'expanse_note',
        'project_note',
        'material_buy',
        'booking_fee',
        'term_payment_vendor',
        'term_payment_customer',
    
        'termin_customer_1',
        'termin_customer_2',
        'termin_customer_3',
        'termin_customer_4',
        'termin_customer_5',
        'termin_customer_1_date',
        'termin_customer_2_date',
        'termin_customer_3_date',
        'termin_customer_4_date',
        'termin_customer_5_date',

        'termin_vendor_1',
        'termin_vendor_2',
        'termin_vendor_3',
        'termin_vendor_4',
        'termin_vendor_5',
        'termin_vendor_1_date',
        'termin_vendor_2_date',
        'termin_vendor_3_date',
        'termin_vendor_4_date',
        'termin_vendor_5_date',
        'payment_retention_date',
        'service_type',
        'admin_user_id',
        'vendor_user_id',
        'user_id',
        'order_number',
        'room_id',
        'consultation_id',
        'street',
        'description',
        'status',
        'sub_status',
        'customer_name',        
        'customer_contact',        
        'vendor_name',        
        'admin_name',        
        'vendor_contact',        
        'estimated_budget',
        'room_number',
        'project_value'        
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
