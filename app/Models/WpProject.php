<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Helpers\OrderStatus;

class WpProject extends Model
{

    use HasFactory;

    use SoftDeletes;
    const Pre_Purchase ="Pre-Purchase";
    const Design_Phase ="Design Phase";
    const Construction_Phase ="Construction_Phase";
    const Project_Started ="Project Started";
    const Project_Ended ="Project Ended";
    const Delay ="Delay";
    const Complaint ="Complaint";
    
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
        'images',
        'room_id',
        'consultation_id',
        'street',
        'description',
        'status',
        'sub_status',
        'customer_name',
        'customer_contact',
        'customer_email',
        'vendor_name',
        'admin_name',
        'vendor_email',
        'admin_email',
        'vendor_contact',
        'estimated_budget',
        'room_number',
        'project_value',
        'rating_vendor',
        'rating_customer',
        'rating_admin',
        'room_type',
        'uniq_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'deleted_at',
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
        'payment_retention_date'
    ];

    protected $appends = ['progress'];


    public function getProgressAttribute()
    {
        if ($this->attributes['status'] == "Pre-Purchase" || $this->attributes['status'] == "pre-purchase")
            return 20;
        else if ($this->attributes['status'] == "Design Phase")
            return 40;
        else if ($this->attributes['status'] == "Consturction Phase")
            return 60;
        else if ($this->attributes['status'] == "Project Started")
            return 80;
        else
            return 100;
    }

    public function getProjectNoteAttribute()
    {
        $os = new OrderStatus;
        $result = $os->getActivityByCode($this->attributes['sub_status']);
        return $result;
    }

    public function customer()
    {
        return $this->belongsTo(WpUser::class,'user_id');        
    }

    public function vendor()
    {
        return $this->belongsTo(WpUser::class,'vendor_user_id');        
    }
}
