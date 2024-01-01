<?php

namespace App\Models;

use App\Models\Branch\Branch;
use App\Models\Hr\User_edu_qualification;
use App\Models\Hr\User_image;
use App\Models\Hr\User_job_title;
use App\Models\Invoice\Invoice;
use App\Models\location\City;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;


class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'code',
        'specialty_id',
        'branch_id',
        'job_title_id',
        'user_edu_qualification_id',
        'identity_doc_number',
        'email',
        'password',
        'first_name',
        'second_name',
        'avatar',
        'birthday',
        'gendar',
        'country',
        'city',
        'address',
        'phone_number',
        'sec_phone_number',
        'marital_status',
        'military_status',
        'religion',
        'driving_license',
        'started_work',
        'deactivate',
        'note',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    /*
        -------------- Relationships --------------
     */

    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id', 'id')->withTrashed();
    }

    public function job_title()
    {
        return $this->belongsTo(User_job_title::class, 'job_title_id', 'id')->withTrashed();
    }

    public function edu_qualification()
    {
        return $this->belongsTo(User_edu_qualification::class, 'user_edu_qualification_id', 'id')->withTrashed();
    }

    public function cityuser()
    {
        return $this->belongsTo(City::class, 'city', 'id');
    }

    public function invoice()
    {
        return $this->morphOne(Invoice::class, 'receivable');
    }


    //for full name
    public function getFullnameAttribute()
    {
        return $this->first_name . " " .   $this->second_name;
    }

    // relationship image
    public function imgs()
    {
        return $this->hasMany(User_image::class, 'user_id', 'id');
    }
}
