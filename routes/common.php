<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;

Route::get('loadFromExcel', function() {
  set_time_limit(3000);
  DB::beginTransaction();
  $dataPath = '/home/iturraldec/Documentos/informatica/iapebm/';

  try {
    echo 'cargos...<br>';
    Excel::import(new App\Imports\CargosImport, $dataPath . 'cargos.csv');

    echo 'condiciones...<br>';
    Excel::import(new App\Imports\CondicionesImport, $dataPath . 'condiciones.csv');

    echo 'rangos...<br>';
    Excel::import(new App\Imports\RangosImport, $dataPath . 'rangos.csv');

    echo 'tipos...<br>';
    Excel::import(new App\Imports\TiposImport, $dataPath . 'tipos_empleados.csv');

    echo 'unidades operativas...<br>';
    Excel::import(new App\Imports\UnidadesGImport, $dataPath . 'uo_g.csv');
    Excel::import(new App\Imports\UnidadesEImport, $dataPath . 'uo_e.csv');

    echo 'cargar reposos...<br>';
    Excel::import(new App\Imports\RepososImport, $dataPath . 'codigo-ivss.csv');

    echo 'administrativos...<br>';
    Excel::import(new App\Imports\AdminImport, $dataPath . 'adm-obreros/administrativos-copia.csv');
 
    echo 'obreros...<br>';
    Excel::import(new App\Imports\ObreroImport, $dataPath . 'adm-obreros/obreros-copia.csv');

    echo 'uniformados...<br>';
    Excel::import(new App\Imports\PoliceImport, $dataPath . 'uniformados/uniformados-copia.csv');
 
    //
    DB::commit();

    getPhotos();

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

///////////////////////////////////////////////////////////////////////////////////

/*
    // cargar archivo
$archivoExcel = '/home/iturraldec/Documentos/iapebm/uniformados-fotos.xlsx';
$spreadsheet = IOFactory::load($archivoExcel);

// cargar hoja activa
$hoja = $spreadsheet->getActiveSheet();

// imágenes
$drawingCollection = $hoja->getDrawingCollection(); // Obtener la colección de dibujos

// Obtener el iterador de filas
$rowIterator = $hoja->getRowIterator();

// Recorrer las filas y obtener los datos de las columnas B y L
foreach ($rowIterator as $row) {
    $rowIndex = $row->getRowIndex(); // Obtener el índice de la fila actual
    if ($rowIndex >= 2 && $rowIndex <= 10) { // Limitar el rango de filas
        echo $hoja->getCell('B' . $rowIndex)->getValue() . '<br>';
        if ($drawingCollection) {
            foreach ($drawingCollection as $dibujo) {
                if ($dibujo instanceof Drawing && $dibujo->getCoordinates() === 'L' . $rowIndex) {
                    $imgPath = $dibujo->getPath(); // Ruta de la imagen
                    $imageContent = file_get_contents($imgPath);
                    
                    // Obtener información de la imagen
                    $imageInfo = getimagesizefromstring($imageContent);
                    if ($imageInfo !== false) {
                        $extension = image_type_to_extension($imageInfo[2]); // Obtener la extensión
                        echo "La extensión de la imagen es: " . $extension . '<br>';
                    } else {
                        echo "No se pudo determinar el tipo de imagen.<br>";
                    }

                    $imagen = '/tmp/fotos/' . uniqid() . $extension; // Usar la extensión para el nombre del archivo
                    file_put_contents($imagen, $imageContent);
                    echo "<img src='$imagen' width='200' height='auto'><br>";
                }
            }
        }
    }
}

    */