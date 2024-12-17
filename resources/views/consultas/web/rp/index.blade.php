@extends('adminlte::page')

@section('title', 'Recibo de Pago')

@section('content_header')
  <h4>Generar Recibo de Pago</h4>
@endsection

@section('content')
<div class="row justify-content-center">
  <div class="col-6">
    <div class="form-group">
      <label>Seleccione el mes del pago</label>

      <select id="selectMes" class="form-control" title="Mes">
        <option value="2024-11" selected>2024-11</option>
      </select>
    </div>
        
    <button type="button" id="btnGenerar" class="btn btn-danger">Generar</button>
  </div>
</div>
@endsection

@section('js')
<script>
  $(document).ready(function () {
    $("#btnGenerar").click(function () {
      let mes = $("#selectMes").val();
      let ruta = "{{ route('cw.rp.pdf', ['mes' => '.value']) }}";

        window.open(ruta.replace('.value', mes), '_blank');
      }
    );
  });
</script>
@endsection