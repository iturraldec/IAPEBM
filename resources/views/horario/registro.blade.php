@extends('adminlte::page')

@section('title', 'Registro de E/S')

@section('content_header')
  <div class="row">
    <div class="col-6">
      <h3>Registro de Entrada/Salida del personal.</h3>
    </div>
  </div>
@endsection

@section('content')
  <div class="row">
    <div class="col-6 mx-auto">
      <div class="card">
        <div class="card-body">
          <h6 class="text-center font-weight-bold text-monospace bg-info font-italic">
            * La busqueda del empleado estara restringida a los trabajadores de planta.
          </h6>

          <label for="inputCedula">Cédula de Identidad</label>
          <input type="text" id="inputCedula" class="form-control">
          
          <label for="inputCedula">Nombre(s) y Apellido(s)</label>
          <input type="text" id="inputNombre" class="form-control" readonly>

          <label for="inputUbicacion">Ubicación laboral</label>
          <input type="text" id="inputUbicacion" class="form-control" readonly>

          <label for="inputUbicacion">Fecha y Hora</label>
          <input type="text" id="inputFecha" class="form-control" readonly>

        </div>

        <div class="card-footer text-center">
          <button id="btnRegistrar" class="btn btn-danger mx-3">Registrar</button>
          <button type="reset" id="btnLimpiar" class="btn btn-secondary">Limpiar</button>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('js')
<script>
  $(document).ready(function () {
    $("#btnRegistrar").on('click', function() {
      let cedula = $("#inputCedula").val();
      let ruta = "{{ route('horario.registra', ['cedula' => '.valor']) }}";

      if(lib_isEmpty(cedula)) {
        lib_ShowMensaje('Error: Debe ingresar un número de cédula!', 'error');
      }
      else {
        fetch(ruta.replace('.valor', cedula), {
            headers: {
              'Content-Type' : 'application/json',
              'Accept' : 'application/json',
            }
        })
        .then(r => r.json())
        .then(resp => {
          if(resp.success) {
            $("#inputNombre").val(resp.data.person.first_name);
            $("#inputUbicacion").val(resp.data.unidad.name);
            $("#inputFecha").val(resp.message);
          }
          else {
            lib_ShowMensaje(resp.message, 'error');
          }
        });
      }
    });

    //
    $("#btnLimpiar").on('click', function() {
      $("#inputCedula").val('');
      $("#inputNombre").val('');
      $("#inputUbicacion").val('');
      $("#inputFecha").val('');
    });
  });
</script>
@endsection