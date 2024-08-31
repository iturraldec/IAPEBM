@extends('adminlte::page')

@section('title', 'Listado de Roles')

@section('content_header')
  <h1>Listado de Roles de Usuarios.</h1>
@endsection

@section('content')
  <div class="row">
    <div class="col-10 mx-auto">
      <table id="dt-roles" class="table table-hover border border-dark">
        <thead class="thead-dark text-center">
          <tr>
            <th scope="col" class="col-sm-1">ID</th>
            <th scope="col">Nombre</th>
            <th scope="col">Permisos</th>
            <th scope="col" class="col-sm-2">Acción</th>
          </tr>
        </thead>
        <tbody>
  
        </tbody>
      </table>
    </div>
  </div>

  @include('admin.roles.edit')

@endsection

@section('js')
  <script>
    $(document).ready(function () {
      // datatable
      let customButton = '<button id="btn-agregar" class="btn btn-primary">Agregar Rol</button>';
      let datatable = $('#dt-roles').DataTable({
          "dom": '<"d-flex justify-content-between"lr<"#dt-add-button">f>t<"d-flex justify-content-between"ip>',
          "ajax": "{{ route('admin.roles.index') }}",
          "columns": [
            {"data": "id", "orderable": false, visible: false},
            {"data": "name"},
            {"data": null,
             "render": function(data, type, row, meta) {
                let badge = '';

                row.permissions.forEach(permission => badge += `<span class="badge badge-info m-1">${permission.name}</span>`);
                
                return badge;
             },
             "orderable": false
            },
            {"data":null,
             "className" : "dt-body-center",  
             "render": function ( data, type, row, meta ) {
                    let btn_editar = '<button type="button" class="editar btn btn-primary btn-sm mr-1"><i class="fas fa-edit"></i></button>';
                    let btn_eliminar = '<button class="eliminar btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i></button>';
                    
                    return  btn_editar + btn_eliminar;
                  },
             "orderable": false
            }
          ]
      });

      $("#dt-add-button").html(customButton);

      // validacion de form
      $('#rolForm').validate({
        submitHandler: function (form) {
          let formData = $(form).serializeArray();

          if (formData[0].value === "") { // agregar rol
            grabar_datos("{{ route('admin.roles.store') }}", 'POST', formData);
          }
          else {                          // editar rol
            let ruta = "{{ route('admin.roles.update', ['role' => 'valor']) }}";

            ruta = ruta.replace('valor', $("#input-id").val());
            grabar_datos(ruta, 'PUT', formData);
          };

          $('#modalForm').modal('hide');
        },
        rules: {
          name: {
            required: true
          },
        },
        messages: {
          name: {
            required: "Debes ingresar el nombre del rol."
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

      // limpiar el array de permisos
      function clean_permissions() {
        $('input[name="permissions[]"]').each(function() {
          $(this).prop('checked', false);
        });
      }

      // boton agregar rol
      $("#btn-agregar").click(function() {
        $("#modalTitle").html("Agregar Rol");
        $("#input-id").val("");
        $("#input-name").val("");
        $("#input-name").attr("placeholder", "Ingrese nuevo Rol");
        clean_permissions();
        $('#modalForm').modal('show');
      });

      // boton editar rol
      $("#dt-roles tbody").on("click", ".editar", function() {
        let data = datatable.row($(this).parents()).data();
        
        $("#modalTitle").html("Modificar Rol");
        $("#input-id").val(data.id);
        $("#input-name").val(data.name);
        $("#input-name").attr('placeholder', 'Modificar Rol');

        // permisos del rol
        clean_permissions();
        data.permissions.forEach(permission => $(`input[name="permissions[]"][value="${permission.name}"]`).prop('checked', true));

        $('#modalForm').modal('show');
      });

      // funcion para grabar los datos al agregar/modificar
      function grabar_datos(_url, _type, _data) {
        $.ajax({
          headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
          url: _url,
          type: _type,
          data: _data,
          dataType:'json'
        })
        .done(function(resp){
          datatable.ajax.reload();
          lib_ShowMensaje(resp.message);
        })
        .fail(function(resp){
          lib_ShowMensaje(resp.responseJSON.message, 'error');
        });
      }
      
      // boton eliminar rol
      $("#dt-roles tbody").on("click",".eliminar",function() {
		    let data = datatable.row($(this).parents()).data();

        lib_Confirmar("Seguro de ELIMINAR el Rol Nro. " + data.id + "?")
        .then((result) => {
          if (result.isConfirmed) {
            let ruta = "{{ route('admin.roles.destroy', ['role' => 'valor']) }}";

            ruta = ruta.replace('valor', data.id);
            
            $.ajax({
              headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
              url: ruta,
              type: 'DELETE',
              dataType:'json',
              success: function(resp){
                datatable.ajax.reload();
                lib_ShowMensaje("Rol eliminado.");
              }
            });
          }
        })
      });
    });
  </script>
@endsection