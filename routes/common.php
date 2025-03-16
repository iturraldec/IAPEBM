<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;

//
const ADM_OBRERO_DATA_PATH = '/home/iturraldec/Documentos/iapebm/';
const ADM_OBRERO_DATA_FILE = 'adm-obreros/202501-adm-obrero.xlsx';
const ADM_OBRERO_ROW_INIT = 2;
const ADM_OBRERO_ROW_END = 224;

//
Route::get('loadFromExcel', function() {
  set_time_limit(3000);
  DB::beginTransaction();

  try {
    echo 'cargos...<br>';
    Excel::import(new App\Imports\CargosImport, ADM_OBRERO_DATA_PATH . 'cargos.csv');

    echo 'cargar reposos...<br>';
    Excel::import(new App\Imports\RepososImport, ADM_OBRERO_DATA_PATH . 'codigo-ivss.csv');

    echo 'condiciones...<br>';
    Excel::import(new App\Imports\CondicionesImport, ADM_OBRERO_DATA_PATH . 'condiciones.csv');

    echo 'rangos...<br>';
    Excel::import(new App\Imports\RangosImport, ADM_OBRERO_DATA_PATH . 'rangos.csv');

    echo 'tipos...<br>';
    Excel::import(new App\Imports\TiposImport, ADM_OBRERO_DATA_PATH . 'tipos_empleados.csv');

    echo 'unidades operativas...<br>';
    Excel::import(new App\Imports\UnidadesGImport, ADM_OBRERO_DATA_PATH . 'uo_g.csv');
    Excel::import(new App\Imports\UnidadesEImport, ADM_OBRERO_DATA_PATH . 'uo_e.csv');
 
    echo 'administrativos/obreros...<br>';
    Excel::import(new App\Imports\AdminObrerosImport, ADM_OBRERO_DATA_PATH . ADM_OBRERO_DATA_FILE);

    /*echo 'uniformados...<br>';
    Excel::import(new App\Imports\PoliceImport, $dataPath . 'uniformados/uniformados-copia.csv'); */
 
    //
    DB::commit();

    // fotos de empleados administrativos/obreros
    getPhotosAdmObreros();

    echo 'carga de datos finalizada!';
  } 
  catch (\Exception $e) {
    DB::rollback();

    return $e->getMessage();
  }
});

//
Route::view('/', 'auth.login');
Route::post('login', [AuthController::class, 'login'])->name('login');
//

/////////////////////////////////////////////////////////////////////////////////////////////////
// cargar fotos
/////////////////////////////////////////////////////////////////////////////////////////////////

