@extends('layouts.pdf')

@section('title')
  Datos de: {{ $data->name }}
@endsection

@section('content')
  VISTA DEL EMPLEADO<br>
  Nombre: {{ $data->name }}<br>
  Cédula: {{ $data->cedula }}<br>
  Sexo: {{ $data->sex }}<br>
  Fecha de Nacimiento: {{ $data->birthday }}<br>
  Lugar de Nacimiento: {{ $data->place_of_birth }}<br>
  Correo Electrónico: {{ $data->email }}<br>
  Estado Civil: {{ $data->civil_status->name }}<br>
  Grupo Sanguineo: {{ $data->blood_type->name }}<br>
  Observaciones: {{ $data->notes }}<br>
  Telefono (s):
  @foreach($data->phones as $phone)
    {{ $phone->number }}<br>
  @endforeach
@endsection