@extends('layouts.pdf.pdf-recibos-pago')

@section('title', 'Recibo de Pago')

{{-- @section('encabezado', "MES DEL RECIBO DE PAGO: $reciboPago->mes") --}}
@section('encabezado', 'Departamento de Nómina')

@section('content')
<font size="1">
  <table style="width: 100%" border="1">
    <tr>
      <th>NÓMINA: {{ $empleado->condicion->name }}</th>
      <th>PERIODO: {{ $reciboPago->desde }} / {{ $reciboPago->hasta }}</th>
    </tr>

    <tr>
      <th>TRABAJADOR: {{ $empleado->codigo_nomina }} {{ $empleado->person->first_last_name }} {{ $empleado->person->second_last_name }} {{ $empleado->person->first_name }} {{ $empleado->person->second_name }}</th>
      <th>FECHA DE INGRESO: {{ $empleado->fecha_ingreso }}</th>
    </tr>

    <tr>
      <th>CÉDULA: {{ $empleado->person->cedula }}</th>
      <th>CARGO: {{ $empleado->cargo->name }}</th>
    </tr>
  </table>

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