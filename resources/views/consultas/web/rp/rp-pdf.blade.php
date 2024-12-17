@extends('layouts.pdf.pdf-recibos-pago')

@section('title', 'Recibo de Pago')

@section('encabezado', "MES: $mes")

@section('content')  
<font size="1">
  <table style="width: 100%" border="1">
    <tr>
      <th>CONCEPTOS</th>
      <th>INGRESOS</th>
      <th>EGRESOS</th>
    </tr>

    <tbody>
      @foreach($data as $item)
        <tr>
          <td>{{ $item['concepto'] }}</td>
          <td>{{ ($item['ingreso'] > 0) ? $item['ingreso'] : '' }}</td>
          <td>{{ ($item['egreso'] > 0) ? $item['egreso'] : '' }}</td>
        </tr>
      @endforeach
    </tbody>
  </table>
</font>
@endsection