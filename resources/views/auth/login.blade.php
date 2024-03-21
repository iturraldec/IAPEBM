@extends('adminlte::auth.login')

@section('js')
<script>
$(document).ready(function () {
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
        required: "Por favor ingresa el número de documento de identificación",
        minlength: "Debe tener al menos 7 dígitos",
      },
      password: {
        required: "Por favor ingresa el password",
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