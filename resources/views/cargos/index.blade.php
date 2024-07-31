@extends('adminlte::page')

@section('title', 'Listado de Cargos')

@section('content_header')
  <div class="row">
    <div class="col-6">
      <h3>Listado de Cargos.</h3>
    </div>

    <div class="col-6 d-flex justify-content-end">
      <button type="button" 
              id="btnAgregar" 
              class="btn btn-sm btn-primary mr-2">
        <i class="fas fa-plus-square"></i> Agregar Cargo
      </button>
    </div>
  </div>
@endsection

@section('content')
  <div class="row justify-content-center">
    <div class="col-7">
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

  <!-- agregar/editar cargo -->
  <div class="modal fade" id="modalForm" 
      data-backdrop="static"
      tabindex="-1" 
      aria-labelledby="staticBackdropLabel" 
      aria-hidden="true"
  >
  <form id="formCargo">
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
              <label for="inputCargo">Cargo</label>
              <input type="text" 
                    id="inputCargo" 
                    name="name"
                    class="form-control"
                    placeholder="Ingresa el cargo"
                    title="Nombre del cargo"
                    onkeyup="this.value = this.value.toUpperCase();"
                    required
              >
            </div>

            <div class="icheck-primary d-inline">
              <input type="checkbox" id="chkActivo" name="activo">
              <label for="chkActivo">Activo</label>
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
    var cargoId = 0;

    // mascara del cargo
    $("#inputCargo").inputmask(lib_characterMask())

    // datatable
    var datatable = $('#dt-cargos').DataTable({
        "ajax": "{{ route('cargos.index') }}",
        "columns": [
          {"data": "id", "visible": false},
          {"data": "name", width: "55%"},
          {"data":null,
           "className" : "dt-body-center",
           "render": function ( data, type, row, meta ) {              
              return  data.activo ? "SI" : "NO";
            },
           "orderable": false,
           width: "15%"
          },
          {"data":null,
           "className" : "dt-body-center",  
           "render": function ( data, type, row, meta ) {
                  let btn_editar = '<button type="button" class="editar btn btn-primary btn-sm mr-1"><i class="fas fa-edit"></i></button>';
                  let btn_eliminar = '<button class="eliminar btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i></button>';
                  
                  return  btn_editar + btn_eliminar;
                },
           "orderable": false,
           width: "30%"
          }
        ]
    });

    // agregar cargo
    $("#btnAgregar").click(function() {
      cargoId = 0;
      $("#modalTitle").html("Agregar Cargo");
      $("#inputCargo").val("");
      $("#chkActivo").prop("checked", true);
      $("#inputCargo").attr("placeholder", "Ingrese nombre del Cargo");
      $('#modalForm').modal('show');
    });

    // editar cargo
    $("#dt-cargos tbody").on("click", ".editar", function() {
      let data = datatable.row($(this).parents()).data();
      
      cargoId = data.id;
      $("#modalTitle").html("Modificar Cargo");
      $("#inputCargo").val(data.name);
      $("#chkActivo").prop("checked", data.activo);
      $("#inputCargo").attr('placeholder', 'Modificar Cargo');
      $('#modalForm').modal('show');
    });

    // grabar los datos al agregar/modificar
    $("#formCargo").submit(function(e) {
      e.preventDefault();

      let ruta = '';
      let formData = new FormData(this);

      if (cargoId == 0) {                                   // agrego cargo
        ruta = "{{ route('cargos.store') }}";
      }
      else {                                                // modifico cargo
        ruta = "{{ route('cargos.update', ['cargo' => '.valor']) }}";
        ruta = ruta.replace('.valor', cargoId);
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
    
    // eliminar cargo
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
              lib_ShowMensaje(resp.message);
            }
          });
        }
      })
    });
  });
</script>
@endsection