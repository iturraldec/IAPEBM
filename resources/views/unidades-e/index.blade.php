@extends('adminlte::page')

@section('title', 'Unidades Operativas Específicas')

@section('content_header')
  <div class="row">
    <div class="col-8">
      <h3>Listado de Unidades Operativas Específicas.</h3>
    </div>
  
    <div class="col-4 d-flex justify-content-end">
      <button type="button" 
              id="btnAgregar" 
              class="btn btn-sm btn-primary mr-2">
        <i class="fas fa-plus-square"></i> Agregar U.O.E.
      </button>
    </div>
  </div>
@endsection

@section('content')
  <div class="row justify-content-center">
    <div class="col-8">

      <label for="selectUnidades">Unidades Operativas Generales</label>
      <select id="selectUnidades" class="form-control mb-2">
        <option value="0" selected>SELECCIONE LA UNIDAD</option>
        @foreach ($unidades as $unidad)
          <option value="{{ $unidad->id }}">{{ $unidad->name }}</option>
        @endforeach
      </select>

      <table id="dt-unidades" class="table table-hover border border-dark">
        <thead class="thead-dark text-center">
          <tr>
            <th scope="col">ID</th>
            <th scope="col">Código</th>
            <th scope="col">Nombre</th>
            <th scope="col">Latitud</th>
            <th scope="col">Longitud</th>
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

    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 id="modalTitle" class="modal-title">?</h4>
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
                    title="Código de la Unidad Operativa Específica"
                    required
              >
            </div>
    
            <div class="col-9">
              <div class="form-group mb-2">
                <label for="inputName">Unidad Operativa Específica</label>
                <input type="text"
                    id="inputName"
                    name="name"
                    class="form-control"
                    maxlength="255"
                    placeholder="Ingresa nueva unidad operativa"
                    onkeyup="this.value = this.value.toUpperCase();"
                    title="Nombre de la Unidad Operativa Específica"
                    required
                />
              </div>
            </div>

            <div class="col-6">
              <div class="form-group mb-2">
                <label for="inputLatitud">Latitud</label>
                <input type="text"
                    id="inputLatitud"
                    name="latitude"
                    class="form-control"
                    placeholder="Ingresa la latitud"
                    title="Latitud de la Unidad Operativa Específica"
                    required
                />
              </div>
            </div>

            <div class="col-6">
              <div class="form-group mb-2">
                <label for="inputLongitud">Longitud</label>
                <input type="text"
                    id="inputLongitud"
                    name="length"
                    class="form-control"
                    placeholder="Ingresa la longitud"
                    title="Longitud de la Unidad Operativa Específica"
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
    var rutaBase = "{{ route('unidades-e.getAll', ['padre_id' => '.valor']) }}";
    var unidadId = 0;

    //////////////////////////////////////////////    
    // mascara: latitud
    //////////////////////////////////////////////

    $("#inputLatitud").inputmask(lib_decimalMask());

    //////////////////////////////////////////////
    // mascara: longitud
    //////////////////////////////////////////////

    $("#inputLongitud").inputmask(lib_decimalMask());

    //////////////////////////////////////////////
    // datatable: unidades operativas
    //////////////////////////////////////////////

    var datatable = $('#dt-unidades').DataTable({
        "columns": [
          {"data": "id", visible: false},
          {"data": "code", width: "10%"},
          {"data": "name", width: "55%"},
          {"data": "latitude", width: "10%"},
          {"data": "length", width: "10%"},
          {"data":null,
           "className" : "dt-body-center",  
           "render": function ( data, type, row, meta ) {
                  let btn_editar = '<button type="button" class="editar btn btn-secondary btn-sm mr-1" title="Editar Unidad Operativa"><i class="fas fa-edit"></i></button>';
                  let btn_eliminar = '<button class="eliminar btn btn-danger btn-sm"  title="Eliminar Unidad Operativa"><i class="fas fa-trash-alt"></i></button>';
                  
                  return  btn_editar + btn_eliminar;
                },
           "orderable": false,
           width: "15%"
          }
        ]
    });

    //////////////////////////////////////////////
    // cargar unidades especificas
    //////////////////////////////////////////////

    $("#selectUnidades").change(function() {
      datatable.ajax.url(rutaBase.replace('.valor', $(this).val())).load();
    });

    //////////////////////////////////////////////
    // agregar unidad operativa especifica
    //////////////////////////////////////////////

    $("#btnAgregar").click(function() {
      unidadId = 0;
      $("#modalTitle").html("Agregar Unidad Operativa Específica");
      $('#formUnidad')[0].reset();
      $('#modalForm').modal('show');
    });

    //////////////////////////////////////////////
    // editar unidad operativa especifica
    //////////////////////////////////////////////

    $("#dt-unidades tbody").on("click", ".editar", function() {
      let data = datatable.row($(this).parents()).data();

      unidadId = data.id;
      $("#modalTitle").html("Modificar Unidad Operativa Específica");
      $("#inputCode").val(data.code);
      $("#inputName").val(data.name);
      $("#inputLatitud").val(data.latitude);
      $("#inputLongitud").val(data.length);
      $('#modalForm').modal('show');
    });

    //////////////////////////////////////////////
    // grabar unidad operativa
    //////////////////////////////////////////////

    $("#formUnidad").submit(function(e) {
      e.preventDefault();

      let formData  = new FormData(this);
      let ruta = '';

      if (unidadId == 0) {                                // agrego unidad operativa especifica
        ruta = "{{ route('unidades-e.store') }}";
        formData.append('padre_id', $("#selectUnidades").val());
      }
      else {                                              // modifico unidad operativa
        ruta = "{{ route('unidades-e.update', ['unidades_e' => '.valor']) }}";
        ruta = ruta.replace('.valor', unidadId);
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
   
    // eliminar unidad operativa especifica
    $("#dt-unidades tbody").on("click",".eliminar",function() {
      let data = datatable.row($(this).parents()).data();
      let message = 'Los empleados asignados a: ' + data.name + ', quedaran sin asignación.';

      lib_Confirmar(message + "\nSeguro de ELIMINAR: " + data.name + "?")
      .then((result) => {
        if (result.isConfirmed) {
          let ruta = "{{ route('unidades-e.destroy', ['unidades_e' => '.valor']) }}";

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