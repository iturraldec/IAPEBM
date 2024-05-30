@extends('adminlte::page')

@section('title', 'Empleados Policiales')

@section('content_header')
  <h1>Listado de Empleados Policiales.</h1>
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

@include('common.load-data')

@include('employee-police.edit')

@endsection

@section('js')
<script>
  $(document).ready(function () {
    toastr.options.closeButton = true;
    toastr.options.timeOut = 0;
    toastr.options.extendedTimeOut = 0;
      
    var person = {};
    var formData;
    var imagePath = "{{ env('IMAGES_URL') }}";
    var municipios  = {{ Js::from($municipios) }};
    var parroquias  = {{ Js::from($parroquias) }};
    var emptyImages = 'Sin imagenes en servidor.';

    ///////////////////////////////////////////////////////////
    // datatable
    ///////////////////////////////////////////////////////////

    let datatable = $('#dtEmpleados').DataTable({
        "dom": '<"d-flex justify-content-between"l<"#dt-add-button">f>t<"d-flex justify-content-between"ip>',
        "ajax": "{{ route('employees-police.index') }}",
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

    $("#dt-add-button").html('<button id="btnAgregar" class="btn btn-primary">Agregar Empleado Policial</button>');

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
    // agregar un empleado 
    ///////////////////////////////////////////////////////////////////

    $("#btnAgregar").click(function() {
      person = {
        id              : 0,
        name            : '',
        cedula          : '',
        sex             : 'M',
        birthday        : '01-01-1970',
        place_of_birth  : '',
        civil_status_id : 1,
        blood_type_id   : 1,
        email           : '',
        notes           : '',
        employee        : {
          id                    : 0,
          person_id             : 0,
          grupo_id              : 1,
          codigo                : '',
          fecha_ingreso         : new Date(Date.now()).toLocaleDateString(),
          employee_cargo_id     : null,
          employee_condicion_id : null,
          employee_tipo_id      : null,
          employee_location_id  : null,
          rif                   : '',
          codigo_patria         : '',
          religion              : '',
          deporte               : '',
          licencia              : '',
          escuela               : '',
          fecha_graducion       : new Date(Date.now()).toLocaleDateString(),
          curso                 : ''
        },
        phones          : [],
        addresses       : [],
        images          : []
      };
      makeForm();
    });

    ///////////////////////////////////////////////////////////////////
    // boton editar empleado
    ///////////////////////////////////////////////////////////////////

    $("#dtEmpleados tbody").on("click", ".editar", function() {
      let data = datatable.row($(this).parents()).data();
      let ruta = "{{ route('employees-adm.edit', ['employees_adm' => 'valor']) }}";

      ruta = ruta.replace('valor', data.id);
      $('#loadDataModal').modal('show');
      fetch(ruta)
      .then(response => response.json())
      .then(responseJSON => {
        person = structuredClone(responseJSON);
        person.images.forEach(image => image.deleted = false);
        makeForm();
        $('#loadDataModal').modal('hide');
      });
    });

    ///////////////////////////////////////////////////////////////////
    // crear formulario
    ///////////////////////////////////////////////////////////////////

    function makeForm()
    {
      formData = new FormData();
      $("#modalTitle").html((person.id == 0) ? 'Agregar Empleado Policial' : person.name);
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
      $("#inputCodigo").val(person.employee.codigo);
      $("#inputFechaIngreso").val(person.employee.fecha_ingreso);
      $("#inputPatria").val(person.employee.codigo_patria);
      $("#inputReligion").val(person.employee.religion);
      $("#inputDeporte").val(person.employee.deporte);
      $("#inputLicencia").val(person.employee.licencia);
      $("#inputEscuela").val(person.employee.escuela);
      $("#inputFechaGrado").val(person.employee.fecha_graducion);
      $("#inputCurso").val(person.employee.curso);
      $("#inputImage").val("");
      imprimirTelefonos();
      imprimirDirecciones();
      imprimirImagenes();
      imprimirImagenesNuevas();
      $('#modalForm').modal('show');
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
    // validar formulario de persona
    ///////////////////////////////////////////////////////////////////

    $("#personForm").validate({
      rules:{
        inputCedula : {
          required : true,
          minlength: 7,
          maxlength: 15
        },
        inputRif : {
          required : true,
          minlength: 10,
          maxlength: 20
        },
        inputNombre : {
          required : true,
          maxlength: 200
        },
        inputBirthday : {
          required : true
        },
        inputPlaceOfBirth : {
          required : true,
          maxlength: 200
        },
        inputEmail : {
          required : true,
          email:true,
          maxlength: 255
        }
      },
      messages: {
        inputCedula: {
          required : "Debe ingresar el número de cédula.",
          minlength: "Debe ingresar mínimo 7 dígitos.",
          maxlength: "Debe ingresar un máxiom de 15 dígitos."
        },
        inputRif: {
          required : "Debe ingresar el número de R.I.F.",
          minlength: "Debe ingresar mínimo 10 dígitos.",
          maxlength: "Debe ingresar un máxiom de 20 dígitos."
        },
        inputNombre: {
          required : "Debe ingresar el nombre del empleado.",
          maxlength: "Debe ingresar un máxiom de 200 carácteres."
        },
        inputBirthday : {
          required : "Debe ingresar la fecha de nacimiento."
        },
        inputPlaceOfBirth : {
          required : "Debe ingresar el lugar de nacimiento.",
          maxlength: "Debe ingresar un máximo de 200 carácteres."
        },
        inputEmail:{
          required: "Deeb ingresar la dirección de correo electrónico.",
          email: "Deeb ingresar una dirección de correo electrónico.",
          maxlength: "Debe ingresar un máximo de 255 carácteres."
        }
      },
      errorElement: 'span',
      errorPlacement: function (error, element) {
        error.addClass('invalid-feedback');
        element.closest('.form-group').append(error);
      },
      highlight: function (element, errorClass, validClass) {
        $(element).addClass('is-invalid');
      },
      unhighlight: function (element, errorClass, validClass) {
        $(element).removeClass('is-invalid');
      },
      submitHandler: function (form, e) {
        e.preventDefault();

        if(person.phones.length < 1) {
          lib_ShowMensaje("Debe ingresar al menos un número teléfonico!", "error");
        }
        else if(person.addresses.length < 1) {
          lib_ShowMensaje("Debe ingresar al menos una dirección de ubicación!", "error");
        }
        else {
          send();
        }
      }
    });

    ///////////////////////////////////////////////////////////////////
    // imprimir telefonos
    ///////////////////////////////////////////////////////////////////

    function imprimirTelefonos() {
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
    $("#btnAddPhone").click(function() {
      let phoneTypeId   = $("#selectPhoneType :selected").val();
      let phoneTypeName = $("#selectPhoneType :selected").text();
      let number        = $("#inputPhone").val();
      
      if(lib_isEmpty(number)) {
        lib_toastr("Error: Debe ingresar un número de teléfono!");
      }
      else {
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

    $("#btnAddAddress").click(function() {
      let address = {
          address       : $("#inputAddress").val(),
          parroquia_id  : $("#selectParroquia :selected").val(),
          zona_postal   : $("#inputZonaPostal").val()
        };

        if(lib_isEmpty(address.address)) {
          lib_toastr("Error: Debe ingresar una dirección!");
        }
        else if(lib_isEmpty(address.zona_postal)) {
          lib_toastr("Error: Debe ingresar la zona postal!");
        }
        else if(address.zona_postal.length > 10) {
          lib_toastr("Error: La zona postal no puede exceder de 10 caracteres!");
        }
        else {
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
    // imprimir imagenes del servidor
    ///////////////////////////////////////////////////////////////////

    function imprimirImagenes() {
      let cadena = "";

      person.images.forEach(image => {
        if(!image.deleted) {
          cadena += `
            <div class="col-6">
              <img src="${imagePath + image['file']}" class="img-fluid img-thumbnail mt-2" width="200" height="250">
              <button class="deleteImage form-control btn-danger p-2" id='${image['id']}'>Eliminar</button>
            </div>`;
        }
      });

      $("#divImages").html(cadena);
    }

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
    // agregar una imagen nueva
    ///////////////////////////////////////////////////////////////////

    $('#inputImage').on('change', function(e) {
      formData.append('images[]', e.target.files[0]);
      imprimirImagenesNuevas();
    });

    ///////////////////////////////////////////////////////////////////
    // eliminar una imagen nueva
    ///////////////////////////////////////////////////////////////////

    $(document).on('click', '.deleteImagenNueva', function() {
      let imagesArray = Array.from(formData.getAll('images[]'));

      imagesArray.splice($(this).attr('id'), 1);
      formData.delete('images[]');
      imagesArray.forEach(image => formData.append('images[]', image));
      imprimirImagenesNuevas();
    });

    ///////////////////////////////////////////////////////////////////
    // imprimir imagenes nuevas
    ///////////////////////////////////////////////////////////////////

    function imprimirImagenesNuevas() {
      let contenedor = $("#divNewImages");

      contenedor.empty();
      for (let i = 0; i < formData.getAll('images[]').length; i++) {
        let div = $('<div class="col-6"></div>');
        let img = $('<img class="img-fluid img-thumbnail mt-2" width="200" height="250">');
        let botonEliminar = $(`<button class="deleteImagenNueva form-control btn-danger p-2" id="${i}">Eliminar</button>`);

        img.attr('src', URL.createObjectURL(formData.getAll('images[]')[i]));
        div.append(img);
        div.append(botonEliminar);
        contenedor.append(div);
      }
    };

    ///////////////////////////////////////////////////////////////////
    // enviar los datos del empleado al servidor
    ///////////////////////////////////////////////////////////////////

    function send() {
      let ruta;
      let _method;

      if(person.id == 0) {
        ruta = "{{ route('employees-police.store') }}";
        _method = "POST";
      }
      else {
        ruta = "{{ route('employees-adm.update', ['employees_adm' => '.valor']) }}";

        ruta = ruta.replace('.valor', person.id);
        _method = "PUT";
      }

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
      person.employee.codigo = $("#inputCodigo").val(); 
      person.employee.fecha_ingreso = $("#inputFechaIngreso").val();
      person.employee.employee_cargo_id = $("#selectCargo").val();
      person.employee.employee_condicion_id = $("#selectStatus").val();
      person.employee.employee_tipo_id = $("#selectTipos").val();
      person.employee.employee_location_id = $("#selectUbicaciones").val();
      person.employee.codigo_patria = $("#inputPatria").val(); 
      person.employee.religion = $("#inputReligion").val(); 
      person.employee.deporte = $("#inputDeporte").val(); 
      person.employee.licencia = $("#inputLicencia").val();
      person.employee.escuela = $("#inputEscuela").val();
      person.employee.fecha_graduacion = $("#inputFechaGrado").val();
      person.employee.curso = $("#inputCurso").val();

      fetch(ruta, {
        method: _method,
        headers: {
          'X-CSRF-TOKEN'  : $('meta[name="csrf-token"]').attr('content'),
          'Content-Type'  : 'application/json',
          'Accept'        : 'application/json'
        },
        body: JSON.stringify(person)
      })
      .then(response => {
        if(response.ok) {
          if(formData.has('images[]')) {
            let postImagesRoute = "{{ route('employees-police.add-images', ['cedula' => '.valor']) }}";

            postImagesRoute = postImagesRoute.replace('.valor', person.cedula);
            fetch(postImagesRoute, {
              method  : "POST",
              headers : {
                'X-CSRF-TOKEN'  : $('meta[name="csrf-token"]').attr('content')
              },
              body    : formData
            });
          };
          
          lib_ShowMensaje("Datos actualizados.");
        }
        else {
          response.text().then(r => {
            let errores = JSON.parse(r);

            for (let propiedad in errores.errors) {
              lib_toastr(errores.errors[propiedad]);
            }
          });
        }
      })
    };

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