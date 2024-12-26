@extends('adminlte::page')

@section('title', 'Subir Recibos de Pago')

@section('css')
<style>
  label.error {
      color: #cc0000;
      display: block;
      margin-top: 5px;
      font-size: 0.9em;
  }

  .form-group.has-error .form-control {
      border-color: #cc0000;
  }

  .form-group.has-error label {
      color: #cc0000;
  }

  .form-group {
      margin-bottom: 15px;
  }
</style>
@endsection

@section('content_header')
  <h3>Subir Recibos de Pago.</h3>
@endsection

@section('content')
  <div class="row justify-content-center">
    <div class="col-6 form-group">
      <form id="formulario" action="{{ route('rp.subir') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
          <label>Mes del recibo de pago a subir</label>
          <input type="text" name="mes" class="form-control" placeholder="AAAA-MM">
        </div>

        <div class="form-group">
          <label>Desde el día</label>
          <input type="date" id="desde" name="desde" class="form-control">
        </div>

        <div class="form-group">
          <label>Hasta el día</label>
          <input type="date" id="hasta" name="hasta" class="form-control">
        </div>
        
        <div class="form-group">
          <p><label for="inputFile">Archivo Excel a cargar</label></p>
          <input type="file" id="inputFile" name="archivo">
        </div>

        <div class="text-center">
          <button class="btn btn-danger">Subir</button>
        </div>
      </form>
    </div>
  </div>
@endsection

@section('js')
<script>
  $(document).ready(function () {
    //
    $.validator.addMethod("validarFechaFormato", function(value, element) {
      if (!/^[2-9][0-9]{3}-(0[1-9]|1[0-2])$/.test(value)) {
          return false;
      }

      var partes = value.split('-');
      var anio = parseInt(partes[0], 10);
      var mes = parseInt(partes[1], 10);

      return anio > 2023 && mes >= 1 && mes <= 12;
    }, "Por favor, ingrese una fecha válida posterior a 2023 (AAAA-MM)");

    //
    $.validator.addMethod("validarFechaRango", function(value, element, params) {
      if (!value || !$(params).val()) {
          return true;
      }

      return new Date(value) < new Date($(params).val());
    }, "La fecha 'Desde' debe ser menor a la fecha 'Hasta'.");

		//
    $("#formulario").validate({
      rules: {
        mes: {
          required: true,
          validarFechaFormato: true
        },
        desde: {
          required: true,
          validarFechaRango:"#hasta"
        },
        hasta: {
          required: true
        },
        archivo: {
          required: true
        }
      },
      messages: {
        mes: "Por favor, ingrese una fecha válida posterior a 2023 (AAAA-MM)",
        desde: {
            required: "Por favor, ingrese la fecha inicial del mes del recibo de pago",
        },
        hasta: "Por favor, ingrese la fecha final del mes del recibo de pago",
        archivo: "Por favor, seleccione el archivo Excel a subir.",
      },
      submitHandler: function(form) {
        form.submit();
      }
    });
  });
</script>
@endsection