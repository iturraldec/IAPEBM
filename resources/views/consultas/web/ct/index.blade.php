@extends('adminlte::page')

@section('title', 'Constancia de Trabajo')

@section('content_header')
  <h4>Generar Constancia de Trabajo</h4>
@endsection

@section('content')
  <div class="form-group">
    <label for="inputConstanciaLaboralMotivo">Motivo de la generación de la constancia de trabajo</label>

    <select id="selectMotivo" class="form-control" title="Motivo">
      <option value="0" selected>SELECCIONE EL MOTIVO</option>
      @foreach ($motivos as $item)
        <option value="{{ $item->id }}">{{ $item->motivo }}</option>
      @endforeach
    </select>
  </div>
      
  <button type="button" id="btnGenerar" class="btn btn-danger">Generar</button>
@endsection

@section('js')
  <script>
    $(document).ready(function () {
      $("#btnGenerar").click(function () {
        let motivo = $("#selectMotivo").val();

        if(motivo === '0') {
          lib_toastr("Error: Debe seleccionar el motivo de la constancia!");
        }
        else {
          let ruta = "{{ route('cw.ct.pdf', ['motivo' => '.value']) }}";

          window.open(ruta.replace('.value', motivo), '_blank');
        }
      });
    });
  </script>
@endsection