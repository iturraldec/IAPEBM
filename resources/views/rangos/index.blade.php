@extends('adminlte::page')

@section('title', 'Listado de Rangos Policiales')

@section('content_header')
  <h1>Listado de Rangos Policiales.</h1>
@endsection

@section('content')
  <div class="col-8 mx-auto">
    <table id="dt-rangos" class="table table-hover border border-dark">
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

@include('rangos.edit')

@endsection

@section('js')
<script>
  $(document).ready(function () {
    // macara del cargo
    $("#inputRango").inputmask(lib_characterMask())

    // datatable
    let datatable = $('#dt-rangos').DataTable({
        "dom": '<"d-flex justify-content-between"lr<"#dt-add-button">f>t<"d-flex justify-content-between"ip>',
        "ajax": "{{ route('rangos.index') }}",
        "columns": [
          {"data": "id", "orderable": false},
          {"data": "name"},
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

    $("#dt-add-button").html('<button id="btn-agregar" class="btn btn-primary">Agregar Rango</button>');

    // boton agregar rango
    $("#btn-agregar").click(function() {
      $("#modalTitle").html("Agregar Rango");
      $("#inputRango").val("");
      $("#inputRango").data("id", "");
      $("#inputRango").attr("placeholder", "Ingrese nombre del Rango");
      $('#modalForm').modal('show');
    });

    // boton editar rango
    $("#dt-rangos tbody").on("click", ".editar", function() {
      let data = datatable.row($(this).parents()).data();
      
      $("#modalTitle").html("Modificar Rango");
      $("#inputRango").val(data.name);
      $("#inputRango").data("id", data.id);
      $("#inputRango").attr('placeholder', 'Modificar Rango');
      $('#modalForm').modal('show');
    });

    // validacion de form
    $('#rangoForm').validate({
      rules: {
        name: {
          required: true,
          maxlength:255
        },
      },
      messages: {
        name: {
          required: "Debes ingresar el nombre del rango.",
          maxlength: "Debes ingresar máximo 255 caracteres."
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
      },
      submitHandler: function (form) {
        let formData = $(form).serializeArray();
        let id = $("#inputRango").data("id");

        if (id === "") {                          // agregar rango
          grabar_datos("{{ route('rangos.store') }}", 'POST', formData);
        }
        else {                                    // editar cargo
          let ruta = "{{ route('rangos.update', ['rango' => 'valor']) }}";

          ruta = ruta.replace('valor', id);
          grabar_datos(ruta, 'PUT', formData);
        };

        $('#modalForm').modal('hide');
      },
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
    
    // boton eliminar rango
    $("#dt-rangos tbody").on("click",".eliminar",function() {
      let data = datatable.row($(this).parents()).data();

      lib_Confirmar("Seguro de ELIMINAR el Rango: " + data.name + "?")
      .then((result) => {
        if (result.isConfirmed) {
          let ruta = "{{ route('rangos.destroy', ['rango' => 'valor']) }}";

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