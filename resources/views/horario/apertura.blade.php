@extends('adminlte::page')

@section('title', 'Aperturar E/S')

@section('content_header')
  <div class="row">
    <div class="col-6">
      <h3>Aperturar horario de Entrada/Salida.</h3>
    </div>
  </div>
@endsection

@section('content')
  <div class="row">
    <div class="col-8 mx-auto card">
      <div class="card-body text-center">
        
        <h3>Se realizara la apertura de Entrada/Salida de hoy: {{ date('Y-m-d') }}</h3>

        <button id="btnAperturar" class="btn btn-danger btn-lg">Aperturar</button>

      </div>
    </div>
  </div>
@endsection

@section('js')
<script>
  $(document).ready(function () {
    $("#btnAperturar").on("click", function() {
      fetch("{{ route('horario.aperturar') }}", {
          headers: {
            'Content-Type'      : 'application/json',
            'X-Requested-With'  : 'XMLHttpRequest'
          },
      })
      .then(r => r.json())
      .then(resp => {
        if(resp.success) {
          lib_ShowMensaje(resp.message, 'mensaje');
        }
        else {
          lib_ShowMensaje(resp.message, 'error');
        }
      });
    });
  });
</script>
@endsection