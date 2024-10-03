@extends('adminlte::page')

@section('title', 'Informes de Empleados')

@section('content_header')
  <h4>Consultas a Empleados</h4>
@endsection
@section('content')
  <div class="row">
    <div class="col-6">
      <ul>
        <li><a href="{{ route('pdf.employee.listado') }}">Listados de Empleados</a></li>
        <li><a href="#" id="lnkConstanciaLaboral">Constancia de trabajo</a></li>
      </ul>
    </div>
  </div>

  <!-- modal de las constancias laborales -->
  @include('pdf.employee.views.modal-constancia-laboral')

@endsection

@section('js')
<script>
  $(document).ready(function () {
    //
    $("#inputConstanciaLaboralCedula").inputmask(lib_digitMask());

    //
    $("#inputConstanciaLaboralMotivo").inputmask(lib_characterMask());

    // modal show de constancias de trabajo
    $("#lnkConstanciaLaboral").click(function(e) {
      e.preventDefault();

      $("#inputConstanciaLaboralCedula").val('');
      $("#inputConstanciaLaboralMotivo").val('');
      $("#constanciaLaboralModal").modal("show");
    });

    // constancias de trabajo
    $("#btnConstanciaLaboralGenerar").click(function () {
      let ok = true;
      let cedula = $("#inputConstanciaLaboralCedula").val();
      let motivo = $("#inputConstanciaLaboralMotivo").val();

      if(lib_isEmpty(cedula)) {
        ok = false;
        lib_toastr("Error: Debe ingresar el número de cédula!");
      }

      if(lib_isEmpty(motivo)) {
        ok = false;
        lib_toastr("Error: Debe ingresar el motivo de la constancia!");
      }

      if(ok) {
        let rutaCheck = "{{ route('pdf.employee.constancia-laboral-check', ['cedula' => '.cedula']) }}";
        let ruta = "{{ route('pdf.employee.constancia-laboral', ['cedula' => '.cedula', 'motivo' => '.motivo']) }}";
        
        rutaCheck = rutaCheck.replace('.cedula', cedula);
        fetch(rutaCheck)
        .then(reponse => reponse.json())
        .then(r => {
          if(!r.success) lib_toastr(r.message);
          else {
            $("#constanciaLaboralModal").modal("hide");
            ruta = ruta.replace('.cedula', cedula);
            ruta = ruta.replace('.motivo', motivo);
            window.open(ruta, '_blank');
          }
        });
      }
    });
  });
</script>
@endsection