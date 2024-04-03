@extends('adminlte::page')

@section('title', 'Emppleados-Condiciones')

@section('content_header')
  <h1>Listado de Condiciones de los Empleados.</h1>
@endsection

@section('content')
  <div class="row justify-content-center">
    <div class="col-8">
      <table id="dt-employee-status" class="table table-hover border border-dark">
        <thead class="thead-dark text-center">
          <tr>
            <th scope="col">ID</th>
            <th scope="col">Nombre</th>
            <th scope="col" class="col-sm-2">Acción</th>
          </tr>
        </thead>
        <tbody>
  
        </tbody>
      </table>
    </div>
  </div>

@include('employee-status.edit')

@endsection

@section('js')
<script>
  $(document).ready(function () {
    // datatable
    let datatable = $('#dt-employee-status').DataTable({
        "ajax": "{{ route('employee-status.index') }}",
        "columns": [
          {"data": "id", "orderable": false},
          {"data": "name"},
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
    var customButton = '<button id="btn-agregar" class="btn btn-primary">Agregar Condición</button>';
    
    $('#dt-employee-status_wrapper .dataTables_length').append(customButton);

    // boton agregar condicion
    $("#btn-agregar").click(function() {
      $("#modalTitle").html("Agregar Condición");
      $("#inputCondicion").val("");
      $("#inputCondicion").data("id", "");
      $("#inputCondicion").attr("placeholder", "Ingrese nombre de la Condición");
      $('#modalForm').modal('show');
    });

    // boton editar condicion
    $("#dt-employee-status tbody").on("click", ".editar", function() {
      let data = datatable.row($(this).parents()).data();
      
      $("#modalTitle").html("Modificar Condición");
      $("#inputCondicion").val(data.name);
      $("#inputCondicion").data("id", data.id);
      $("#inputCondicion").attr('placeholder', 'Modificar Condición');
      $('#modalForm').modal('show');
    });

    // validacion de form
    $('#condicionForm').validate({
      submitHandler: function (form) {
        let formData = $(form).serializeArray();
        let id = $("#inputCondicion").data("id");

        if (id === "") {                          // agregar condicion
          grabar_datos("{{ route('employee-status.store') }}", 'POST', formData);
        }
        else {                                    // editar cargo
          let ruta = "{{ route('employee-status.update', ['employee_status' => 'valor']) }}";

          ruta = ruta.replace('valor', id);
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
          required: "Debes ingresar el nombre de la condición."
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
    
    // boton eliminar condicion
    $("#dt-employee-status tbody").on("click",".eliminar",function() {
      let data = datatable.row($(this).parents()).data();

      lib_Confirmar("Seguro de ELIMINAR la condición: " + data.name + "?")
      .then((result) => {
        if (result.isConfirmed) {
          let ruta = "{{ route('employee-status.destroy', ['employee_status' => 'valor']) }}";

          ruta = ruta.replace('valor', data.id);
          
          $.ajax({
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url: ruta,
            type: 'DELETE',
            dataType:'json',
            success: function(resp){
              datatable.ajax.reload();
              lib_ShowMensaje("Condición eliminada.");
            }
          });
        }
      })
    });
  });
</script>
@endsection