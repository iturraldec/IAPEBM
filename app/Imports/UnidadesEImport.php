<?php
namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\DB;

class UnidadesEImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) 
        {   
          DB::table('unidades')->insert([
            'padre_id'  => $row['padre_id'],
            'code'      => $row['code'],
            'name'      => $row['name'],
            'latitude'  => $row['latitude'],
            'length'    => $row['length'],
          ]);
        }
    }
}