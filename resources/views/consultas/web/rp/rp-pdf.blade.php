@extends('layouts.pdf.pdf-recibos-pago')

@section('title', 'Recibo de Pago')

{{-- @section('encabezado', "MES DEL RECIBO DE PAGO: $reciboPago->mes") --}}
@section('encabezado', 'Departamento de Nómina')

@section('content')
<font size="1">
  <table style="width: 100%" border="1">
    <tr>
      <td><b>NÓMINA</b></td>
      <td>{{ $empleado->condicion->name }}</td>
      <td><b>PERIODO</b></td>
      <td>{{ $reciboPago->desde }} / {{ $reciboPago->hasta }}</td>
    </tr>

    <tr>
      <td><b>TRABAJADOR</b></td>
      <td>({{ $empleado->codigo_nomina }}) {{ $empleado->person->first_last_name }} {{ $empleado->person->second_last_name }} {{ $empleado->person->first_name }} {{ $empleado->person->second_name }}</td>
      <td><b>FECHA DE INGRESO</b></td>
      <td>{{ $empleado->fecha_ingreso }}</td>
    </tr>

    <tr>
      <td><b>CÉDULA</b></td>
      <td>{{ $empleado->person->cedula }}</td>
      <td><b>CARGO</b></td>
      <td>{{ $empleado->cargo->name }}</td>
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