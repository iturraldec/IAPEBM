@extends('adminlte::page')

@section('title', 'Listado de Usuarios')

@section('content_header')
  <h1>Listado de Usuarios.</h1>
@endsection

@section('content')
  <div class="col-8 mx-auto">
    <table id="dt-users" class="table table-hover border border-dark">
      <thead class="thead-dark text-center">
        <tr>
          <th scope="col">ID</th>
          <th scope="col">C.I.</th>
          <th scope="col">Nombre</th>
          <th scope="col">Correo</th>
          <th scope="col">Roles</th>
          <th scope="col" class="col-sm-2">Acción</th>
        </tr>
      </thead>
      <tbody>

      </tbody>
    </table>
  </div>

  @include('admin.users.edit')

@endsection

@section('js')
  <script>
    $(document).ready(function () {
      // mascara de cedula del usuario
      $("#documentInput").inputmask({regex:"\\d+"})
      
      // mascara del nombre del usuario
      $("#nameInput").inputmask({regex:"[A-Za-z]+"})

      // datatable
      let datatable = $('#dt-users').DataTable({
          "ajax": "{{ route('admin.users.index') }}",
          "columns": [
            {"data": "id", visible: false},
            {"data": "code", orderable: false},
            {"data": "name"},
            {"data": "email", orderable: false},
            {"data": null,
             "render": function(data, type, row, meta) {
              let badge = '';

              row.roles.forEach(roles => badge += `<span class="badge badge-info m-1">${roles.name}</span>`);
                
              return badge;
             },
             "orderable": false
            },
            {"data":null,
            "render": function ( data, type, row, meta ) {
                    let btn_editar = '<button type="button" class="editar btn btn-primary btn-sm"><i class="fas fa-edit"></i></button>';
                    let btn_eliminar = '<button class="eliminar btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i></button>';
                    
                    return  btn_editar + btn_eliminar;
                  },
            "orderable": false
            }
          ]
      });

      // Agregar botón personalizado
      var customButton = '<button id="btn-agregar" class="btn btn-primary">Agregar Usuario</button>';
      
      $('#dt-users_wrapper .dataTables_length').append(customButton);

      // limpiar el array de roles
      function clean_roles() {
        $('input[name="roles[]"]').each(function() {
          $(this).prop('checked', false);
        });
      }

      // validacion de form
      $('#form-user').validate({
        submitHandler: function (form) {
          let formData = $(form).serializeArray();
          let inputId = $("#idInput").val();

          if (inputId === "") { // agregar usuario
            grabar_datos("{{ route('admin.users.store') }}", 'POST', formData);
          }
          else {                          // editar rol
            let ruta = "{{ route('admin.users.update', ['user' => 'valor']) }}";

            ruta = ruta.replace('valor', inputId);
            grabar_datos(ruta, 'PUT', formData);
          };

          $('#modalForm').modal('hide');
        },
        rules: {
          code: {
            required: true
          },
          name: {
            required: true
          },
          email: {
            required: true,
            email: true
          }
        },
        messages: {
          code: {
            required: "Debes ingresar el número de cédula del usuario."
          },
          name: {
            required: "Debes ingresar el nombre del usuario."
          },
          email: {
            required: "Debes ingresar el correo electrónico del usuario.",
            email: "Por favor ingresa un correo electrónico valido."
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

      // boton agregar usuario
      $("#btn-agregar").click(function() {
        $("#modalTitle").html("Agregar Usuario");
        $("#idInput").val("");
        $("#documentInput").val("");
        $("#documentInput").attr("placeholder", "Ingrese cédula de identidad del usuario");
        $("#nameInput").val("");
        $("#nameInput").attr("placeholder", "Ingrese nombre de usuario");
        $("#documentInput").attr("readonly", false);
        $("#emailInput").val("");
        $("#emailInput").attr("placeholder", "Ingrese el correo del usuario");
        clean_roles();
        $('#modalForm').modal('show');
      });

      // boton editar usario
      $("#dt-users tbody").on("click", ".editar", function() {
        let data = datatable.row($(this).parents()).data();
        
        $("#modalTitle").html("Modificar Usuario");
        $("#idInput").val(data.id);
        $("#documentInput").val(data.code);
        $("#documentInput").attr("readonly", true);
        $("#nameInput").val(data.name);
        $("#nameInput").attr('placeholder', 'Modificar Usuario');
        $("#emailInput").val(data.email);
        $("#emailInput").attr('placeholder', 'Correo del Usuario');

        // roles del usuario
        clean_roles();
        data.roles.forEach(role => $(`input[name="roles[]"][value="${role.name}"]`).prop('checked', true));

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
      
      // boton eliminar usuario
      $("#dt-users tbody").on("click",".eliminar",function() {
		    let data = datatable.row($(this).parents()).data();

        lib_Confirmar("Seguro de ELIMINAR el Usuario: " + data.name + "?")
        .then((result) => {
          if (result.isConfirmed) {
            let ruta = "{{ route('admin.users.destroy', ['user' => 'valor']) }}";

            ruta = ruta.replace('valor', data.id);
            
            $.ajax({
              headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
              url: ruta,
              type: 'DELETE',
              dataType:'json',
              success: function(resp){
                datatable.ajax.reload();
                lib_ShowMensaje("Usuario eliminado.");
              }
            });
          }
        })
      });
    });
  </script>
@endsection