<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'country_id',
        'country_code',
        'fips_code',
        'iso2',
        'latitude',
        'longitude',
        'created_at',
        'updated_at',
        'flag',
        'wikiDataId',
    ];

    public function users()
    {
        return $this->hasMany(Users::class);
    }

}
