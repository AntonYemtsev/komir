<?php

namespace App\Models;

use App\Models\Station;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class StationExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Station::select("station_id","station_name","station_code","station_km","station_rate","station_rate_nds")->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Станция назначения',
            'Код станции',
            'Расстояние, км',
            'Тариф на 1 тонну, без НДС',
            'Тариф на 1 тонну, с НДС'
        ];
    }

}
