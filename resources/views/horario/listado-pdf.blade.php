@extends('layouts.pdf.pdf-listados')

@section('title', 'Listado de Empleados')

@section('encabezado', "Listado de Entradas/Salidas de Empleados del $fecha")

@section('content')
  <font size="1">
    <table style="width: 100%" border="1">
      <tr>
        <th width="5%">Nro.</th>
        <th width="20%">Ubicación</th>
        <th width="5%">Cédula</th>
        <th width="40%">Apellidos y Nombres</th>
        <th>Entrada</th>
        <th>Salida</th>
        <th>Observaciones</th>
      </tr>

      <tbody>
        @foreach($listado as $index => $item)
          <tr>
            <td>{{ $index + 1 }}</td>
            <td>{{ $item->unidad }}</td>
            <td>{{ $item->cedula }}</td>
            <td>{{ $item->first_last_name }} {{ $item->second_last_name }}, {{ $item->first_name }} {{ $item->second_name }}</td>
            <td>{{ $item->entrada }}</td>
            <td>{{ $item->salida }}</td>
            <td>
              @php
                if(! empty($item->observacion)) {
                  echo $item->observacion;  
                }
                else {
                  if(! empty($item->entrada) && ! empty($item->salida)) {
                    $entrada = new DateTime($item->entrada);
                    $salida = new DateTime($item->salida);
                    $interval = $entrada->diff($salida);
                    echo $interval->format('Tiempo: %H horas y %i minutos.');
                  }
                }
              @endphp
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </font>
@endsection