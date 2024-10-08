<?php
namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\DB;

class UnidadesGImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) 
        {   
          DB::table('unidades')->insert([
            'eje_id'    => 1,
            'code'      => $row['code'],
            'name'      => $row['name']
          ]);
        }
    }
}