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
    <div class="col-4 mx-auto card">
      <div class="card-body">
        <div class="form-group">
          <label for="inputDesde">Fecha inicial</label>
          <input type="date" class="form-control" id="inputDesde" value="{{ date('Y-m-d') }}">
        </div>
        
        <div class="form-group">
          <label for="inputHasta">Fecha final</label>
          <input type="date" class="form-control" id="inputHasta" value="{{ date('Y-m-d') }}">
        </div>
      </div>

      <div class="card-footer">
        <button id="btnConsultar" class="btn btn-primary">Consultar</button>
      </div>    
    </div>
  </div>
@endsection

@section('js')
<script>
  $(document).ready(function () {
    var ruta = "{{ route('horario.listar', ['desde' => '.desde', 'hasta' => '.hasta']) }}";

    $("#btnConsultar").on("click", function() {
      let _ruta = ruta.replace('.desde', $("#inputDesde").val());
      _ruta = _ruta.replace('.hasta', $("#inputHasta").val());

      window.open(_ruta, '_blank');
    })
  });
</script>
@endsection