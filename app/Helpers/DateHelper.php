<?php
namespace App\Helpers;

class DateHelper
{
  //
  static function fechaCadena($fecha) {
    $date = new \DateTime($fecha);
    $dia = $date->format('d');
    $mes = $date->format('n');
    $anio = $date->format('Y');

    // Convertir el día a su representación en palabras
    $diasEnPalabras = [
        '01' => 'UNO', '02' => 'DOS', '03' => 'TRES', '04' => 'CUATRO',
        '05' => 'CINCO', '06' => 'SEIS', '07' => 'SIETE', '08' => 'OCHO',
        '09' => 'NUEVE', '10' => 'DIEZ', '11' => 'ONCE', '12' => 'DOCE',
        '13' => 'TRECE', '14' => 'CATORCE', '15' => 'QUINCE', '16' => 'DIECISEIS',
        '17' => 'DIECISIETE', '18' => 'DIECIOCHO', '19' => 'DIECINUEVE',
        '20' => 'VEINTE', '21' => 'VEINTIUNO', '22' => 'VEINTIDOS',
        '23' => 'VEINTITRES', '24' => 'VEINTICUATRO', '25' => 'VEINTICINCO',
        '26' => 'VEINTISEIS', '27' => 'VEINTISIETE', '28' => 'VEINTIOCHO',
        '29' => 'VEINTINUEVE', '30' => 'TREINTA', '31' => 'TREINTA Y UNO'
    ];

    // Convertir el mes a su representación en palabras
    $mesesEnPalabras = [
      'ENERO', 'FEBRERO', 'MARZO', 'ABRIL', 'MAYO', 'JUNIO', 
      'JULIO', 'AGOSTO', 'SEPTIEMBRE', 'OCTUBRE', 'NOVIEMBRE', 'DICIEMBRE'
    ];
    
    // Retornar la cadena formateada
    return "{$diasEnPalabras[$dia]} ({$dia}) días del mes de {$mesesEnPalabras[$mes-1]} de {$anio}";
  }
}