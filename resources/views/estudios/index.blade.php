@extends('adminlte::page')

@section('title', 'Tipo de estudios')

@section('content_header')
  <div class="row">
    <div class="col-6">
      <h3>Listado de tipos de estudios.</h3>
    </div>

    <div class="col-6 d-flex justify-content-end">
      <button type="button" 
              id="btnAgregar" 
              class="btn btn-sm btn-primary mr-2">
        <i class="fas fa-plus-square"></i> Agregar tipo
      </button>
    </div>
  </div>
@endsection

@section('content')
  <div class="row justify-content-center">
    <div class="col-7">
      <table id="dt-estudios" class="table table-hover border border-dark">
        <thead class="thead-dark text-center">
          <tr>
            <th scope="col">ID</th>
            <th scope="col">Tipo</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
  
        </tbody>
      </table>
    </div>
  </div>

  <!-- agregar/editar tipo de estudio -->
  <div class="modal fade" id="modalForm" 
      data-backdrop="static"
      tabindex="-1" 
      aria-labelledby="staticBackdropLabel" 
      aria-hidden="true"
  >
  <form id="formTipo">
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
          <div class="form-group">
            <label for="inputTipo">Tipo</label>
            <input type="text"
                id="inputTipo"
                name="tipo"
                class="form-control"
                maxlength="100"
                onkeyup="this.value = this.value.toUpperCase();"
                title="Tipo de estudio"
                required
            />
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
  <!-- fin de agregar condicion -->

@endsection

@section('js')
<script>
  $(document).ready(function () {
    var tipoId = 0;

    // macara del tipo
    $("#inputTipo").inputmask(lib_characterMask());

    // datatable
    var datatable = $('#dt-estudios').DataTable({
        "ajax": "{{ route('estudio-types.index') }}",
        "columns": [
          {"data": "id", visible: false},
          {"data": "tipo", width: "70%"},
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

    // agregar tipo de estudio
    $("#btnAgregar").click(function() {
      tipoId = 0;
      $("#modalTitle").html("Agregar tipo de estudio");
      $("#inputTipo").val("");
      $('#modalForm').modal('show');
    });

    // editar tipo de estudio
    $("#dt-estudios tbody").on("click", ".editar", function() {
      let data = datatable.row($(this).parents()).data();
      
      $("#modalTitle").html("Modificar el tipo de estudio");
      tipoId = data.id;
      $("#inputTipo").val(data.tipo);
      $('#modalForm').modal('show');
    });

    // enviar formulario
    $('#formTipo').submit(function(e) {
      e.preventDefault();

      let formData = new FormData(this);
      let ruta = '';

      if (tipoId == 0) {                                    // agrego tipo de estudio
        ruta = "{{ route('estudio-types.store') }}";
      }
      else {                                                // modifico tipo de estudio
        ruta = "{{ route('estudio-types.update', ['estudio' => '.valor']) }}";
        ruta = ruta.replace('.valor', tipoId);
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
    
    // boton eliminar tipo de estudio
    $("#dt-estudios tbody").on("click",".eliminar",function() {
      let data = datatable.row($(this).parents()).data();

      lib_Confirmar("Seguro de ELIMINAR el tipo de estudio: " + data.tipo + "?")
      .then((result) => {
        if (result.isConfirmed) {
          let ruta = "{{ route('estudio-types.destroy', ['estudio' => '.valor']) }}";

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
      })
    });
  });
</script>
@endsection