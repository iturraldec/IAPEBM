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

          <label for="inputCedula">Cédula de Identidad</label>
          <div class="input-group">
            <input type="text" id="inputCedula" class="form-control">

            <div class="input-group-append">
              <button type="button"
                      id="btnSearch"
                      class="input-group-text btn btn-primary btn-sm"
                      title="Agregar ubicación del empleado"
              >
                <i class="fas fa-search"></i>
              </button>
            </div>
          </div>
          
          <label for="inputCedula">Nombre(s) y Apellido(s)</label>
          <input type="text" id="inputNombre" class="form-control" readonly>

          <label for="inputUbicacion">Ubicación laboral</label>
          <input type="text" id="inputUbicacion" class="form-control" readonly>

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
    ///////////////////////////////////////////////////////////////////
    // ruta
    ///////////////////////////////////////////////////////////////////

    var rutaBuscar =  "{{ route('horario.buscar', ['cedula' => '.valor']) }}";
    var ok = false;

    //
    $("#btnSearch").on('click', function() {
      let cedula = $("#inputCedula").val();
      let _ruta = rutaBuscar.replace('.valor', cedula);

      $("#inputNombre").val('');
      $("#inputUbicacion").val('');
      fetch(_ruta)
      .then(r => r.json())
      .then(resp => {
        if(resp.success) {
          $("#inputNombre").val(resp.data.person.first_last_name + " " + resp.data.person.second_last_name + ", " + resp.data.person.first_name + " " + resp.data.person.second_name);
          $("#inputUbicacion").val(resp.data.unidad.name);
          ok = true;
        }
        else {
          lib_ShowMensaje(resp.message, 'error');
          ok = false;
        }
      });
    });

    //
    $("#btnRegistrar").on('click', function() {
      if(! ok) {
        lib_ShowMensaje('Error: Debe buscar al empleado.', 'error');
      }
      else {
        let cedula = $("#inputCedula").val();

        fetch("{{ route('horario.registrar') }}", {
          headers: {
            'Content-Type' : 'application/json',
            'Accept' : 'application/json',
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
          },
          method: 'POST',
          body: JSON.stringify({'cedula': cedula})
        })
        .then(r => r.json())
        .then(resp => {
          if(resp.success) {
            ok = false;
            $("#inputCedula").val('');
            $("#inputNombre").val('');
            $("#inputUbicacion").val('');
            lib_ShowMensaje(resp.message, 'mensaje');
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
    });
  });
</script>
@endsection