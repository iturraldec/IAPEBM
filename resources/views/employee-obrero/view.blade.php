@extends('layouts.pdf')

@section('title')
  Datos personales de: {{ $data->name }}
@endsection

@section('content')
  <table class="table table-bordered table-sm" style="font-size: 24px">
    <tbody>
      <tr>
        <td>
          1.1. Nombres y Apellidos<br>
          1.2. Partida de Nacimiento (anexo)
        </td>
        <td class="h6">{{ $data->name }}</td>
        <td class="text-center">
            <img src="{{ asset($data->image) }}" 
                class="img-thumbnail border border-dark"
                width="150" 
                height="auto"
            >
        </td>
      </tr>
      <tr>
        <td>
          Cédula de Identidad
          <div>{{ $data->cedula }}</div>
        </td>
        <td>
          Lugar de Nacimiento
          <div>{{ $data->place_of_birth }}</div>
        </td>
      </tr>
    </tbody>
  </table>

  Cédula: {{ $data->cedula }}<br>
  Sexo: {{ $data->sex }}<br>
  Fecha de Nacimiento: {{ $data->birthday }}<br>
  Lugar de Nacimiento: {{ $data->place_of_birth }}<br>
  Correo Electrónico: {{ $data->email }}<br>
  Estado Civil: {{ $data->civil_status->name ?? 'NO DEFINIDO' }}<br>
  Grupo Sanguineo: {{ $data->blood_type->name }}<br>
  Observaciones: {{ $data->notes }}<br>
  Telefono (s):
  @foreach($data->phones as $phone)
    {{ $phone->number }}<br>
  @endforeach
@endsection