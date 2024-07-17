<?php
namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\DB;

class AdminImport implements ToCollection, WithHeadingRow
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
            $record = [
                'cedula'            => $row['cedula_id'],
                'first_name'        => substr($row['nom_ape'], 0, 50),
                'first_last_name'   => substr($row['nom_ape'], 0, 50),
                'sex'               => $row['sexo'],
                'birthday'          => date('Y-m-d', strtotime($row['fecha_nac'])),
                'place_of_birth'    => $row['lugar_nac'],
                'civil_status_id'   => $civil_status_id,
                'blood_type'        => $row['grupo_sang_usr'],
            ];

            $person_id = DB::table('people')->insertGetId($record);

            // datos de los telefonos
            if(substr($row['tlf_movil'], 0, 4) != '0000') {
                DB::table('phones')->insert([
                    'person_id'     => $person_id, 
                    'phone_type_id' => 1, 
                    'number'        => $row['tlf_movil']
                ]);
            }
            
            if(substr($row['tlf_resi'], 0, 4) != '0000') {
                DB::table('phones')->insert([
                    'person_id'     => $person_id, 
                    'phone_type_id' => 2, 
                    'number'        => $row['tlf_resi']
                ]);
            }

            // direccion
            if(substr($row['ult_direcc'], 0, 3) != 'SIN') {
                DB::table('addresses')->insert([
                    'person_id'     => $person_id,
                    'parroquia_id'  => 556,
                    'address'       => $row['ult_direcc'],
                    'zona_postal'   => $row['zona_postal_usr']
                ]);
            }

            // empleado administrativo
            $record = [
                'person_id'         => $person_id,
                'grupo_id'          => 1,
                'codigo_nomina'     => $row['codigo_inst'],
                'fecha_ingreso'     => date('Y-m-d', strtotime($row['fecha_ing'])),
                'tipo_id'           => 1,
                'rif'               => $row['rif_usr'],
                'religion'          => $row['religion_usr'],
                'deporte'           => $row['deportes_usr'],
                'licencia'          => $row['gradolicen_usr'],
            ];
            
            $empleado_id = DB::table('employees')->insertGetId($record);

            // correo electronico
            $record = [
                'person_id' => $person_id,
                'email'     => $row['correo_usr'],
            ];

            DB::table('emails')->insert($record);
        }
    }
}