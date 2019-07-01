<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Station extends Model
{
    protected $table = 'stations';
    protected $primaryKey = 'station_id';

    protected $fillable = ['station_id','station_name','station_code','station_km','station_region_id','station_rate','station_rate_nds','station_brand_id'];

}
