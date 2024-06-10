@extends('adminlte::page')

@section('title', 'Edición de Empleado Administrativo')

@section('content_header')
  <h1>
    @if(! isset($data))
      Agregar Empleado Administrativo
    @endisset
  </h1>
@endsection

@section('content')
<div class="card card-primary card-tabs">
  <div class="card-header p-0 pt-1">
    <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
      <li class="nav-item">
        <a class="nav-link active" id="custom-tabs-one-home-tab" data-toggle="pill" href="#custom-tabs-one-home" role="tab" aria-controls="custom-tabs-one-home" aria-selected="true">Identificación</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" id="custom-tabs-one-phones-tab" data-toggle="pill" href="#custom-tabs-one-phones" role="tab" aria-controls="custom-tabs-one-profile" aria-selected="false">Teléfono(s)</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" id="custom-tabs-one-adresses-tab" data-toggle="pill" href="#custom-tabs-one-adresses" role="tab" aria-controls="custom-tabs-one-adresses" aria-selected="false">Dirección(es)</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" id="custom-tabs-one-images-tab" data-toggle="pill" href="#custom-tabs-one-images" role="tab" aria-controls="custom-tabs-one-images" aria-selected="false">Imagenes</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" id="custom-tabs-one-admin-tab" data-toggle="pill" href="#custom-tabs-one-admin" role="tab" aria-controls="custom-tabs-one-admin" aria-selected="false">Administración</a>
      </li>
    </ul>
  </div>
  <!-- fin de card-header -->

  <div class="card-body">
  <form id="empleadoForm">
    <div class="tab-content" id="custom-tabs-one-tabContent">
      
      <!-- tab principal -->
      <div class="tab-pane fade active show" id="custom-tabs-one-home" role="tabpanel" aria-labelledby="custom-tabs-one-home-tab">
        <form id="personForm">
          <div class="row">
            <div class="col-3 form-group">
              <label for="inputCedula">Cédula</label>
              <input type="text" 
                    class="form-control" 
                    id="inputCedula" 
                    name="inputCedula" 
                    placeholder="No. de cédula"
              />
            </div>

            <div class="col-3 form-group">
              <label for="inputRif">R.I.F.</label>
              <input type="text" 
                    class="form-control" 
                    id="inputRif" 
                    name="inputRif"
                    placeholder="No. de R.I.F."
                    onkeyup="this.value = this.value.toUpperCase();"
              />
            </div>

            <div class="col-6 form-group">
              <label for="inputNombre">Nombre(s) y Apellido(s)</label>
              <input type="text" 
                    class="form-control" 
                    id="inputNombre"
                    name="inputNombre"
                    placeholder="Ingresa su nombre(s) y apellido(s)"
                    onkeyup="this.value = this.value.toUpperCase();"
              />
            </div>

            <div class="col-3 form-group">
              <label for="selectSexo">Sexo</label>
              <select id="selectSexo" class="form-control">
                <option value="M">MASCULINO</option>
                <option value="F">FEMENINO</option>
              </select>
            </div>

            <div class="col-3 form-group">
              <label for="inputBirthday">Fecha de Nacimiento</label>
              <input type="date" class="form-control" id="inputBirthday" name="inputBirthday" />
            </div>

            <div class="col-6 form-group">
              <label for="inputPlaceOfBirth">Lugar de Nacimiento</label>
              <input type="text"
                    class="form-control"
                    id="inputPlaceOfBirth"
                    name="inputPlaceOfBirth"
                    placeholder="Ingresa el lugar de nacimiento"
                    onkeyup="this.value = this.value.toUpperCase();"
              />
            </div>

            <div class="col-3 form-group">
              <label for="selectEstadoCivil">Estado Civil</label>
              <select id="selectEstadoCivil" class="form-control">
                @foreach($edoCivil as $estado)
                  <option value="{{ $estado->id }}">{{ $estado->name }}</option>
                @endforeach
              </select>
            </div>

            <div class="col-3 form-group">
              <label for="selectSangre">Tipo Sanguineo</label>
              <select id="selectSangre" class="form-control">
                @foreach($tipoSangre as $tipo)
                  <option value="{{ $tipo->id }}">{{ $tipo->name }}</option>
                @endforeach
              </select>
            </div>
            
            <div class="col-6 form-group">
              <label for="inputEmail">Correo Electrónico</label>
              <input type="email"
                    class="form-control"
                    id="inputEmail"
                    name="inputEmail"
                    placeholder="Ingresa el correo electrónico"
                    onkeyup="this.value = this.value.toLowerCase();"
              />
            </div>

            <div class="col-12 form-group">
              <label for="inputNotas">Observaciones</label>
              <textarea class="form-control"
                        id="inputNotas"
                        placeholder="Ingresa observaciones"
                        rows="3"
                        onkeyup="this.value = this.value.toUpperCase();"
              /></textarea>
            </div>

            <div class="col">
              <button type="submit" id="btnGrabar" class="btn btn-danger">Grabar</button>
            </div>
          </div>
        </form>
      </div>
      <!-- fin de tab principal -->
      
      <!-- tab phones -->
      <div class="tab-pane fade" id="custom-tabs-one-phones" role="tabpanel" aria-labelledby="custom-tabs-one-phone-tab">
        <div class="row">



          <div class="col-6 form-group">
            <label for="inputDemo">Lugar de Nacimiento</label>
            <input type="text"
                  class="form-control"
                  id="demo"
                  name="demo"
                  onkeyup="this.value = this.value.toUpperCase();"
            />
          </div>



          <div class="col-6">
            <select id="selectPhoneType" class="form-control">
              @foreach ($phone_types as $phone_type)
                <option value="{{ $phone_type->id }}">{{ $phone_type->name }}</option>
              @endforeach
            </select>
          </div>

          <div class="col-6">
            <div class="input-group mb-2">
              <input type="text" id="inputPhone" name="inputPhone" class="form-control" placeholder="Ingresa número de teléfono">
              <div class="input-group-append">
                <button type="button" id="btnAddPhone" class="btn btn-primary btn-sm"><i class="fas fa-plus-square"></i></button>
              </div>
            </div>
          </div>
        
          <div id="divPhones"></div>
        </div>
      </div>
      <!-- fin de tab phones -->

      <!-- tab de direcciones -->
      <div class="tab-pane fade" id="custom-tabs-one-adresses" role="tabpanel" aria-labelledby="custom-tabs-one-adresses-tab">
        <div class="row">
          <div class="col-6">
            <label for="selectMunicipio">Municipio</label>
            <select id="selectMunicipio" class="form-control">
              <option value="0">SELECCIONE MUNICIPIO</option>
              @foreach ($municipios as $municipio)
                <option value="{{ $municipio->id }}">{{ $municipio->name }}</option>
              @endforeach
            </select>
          </div>

          <div class="col-6">
            <label for="selectParroquia">Parroquia</label>
            <select id="selectParroquia" class="form-control"></select>
          </div>

          <div class="col my-2">
            <label for="inputZonaPostal">Dirección y Zona Postal</label>
            <input type="text" 
                  id="inputAddress" 
                  name="inputAddress" 
                  class="form-control" 
                  placeholder="Ingresa la dirección"
                  onkeyup="this.value = this.value.toUpperCase();"
            >
          </div>

          <div class="input-group mb-2">
            <input type"text" 
                  id="inputZonaPostal" 
                  name="inputZonaPostal" 
                  class="form-control" 
                  placeholder="Ingrese la zona postal"
            />

            <div class="input-group-append">
              <button type="buttond" id="btnAddAddress" class="btn btn-primary btn-sm"><i class="fas fa-plus-square"></i></button>
            </div>
          </div>

        </div>

        <div id="divAddresses"></div>

      </div>
      <!-- fin de tab de direcciones -->

      <!-- tab de fotos -->
      <div class="tab-pane fade" id="custom-tabs-one-images" role="tabpanel" aria-labelledby="custom-tabs-one-images-tab">
        <div class="container">
          <div class="row">

            <!-- imagenes nuevas -->
            <div class="col-6 border border-dark">
              <div class="h5 text-center">Imagenes a subir</div>

              <div id="divNewImages" class="row"></div>

              <div class="col mt-2">
                <input type="file" class="form-control" id="inputImage" accept="image/*">
              </div>
            </div>
            <!-- fin de imagenes nuevas -->
            
            <!-- imagenes en servidor -->
            <div class="col-6 border border-dark">
              <div class="h5 text-center">Imagenes en servidor</div>

              <div  id="divImages" class="row"></div>
            </div>
            <!-- fin de imagenes en servidor -->
          </div>
        </div>
      </div>
      <!-- fin de tab de fotos -->

      <!-- tab datos administrativos -->
      <div class="tab-pane fade" id="custom-tabs-one-admin" role="tabpanel" aria-labelledby="custom-tabs-one-admin-tab">
        <div class="row">
          <div class="col-4 form-group">
            <label for="inputCodigo">Código Administrativo</label>
            <input type="text" 
                  class="form-control" 
                  id="inputCodigo" 
                  name="inputCodigo" 
                  placeholder="No. de código"
            />
          </div>

          <div class="col-4 form-group">
            <label for="inputFechaIngreso">Fecha de Ingreso</label>
            <input type="date"
                  class="form-control" 
                  id="inputFechaIngreso" 
                  name="inputFechaIngreso"
            />
          </div>

          <div class="col-4 form-group">
            <label for="selectCargo">Cargo</label>
            <select id="selectCargo" class="form-control">
              @foreach($cargos as $cargo)
                <option value="{{ $cargo->id }}">{{ $cargo->name }}</option>
              @endforeach
            </select>
          </div>

          <div class="col-4 form-group">
            <label for="selectStatus">Condición</label>
            <select id="selectStatus" class="form-control">
              @foreach($status as $condicion)
                <option value="{{ $condicion->id }}">{{ $condicion->name }}</option>
              @endforeach
            </select>
          </div>

          <div class="col-4 form-group">
            <label for="selectTipos">Tipo</label>
            <select id="selectTipos" class="form-control">
              @foreach($tipos as $tipo)
                <option value="{{ $tipo->id }}">{{ $tipo->name }}</option>
              @endforeach
            </select>
          </div>

          <div class="col-4 form-group">
            <label for="selectUbicaciones">Ubicación</label>
            <select id="selectUbicaciones" class="form-control">
              @foreach($ubicaciones as $ubicacion)
                <option value="{{ $ubicacion->id }}">{{ $ubicacion->name }}</option>
              @endforeach
            </select>
          </div>
          
          <div class="col-4 form-group">
            <label for="inputPatria">Código Patria</label>
            <input type="text"
                  class="form-control"
                  id="inputPatria"
                  name="inputPatria"
                  placeholder="Ingresa el código patria"
            />
          </div>

          <div class="col-4 form-group">
            <label for="inputReligion">Religión</label>
            <input type="text"
                  class="form-control"
                  id="inputReligion"
                  name="inputReligion"
                  placeholder="Religión prefesada por el empleado"
                  onkeyup="this.value = this.value.toUpperCase();"
            />
          </div>

          <div class="col-4 form-group">
            <label for="inputDeporte">Deporte</label>
            <input type="text"
                  class="form-control"
                  id="inputDeporte"
                  name="inputDeporte"
                  placeholder="Deporte practicado por el empleado"
                  onkeyup="this.value = this.value.toUpperCase();"
            />
          </div>

          <div class="col-4 form-group">
            <label for="inputLicencia">Licencia</label>
            <input type="text"
                  class="form-control"
                  id="inputLicencia"
                  name="inputLicencia"
                  placeholder="Ingrese la licencia"
            />
          </div>
        </div>
      </div>
      <!-- fin de datos administrativos -->
    </div>
    <!-- fin de tab -->
  </form>
  </div>
  <!-- fin de card-body -->  
