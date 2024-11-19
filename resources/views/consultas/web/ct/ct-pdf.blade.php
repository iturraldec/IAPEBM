@extends('layouts.pdf.pdf-documento')

@section('title', 'Constancia Laboral')

@section('encabezado', 'HACE CONSTAR')

@section('content')  
  Por medio de la presente que el(la) ciudadano(a): <b>{{ $empleado->person->first_last_name }} {{ $empleado->person->second_last_name }} 
  {{ $empleado->person->first_name }} {{ $empleado->person->second_name }}</b>, 
  titular de la Cédula de Identidad Nro. <b>{{ $empleado->person->cedula }}</b>,
  prestando sus servicios como: <b>{{ $empleado->cargo->name }}</b>, adscrito(a) al INSTITUTO AUTÓNOMO DE LA POLICÍA 
  DEL ESTADO BOLIVARIANO DE MÉRIDA, bajo el Código de Nómina Nro. <b>{{ $empleado->codigo_nomina }}</b>.
  
  <h5 style="text-align: center"><b>FECHA DE INGRESO: {{ $empleado->fecha_ingreso }}</b></h5>

  Constancia que se expide a solicitud de parte interesada, para: <b>{{ $motivo->motivo }}</b>, en la ciudad Mérida del Estado Bolivariano de
  Mérida {{ $hoy }}.
@endsection