<?php
namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use App\Models\ReciboPago;
use App\Models\EmpleadoRecibo;
use App\Clases\EmpleadoAbstract;

//
class RecibosPagosImport implements ToCollection, WithStartRow, WithChunkReading
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

    // leo el excel
    foreach ($rows as $row) {   
      $empleado = EmpleadoAbstract::GetByCedula($row[0]);

      // asignaciones
      $this->_crearRecibo($empleado->id, $recibo_enc->id, 'SUELDO BASE', $row[1], 0.00);
      $this->_crearRecibo($empleado->id, $recibo_enc->id, 'COMP. EVAL. DESEMP.', $row[2], 0.00);
      $this->_crearRecibo($empleado->id, $recibo_enc->id, 'PRIMA HOGAR', $row[3], 0.00);
      $this->_crearRecibo($empleado->id, $recibo_enc->id, 'PRIMA POR HIJOS', $row[4], 0.00);
      $this->_crearRecibo($empleado->id, $recibo_enc->id, 'PRIMA DE PROFES.', $row[5], 0.00);
      $this->_crearRecibo($empleado->id, $recibo_enc->id, 'PRIMA POR ANTIG.', $row[6], 0.00);
      $this->_crearRecibo($empleado->id, $recibo_enc->id, 'PRIMA PROT. FAM.', $row[7], 0.00);
      $this->_crearRecibo($empleado->id, $recibo_enc->id, 'PRIMA FUNC. ADM.', $row[8], 0.00);
      $this->_crearRecibo($empleado->id, $recibo_enc->id, 'PRI. JERAR. O RESP. EN EL CARGO', $row[9], 0.00);
      $this->_crearRecibo($empleado->id, $recibo_enc->id, 'BONO VACACIONAL', $row[10], 0.00);

      // deducicones

    }
  }

  //
  public function startRow(): int
  {
    return 2;
  }

  //
  public function chunkSize(): int
  {
      return 200;
  }

  //
  private function _crearRecibo(int $employee_id, int $recibo_id, string $concepto, float $asignacion, float $deduccion)
  {
    if($asignacion == 0.00 && $deduccion == 0.00) return;
    EmpleadoRecibo::create([
      'employee_id'   => $employee_id,
      'recibo_id'     => $recibo_id,
      'concepto'      => $concepto,
      'asignacion'    => $asignacion,
      'deduccion'     => $deduccion,
    ]);
  }
}