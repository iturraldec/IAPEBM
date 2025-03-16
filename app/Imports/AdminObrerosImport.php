<?php
namespace App\Imports;

use Illuminate\Support\Facades\DB;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithStartRow;

use function PHPSTORM_META\type;

//
class AdminObrerosImport implements ToCollection, WithStartRow
{
  public function collection(Collection $rows)
  {
    foreach ($rows as $row) {
      if(trim($row[1] == '')) continue;

      //////////////////////////////////
      // datos personales
      //////////////////////////////////

      // nombres
      $nombre = explode(' ', $row[2]);
      $first_name = $nombre[0];
      $second_name = null;
      $second_last_name = null;
      switch (count($nombre)) {
        case 2:
          $first_last_name = $nombre[1];
          break;
        case 3:
          $second_name = $nombre[1];
          $first_last_name = $nombre[2];
          break;
        default:
          $second_name = $nombre[1];
          $first_last_name = $nombre[2];
          $second_last_name = $nombre[3];
          break;
      };

      // estado civil
      $civil_status_id = null;
      $civil_status = trim($row[8]);
      if(str_contains($civil_status, 'SOLTERO')) $civil_status_id = 1;
      else if(str_contains($civil_status, 'CASADO')) $civil_status_id = 2;
      else if(str_contains($civil_status, 'DIVORSIADO')) $civil_status_id = 3;
      else if(str_contains($civil_status, 'VIUDO')) $civil_status_id = 4;
      else if(str_contains($civil_status, 'UNION')) $civil_status_id = 5;
      else $civil_status_id = 1;

      // ingreso sus datos a la tabla 'people'
      $record = [
        'cedula'            => $row[1],
        'first_name'        => $first_name,
        'second_name'       => $second_name,
        'first_last_name'   => $first_last_name,
        'second_last_name'  => $second_last_name,
        'sex'               => $row[3],
        'birthday'          => date('Y-m-d', ($row[9] - 25569) * 86400),
        'civil_status_id'   => $civil_status_id,
        'blood_type'        => $row[7],
      ];

      $person_id = DB::table('people')->insertGetId($record);

      // creo su carpeta de documentos
      $path = storage_path("app/public/employees/{$row[1]}/");
      mkdir($path);

      // telefonos
      $temporal = explode('/', $row[21]);
      foreach($temporal as $key => $value) {
        DB::table('phones')->insert([
          'person_id'     => $person_id, 
          'phone_type_id' => 2, 
          'number'        => trim($value)
      ]);
      }

      // direccion
      if(trim($row[11]) != '') {
          DB::table('addresses')->insert([
            'person_id'     => $person_id,
            'parroquia_id'  => 556,
            'address'       => trim($row[11]),
          ]);
      }
      
      // creo su usuario web
      $user = User::create([
          'code'      => $row[1],
          'name'      => $first_name.' '.$first_last_name,
          //'email'     => $row['correo_usr'],
          'password'  => Hash::make(config('app_config.users_init_password')),
      ]);

      $user->assignRole('Usuario Web');

      // correo electronico
      if(trim($row[18]) != '') {
        $record = [
          'person_id' => $person_id,
          'email'     => trim($row[18]),
        ];

        DB::table('emails')->insert($record);
      }

      // busco su unidad operativa
      /* $unidad = DB::select("SELECT id FROM unidades WHERE code = '{$row[6]}';");
      $unidad_id = (empty($unidad)) ? 134 : $unidad[0]->id;
 */
      // empleado
      $record = [
          'person_id'         => $person_id,
          'type_id'           => (str_contains($row[5], 'OBRERO')) ? 2 : 1,
          'codigo_nomina'     => $row[0],
          'cargo_id'          => 1,
          'condicion_id'      => 1, // ACTIVO
          'unidad_id'         => 1,
          'fecha_ingreso'     => date('Y-m-d', ($row[6] - 25569) * 86400),
          'tipo_id'           => (str_contains($row[5], 'OBRERO')) ? 4 : 3,
          'fisio_contextura'  => $row[17],
          'fisio_calzado'     => $row[16],
          'fisio_camisa'      => $row[14],
          'fisio_pantalon'    => $row[15],
      ];
      
      $empleado_id = DB::table('employees')->insertGetId($record);      
    }
  }

  public function startRow(): int
  {
      return 2;
  }
}