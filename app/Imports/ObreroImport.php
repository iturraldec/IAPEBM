<?php
namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\DB;

/*
    MODIFICACIONES AL ARCHIVO 'administrativos-cops.csv'

    1. reemplazo de caracter especial por 'Ñ'
    2. reemplazo de los tipos sanguineos por: 'A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'
    3. aceptar 'cod_tipoemp': 3, 7, 10
    4. eliminar columna 'zona_postal_usr
    5. eliminar columna 'cod_car_pol'
    6. eliminar columna 'cod_car_patr'
    7. eliminar columna 'gradolicen_usr'
    8. eliminar columna 'ausente'
    9. eliminar columnas de los datos fisicos
*/

//
class ObreroImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        $administrativos = [3, 7, 10];
        foreach ($rows as $row) {
            if (array_search($row['cod_tipoemp'], $administrativos)) {
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

                // creo su carpeta de documentos
                $path = storage_path("app/public/employees/{$row['cedula_id']}/");
                mkdir($path);

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
                    ]);
                }

                // busco su unidad operativa
                $unidad = DB::select("SELECT id FROM unidades WHERE code = '{$row['codigo_ub']}';");
                $unidad_id = (empty($unidad)) ? 1 : $unidad[0]->id;

                // empleado obrero
                $record = [
                    'person_id'         => $person_id,
                    'type_id'           => 2,
                    'codigo_nomina'     => $row['codigo_isnt'],
                    'cargo_id'          => $row['codigo_cargo'],
                    'condicion_id'      => $row['condicion_usr'],
                    'unidad_id'         => $unidad_id,
                    'fecha_ingreso'     => date('Y-m-d', strtotime($row['fecha_ing'])),
                    'tipo_id'           => $row['cod_tipoemp'],
                    'rif'               => $row['rif_usr'],
                    'religion'          => $row['religion_usr'],
                    'deporte'           => $row['deportes_usr'],
                    'licencia'          => $row['licen_usr'],
                    'codigo_patria'     => 'NO DEFINIDO',
                    'serial_patria'     => 'NO DEFINIDO',
                    'cta_bancaria_nro'  => 'NO DEFINIDO',
                ];
                
                $empleado_id = DB::table('employees')->insertGetId($record);

                // correo electronico
                $record = [
                    'person_id' => $person_id,
                    'email'     => $row['correo_usr'],
                ];

                DB::table('emails')->insert($record);

                // datos fisionomicos
                $fisionomia = DB::select('SELECT * FROM fisionomia;');
                foreach($fisionomia as $item) {
                    $record = [
                        'employee_id'   => $empleado_id,
                        'fisionomia_id' => $item->id,
                    ];
                    switch($item->id) {
                        case 1 : $record['info'] = $row['estatura_usr'];
                                 break;
                        case 2 : $record['info'] = $row['color_tez_usr'];
                                break;
                        case 3 : $record['info'] = $row['cabello_usr'];
                                break;
                        case 4 : $record['info'] = $row['cara_usr'];
                                break;
                        case 5 : $record['info'] = $row['frente_usr'];
                                break;
                        case 6 : $record['info'] = $row['cejas_usr'];
                                break;
                        case 7 : $record['info'] = $row['ojos_usr'];
                                 break;
                        case 8 : $record['info'] = $row['nariz_usr'];
                                 break;
                        case 9 : $record['info'] = $row['boca_usr'];
                                 break;
                        case 10 : $record['info'] = $row['labios_usr'];
                                 break;
                        case 11 : $record['info'] = $row['barba_usr'];
                                 break;
                        case 12 : $record['info'] = $row['bigote_usr'];
                                 break;
                        case 13 : $record['info'] = $row['contextura_usr'];
                                 break;
                        case 14 : $record['info'] = $row['dentadura_usr'];
                                 break;
                        case 15 : $record['info'] = $row['peso_usr'];
                                 break;
                        case 16 : $record['info'] = $row['senales_part_usr'];
                                 break;
                        case 17 : $record['info'] = $row['lentes_usr'];
                                 break;
                        case 18 : $record['info'] = $row['talla_camisa_usr'];
                                 break;
                        case 19 : $record['info'] = $row['talla_pantalon_usr'];
                                 break;
                        case 20 : $record['info'] = $row['talla_calzado_usr'];
                                 break;
                        case 21 : $record['info'] = $row['talla_gorra_usr'];
                                 break;
                        default: $record['info'] = '?';
                                 break;
                    }

                    DB::table('empleado_fisionomia')->insert($record);
                }
            }
        }
    }
}