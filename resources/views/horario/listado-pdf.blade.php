@extends('layouts.pdf.pdf-listados')

@section('title', 'Listado de Empleados')

@section('encabezado', 'Listado de Entradas/Salidas de Empleados')

@section('content')
  <font size="1">
    <table style="width: 100%" border="1">
      <tr>
        <th>Nro.</th>
        <th>Ubicación</th>
        <th>Apellidos y Nombres</th>
        <th>Entrada</th>
        <th>Salida</th>
      </tr>

      <tbody>
        @foreach($listado as $index => $item)
          <tr>
            <td>{{ $index + 1 }}</td>
            <td>{{ $item->unidad }}</td>
            <td>{{ $item->first_last_name }} {{ $item->second_last_name }}, {{ $item->first_name }} {{ $item->second_name }}</td>
            <td>{{ $item->entrada }}</td>
            <td>{{ $item->salida }}</td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </font>
@endsection