@extends('adminlte::page')

@section('title', 'Listado de E/S')

@section('content_header')
  <div class="row">
    <div class="col-6">
      <h3>Listado de Entrada/Salida del personal.</h3>
    </div>
  </div>
@endsection

@section('content')
  <div class="row">
    <div class="col-6 mx-auto">
      <p>desde</p>
      <p>hasta</p>
    </div>
  </div>
@endsection

@section('js')
<script>
  $(document).ready(function () {
    
  });
</script>
@endsection