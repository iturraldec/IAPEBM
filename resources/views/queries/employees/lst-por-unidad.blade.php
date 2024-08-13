@extends('adminlte::page')

@section('title', 'Consulta de Empleados')

@section('content_header')
  <h4>Consulta de Empleados por Unidades Operativas</h4>
@endsection

@section('content')
  <div class="row">
    <div class="col-8 form-group">
      <label for="selectUnidad">Unidad Operativa</label>
      <select id="selectUnidad" class="form-control" title="Ubicación del empleado">
        <option value="0" selected>SELECCIONE LA UNIDAD</option>
        @foreach($unidades as $unidad)
          <option value="{{ $unidad->id }}">{{ $unidad->name }}</option>
        @endforeach
      </select>
    </div>

    <div class="col-4">
      <a id="btnUnidad" class="btn btn-primary btn-sm" href="#">Informe general</a>
    </div>

    <div class="col-8 form-group">
      <label for="selectUnidadEspecifica">Unidad Operativa específica</label>
      <select id="selectUnidadEspecifica" class="form-control" title="Ubicación específica del empleado">
      </select>
    </div>

    <div class="col-4">
      <a id="btnUnidadEspecifica" class="btn btn-primary btn-sm" href="#">Informe específico</a>
    </div>
  </div>
@endsection

@section('js')
<script>
  $(document).ready(function () {
    ///////////////////////////////////////////////////////////////////
    // cargar unidades especificas de una unidad general
    ///////////////////////////////////////////////////////////////////

    $("#selectUnidad").change(function() {
      let unidad_id = $(this).val();
      let ruta = "{{ route('unidades-e.getAll', ['padre_id' => '.valor']) }}";

      ruta = ruta.replace('.valor', unidad_id);
      fetch(ruta)
      .then(response => response.json())
      .then(r => {
        $("#selectUnidadEspecifica").empty();
        $("#selectUnidadEspecifica").append('<option value="0">SELECCIONE LA U.O.E.</option>');
        r.data.forEach(element => {
          $("#selectUnidadEspecifica").append(`<option value="${element.id}">${element.name}</option>`);
        });
      });
    });

    ///////////////////////////////////////////////////////////////////
    // empleados por unidad general
    ///////////////////////////////////////////////////////////////////

    $("#btnUnidad").click(function (e) {
      e.preventDefault();

      let ruta = "{{ route('query.employees.lst-por-unidad', ['tipo' => 1, 'unidad' => '.valor']) }}";

      window.open(ruta.replace('.valor', $("#selectUnidad").val()), '_blank');
    });

    ///////////////////////////////////////////////////////////////////
    // empleados por unidad especifica
    ///////////////////////////////////////////////////////////////////

    $("#btnUnidadEspecifica").click(function (e) {
      e.preventDefault();

      let ruta = "{{ route('query.employees.lst-por-unidad', ['tipo' => 2, 'unidad' => '.valor']) }}";

      window.open(ruta.replace('.valor', $("#selectUnidadEspecifica").val()), '_blank');
    });
  });
</script>
@endsection