<?php
namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\DB;

class UbicacionesEImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) 
        {   
          DB::table('ccps_e')->insert([
            'ccp_id'    => $row['ccp_id'],
            'code'      => $row['code'],
            'name'      => $row['name'],
            'latitude'  => $row['latitude'],
            'length'    => $row['length'],
          ]);
        }
    }
}