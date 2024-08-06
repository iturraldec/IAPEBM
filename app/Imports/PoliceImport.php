<?php
namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\DB;

class PoliceImport implements ToCollection, WithHeadingRow
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

            // datos de la persona
            $record = [
                'cedula'            => $row['cedula_id'],
                'first_name'        => substr($row['nombre_1'], 0, 50),
                'second_name'        => substr($row['nombre_2'], 0, 50),
                'first_last_name'   => substr($row['apellido_1'], 0, 50),
                'second_last_name'  => substr($row['apellido_2'], 0, 50),
                //'sex'               => $row['sex'],
                'sex'               => 'M',
                'birthday'          => date('Y-m-d', strtotime($row['fecha_nac'])),
                //'place_of_birth'    => $row['lugar_nac'],
                'place_of_birth'    => 'POR DEFINIR',
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
                    'address'       => substr($row['ult_direcc'], 0, 250),
                    'zona_postal'   => $row['zona_postal_usr']
                ]);
            }

            // empleado uniformado
            $record = [
                'person_id'         => $person_id,
                'type_id'           => 3,
                'codigo_nomina'     => $row['codigo_isnt'],
                'cargo_id'          => $row['codigo_cargo'],
                'condicion_id'      => $row['condicion_usr'],
                'unidad_id'         => 1,
                'fecha_ingreso'     => date('Y-m-d', strtotime($row['fecha_ing'])),
                'tipo_id'           => $row['cod_tipoemp'],
                'rif'               => $row['rif_usr'],
                'religion'          => $row['religion_usr'],
                'deporte'           => $row['deportes_usr'],
                'licencia'          => $row['licen_usr'],
                'codigo_patria'     => 'NO DEFINIDO',
                'serial_patria'     => 'NO DEFINIDO',
                'religion'          => 'NO DEFINIDO',
                'deporte'           => 'NO DEFINIDO',
                'licencia'          => $row['licen_usr'],
                'cta_bancaria_nro'  => 'NO DEFINIDO',
            ];
            
            $empleado_id = DB::table('employees')->insertGetId($record);

            // empleado uniformado
            $record = [
              'employee_id'         => $empleado_id,
              'escuela'             => $row['escuela_usr'],
              'fecha_graduacion'    => date('Y-m-d', strtotime($row['fecha_grad_usr'])),
              'curso'               => $row['curso_usr'],
              'curso_duracion'      => 'NO DEFINIDO',
              'cup'                 => 'N/D',
            ];

            $empleado_id = DB::table('police')->insertGetId($record);

            // correo electronico
            $record = [
                'person_id' => $person_id,
                'email'     => $row['correo_usr'],
            ];

            DB::table('emails')->insert($record);
        }
    }
}