<?php
namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use App\Models\ReciboPago;
use App\Models\EmpleadoRecibo;
use App\Clases\EmpleadoAbstract;

//
class RecibosPagosImport implements ToCollection, WithHeadingRow, WithChunkReading
{
  //
  private $_mes;

  //
  private $_desde;

  //
  private $_hasta;
  
  //
  public function __construct($mes, $desde, $hasta)
  {
    $this->_mes = $mes;
    $this->_desde = $desde;
    $this->_hasta = $hasta;
  }

  //
  public function collection(Collection $rows)
  {
    // creo el encabezado
    $recibo_enc = ReciboPago::create([
        'mes'   => $this->_mes,
        'desde' => $this->_desde,
        'hasta' => $this->_hasta,
    ]);

    // creo los items
    $empleado = null;
    $cedula = '';
    foreach ($rows as $row) 
    {   
      if($cedula != $row['cedula']) {
        $empleado = EmpleadoAbstract::GetByCedula($row['cedula']);
        $cedula = $row['cedula'];
      }

      EmpleadoRecibo::create([
          'employee_id'   => $empleado->id,
          'recibo_id'     => $recibo_enc->id,
          'asignacion'    => $row['asignaciones'],
          'deduccion'     => $row['deducciones'],
      ]);
    
    }
  }

  //
  public function chunkSize(): int
  {
      return 200;
  }
}