<?php

namespace App\Models;

use App\Models\Station;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;

class StationImport implements ToModel
{
    use Importable;

    public function  __construct($station_region_id,$station_brand_id,$is_new_import)
    {
        $this->station_region_id = $station_region_id;
        $this->station_brand_id = $station_brand_id;
        $this->is_new_import = $is_new_import;
    }
    public function model(array $row)
    {
        if($this->is_new_import == 1){
            return new Station([
                'station_name'    => $row[0],
                'station_code'    => $row[1],
                'station_km'    => $row[2],
                'station_rate'    => $row[3],
                'station_rate_nds'    => $row[4],
                'station_region_id' => $this->station_region_id,
                'station_brand_id' => $this->station_brand_id
            ]);
        }
        else{
            $station_row = Station::where("station_id","=",$row[0])->first();
            if(@count($station_row) > 0){
                $station_row->station_name = $row[1];
                $station_row->station_code = $row[2];
                $station_row->station_km = $row[3];
                $station_row->station_rate = $row[4];
                $station_row->station_rate_nds = $row[5];
                $station_row->save();
            }
        }
    }
}
