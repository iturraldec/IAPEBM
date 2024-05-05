@extends('adminlte::page')

@section('title', 'Listado de Permisos')

@section('content_header')
  <h1>Listado de Permisos.</h1>
@endsection


@section('content')
  <div class="col-8 mx-auto">
    <form id="permissionForm">
      <div class="row mb-3">
        <div class="input-group col-10">
          <input type="text" 
                id="inputPermission" 
                name="permission" 
                class="form-control" 
                placeholder="Ingresa nuevo Permiso"
                onkeyup="this.value = this.value.toUpperCase();"
          >
        </div>
        
        <div class="form-group col-2">
          <button type="submit" class="form-control btn btn-primary">Agregar</button>
        </div>
      </div>
    </form>
    
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

  @include('admin.permissions.edit')

@endsection

@section('js')
  <script>
    $(document).ready(function () {
      // mascara  de 'inputPermission' (agregar)
      $("#inputPermission").inputmask(lib_characterMask());

      // mascara  de 'input_permission' (editar)
      $("#input_permission").inputmask(lib_characterMask());

      // validacion de form para agregar
      $('#permissionForm').validate({
        submitHandler: function () {
          let _data = {
            'name' : $("#inputPermission").val()
          };

          $.ajax({
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url: "{{ route('admin.permissions.store') }}",
            type: 'POST',
            data: _data,
            dataType:'json'
          })
          .done(function(resp){
            $("#inputPermission").val("");
            datatable.ajax.reload();
            lib_ShowMensaje('Permiso agregado...');
          })
          .fail(function(resp){
            lib_ShowMensaje(resp.responseJSON.message, 'error');
          })
        },
        rules: {
          permission: {
            required: true
          },
        },
        messages: {
          permission: {
            required: "Debes ingresar la definición del permiso."
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

      // datatable
      let datatable = $('#dt-permissions').DataTable({
          "ajax": "{{ route('admin.permissions.index') }}",
          "columns": [
            {"data": "id", "orderable": false},
            {"data": "name"},
            {"data":null,
             "className" : "dt-body-center",
             "render": function ( data, type, row, meta ) {
                    let btn_editar = '<button type="button" class="editar btn btn-primary btn-sm mr-1" data-toggle="modal" data-target="#modalForm"><i class="fas fa-edit"></i></button>';
                    let btn_eliminar = '<button class="eliminar btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i></button>';
                    
                    return  btn_editar + btn_eliminar;
                  },
             "orderable": false
            }
          ]
      });

      // boton editar permiso
      $("#dt-permissions tbody").on("click", ".editar", function() {
        let data = datatable.row($(this).parents()).data();
        
        $("#input_permission").data("id", data.id);
        $("#input_permission").val(data.name);
      });

      // validacion de form para editar
      $('#editForm').validate({
        submitHandler: function () {
          let id = $("#input_permission").data("id");
          let ruta = "{{ route('admin.permissions.update', ['permission' => 'valor']) }}";
          let _data = {
            'name' : $("#input_permission").val()
          };

          ruta = ruta.replace('valor', id);
          $.ajax({
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url: ruta,
            type: 'PUT',
            data: _data,
            dataType:'json'
          })
          .done(function(resp){
            $("#modalForm").modal('hide');
            datatable.ajax.reload();
            lib_ShowMensaje('Permiso modificado...');
          })
          .fail(function(resp){
            lib_ShowMensaje(resp.responseJSON.message, 'error');
          })
        },
        rules: {
          input_permission: {
            required: true
          },
        },
        messages: {
          input_permission: {
            required: "Debes ingresar el nombre del permiso."
          },
        },
        errorElement: 'span',
        errorPlacement: function (error, element) {
          error.addClass('invalid-feedback');
          element.closest('.form-group').append(error);
        },
        highlight: function (element, errorClass, validClass) {
          $(element).addClass('is-invalid');
        },
        unhighlight: function (element, errorClass, validClass) {
          $(element).removeClass('is-invalid');
        }
      });

      // boton eliminar permiso
      $("#dt-permissions tbody").on("click",".eliminar",function() {
		    let data = datatable.row($(this).parents()).data();

        lib_Confirmar("Seguro de ELIMINAR el Permiso Nro. " + data.id + "?")
        .then((result) => {
          if (result.isConfirmed) {
            let ruta = "{{ route('admin.permissions.destroy', ['permission' => 'valor']) }}";

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