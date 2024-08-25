@extends('adminlte::page')

@section('title', 'Listado de Reposos')

@section('content_header')
  <div class="row">
    <div class="col-6">
      <h3>Listado de Reposos.</h3>
    </div>

    <div class="col-6 d-flex justify-content-end">
      <button type="button" 
              id="btnAgregar" 
              class="btn btn-sm btn-primary mr-2">
        <i class="fas fa-plus-square"></i> Agregar Reposo
      </button>
    </div>
  </div>
@endsection

@section('content')
  <div class="row justify-content-center">
    <div class="col-10">
      <table id="dt-reposos" class="table table-hover border border-dark">
        <thead class="thead-dark text-center">
          <tr>
            <th scope="col">ID</th>
            <th scope="col" style="width:10%">Código</th>
            <th scope="col" style="width:70%">Diagnóstico</th>
            <th scope="col" style="width:10%"></th>
          </tr>
        </thead>
        <tbody>
  
        </tbody>
      </table>
    </div>
  </div>

  <!-- agregar/editar reposo -->
  <div class="modal fade" id="modalForm" 
      data-backdrop="static"
      tabindex="-1" 
      aria-labelledby="staticBackdropLabel" 
      aria-hidden="true">

    <form id="formReposo">
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
            <div class="row">
              <div class="col-4">
                <div class="form-group">
                  <label for="inputCodigo">Código*</label>
                  <input type="text" 
                        id="inputCodigo" 
                        name="codigo"
                        class="form-control"
                        placeholder="Ingresa el código"
                        title="Código del reposo"
                        onkeyup="this.value = this.value.toUpperCase();"
                        required
                  >
                </div>
              </div>

              <div class="col-12">
                <div class="form-group">
                  <label for="inputDiagnostico">Diagnóstico*</label>
                  <textarea name="diagnostico" 
                            id="inputDiagnostico"
                            class="form-control"
                            placeholder="Ingresa el diagnóstico"
                            title="Diagnóstico"
                            onkeyup="this.value = this.value.toUpperCase();"
                            required
                  ></textarea>
                </div>
              </div>
            </div>
          </div>

          <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-default" data-dismiss="modal">Salir</button>
            <button class="btn btn-danger">Grabar</button>
          </div>
        </div>
      </div>
    </form>
  </div>

@endsection

@section('js')
<script>
  $(document).ready(function () {
    //
    var reposoId = 0;

    // datatable
    var datatable = $('#dt-reposos').DataTable({
        processing: true,
        serverSide: true,
        "ajax": "{{ route('reposos.index') }}",
        "columns": [
          {"data": "id", "visible": false},
          {"data": "codigo"},
          {"data": "diagnostico"},
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

    // agregar reposo
    $("#btnAgregar").click(function() {
      $("#modalTitle").html("Agregar Reposo");
      $("#inputCodigo").val("");
      $("#inputCodigo").attr("placeholder", "Ingrese código");
      $("#inputDiagnostico").val("");
      $("#inputDiagnostico").attr("placeholder", "Ingrese diagnóstico");
      $('#modalForm').modal('show');
    });

    // editar reposo
    $("#dt-reposos tbody").on("click", ".editar", function() {
      let data = datatable.row($(this).parents()).data();
      
      reposoId = data.id;
      $("#modalTitle").html("Modificar Reposo");
      $("#inputCodigo").val(data.codigo);
      $("#inputDiagnostico").val(data.diagnostico);
      $('#modalForm').modal('show');
    });

    // grabar los datos al agregar/modificar
    $("#formReposo").submit(function(e) {
      e.preventDefault();

      let ruta = '';
      let formData = new FormData(this);

      if (reposoId == 0) {                                   // agrego reposo
        ruta = "{{ route('reposos.store') }}";
      }
      else {                                                // modifico cargo
        ruta = "{{ route('reposos.update', ['reposo' => '.valor']) }}";
        ruta = ruta.replace('.valor', reposoId);
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
    
    // eliminar reposo
    $("#dt-reposos tbody").on("click",".eliminar",function() {
      let data = datatable.row($(this).parents()).data();

      lib_Confirmar("Seguro de ELIMINAR el Reposo: " + data.codigo + "?")
      .then((result) => {
        if (result.isConfirmed) {
          let ruta = "{{ route('reposos.destroy', ['reposo' => '.valor']) }}";

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