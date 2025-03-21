@extends('adminlte::page')

@section('title', 'Constancia de Trabajo: Motivos')

@section('content_header')
  <div class="row">
    <div class="col-6">
      <h3>Listado de Motivos.</h3>
    </div>

    <div class="col-6 d-flex justify-content-end">
      <button type="button" 
              id="btnAgregar" 
              class="btn btn-sm btn-primary mr-2">
        <i class="fas fa-plus-square"></i> Agregar Motivo
      </button>
    </div>
  </div>
@endsection

@section('content')
  <div class="row justify-content-center">
    <div class="col-7">
      <table id="dt-motivos" class="table table-hover border border-dark">
        <thead class="thead-dark text-center">
          <tr>
            <th scope="col">ID</th>
            <th scope="col">Motivos de las Constancias de Trabajo</th>
            <th scope="col" class="col-sm-2">Acción</th>
          </tr>
        </thead>
        <tbody>
  
        </tbody>
      </table>
    </div>
  </div>

  <!-- agregar/editar motivo -->
  <div class="modal fade" id="modalForm" 
      data-backdrop="static"
      tabindex="-1" 
      aria-labelledby="staticBackdropLabel" 
      aria-hidden="true"
  >
  <form id="formMotivo">
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
            <label for="inputMotivo">Motivo</label>
            <input type="text"
                id="inputMotivo"
                name="motivo"
                class="form-control"
                maxlength="100"
                placeholder="Ingresa el nuevo motivo"
                onkeyup="this.value = this.value.toUpperCase();"
                title="Motivo de la constancia"
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
  <!-- fin de agregar motivo -->

@endsection

@section('js')
<script>
  $(document).ready(function () {
    var motivoId = 0;

    // macara del cargo
    $("#inputMotivo").inputmask(lib_characterMask());

    // datatable
    var datatable = $('#dt-motivos').DataTable({
        "ajax": "{{ route('ct.motivos.index') }}",
        "columns": [
          {"data": "id", visible: false},
          {"data": "motivo", width: "70%"},
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

    // agregar motivo
    $("#btnAgregar").click(function() {
      motivoId = 0;
      $("#modalTitle").html("Agregar Motivo");
      $("#inputMotivo").val("");
      $('#modalForm').modal('show');
    });

    // editar motivo
    $("#dt-motivos tbody").on("click", ".editar", function() {
      let data = datatable.row($(this).parents()).data();
      
      $("#modalTitle").html("Modificar Motivo");
      motivoId = data.id;
      $("#inputMotivo").val(data.motivo);
      $('#modalForm').modal('show');
    });

    // enviar formulario
    $('#formMotivo').submit(function(e) {
      e.preventDefault();

      let formData = new FormData(this);
      let ruta = '';

      if (motivoId == 0) {                                  // agrego motivo
        ruta = "{{ route('ct.motivos.store') }}";
      }
      else {                                                // modifico condicion
        ruta = "{{ route('ct.motivos.update', ['ct_motivo' => '.valor']) }}";
        ruta = ruta.replace('.valor', motivoId);
        formData.append('_method', 'PUT');
        console.log(ruta);
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
    
    // boton eliminar condicion
    $("#dt-motivos tbody").on("click", ".eliminar", function() {
      let data = datatable.row($(this).parents()).data();

      lib_Confirmar("Seguro de ELIMINAR el motivo: " + data.motivo + "?")
      .then((result) => {
        if (result.isConfirmed) {
          let ruta = "{{ route('ct.motivos.destroy', ['ct_motivo' => '.valor']) }}";

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