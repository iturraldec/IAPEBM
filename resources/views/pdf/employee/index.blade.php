@extends('adminlte::page')

@section('title', 'Informes de Empleados')

@section('content_header')
  <h4>Consultas a Empleados</h4>
@endsection
@section('content')
  <div class="row">
    <div class="col-6">
      <ul>
        <li><a href="#">Empleados por unidad operativa</a></li>
        <li><a href="#" id="lnkConstanciaLaboral">Constancia de trabajo</a></li>
      </ul>
    </div>
  </div>

  @include('pdf.employee.modal-constancia-laboral')

@endsection

@section('js')
<script>
  $(document).ready(function () {
    //
    $("#inputConstanciaLaboralCedula").inputmask(lib_digitMask());

    //
    $("#inputConstanciaLaboralMotivo").inputmask(lib_characterMask());

    //
    $("#lnkConstanciaLaboral").click(function(e) {
      e.preventDefault();

      $("#inputConstanciaLaboralCedula").val('');
      $("#inputConstanciaLaboralMotivo").val('');
      $("#constanciaLaboralModal").modal("show");
    });

    //
    $("#btnConstanciaLaboralGenerar").click(function () {
      let ok = true;
      let ruta = "{{ route('pdf.employee.constancia-laboral', ['cedula' => '.cedula', 'motivo' => '.motivo']) }}";
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
        $("#constanciaLaboralModal").modal("hide");
        ruta = ruta.replace('.cedula', cedula);
        ruta = ruta.replace('.motivo', motivo);
        window.open(ruta, '_blank');
      }
    });
  });
</script>
@endsection