@extends('adminlte::page')

@section('title', 'Listado de Permisos')

@section('content_header')
  <h1>Listado de Permisos</h1>
@endsection


@section('content')
  <div class="row justify-content-center">
    <div class="col-8">
      <div class="row form-group mb-3">
        <div class="col-10">
          <input type="text" id="input_name" class="form-control" placeholder="Ingresa nuevo Permiso">
        </div>
        
        <div class="col-2">
          <button type="button" id="btn_agregar" class="form-control btn btn-primary">
            Agregar
          </button>
        </div>
      </div>
      
      <div class="row">
        <div class="col">
          <table id="dt-permissions" class="table table-hover border border-dark">
            <thead class="thead-dark text-center">
              <tr>
                <th scope="col" class="col-sm-1">ID</th>
                <th scope="col">Nombre</th>
                <th scope="col" class="col-sm-2">Acción</th>
              </tr>
            </thead>
            <tbody>
      
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  @include('auth.permissions.edit')

@endsection

@section('js')
  <script type="text/javascript" src="{{ asset('assets/js/libreria.js') }}"></script>

  <script>
    $(document).ready(function () {
      // datatable
      let datatable = $('#dt-permissions').DataTable({
          "ajax": "{{ route('permissions.load-data') }}",
          "columns": [
            {"data": "id", "orderable": false},
            {"data": "name"},
            {"data":null,
            "render": function ( data, type, row, meta ) {
                    let btn_editar = '<button type="button" class="editar btn btn-primary btn-sm" data-toggle="modal" data-target="#modalForm"><i class="fas fa-edit"></i></button>';
                    let btn_eliminar = '<button class="eliminar btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i></button>';
                    
                    return  btn_editar + btn_eliminar;
                  },
            "orderable": false
            }
          ]
      });

      // boton agregar un permiso
      $("#btn_agregar").click(function() {
        let name = $("#input_name").val();

        $.ajax({
          headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
          url: "{{ route('permissions.store') }}",
          type: 'POST',
          data: {"name" : name},
          dataType:'json'
        })
        .done(function(resp){
          $("#input_name").val("");
          datatable.ajax.reload();
          lib_ShowMensaje('Permiso agregado...');
        })
        .fail(function(resp){
          lib_ShowMensaje(resp.responseJSON.message, 'error');
        });
      });

      // boton editar permiso
      $("#dt-permissions tbody").on("click", ".editar", function() {
        let data = datatable.row($(this).parents()).data();
        
        $("#modalForm").data("id", data.id);
        $("#input_permission").val(data.name);
      });

      // boton actualizar
      $("#btn-update").click(function(){
        let id = $("#modalForm").data("id");
        let name = $("#input_permission").val();
        let ruta = "{{ route('permissions.update', ['permission' => 'valor']) }}";

        ruta = ruta.replace('valor', id);

        $.ajax({
          headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
          url: ruta,
          type: 'PUT',
          data: {"name" : name},
          dataType:'json'
        })
        .done(function(resp){
          datatable.ajax.reload();
          lib_ShowMensaje('Permiso modificado...');
        })
        .fail(function(resp){
          lib_ShowMensaje(resp.responseJSON.message, 'error');
        });
      });

      // boton eliminar permiso
      $("#dt-permissions tbody").on("click",".eliminar",function() {
		    let data = datatable.row($(this).parents()).data();

        lib_Confirmar("Seguro de ELIMINAR el Permiso Nro. " + data.id + "?")
        .then((result) => {
          if (result.isConfirmed) {
            let ruta = "{{ route('permissions.destroy', ['permission' => 'valor']) }}";

            ruta = ruta.replace('valor', data.id);
            
            $.ajax({
              headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
              url: ruta,
              type: 'DELETE',
              dataType:'json',
              success: function(resp){
                datatable.ajax.reload();
                lib_ShowMensaje(resp.message);
              }
            });
          }
        })
      });
    });
  </script>
@endsection