<?php
namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\DB;

class DemoImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) 
        {   
            //
            $civil_status_id = null;
            $civil_status = $row['est_civil_usr'];
            if(strpos($civil_status, 'Soltero') !== false) $civil_status_id = 1;
            else if(strpos($civil_status, 'Casado') !== false) $civil_status_id = 2;
            else if(strpos($civil_status, 'Divorsiado') !== false) $civil_status_id = 3;
            else if(strpos($civil_status, 'Viudo') !== false) $civil_status_id = 4;
            else if(strpos($civil_status, 'Union') !== false) $civil_status_id = 5;

            //
            $blood_type_id = DB::table('blood_types')->where('name', $row['grupo_sang_usr'])->value('id');

            //
            $record = [
                'cedula' => $row['cedula_id'],
                'name' => $row['nom_ape'],
                'sex' => $row['sexo'],
                'birthday' => date('Y-m-d', strtotime($row['fecha_nac'])),
                'place_of_birth' => $row['lugar_nac'],
                'email' => $row['correo_usr'],
                'civil_status_id' => $civil_status_id,
                'blood_type_id' => $blood_type_id,
            ];
            
            // people
            $person_id = DB::table('people')->insertGetId($record);

            // phones
            if(substr($row['tlf_movil'], 0, 4) != '0000') {
                DB::table('phones')->insert([
                    'person_id' => $person_id, 
                    'phone_type_id' => 1, 
                    'number' => $row['tlf_movil']
                ]);
            }
            
            if(substr($row['tlf_resi'], 0, 4) != '0000') {
                DB::table('phones')->insert([
                    'person_id' => $person_id, 
                    'phone_type_id' => 2, 
                    'number' => $row['tlf_resi']
                ]);
            }

            // direccion
            if(substr($row['ult_direcc'], 0, 3) != 'SIN') {
                DB::table('addresses')->insert([
                    'person_id' => $person_id, 
                    'address_type_id' => 1, 
                    'address' => $row['ult_direcc']
                ]);
            }

            echo "$person_id<br>";
        }
    }
}