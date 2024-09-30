@extends('layouts.pdf.pdf-documento')

@section('title', 'Constancia Laboral')

@section('encabezado', 'HACE CONSTAR')

@section('content')  
  Por medio de la presente que el(la) ciudadano(a): <b>{{ $person->first_last_name }} {{ $person->second_last_name }} 
  {{ $person->first_name }} {{ $person->second_name }}</b>, titular de la Cédula de Identidad Nro. <b>{{ $person->cedula }}</b>,
  prestando sus servicios como: <b>{{ $person->employee->cargo->name }}</b>, adscrito(a) al INSTITUTO AUTÓNOMO DE LA POLICÍA 
  DEL ESTADO BOLIVARIANO DE MÉRIDA, bajo el Código de Nómina Nro. <b>{{ $person->employee->codigo_nomina }}</b>.
  
  <h5 style="text-align: center"><b>FECHA DE INGRESO: {{ $person->employee->fecha_ingreso }}</b></h5>

  Constancia que se expide a solicitud de parte interesada, para: <b>{{ $motivo }}</b>, en la ciudad Mérida del Estado Bolivariano de
  Mérida a los {{ $hoy }}.
@endsection