</div>
<!-- fin de card -->

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

    $.validator.setDefaults({
    ignore: ""
});

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
          id            : 0,
          person_id     : 0,
          grupo_id      : 1,
          codigo        : '',
          fecha_ingreso : new Date(Date.now()).toLocaleDateString(),
          employee_cargo_id     : null,
          employee_condicion_id : null,
          employee_tipo_id      : null,
          employee_location_id  : null,
          rif                   : '',
          codigo_patria         : '',
          religion              : '',
          deporte               : '',
          licencia              : ''
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
      $("#modalTitle").html((person.id == 0) ? 'Agregar Empleado Administrativo' : person.name);
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
      ignore: "",
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
        },
        demo: {
          required:true
        }
      },
      messages: {
        demo: {
          required: "Este es demo input",
        },
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
          return;
        }

        if(person.addresses.length < 1) {
          lib_ShowMensaje("Debe ingresar al menos una dirección de ubicación!", "error");
          return;
        }

        //
        send();
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
              <img src="${image['file']}" class="img-fluid img-thumbnail mt-2" width="200" height="250">
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
    // formulario de datos administrativos
    ///////////////////////////////////////////////////////////////////

    $('#adminForm').validate({
      rules: {
        inputCodigo: {
          required: true,
          maxlength: 20
        },
        inputFechaIngreso: {
          required: true
        },
        inputPatria: {
          required: true,
          maxlength: 20
        },
        inputReligion: {
          required: true,
          maxlength: 100
        },
        inputDeporte: {
          required: true,
          maxlength: 100
        },
        inputLicencia: {
          required: true,
          maxlength: 100
        }
      },
      messages: {
        inputCodigo: {
          required: "Debes ingresar el Código Administrativo.",
          maxlength: "Debes ingresar máximo 20 digitos."
        },
        inputFechaIngreso: {
          required: "Debes ingresar la fecha de ingreso."
        },
        inputPatria: {
          required: "Debes ingresar el Código del Carnet Patria.",
          maxlength: "Debes ingresar máximo 20 digitos."
        },
        inputReligion: {
          required: "Debes ingresar la religión profesada por el empleado.",
          maxlength: "Debes ingresar máximo 100 digitos."
        },
        inputDeporte: {
          required: "Debes ingresar el deporte practicado por el empleado.",
          maxlength: "Debes ingresar máximo 100 digitos."
        },
        inputLicencia: {
          required: "Debes ingresar el tipo de licencia del empleado.",
          maxlength: "Debes ingresar máximo 100 digitos."
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

        alert("vengo?");
      }
    });

    ///////////////////////////////////////////////////////////////////
    // enviar los datos del empleado al servidor
    ///////////////////////////////////////////////////////////////////

    function send() {
      let ruta;
      let _method;

      if(person.id == 0) {
        ruta = "{{ route('employees-adm.store') }}";
        _method = "POST";
      }
      else {
        ruta = "{{ route('employees-adm.update', ['employees_adm' => '.valor']) }}";

        ruta = ruta.replace('.valor', person.employee.id);
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
            let postImagesRoute = "{{ route('employees-adm.add-images', ['cedula' => '.valor']) }}";

            postImagesRoute = postImagesRoute.replace('.valor', person.cedula);
            fetch(postImagesRoute, {
              method  : "POST",
              headers : {
                'X-CSRF-TOKEN'  : $('meta[name="csrf-token"]').attr('content')
              },
              body    : formData
            });
          };
          
          datatable.ajax.reload();
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
  });
</script>
@endsection