@extends('layouts.pdf.pdf')

@section('title', 'Listado de Empleados por Unidades Operativas')

@section('encabezado', 'Listado de Empleados por Unidades Operativas')

@section('content')
  <font size="1">
    <table style="width: 100%" border="1">
      <tr>
        <th>Unidad Operativa</th>
        <th>Unidad Operativa Específica</th>
        <th>Cédula</th>
        <th>Apellidos</th>
        <th>Nombres</th>
        <th>Imagen</th>
      </tr>

      <tbody>
        @foreach($empleados as $empleado)
          <tr>
            <td>{{ $empleado->unidad }}</td>
            <td>{{ $empleado->unidad_especifica }}</td>
            <td>{{ $empleado->cedula }}</td>
            <td>{{ $empleado->apellidos }}</td>
            <td>{{ $empleado->nombres }}</td>
            <td><img src="{{ public_path($empleado->imagef) }}" width="120" height="auto"></td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </font>
@endsection