function getPhotosAdmObreros()
{
  $archivoExcel = ADM_OBRERO_DATA_PATH . ADM_OBRERO_DATA_FILE;
  $spreadsheet = IOFactory::load($archivoExcel);

  // cargar hoja activa
  $hoja = $spreadsheet->getActiveSheet();

  // coleccion de filas
  $rows = $hoja->getRowDimensions();

  // coleccion de imagenes
  $drawingCollection = $hoja->getDrawingCollection();

  // Recorrer las filas y obtener los datos de las columnas B y L
  for ($row = ADM_OBRERO_ROW_INIT; $row <= ADM_OBRERO_ROW_END; $row++) {
    // leemos la celda de la cedula
    $cedula = $hoja->getCell('B' . $row)->getValue();
    $storePath = public_path("employees/$cedula");
    $extension = 'png';

    // buscamos el empleado en la bd
    $r = DB::select("SELECT count(*) as total FROM people WHERE cedula = '$cedula';");

    // si existe el empleado, actualizamos su foto
    if ($r[0]->total == 1) {
      if ($drawingCollection) {
        foreach ($drawingCollection as $dibujo) {      
          // foto de frente
          if ($dibujo instanceof Drawing && $dibujo->getCoordinates() === 'U' . $row) {
            $xlsImagePath = $dibujo->getPath(); // Ruta de la imagen en excel
            $imageContent = file_get_contents($xlsImagePath);

            // Obtener información de la imagen   
            $imageInfo = getimagesizefromstring($imageContent);
            if ($imageInfo !== false) {
                $extension = image_type_to_extension($imageInfo[2]); // Obtener la extensión
            }

            $imagen = uniqid() . $extension;
            file_put_contents($storePath . '/' . $imagen, $imageContent);

            DB::update("update people set imagef = 'employees/$cedula/$imagen' where cedula = ?", [$cedula]);
          }

          // foto del lado izquierdo
          if ($dibujo instanceof Drawing && $dibujo->getCoordinates() === 'V' . $row) {
            $xlsImagePath = $dibujo->getPath(); // Ruta de la imagen en excel
            $imageContent = file_get_contents($xlsImagePath);

            // Obtener información de la imagen   
            $imageInfo = getimagesizefromstring($imageContent);
            if ($imageInfo !== false) {
                $extension = image_type_to_extension($imageInfo[2]); // Obtener la extensión
            }

            $imagen = uniqid() . $extension;
            file_put_contents($storePath . '/' . $imagen, $imageContent);

            DB::update("update people set imageli = 'employees/$cedula/$imagen' where cedula = ?", [$cedula]);
          }

          // foto del lado derecho
          if ($dibujo instanceof Drawing && $dibujo->getCoordinates() === 'W' . $row) {
            $xlsImagePath = $dibujo->getPath(); // Ruta de la imagen en excel
            $imageContent = file_get_contents($xlsImagePath);

            // Obtener información de la imagen   
            $imageInfo = getimagesizefromstring($imageContent);
            if ($imageInfo !== false) {
                $extension = image_type_to_extension($imageInfo[2]); // Obtener la extensión
            }

            $imagen = uniqid() . $extension;
            file_put_contents($storePath . '/' . $imagen, $imageContent);

            DB::update("update people set imageld = 'employees/$cedula/$imagen' where cedula = ?", [$cedula]);
          }
        }

        echo "foto de $cedula...actualizada...<br>";
      }
    }
  }
}


// cargar fotos
function getPhotos()
{
    $dataPath = '/home/iturraldec/Documentos/informatica/iapebm/uniformados/';
    echo 'cargando fotos de uniformados...<br>';
    
    // cargar archivo
    $archivoExcel = $dataPath . 'uniformados-fotos.xlsx';
    $spreadsheet = IOFactory::load($archivoExcel);

    // cargar hoja activa
    $hoja = $spreadsheet->getActiveSheet();

    // coleccion de filas
    $rows = $hoja->getRowDimensions();

    // coleccion de imagenes
    $drawingCollection = $hoja->getDrawingCollection();

    // Recorrer las filas y obtener los datos de las columnas B y L
    for ($row = 2; $row <= 1044; $row++) {
        // leemos la celda de la cedula
        $cedula = $hoja->getCell('B' . $row)->getValue();

        // buscamos el empleado en la bd
        $r = DB::select("SELECT count(*) as total FROM people WHERE cedula = '$cedula';");

        // si existe actualizamos su foto
        if ($r[0]->total == 1) {
            if ($drawingCollection) {
                foreach ($drawingCollection as $dibujo) {
                    if ($dibujo instanceof Drawing && $dibujo->getCoordinates() === 'L' . $row) {
                        $storePath = public_path("employees/$cedula");

                        $xlsImagePath = $dibujo->getPath(); // Ruta de la imagen en excel
                        $imageContent = file_get_contents($xlsImagePath);

                        // Obtener información de la imagen
                        $extension = 'png';
                        $imageInfo = getimagesizefromstring($imageContent);
                        if ($imageInfo !== false) {
                            $extension = image_type_to_extension($imageInfo[2]); // Obtener la extensión
                        }

                        $imagen = uniqid() . $extension;
                        file_put_contents($storePath . '/' . $imagen, $imageContent);

                        DB::update("update people set imagef = 'employees/$cedula/$imagen' where cedula = ?", [$cedula]);
                        echo "foto de $cedula...actualizada...<br>";
                    }
                }
            }
        }
    }
}
