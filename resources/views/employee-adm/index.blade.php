@extends('adminlte::page')

@section('title', 'Emppleados Administrativos')

@section('css')
<style>
  #previewImage {
    width: 250px;
    height: 200px;
    border: 1px solid black;
    overflow: hidden;
  }

  #previewImage img {
    width: 100%;
    height: 100%;
    object-fit: contain;
  }
</style>
@endsection

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
    var imagePath = "{{ asset('storage') }}";
    var person = {};
    var municipios  = {{ Js::from($municipios) }};
    var parroquias  = {{ Js::from($parroquias) }};

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

    ///////////////////////////////////////////////////////////////////
    // filtro de las parroquias
    ///////////////////////////////////////////////////////////////////

    $("#selectMunicipio").change(function() {
      let selectedOption = $(this).val();

      $("#selectParroquia").empty();
      parroquias.forEach(parroquia => {
        if(parroquia.padre_id == selectedOption) {
          $('#selectParroquia')
            .append($("<option></option>")
            .attr("value", parroquia.id)
            .text(parroquia.name));
        }
      });
    });

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
        person.images.forEach(image => image.deleted = false);
        makeForm();
        $('#modalForm').modal('show');
      });
    });

    ///////////////////////////////////////////////////////////////////
    // crear formulario
    ///////////////////////////////////////////////////////////////////

    function makeForm()
    {
      $("#modalTitle").html(person.name);
      $("#inputCedula").val(person.cedula);
      $("#inputRif").val(person.employee.rif);
      $("#inputNombre").val(person.name);
      $("#selectSexo").val(person.sex);
      $("#inputBirthday").val(person.birthday);
      $("#inputPlaceOfBirth").val(person.place_of_birth);
      $("#selectEstadoCivil").val(person.civil_status_id);
      $("#selectSangre").val(person.blood_type_id);
      $("#inputEmail").val(person.email);
      $("#inputNotas").val(person.notes);
      $("#selectMunicipio").val("0");
      $("#selectParroquia").empty();
      imprimirTelefonos();
      imprimirDirecciones();
      imprimirImagenes();
    }

    ///////////////////////////////////////////////////////////////////
    // mascara para el numero de telefono
    ///////////////////////////////////////////////////////////////////

    $("#inputPhone").inputmask(lib_phoneMask());

    ///////////////////////////////////////////////////////////////////
    // mascara la zona postal
    ///////////////////////////////////////////////////////////////////

    $("#inputZonaPostal").inputmask(lib_digitMask());

    ///////////////////////////////////////////////////////////////////
    // imprimir telefonos
    ///////////////////////////////////////////////////////////////////

    function imprimirTelefonos()
    {
      let cadena = '';

      person.phones.forEach((phone, index) => {
        cadena += `
          <div class="col input-group mb-2">
            <span class="mr-1">
              <input type="text" class="form-control" value="${phone.type.name}" readonly />
            </span>
            <input type="text" class="form-control" value="${phone.number}" readonly />
            <div class="input-group-append">
              <a class="delPhone btn btn-danger btn-sm" id="${index}"><i class="fas fa-trash-alt"></i></a>
            </div>
          </div>`
      });

      $("#divPhones").html(cadena);
    }

    ///////////////////////////////////////////////////////////////////
    // agregar telefono
    ///////////////////////////////////////////////////////////////////

    $('#phoneForm').validate({
      rules: {
        inputPhone: {
          required: true
        },
      },
      messages: {
        inputPhone: {
          required: "Debes ingresar el número de teléfono."
        },
      },
      errorElement: 'span',
      errorPlacement: function (error, element) {
        error.addClass('invalid-feedback');
        element.closest('.input-group').append(error);
      },
      highlight: function (element, errorClass, validClass) {
        $(element).addClass('is-invalid');
      },
      unhighlight: function (element, errorClass, validClass) {
        $(element).removeClass('is-invalid');
      },
      submitHandler: function (form, e) {
        e.preventDefault();

        let phoneTypeId = $("#selectPhoneType :selected").val();
        let phoneTypeName = $("#selectPhoneType :selected").text();
        let number = $("#inputPhone").val();
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

    $(document).on('click', '.delPhone', function() {
      let phone_id = $(this).attr('id');
      
      person.phones = person.phones.filter((phone, index) => index != phone_id);
      imprimirTelefonos();
    });

    ///////////////////////////////////////////////////////////////////
    // imprimir direcciones
    ///////////////////////////////////////////////////////////////////

    function imprimirDirecciones()
    {
      let cadena = '';

      person.addresses.forEach((address, index) => {
        cadena += `
          <div class="input-group mb-2">
            <input type="text" class="form-control" value="${address.address}" readonly />
            <div class="input-group-append">
              <a class="delAddress btn btn-danger btn-sm" id="${index}"><i class="fas fa-trash-alt"></i></a>
            </div>
          </div>`
      });

      $("#divAddresses").html(cadena);
    }

    ///////////////////////////////////////////////////////////////////
    // agregar direccion
    ///////////////////////////////////////////////////////////////////

    $('#addressForm').validate({
      rules: {
        inputAddress: {
          required: true
        },
        inputZonaPostal: {
          required: true,
          maxlength: 10
        }
      },
      messages: {
        inputAddress: {
          required: "Debes ingresar una direeción."
        },
        inputZonaPostal: {
          required: "Debes ingresar la zona postal de la dirección.",
          maxlength: "Debes ingresar máximo 10 digitos."
        },
      },
      errorElement: 'span',
      errorPlacement: function (error, element) {
        error.addClass('invalid-feedback');
        element.closest('.input-group').append(error);
      },
      highlight: function (element, errorClass, validClass) {
        $(element).addClass('is-invalid');
      },
      unhighlight: function (element, errorClass, validClass) {
        $(element).removeClass('is-invalid');
      },
      submitHandler: function (form, e) {
        e.preventDefault();

        let address = {
          address       : $("#inputAddress").val(),
          parroquia_id  : $("#selectParroquia :selected").val(),
          zona_postal   : $("#inputZonaPostal").val()
        };

        person.addresses.push(address);
        $("#inputAddress").val("");
        $("#inputZonaPostal").val("");
        imprimirDirecciones();
      }
    });

    ///////////////////////////////////////////////////////////////////
    // eliminar direccion
    ///////////////////////////////////////////////////////////////////

    $(document).on('click', '.delAddress', function() {
      let address_id = $(this).attr('id');

      person.addresses = person.addresses.filter((address, index) => index != address_id);
      imprimirDirecciones();
    });

    ///////////////////////////////////////////////////////////////////
    // imprimir imagenes
    ///////////////////////////////////////////////////////////////////

    function imprimirImagenes() {
      let cadena = "";

      person.images.forEach(image => {
        if(!image.deleted) {
          cadena += `
            <div class="col-6 mb-2">
              <img src="${imagePath + '/' + image['file']}" class="img-fluid img-thumbnail mb-2" >
              <button class="deleteImage form-control btn-danger mb-2" id='${image['id']}'>Eliminar</button>
            </div>`
        }
      });

      $("#divImages").html(cadena);
    }

    ///////////////////////////////////////////////////////////////////
    // agregar una imagen
    ///////////////////////////////////////////////////////////////////

    $('#inputFile').change(function() {
      var file = this.files[0];
      var reader = new FileReader();

      reader.onload = function(e) {
        $('#previewImage').html('<img src="' + e.target.result + '">');
      }

      reader.readAsDataURL(file);
    });

    ///////////////////////////////////////////////////////////////////
    // borrar una imagen del servidor
    ///////////////////////////////////////////////////////////////////

    $(document).on('click', '.deleteImage', function() {
      let imagen_id = $(this).attr('id');

      person.images.forEach(image => {
        if(image.id.toString() === imagen_id) {
          image.deleted = true;
        }
      });
      imprimirImagenes();
    });

    ///////////////////////////////////////////////////////////////////
    // enviar los datos del empleado al servidor
    ///////////////////////////////////////////////////////////////////

    $("#btnGrabar").click(function() {
      if(person.phones.length < 1) {
        lib_ShowMensaje("Debe ingresar al menos un teléfono!", "error");
        return;
      }

      if(person.addresses.length < 1) {
        lib_ShowMensaje("Debe ingresar al menos una dirección!", "error");
        return;
      }

      let ruta = "{{ route('employees-adm.update', ['employees_adm' => 'valor']) }}";

      ruta = ruta.replace('valor', person.id);
      person.cedula = $("#inputCedula").val();
      person.name = $("#inputNombre").val();
      person.sex = $("#selectSexo").val();
      person.birthday = $("#inputBirthday").val();
      person.place_of_birth = $("#inputPlaceOfBirth").val();
      person.civil_status_id = $("#selectEstadoCivil").val();
      person.blood_type_id = $("#selectSangre").val();
      person.email = $("#inputEmail").val();
      person.notes = $("#inputNotas").val();
      person.employee.rif = $("#inputRif").val();
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
      .then(data => {
        console.log(data);
        datatable.ajax.reload();
        lib_ShowMensaje("Datos actualizados.");
      });
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
              lib_ShowMensaje("Empleado Administrativo eliminado.");
            }
          });
        }
      })
    });
  });
</script>
@endsection