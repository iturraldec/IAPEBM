@extends('adminlte::page')

@section('title', 'Informes de Empleados')

@section('content_header')
  <h4>Informes de Empleados</h4>
@endsection
@section('content')
  <div class="row">
    <div class="col">
      <a href="{{ route('query.employees', ['tipo' => 1]) }}">Empleados por unidad operativa</a>
    </div>
  </div>
@endsection