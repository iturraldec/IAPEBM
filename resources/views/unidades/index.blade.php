@extends('adminlte::page')

@section('title', 'Unidades Operativas')

@section('content_header')
  <div class="row">
    <div class="col-6">
      <h3>Listado de las Unidades Operativas.</h3>
    </div>
  
    <div class="col-6 d-flex justify-content-end">
      <button type="button" 
              id="btnAgregar" 
              class="btn btn-sm btn-primary mr-2">
        <i class="fas fa-plus-square"></i> Agregar Unidad
      </button>
    </div>
  </div>
@endsection

@section('content')
  <div class="row justify-content-center">
    <div class="col-6">
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

  <!-- agregar unidad operativa -->
  <div class="modal fade" id="modalForm" 
      data-backdrop="static"
      tabindex="-1" 
      aria-labelledby="staticBackdropLabel" 
      aria-hidden="true"
  >
  <form id="formUnidad">
    @csrf
    <input type="hidden" id="inputId" name="id">

    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 id="modalTitle" class="modal-title">Default Modal</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-3">
              <label for="inputCode">Código</label>
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
              <div class="form-group mb-2">
                <label for="inputName">Unidad Operativa</label>
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
              </div>
            </div>
          </div>
        </div>

        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" data-dismiss="modal">Salir</button>
          <button class="btn btn-danger">Grabar</button>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
  </form>
  </div>
  <!-- fin de agregar unidad operativa -->

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
                  let btn_editar = '<button type="button" class="editar btn btn-secondary btn-sm mr-1" title="Editar Unidad Operativa"><i class="fas fa-edit"></i></button>';
                  let btn_eliminar = '<button class="eliminar btn btn-danger btn-sm"  title="Eliminar Unidad Operativa"><i class="fas fa-trash-alt"></i></button>';
                  
                  return  btn_editar + btn_eliminar;
                },
           "orderable": false
          }
        ]
    });

    //////////////////////////////////////////////
    // agregar unidad
    //////////////////////////////////////////////

    $("#btnAgregar").click(function() {
      $("#modalTitle").html("Agregar Unidad Operativa")
      $("#inputId").val("0");
      $("#inputCode").val("");
      $("#inputName").val("");
      $('#modalForm').modal('show');
    });

    //////////////////////////////////////////////
    // editar unidad operativa
    //////////////////////////////////////////////

    $("#dt-unidades tbody").on("click", ".editar", function() {
      let data = datatable.row($(this).parents()).data();

      $("#modalTitle").html("Modificar Unidad Operativa");
      $("#inputId").val(data.id);
      $("#inputCode").val(data.code);
      $("#inputName").val(data.name);
      $('#modalForm').modal('show');
    });

    //////////////////////////////////////////////
    // grabar unidad operativa
    //////////////////////////////////////////////

    $("#formUnidad").submit(function(e) {
      e.preventDefault();

      let formData  = new FormData(this);
      let ruta = '';

      if (formData.get("id") == '0') {                    // agrego unidad operativa
        ruta = "{{ route('unidades.store') }}";
      }
      else {                                              // modifico unidad operativa
        ruta = "{{ route('unidades.update', ['unidade' => '.valor']) }}";
        ruta = ruta.replace('.valor', formData.get("id"));
        formData.append('_method', 'PUT');
      }

      fetch(ruta, {
        headers: {
          'Accept' : 'application/json'
        },
        method: 'POST',
        body: formData
      })
      .then(function(response) {
        if(response.ok) {
          $('#modalForm').modal('hide');
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
   
    // eliminar unidad operativa
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