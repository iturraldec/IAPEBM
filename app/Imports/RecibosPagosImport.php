<?php
namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\DB;

class RecibosPagosImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) 
        {   
          //DB::table('tipos')->insert(['name' => $row['name']]);
          echo "cedula: {$row['cedula']};concepto: {$row['conceptos']}; ingresos: {$row['ingresos']}<br>";
        }
    }
}