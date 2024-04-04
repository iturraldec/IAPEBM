@extends('adminlte::auth.login')

@section('js')
<script>
$(document).ready(function () {
  // masacara de 'document'
  $('#document').inputmask({ regex: "\\d+" });

  // validacion del formulario
  $('#loginForm').validate({
    rules: {
      document: {
        required: true,
        minlength: 7
      },
      password: {
        required: true,
        minlength: 5
      },
    },
    messages: {
      document: {
        required: "Debes ingresar el número de documento de identificación",
        minlength: "Debe tener al menos 7 dígitos",
      },
      password: {
        required: "Debes ingresar el password",
        minlength: "Debe tener al menos 5 dígitos"
      },
    },
    errorElement: 'span',
    errorPlacement: function (error, element) {
      error.addClass('invalid-feedback');
      element.closest('.input-group').append(error);
    },
    highlight: function (element, errorClass, validClass) {
      $(element).addClass('is-invalid');
    },
    unhighlight: function (element, errorClass, validClass) {
      $(element).removeClass('is-invalid');
    }
  });
});
</script>
@endsection