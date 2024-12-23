@extends('layouts.pdf.pdf-recibos-pago')

@section('title', 'Recibo de Pago')

@section('encabezado', "MES: $reciboPago->mes")

@section('content')  
<font size="1">
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