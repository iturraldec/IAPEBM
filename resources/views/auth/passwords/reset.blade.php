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
          <div class="input-group">
            <input type="text" id="inputDocument" class="form-control form-control-lg" placeholder="Inserte Número de Cédula">
            <div class="input-group-append">
                <button id="btnSearch" class="btn btn-lg btn-default">
                    <i class="fa fa-search"></i>
                </button>
            </div>
          </div>

          <label id="lblName" class="h4 mt-2">Usuario?</label>
        </div>
        <!-- /.card-body -->

        <div class="card-footer">
          <button id="btnReset" class="btn btn-danger">Resetear</button>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('js')
  <script>
    $(document).ready(function () {
      let user_id = 0;

      //
      $("#btnSearch").click(function() {
        let ruta = "{{ route('admin.users.getByDocument', ['document' => ':valor']) }}";

        ruta = ruta.replace(':valor', $("#inputDocument").val());
        fetch(ruta)
        .then(response => response.json())
        .then(json => {
          $("#lblName").text("Usuario: " + json.data.name);
          user_id = json.data.id;
        })
      });

      //
      $("#btnReset").click(function() {
        if(user_id == 0) {
          alert("Debe seleccionar un usuario.");
        }
        else {
          $.ajax({
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url: "{{ route('admin.users.password.reset') }}",
            type: 'POST',
            data: {'id': user_id},
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