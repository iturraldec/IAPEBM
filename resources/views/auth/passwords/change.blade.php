@extends('adminlte::page')

@section('title', 'Cambio de clave de usuario')

@section('content_header')
  <h1>Cambio de clave de usuario.</h1>
@endsection

@section('content')
  <div class="row justify-content-center">
    <div class="col-6">
      <div class="card card-dark">
        <div class="card-header">
          <h3 class="card-title">Cambio de clave de usuario</h3>
        </div>
        <!-- /.card-header -->
        <!-- form start -->
        <div class="card-body">
          <div class="form-group">
            <label for="inputPwd1">Nueva clave</label>
            <input type="password" class="form-control" id="inputPwd1" placeholder="Ingrese nueva clave">
          </div>
          <div class="form-group">
            <label for="inputPwd2">Repita nueva clave</label>
            <input type="password" class="form-control" id="inputPwd2" placeholder="Ingrese nuevamente la clave">
          </div>
        </div>
        <!-- /.card-body -->

        <div class="card-footer">
          <button id="btnChange" class="btn btn-danger">Cambiar</button>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('js')
  <script>
    $(document).ready(function () {
      $("#btnChange").on('click', function() {
        let pwd1 = $("#inputPwd1").val();
        let pwd2 = $("#inputPwd2").val();

        if(lib_isEmpty(pwd1) || lib_isEmpty(pwd2)) {
          lib_toastr('Error: Debe ingresar las nuevas claves!');
        }
        else if(pwd1 != pwd2) {
          lib_toastr('Error: Las nuevas claves no coinciden!');
        }
        else {
          $.ajax({
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url: "{{ route('users.password.change') }}",
            type: 'POST',
            data: {'password': pwd1},
            dataType:'json'
          })
          .done(function(resp){
            lib_ShowMensaje(resp.message);
          })
          .fail(function(resp){
            lib_ShowMensaje(resp.responseJSON.message, 'error');
          });
        }
      });
    });
  </script>
@endsection