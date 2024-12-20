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
        @foreach ($meses as $item)
          <option value="{{ $item->id }}">{{ $item->mes }}</option>
        @endforeach
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
        let ruta = "{{ route('rp.descargar-pdf', ['reciboPago' => '.value']) }}";

        window.open(ruta.replace('.value', mes), '_blank');
      }
    );
  });
</script>
@endsection