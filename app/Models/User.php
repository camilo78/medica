<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use QCod\ImageUp\HasImageUploads;
use Spatie\Permission\Traits\HasRoles;
use App\Models\City;
use App\Models\State;
use App\Models\Country;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;


class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles, HasImageUploads, LogsActivity,SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name1',
        'name2',
        'surname1',
        'surname2',
        'avatar',
        'phone1',
        'address',
        'country_id',
        'state_id',
        'city_id',
        'email',
        'password',
        'setting_id',
    ];

    protected $dates = ['deleted_at'];

    protected static $imageFields = [
        'avatar' => [
            'placeholder' => 'https://api.adorable.io/avatars/160',
            'width' => 260,
            'height' => 260,
            'resize_image_quality' => 100,
            'crop' => true
        ]
    ];

    protected static $logAttributes = [
        'name1',
        'name2',
        'surname1',
        'surname2',
        'avatar',
        'phone1',
        'address',
        'country_id',
        'state_id',
        'city_id',
        'email',
    ];
    protected static $logName = 'user';
    protected static $logOnlyDirty = true;
    protected static $recordEvents = ['deleted','created','updated'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function city()
    {
        return $this->belongsTo(city::class);
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function state()
    {
        return $this->belongsTo(State::class);
    }
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public  function scopeLike($query,$value){
        return $query->where('name1', 'like', "%" . $value . "%")
            ->orWhere('surname1', 'like', "%" . $value . "%")
            ->orWhere('name2', 'like', "%" . $value . "%")
            ->orWhere('surname2', 'like', "%" . $value . "%");

    }
}
