@extends('adminlte::page')

@section('title', 'Listado de Roles')

@section('content_header')
  <h1>Listado de Roles</h1>
@endsection

@section('content')
  <div class="row justify-content-center">
    <div class="col-8">
      <table id="dt-roles" class="table table-hover border border-dark">
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

  @include('auth.roles.edit')

@endsection

@section('js')
  <script>
    $(document).ready(function () {
      // datatable
      let datatable = $('#dt-roles').DataTable({
          "ajax": "{{ route('roles.load-data') }}",
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

      // Agregar botón personalizado
      var customButton = '<button id="btn-agregar" class="btn btn-primary">Agregar Rol</button>';
      
      $('#dt-roles_wrapper .dataTables_length').append(customButton);

      // limpiar el array de permisos
      function clean_permissions() {
        $('input[name="permissions[]"]').each(function() {
          $(this).prop('checked', false);
        });
      }

      // boton agregar
      $("#btn-agregar").click(function() {
        $("#modalForm").data("id", "");
        $("#modalTitle").html("Agregar Rol");
        $("#input-name").val("");
        $("#input-name").attr("placeholder", "Ingrese nuevo Rol");
        clean_permissions();

        // cargo los permisos del rol
        
        $('#modalForm').modal('show');
      });

      // boton editar rol
      $("#dt-roles tbody").on("click", ".editar", function() {
        let data = datatable.row($(this).parents()).data();
        
        $("#modalForm").data("id", data.id);
        $("#input-name").val(data.name);
        $("#input-name").attr('placeholder', 'Modificar Rol');
        clean_permissions();
      });

      // grabar
      $('#form-rol').submit(function(event) {
        event.preventDefault();

        let formData = $(this).serializeArray();
        let id = $('#modalForm').data('id');

        $('#modalForm').modal('hide');

        if (id === "") {
          let _url = "{{ route('roles.store') }}";
          let _type = 'POST';

          $.ajax({
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url: _url,
            type: _type,
            data: formData,
           dataType:'json'
          })
          .done(function(resp){
            datatable.ajax.reload();
            lib_ShowMensaje('Rol agregado...');
          })
          .fail(function(resp){
            lib_ShowMensaje(resp.responseJSON.message, 'error');
          });
        }
      });

      // boton actualizar
      $("#btn-update").click(function(){
        let id = $("#input_permission").data("id");
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