<?php
namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use App\Clases\EmpleadoAbstract;

//
class RecibosPagosChkImport implements ToCollection, WithHeadingRow, WithChunkReading
{
  //
  private $filas = [];

  //
  public function collection(Collection $rows)
  {
    foreach ($rows as $row) 
    {   
      $empleado = EmpleadoAbstract::GetByCedula($row['cedula']);
      if (! $empleado) $this->filas[] = $row['cedula'];
    }
  }

  //
  public function chunkSize(): int
  {
      return 200;
  }

  //
  public function getResultado() : array
  {
    return $this->filas;
  }
}

/*
<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Validator;
use Throwable;

class TuImportacion implements ToCollection, WithHeadingRow
{
    private $resultados = []; // Array para almacenar los resultados

    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            try {
                $validator = Validator::make($row->toArray(), [
                    'nombre' => 'required|string|max:255',
                    // ... otras validaciones
                ]);

                if ($validator->fails()) {
                    // Manejar errores (como antes)
                    $errores = $validator->errors()->all();
                    \Log::error("Error en la fila: " . $row->get('nombre', 'Fila sin nombre') . ". Errores: " . implode(", ", $errores));
                    continue;
                }

                // Crear el array asociativo y agregarlo a $resultados
                $this->resultados[] = [
                    'nombre' => $row['nombre'],
                    // ... otros campos que necesites
                ];

            } catch (Throwable $e) {
                \Log::error("Error al procesar fila: " . $e->getMessage());
                continue;
            }
        }
    }

    public function headingRow(): int
    {
        return 1;
    }

    // Método para obtener los resultados después de la importación
    public function obtenerResultados(): array
    {
        return $this->resultados;
    }
}

use App\Imports\TuImportacion;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;

// ... dentro de un controlador

public function importar(Request $request)
{
    $request->validate([
        'archivo' => 'required|file|mimes:xls,xlsx'
    ]);

    $importacion = new TuImportacion; // Instanciar la clase de importación

    try {
        Excel::import($importacion, $request->file('archivo'));

        $resultados = $importacion->obtenerResultados(); // Obtener los resultados

        // Ahora $resultados contiene el array de arrays asociativos
        dd($resultados); // Imprimir los resultados para verificar

        // ... hacer algo con los resultados, por ejemplo, pasarlos a una vista
        return view('vista_con_resultados', compact('resultados'));

    } catch (Throwable $e) {
        \Log::error("Error general en la importación: " . $e->getMessage());
        return redirect()->back()->with('error', 'Error en la importación. Revisa el log para más detalles.');
    }
}

*/