<?php
namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\DB;

class LocationsImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
      $municipio_id = 0;
      foreach ($rows as $row) 
      {
        if($row['type'] === 'Municipio') {
          $municipio_id = DB::table('locations')->insertGetId(['type' => 'MUNICIPIO', 'name' => strtoupper($row['name'])]);
        }
        else {
          DB::table('locations')->insert(['type' => 'PARROQUIA', 'name' => strtoupper($row['name']), 'padre_id' => $municipio_id]);
        }
      }
    }
}