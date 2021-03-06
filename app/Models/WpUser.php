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
    const TYPE_CUSTOMER = "customer";
    const TYPE_VENDOR = "vendor";
    const TYPE_ADMIN = "admin";

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
        'deleted_at',
        'npwp',
        'nik',
        'file_npwp',
        'file_nik',
        'file_bank',
        'bank',
        'bank_account',
        'portfolio',
        'portfolio_link',
        'capacity',
        'ID'
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

    public function extension()
    {
        return $this->hasMany(WpUserExtensionAttribute::class, 'user_id');        
    }

    public function projects()
    {
        return $this->hasMany(WpProject::class, 'vendor_user_id');        
    }

    public function review()
    {
        return $this->hasOne(WpVendorExtensionAttribute::class,'user_id');        
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

    public function getFileNikAttribute()
    {
        return url('/') . '/storage/' . $this->attributes['file_nik'];
    }

    public function getFileNpwpAttribute()
    {
        return url('/') . '/storage/' . $this->attributes['file_npwp'];
    }

    public function getFileBankAttribute()
    {
        return url('/') . '/storage/' . $this->attributes['file_bank'];
    }

    public function getPortfolioAttribute()
    {
        return url('/') . '/storage/' . $this->attributes['portfolio'];
    }
    
}
