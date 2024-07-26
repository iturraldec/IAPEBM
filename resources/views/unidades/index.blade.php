@extends('adminlte::page')

@section('title', 'Unidades Operativas')

@section('content_header')
  <h1>Listado de las Unidades Operativas.</h1>
@endsection

@section('content')
  <div class="row justify-content-center">
    <div class="col-6">
      <form id="formAddUnidad">
        @csrf

      <div class="row">
        <div class="col-3">
          <input type="text"
                id="inputCode"
                name="code" 
                class="form-control" 
                maxlength="20" 
                placeholder="Código"
                onkeyup="this.value = this.value.toUpperCase();"
                title="Código de la Unidad Operativa"
                required
          >
        </div>

        <div class="col-9">
          <div class="input-group mb-2">
            <input type="text"
                id="inputName"
                name="name"
                class="form-control"
                maxlength="255"
                placeholder="Ingresa nueva unidad operativa"
                onkeyup="this.value = this.value.toUpperCase();"
                title="Nombre de la Unidad Operativa"
                required
            />
    
            <div class="input-group-append">
              <button class="input-group-text btn btn-primary btn-sm" title="Agregar Unidad Operativa"><i class="fas fa-plus-square"></i></button>
            </div>
          </div>
        </div>
      </div>

      </form>

      <table id="dt-unidades" class="table table-hover border border-dark">
        <thead class="thead-dark text-center">
          <tr>
            <th scope="col">ID</th>
            <th scope="col">Código</th>
            <th scope="col">Nombre</th>
            <th scope="col" class="col-sm-2">Acción</th>
          </tr>
        </thead>
        <tbody></tbody>
      </table>
    </div>
  </div> 

  @include('unidades.edit')

@endsection

@section('js')
<script>
  $(document).ready(function () {
    //////////////////////////////////////////////    
    // mascara: latitud
    //////////////////////////////////////////////

    $("#inputELatitud").inputmask(lib_decimalMask());

    //////////////////////////////////////////////
    // mascara: longitud
    //////////////////////////////////////////////

    $("#inputELongitud").inputmask(lib_decimalMask());

    //////////////////////////////////////////////
    // datatable: unidades operativas
    //////////////////////////////////////////////

    var datatable = $('#dt-unidades').DataTable({
        "ajax": "{{ route('unidades.index') }}",
        "columns": [
          {"data": "id", visible: false},
          {"data": "code", "width": '20%'},
          {"data": "name", "width": '55%'},
          {"data":null,
           "className" : "dt-body-center",  
           "render": function ( data, type, row, meta ) {
                  let btn_editar = '<button type="button" class="editar btn btn-primary btn-sm mr-1" title="Editar Unidad Operativa"><i class="fas fa-edit"></i></button>';
                  let btn_eliminar = '<button class="eliminar btn btn-danger btn-sm"  title="Eliminar Unidad Operativa"><i class="fas fa-trash-alt"></i></button>';
                  
                  return  btn_editar + btn_eliminar;
                },
           "orderable": false
          }
        ]
    });

    //////////////////////////////////////////////
    // datatable: unidades operativas especificas
    //////////////////////////////////////////////

    var datatable2 = $('#dt-unidades-e').DataTable({
        info:false,
        paging: false,
        searching: false,
        "ajax": "{{ route('unidades.index') }}",
        "columns": [
          {"data": "id", visible: false},
          {"data": "code", "width": '20%'},
          {"data": "name", "width": '55%'},
          {"data":null,
           "className" : "dt-body-center",  
           "render": function ( data, type, row, meta ) {
                  let btn_eliminar = '<button class="eliminar btn btn-danger btn-sm"  title="Eliminar Unidad Operativa"><i class="fas fa-trash-alt"></i></button>';
                  
                  return  btn_eliminar;
                },
           "orderable": false
          }
        ]
    });

    //////////////////////////////////////////////
    // agregar unidad operativa
    //////////////////////////////////////////////

    $("#formAddUnidad").submit(function(e) {
      e.preventDefault();

      let formData = new FormData(this);

      fetch("{{ route('unidades.store') }}", {
        headers: {
          'Accept' : 'application/json'
        },
        method: 'POST',
        body: formData
      })
      .then(function(response) {
        if(response.ok) {
          $("#inputCode").val("");
          $("#inputName").val("");
          datatable.ajax.reload();  
          response.json().then(r => lib_ShowMensaje(r.message));
        }
        else {
          response.text().then(r => {
            let errores = JSON.parse(r);

            for (let propiedad in errores.errors) {
              lib_toastr(errores.errors[propiedad]);
            }
          });
        }
      });
    });

    //////////////////////////////////////////////
    // editar unidad operativa
    //////////////////////////////////////////////

    $("#dt-unidades tbody").on("click", ".editar", function() {
      let data = datatable.row($(this).parents()).data();
      let ruta = "{{ route('unidades.edit', ['unidade' => '.valor']) }}";

      ruta = ruta.replace('.valor', data.id);
      fetch(ruta, {
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
      })
      .then(response => response.json())
      .then(r => {
        console.log(r);
        $("#modalTitle").html("U.O.: " + data.name);
        $("#padreId").val(data.id);
        $("#inputECode").val("");
        $("#inputEName").val("");
        $("#inputELatitud").val("");
        $("#inputELongitud").val("");
        $('#modalForm').modal('show');
      });
    });

    //////////////////////////////////////////////
    // agregar unidad operativa especifica
    //////////////////////////////////////////////

    $("#formEditUnidad").submit(function(e) {
      e.preventDefault();

      let formData = new FormData(this);
console.log(formData)
/*       fetch("{{ route('unidades.store') }}", {
        headers: {
          'Accept' : 'application/json'
        },
        method: 'POST',
        body: formData
      })
      .then(function(response) {
        if(response.ok) {
          $("#inputCode").val("");
          $("#inputName").val("");
          datatable.ajax.reload();  
          response.json().then(r => lib_ShowMensaje(r.message));
        }
        else {
          response.text().then(r => {
            let errores = JSON.parse(r);

            for (let propiedad in errores.errors) {
              lib_toastr(errores.errors[propiedad]);
            }
          });
        }
      }); */
    });

    // validacion de form
    /* $('#condicionForm').validate({
      submitHandler: function (form) {
        let formData = $(form).serializeArray();
        let id = $("#inputCondicion").data("id");

        if (id === "") {                          // agregar condicion
          grabar_datos("{{ route('unidades.store') }}", 'POST', formData);
        }
        else {                                    // editar cargo
          let ruta = "{{ route('unidades.update', ['unidade' => 'valor']) }}";

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
 */    
    // boton eliminar unidad operativa
    $("#dt-unidades tbody").on("click",".eliminar",function() {
      let data = datatable.row($(this).parents()).data();
      let message = 'Los empleados asignados a: ' + data.name + ', quedaran sin asignación.';

      lib_Confirmar(message + "\nSeguro de ELIMINAR: " + data.name + "?")
      .then((result) => {
        if (result.isConfirmed) {
          let ruta = "{{ route('unidades.destroy', ['unidade' => '.valor']) }}";

          ruta = ruta.replace('.valor', data.id);
          
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
      });
    });
  });
</script>
@endsection