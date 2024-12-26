@extends('layouts.pdf.pdf-recibos-pago')

@section('title', 'Recibo de Pago')

@section('encabezado', "MES DEL RECIBO DE PAGO: $reciboPago->mes")

@section('content')
<font size="1">
  <p>Cédula: {{ $empleado->person->cedula }}</p>
  <p>Apellidos y Nombres: {{ $empleado->person->first_last_name }} {{ $empleado->person->second_last_name }} {{ $empleado->person->first_name }} {{ $empleado->person->second_name }}</p>
  <p>Código: {{ $empleado->codigo_nomina }}</p>
  <p>Ingreso: {{ $empleado->fecha_ingreso }}</p>
  <table style="width: 100%" border="1">
    <tr>
      <th>CONCEPTO</th>
      <th>ASIGNACIONES</th>
      <th>DEDUCCIONES</th>
    </tr>

    <tbody>
      @foreach($data as $item)
        <tr>
          <td>{{ $item['concepto'] }}</td>
          <td>{{ $item['asignacion'] }}</td>
          <td>{{ $item['deduccion'] }}</td>
        </tr>
      @endforeach
    </tbody>
  </table>

  Asignaciones: {{ $totales['asignacion'] }} <br>
  Deducciones: {{ $totales['deduccion'] }} <br>
  Total a Pagar: {{ $totales['asignacion'] - $totales['deduccion'] }} <br>
</font>
@endsection