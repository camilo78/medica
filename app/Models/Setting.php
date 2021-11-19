<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use QCod\ImageUp\HasImageUploads;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Setting extends Model
{
    use HasFactory,HasImageUploads;

    protected $fillable = [
        'name',
        'avatar',
        'address',
        'phone',
        'web',
    ];

    protected static $imageFields = [
        'avatar' => [
            'width' => 260,
            'height' => 260,
            'resize_image_quality' => 100,
            'crop' => true
        ]
    ];

      protected static $logAttributes = [
        'name',
        'image',
        'address',
        'phone',
        'web'
    ];
    protected static $logName = 'setting';
    protected static $logOnlyDirty = true;
    protected static $recordEvents = [
            'created',
        ];

    public function users()
    {
        return $this->hasMany(Users::class);
    }

}
