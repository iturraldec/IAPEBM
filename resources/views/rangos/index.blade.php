@extends('adminlte::page')

@section('title', 'Listado de Rangos')

@section('content_header')
  <div class="row">
    <div class="col-6">
      <h3>Listado de Rangos.</h3>
    </div>
  
    <div class="col-6 d-flex justify-content-end">
      <button type="button" 
              id="btnAgregar" 
              class="btn btn-sm btn-primary mr-2">
        <i class="fas fa-plus-square"></i> Agregar Rango
      </button>
    </div>
  </div>
@endsection

@section('content')
  <div class="col-6 mx-auto">
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

  <!-- agregar/editar rango -->
  <div class="modal fade" id="modalForm" 
      data-backdrop="static"
      tabindex="-1" 
      aria-labelledby="staticBackdropLabel" 
      aria-hidden="true"
  >
    <form id="formRango">
      @csrf

        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="modalTitle">?</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>

            <div class="modal-body">		
              <div class="form-group">
                <label for="inputRango">Rango</label>
                <input type="text" 
                      id="inputRango" 
                      name="name"
                      class="form-control"
                      placeholder="Ingresa el rango"
                      title="Nombre del rango"
                      onkeyup="this.value = this.value.toUpperCase();"
                      required
                >
              </div>            
            </div>

            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Salir</button>
              <button class="btn btn-danger">Grabar</button>
            </div>
          </div>
        </div>
    </div>
  </form>
@endsection

@section('js')
<script>
  $(document).ready(function () {
    var rangoId = 0;

    // macara del cargo
    $("#inputRango").inputmask(lib_characterMask())

    // datatable
    var datatable = $('#dt-rangos').DataTable({
        "ajax": "{{ route('rangos.index') }}",
        "columns": [
          {"data": "id", "visible": false},
          {"data": "name", width: "70%"},
          {"data":null,
           "className" : "dt-body-center",
           "render": function ( data, type, row, meta ) {
                  let btn_editar = '<button type="button" class="editar btn btn-secondary btn-sm mr-1"><i class="fas fa-edit"></i></button>';
                  let btn_eliminar = '<button class="eliminar btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i></button>';
                  
                  return  btn_editar + btn_eliminar;
                },
           "orderable": false
          }
        ]
    });

    // agregar rango
    $("#btnAgregar").click(function() {
      rangoId = 0;
      $("#modalTitle").html("Agregar Rango");
      $("#inputRango").val("");
      $('#modalForm').modal('show');
    });

    // editar cargrango
    $("#dt-rangos tbody").on("click", ".editar", function() {
      let data = datatable.row($(this).parents()).data();
      
      rangoId = data.id;
      $("#modalTitle").html("Modificar Rango");
      $("#inputRango").val(data.name);
      $('#modalForm').modal('show');
    });

    // grabar los datos al agregar/modificar
    $("#formRango").submit(function(e) {
      e.preventDefault();

      let ruta = '';
      let formData = new FormData(this);

      if (rangoId == 0) {                                   // agrego rango
        ruta = "{{ route('rangos.store') }}";
      }
      else {                                                // modifico rango
        ruta = "{{ route('rangos.update', ['rango' => '.valor']) }}";
        ruta = ruta.replace('.valor', rangoId);
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
    
    // eliminar rango
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
              lib_ShowMensaje(resp.message);
            }
          });
        }
      })
    });
  });
</script>
@endsection