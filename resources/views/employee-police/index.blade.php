@extends('adminlte::page')

@section('title', 'Empleados Uniformados')

@section('content_header')
  <h1>Listado de Empleados Uniformados.</h1>
@endsection

@section('content')
  <div class="col-8 mx-auto">
    <table id="dtEmpleados" class="table table-hover border border-dark">
      <thead class="thead-dark text-center">
        <tr>
          <th scope="col">ID</th>
          <th scope="col">Código de Nómina</th>
          <th scope="col">Cédula</th>
          <th scope="col">Nombres y Apellidos</th>
          <th scope="col">Imagen</th>
          <th scope="col" class="col-sm-2">Acción</th>
        </tr>
      </thead>
      <tbody>

      </tbody>
    </table>
  </div>

@endsection

@section('js')
<script>
  $(document).ready(function () {
    ///////////////////////////////////////////////////////////
    // datatable
    ///////////////////////////////////////////////////////////

    var datatable = $('#dtEmpleados').DataTable({
        "dom": '<"d-flex justify-content-between"l<"#dt-add-button">f>t<"d-flex justify-content-between"ip>',
        serverSide: true,
        "ajax": "{{ route('employees-police.index') }}",
        "columns": [
          {"data": "id", visible: false},
          {"data": "codigo_nomina"},
          {"data": "person.cedula"},
          {"data": null,
           "render": function(data, type, row, meta) {
                  let nombre = `${data.person.first_last_name} ${data.person.second_last_name}, ${data.person.first_name} ${data.person.second_name}`;

                  return nombre;
            }
          },
          {"data": null,
            "render": function(data, type, row, meta) {              
              let imagen = "{{ asset('') }}" + data.person.imagef;

              return `<img src="${imagen}" class="img-thumbnail border border-dark" width="80" height="auto">`;
            },
            "orderable": false
          },
          {"data":null,
           "className" : "dt-body-center",
           "render": function ( data, type, row, meta ) {
                  let rutaView = "{{ route('employees-police.show', ['employees_polouse' => 'valor']) }}";
                  let rutaEdit = "{{ route('employees-police.edit', ['employees_polouse' => 'valor']) }}";

                  rutaView = rutaView.replace('valor', data.id);
                  rutaEdit = rutaEdit.replace('valor', data.id);
                  let btn_view = `<a class="ver btn btn-secondary btn-sm mr-1" href="${rutaView}" target="_blank"><i class="fas fa-eye"></i></a>`;
                  let btn_editar = `<a class="btn btn-primary btn-sm mr-1" href="${rutaEdit}" target="_blank"><i class="fas fa-edit"></i></a>`;
                  let btn_eliminar = '<button class="eliminar btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i></button>';
                  
                  return  btn_view + btn_editar + btn_eliminar;
                },
           "orderable": false,
           "width" : "8em"
          }
        ]
    });

    $("#dt-add-button").html(`<a href="#" id="btnAgregarEmpleado" class="btn btn-primary">Agregar Empleado Uniformado</a>`);

    ///////////////////////////////////////////////////////////////////
    // agregar empleado policial
    ///////////////////////////////////////////////////////////////////

    $("#btnAgregarEmpleado").on('click', function() {
      window.open("{{ route('employees-police.create') }}");
    });

    ///////////////////////////////////////////////////////////////////
    // eliminar empleado policial
    ///////////////////////////////////////////////////////////////////

    $("#dtEmpleados tbody").on("click",".eliminar",function() {
      let data = datatable.row($(this).parents()).data();

      lib_Confirmar(`Seguro de ELIMINAR a: ${data.person.first_name} ${data.person.firts_last_name}?`)
      .then((result) => {
        if (result.isConfirmed) {
          let ruta = "{{ route('employees-police.destroy', ['employees_polouse' => 'valor']) }}";

          ruta = ruta.replace('valor', data.id);
          
          $.ajax({
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url: ruta,
            type: 'DELETE',
            dataType:'json',
            success: function(resp){
              datatable.ajax.reload();
              lib_ShowMensaje("Empleado Policial eliminado.");
            }
          });
        }
      })
    });
  });
</script>
@endsection