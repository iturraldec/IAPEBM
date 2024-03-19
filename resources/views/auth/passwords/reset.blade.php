@extends('adminlte::page')

@section('title', 'Resetear clave de usuario')

@section('content_header')
  <h1>Resetear clave de usuario.</h1>
@endsection

@section('content')
  <div class="row justify-content-center">
    <div class="col-6">
      <div class="card card-dark">
        <div class="card-header">
          <h3 class="card-title">Resetear clave de usuario</h3>
        </div>
        <!-- /.card-header -->
        <!-- form start -->
        <div class="card-body">
          <div class="form-group">
            <label for="inputDocument">Documento de identificación</label>
            <input type="password" class="form-control" id="inputPwd1" placeholder="Ingrese nueva clave">
          </div>

          <div class="form-group">
            <input type="button" class="form-control" id="inputSearch">
          </div>
        </div>
        <!-- /.card-body -->

        <div class="card-footer">
          <button id="btnChange" class="btn btn-danger">Resetear</button>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('js')
  <script>
    $(document).ready(function () {
      $("#btnChange").click(function() {
        let clave = $("#inputPwd1").val();

        $.ajax({
          headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
          url: "{{ route('users.password.update') }}",
          type: 'POST',
          data: {'pwd': clave},
          dataType:'json'
        })
        .done(function(resp){
          lib_ShowMensaje(resp.message);
        })
        .fail(function(resp){
          lib_ShowMensaje(resp.responseJSON.message, 'error');
        });
      });
    });
  </script>
@endsection