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
          <label for="inputFecha">Fecha</label>
          <input type="date" class="form-control" id="inputFecha" value="{{ date('Y-m-d') }}">
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
    var ruta = "{{ route('horario.listado-pdf', ['fecha' => '.valor']) }}";

    $("#btnConsultar").on("click", function() {
      let _ruta = ruta.replace('.valor', $("#inputFecha").val());

      window.open(_ruta, '_blank');
    })
  });
</script>
@endsection