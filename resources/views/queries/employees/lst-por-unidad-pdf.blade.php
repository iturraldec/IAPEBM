@extends('layouts.pdf')

@section('title', 'Listado de Empleados por Unidades Operativas')

@section('encabezado', 'Listado de Empleados por Unidades Operativas')

@section('content')
  <font size="2">
    <table style="width: 100%">
      <tr>
        <th>Unidad Operativa</th>
        <th>Unidad Operativa Específica</th>
        <th>Cédula</th>
        <th>Apellidos</th>
        <th>Nombres</th>
      </tr>

      <tbody>
        @foreach($empleados as $empleado)
          <tr>
            <td>{{ $empleado->unidad }}</td>
            <td>{{ $empleado->unidad_especifica }}</td>
            <td>{{ $empleado->cedula }}</td>
            <td>{{ $empleado->apellidos }}</td>
            <td>{{ $empleado->nombres }}</td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </font>
@endsection