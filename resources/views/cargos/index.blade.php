@extends('adminlte::page')

@section('title', 'Listado de Cargos')

@section('content_header')
  <h1>Listado de Cargos de Empleados.</h1>
@endsection

@section('content')
  <div class="row justify-content-center">
    <div class="col-8">
      <table id="dt-cargos" class="table table-hover border border-dark">
        <thead class="thead-dark text-center">
          <tr>
            <th scope="col">ID</th>
            <th scope="col">Nombre</th>
            <th scope="col">Activo</th>
            <th scope="col" class="col-sm-2">Acción</th>
          </tr>
        </thead>
        <tbody>
  
        </tbody>
      </table>
    </div>
  </div>

@include('cargos.edit')

@endsection

@section('js')
<script>
  $(document).ready(function () {
    // mascara del cargo
    $("#inputCargo").inputmask(lib_characterMask())

    // datatable
    let customButton = '<button id="btn-agregar" class="btn btn-primary">Agregar Cargo</button>';
    let datatable = $('#dt-cargos').DataTable({
        "dom": '<"d-flex justify-content-between"lr<"#dt-add-button">f>t<"d-flex justify-content-between"ip>',
        "ajax": "{{ route('cargos.index') }}",
        "columns": [
          {"data": "id", "orderable": false},
          {"data": "name"},
          {"data":null,
           "className" : "dt-body-center",
           "render": function ( data, type, row, meta ) {              
              return  data.activo ? "SI" : "NO";
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

    // boton agregar cargo
    $("#btn-agregar").click(function() {
      $("#modalTitle").html("Agregar Cargo");
      $("#inputCargo").val("");
      $("#chkActivo").prop("checked", true);
      $("#inputCargo").data("id", "");
      $("#inputCargo").attr("placeholder", "Ingrese nombre del Cargo");
      $('#modalForm').modal('show');
    });

    // boton editar cargo
    $("#dt-cargos tbody").on("click", ".editar", function() {
      let data = datatable.row($(this).parents()).data();
      
      $("#modalTitle").html("Modificar Cargo");
      $("#inputCargo").val(data.name);
      $("#chkActivo").prop("checked", data.activo);
      $("#inputCargo").data("id", data.id);
      $("#inputCargo").attr('placeholder', 'Modificar Cargo');
      $('#modalForm').modal('show');
    });

    // validacion de form
    $('#cargoForm').validate({
      submitHandler: function (form) {
        let formData = $(form).serializeArray();
        let id = $("#inputCargo").data("id");

        if (id === "") {                          // agregar cargo
          grabar_datos("{{ route('cargos.store') }}", 'POST', formData);
        }
        else {                                    // editar cargo
          let ruta = "{{ route('cargos.update', ['cargo' => 'valor']) }}";

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
          required: "Debes ingresar el nombre del cargo."
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
    
    // boton eliminar cargo
    $("#dt-cargos tbody").on("click",".eliminar",function() {
      let data = datatable.row($(this).parents()).data();

      lib_Confirmar("Seguro de ELIMINAR el Cargo: " + data.name + "?")
      .then((result) => {
        if (result.isConfirmed) {
          let ruta = "{{ route('cargos.destroy', ['cargo' => 'valor']) }}";

          ruta = ruta.replace('valor', data.id);
          
          $.ajax({
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url: ruta,
            type: 'DELETE',
            dataType:'json',
            success: function(resp){
              datatable.ajax.reload();
              lib_ShowMensaje("Cargo eliminado.");
            }
          });
        }
      })
    });
  });
</script>
@endsection