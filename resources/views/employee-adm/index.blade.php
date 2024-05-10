@extends('adminlte::page')

@section('title', 'Emppleados Administrativos')

@section('content_header')
  <h1>Listado de Empleados Administrativos.</h1>
@endsection

@section('content')
  <div class="col-8 mx-auto">
    <table id="dtEmpleados" class="table table-hover border border-dark">
      <thead class="thead-dark text-center">
        <tr>
          <th scope="col">ID</th>
          <th scope="col">Código</th>
          <th scope="col">Cédula</th>
          <th scope="col">Nombres y Apellidos</th>
          <th scope="col" class="col-sm-2">Acción</th>
        </tr>
      </thead>
      <tbody>

      </tbody>
    </table>
  </div>

@include('employee-adm.edit')

@endsection

@section('js')
<script>
  $(document).ready(function () {
    var person = {};

    ///////////////////////////////////////////////////////////
    // datatable
    ///////////////////////////////////////////////////////////

    let customButton = '<button id="btn-agregar" class="btn btn-primary">Agregar Empleado Administrativo</button>';
    let datatable = $('#dtEmpleados').DataTable({
        "dom": '<"d-flex justify-content-between"l<"#dt-add-button">f>t<"d-flex justify-content-between"ip>',
        serverSide: true,
        "ajax": "{{ route('employees-adm.index') }}",
        "columns": [
          {"data": "id", visible: false},
          {"data": "codigo"},
          {"data": "person.cedula"},
          {"data": "person.name"},
          {"data":null,
           "className" : "dt-body-center",
           "render": function ( data, type, row, meta ) {
                  let ruta = "{{ route('employees-adm.show', ['employees_adm' => 'valor']) }}";

                  ruta = ruta.replace('valor', data.id);
                  let btn_view = `<a class="ver btn btn-secondary btn-sm mr-1" href="${ruta}" target="_blank"><i class="fas fa-eye"></i></a>`;
                  let btn_editar = '<button type="button" class="editar btn btn-primary btn-sm mr-1"><i class="fas fa-edit"></i></button>';
                  let btn_eliminar = '<button class="eliminar btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i></button>';
                  
                  return  btn_view + btn_editar + btn_eliminar;
                },
           "orderable": false,
           "width" : "8em"
          }
        ]
    });

    $("#dt-add-button").html(customButton);

    // definir numero de telefono
    $("#inputPhone").inputmask(lib_phoneMask());

    ///////////////////////////////////////////////////////////////////
    // boton editar empleado
    ///////////////////////////////////////////////////////////////////

    $("#dtEmpleados tbody").on("click", ".editar", function() {
      let data = datatable.row($(this).parents()).data();
      let ruta = "{{ route('employees-adm.edit', ['employees_adm' => 'valor']) }}";

      ruta = ruta.replace('valor', data.id);
      fetch(ruta)
      .then(response => response.json())
      .then(responseJSON => {
        person = structuredClone(responseJSON);
        makeForm();
        $("#modalTitle").html(person.name);
        $('#modalForm').modal('show');
      });
    });

    ///////////////////////////////////////////////////////////////////
    // crear formulario
    ///////////////////////////////////////////////////////////////////

    function makeForm()
    {
      // print de telefonos
      imprimirTelefonos();
    }

    ///////////////////////////////////////////////////////////////////
    // imprimir telefonos
    ///////////////////////////////////////////////////////////////////

    function imprimirTelefonos()
    {
      let cadena = '';

      $("#divPhones").html("");
      person.phones.forEach(phone => {
        cadena += `
          <div class="col input-group mb-2">
            <span class="mr-1">
              <input type="text" class="form-control" value="${phone.type.name}" readonly />
            </span>
            <input type="text" class="form-control" value="${phone.number}" readonly />
            <div class="input-group-append">
              <a class="delPhone btn btn-danger btn-sm" data-phone-id="${phone.number}"><i class="fas fa-trash-alt"></i></a>
            </div>
          </div>`
      });
      $("#divPhones").html(cadena);
    }

    ///////////////////////////////////////////////////////////////////
    // agregar telefono
    ///////////////////////////////////////////////////////////////////
    $("#addPhone").click(function () {
      let number = $("#inputPhone").val();

      if(lib_isEmpty(number)) {
        lib_ShowMensaje("Debe ingresar el número de teléfono!", "error");
      } 
      else {
        let phoneTypeId = $("#selectPhoneType :selected").val();
        let phoneTypeName = $("#selectPhoneType :selected").text();
        let phone = {
          phone_type_id   : phoneTypeId,
          number          : number,
          type            : { name :  phoneTypeName }
        };

        person.phones.push(phone);
        $("#inputPhone").val("");
        imprimirTelefonos();
      }
    });

    ///////////////////////////////////////////////////////////////////
    // eliminar telefono
    ///////////////////////////////////////////////////////////////////

    $(document).delegate('.delPhone', 'click', function() {
      let phone_id = $(this).attr('data-phone-id');
      
      person.phones = person.phones.filter(phone => phone.number != phone_id);
      imprimirTelefonos();
    });

    ///////////////////////////////////////////////////////////////////
    // enviar los datos del empleado al servidor
    ///////////////////////////////////////////////////////////////////

    $("#btnGrabar").click(function() {
      let ruta = "{{ route('employees-adm.update', ['employees_adm' => 'valor']) }}";

      ruta = ruta.replace('valor', person.id);
      fetch(ruta, {
        method: "PUT",
        headers: {
          'X-CSRF-TOKEN'  : $('meta[name="csrf-token"]').attr('content'),
          'Content-Type'  : 'application/json',
          'Accept'        : 'application/json'
        },
        body: JSON.stringify(person)
      })
      .then(response => response.json())
      .then(data => console.log(data));
    });


    ///////////////////////////////////////////////////////////////////
    // eliminar empleado
    ///////////////////////////////////////////////////////////////////

    $("#dtEmpleados tbody").on("click",".eliminar",function() {
      let data = datatable.row($(this).parents()).data();

      lib_Confirmar("Seguro de ELIMINAR a: " + data.person.name + "?")
      .then((result) => {
        if (result.isConfirmed) {
          let ruta = "{{ route('employees-adm.destroy', ['employees_adm' => 'valor']) }}";

          ruta = ruta.replace('valor', data.id);
          
          $.ajax({
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url: ruta,
            type: 'DELETE',
            dataType:'json',
            success: function(resp){
              datatable.ajax.reload();
              lib_ShowMensaje("Empleado Administrativo.");
            }
          });
        }
      })
    });
  });
</script>
@endsection