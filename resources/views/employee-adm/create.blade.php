@extends('adminlte::page')

@section('title', 'Empleado Administrativo')

@section('content_header')
  <h1>Agregar Empleado Administrativo</h1>
@endsection

@section('content')
<div class="card card-primary card-tabs">
  <!-- card-header -->
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
    @csrf

    <div class="tab-content" id="custom-tabs-one-tabContent">
      
      <!-- tab principal -->
      <div class="tab-pane fade active show" id="custom-tabs-one-home" role="tabpanel" aria-labelledby="custom-tabs-one-home-tab">
        <!-- inicio de row -->
        <div class="row">
          <div class="col-9">

            <!-- inicio de row -->
            <div class="row">
              <div class="col-3 form-group">
                <label for="inputCedula">Cédula</label>
                <input type="text" 
                      class="form-control" 
                      id="inputCedula" 
                      name="cedula"
                      minlength="7"
                      maxlength="15"
                      required
                      placeholder="No. de cédula"
                />
              </div>

              <div class="col-3 form-group">
                <label for="inputRif">R.I.F.</label>
                <input type="text" 
                      class="form-control" 
                      id="inputRif" 
                      name="rif"
                      maxlength="20"
                      required
                      placeholder="No. de R.I.F."
                      onkeyup="this.value = this.value.toUpperCase();"
                />
              </div>

              <div class="col-6 form-group">
                <label for="inputNombre">Nombre(s) y Apellido(s)</label>
                <input type="text" 
                      class="form-control" 
                      id="inputNombre"
                      name="name"
                      required
                      minlength="3"
                      maxlength="200"
                      placeholder="Ingresa su nombre(s) y apellido(s)"
                      onkeyup="this.value = this.value.toUpperCase();"
                />
              </div>

              <div class="col-3 form-group">
                <label for="selectSexo">Sexo</label>
                <select id="selectSexo" class="form-control" name="sex">
                  <option value="0" selected>SELECCIONE EL SEXO</option>
                  <option value="M">MASCULINO</option>
                  <option value="F">FEMENINO</option>
                </select>
              </div>
    
              <div class="col-3 form-group">
                <label for="inputBirthday">Fecha de Nacimiento</label>
                <input type="date"
                      class="form-control" 
                      id="inputBirthday" 
                      name="birthday"
                      required />
              </div>
    
              <div class="col-6 form-group">
                <label for="inputPlaceOfBirth">Lugar de Nacimiento</label>
                <input type="text"
                      class="form-control"
                      id="inputPlaceOfBirth"
                      name="place_of_birth"
                      maxlength="255"
                      required
                      placeholder="Ingresa el lugar de nacimiento"
                      onkeyup="this.value = this.value.toUpperCase();"
                />
              </div>

              <div class="col-3 form-group">
                <label for="selectEstadoCivil">Estado Civil</label>
                <select id="selectEstadoCivil" class="form-control" name="civil_status_id">
                  <option value="0" selected>SELECCIONE ESTADO CIVIL</option>
                  @foreach($edoCivil as $estado)
                    <option value="{{ $estado->id }}">{{ $estado->name }}</option>
                  @endforeach
                </select>
              </div>
    
              <div class="col-3 form-group">
                <label for="selectSangre">Tipo de Sangre</label>
                <select id="selectSangre" class="form-control" name="blood_type_id">
                  <option value="0" selected>SELECCIONE TIPO</option>
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
                      name="email"
                      placeholder="Ingresa el correo electrónico"
                      onkeyup="this.value = this.value.toLowerCase();"
                />
              </div>

              <div class="col form-group">
                <label for="inputNotas">Observaciones</label>
                <textarea class="form-control"
                          id="inputNotas"
                          name="notes"
                          placeholder="Ingresa observaciones"
                          rows="3"
                          onkeyup="this.value = this.value.toUpperCase();"
                /></textarea>
              </div>

            </div>
            <!-- fin de row -->

          </div>

          <div class="col-3 border p-2 text-center">
            <img src="{{ asset('assets/images/avatar.png') }}" 
                 id="imgAvatar" 
                 class="img-thumbnail border border-dark"
                 width="200"
                 height="250"
            >
            <label for="inputAvatar" class="form-control btn btn-primary mt-2">Imagen</label>
            <input type="file" id="inputAvatar" name="imagen" accept="image/*" style="display: none;" />
          </div>          

        </div>
        <!-- fin de row -->

        <div class="row">
          <div class="col">
            <button type="submit" class="btn btn-danger">Grabar</button>
            <button type="button" id="btnSalir" class="btn btn-secondary">Retornar</button>
          </div>
        </div>
      </div>
      <!-- fin de tab principal -->
      
      <!-- tab phones -->
      <div class="tab-pane fade" id="custom-tabs-one-phones" role="tabpanel" aria-labelledby="custom-tabs-one-phone-tab">
        <div class="row">

          <div class="col-6">
            <select id="selectPhoneType" class="form-control">
              <option value="0" selected>SELECCIONE EL TIPO DE NÚMERO</option>
              @foreach ($phone_types as $phone_type)
                <option value="{{ $phone_type->id }}">{{ $phone_type->name }}</option>
              @endforeach
            </select>
          </div>

          <div class="col-6">
            <div class="input-group mb-2">
              <input type="text" id="inputPhone" class="form-control" placeholder="Ingresa número de teléfono">
              <div class="input-group-append">
                <button type="button" id="btnAddPhone" class="btn btn-primary btn-sm">
                  <i class="fas fa-plus-square"></i>
                </button>
              </div>
            </div>
          </div>
        
        </div>

        <div class="row" id="divPhones"></div>
      </div>
      <!-- fin de tab phones -->

      <!-- tab de direcciones -->
      <div class="tab-pane fade" id="custom-tabs-one-adresses" role="tabpanel" aria-labelledby="custom-tabs-one-adresses-tab">
        <div class="row">
          <div class="col-6">
            <label for="selectMunicipio">Municipio</label>
            <select id="selectMunicipio" class="form-control">
              <option value="0" selected>SELECCIONE MUNICIPIO</option>
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
            <label for="inputAddress">Dirección y Zona Postal</label>
            <div class="input-group mb-2">
              <input type="text" 
                    id="inputAddress" 
                    class="form-control" 
                    placeholder="Ingresa la dirección"
                    onkeyup="this.value = this.value.toUpperCase();"
              >
              <div class="input-group-append">
                <button type="button" id="btnAddAddress" class="btn btn-primary btn-sm"><i class="fas fa-plus-square"></i></button>
              </div>
            </div>
          </div>

          <div class="input-group mb-2">
            <input type"text" 
                  id="inputZonaPostal" 
                  class="form-control" 
                  placeholder="Ingrese la zona postal"
            />
          </div>
        </div>

        <div class="row" id="divAddresses"></div>

      </div>
      <!-- fin de tab de direcciones -->

      <!-- tab de imagenes -->
      <div class="tab-pane fade" id="custom-tabs-one-images" role="tabpanel" aria-labelledby="custom-tabs-one-images-tab">
        <div class="row">

          <!-- imagenes nuevas -->
          <div class="col border border-dark">
            <div class="h5 text-center">Imagenes a subir</div>

            <div id="divNewImages" class="row"></div>

            <div class="mt-2">
              <input type="file" class="form-control" id="inputImage" accept="image/*">
            </div>
          </div>
          <!-- fin de imagenes nuevas -->
        </div>
      </div>
      <!-- fin de tab de fotos -->

      <!-- tab datos administrativos -->
      <div class="tab-pane fade" id="custom-tabs-one-admin" role="tabpanel" aria-labelledby="custom-tabs-one-admin-tab">
        <div class="row">
          <div class="col-4 form-group">
            <label for="inputCodigo">Código de Nómina</label>
            <input type="text" 
                  class="form-control" 
                  id="inputCodigo" 
                  name="codigo_nomina"
                  placeholder="No. de código de nómina"
            />
          </div>

          <div class="col-4 form-group">
            <label for="inputFechaIngreso">Fecha de Ingreso</label>
            <input type="date"
                  class="form-control" 
                  id="inputFechaIngreso" 
                  name="fecha_ingreso"
            />
          </div>

          <div class="col-4 form-group">
            <label for="selectCargo">Cargo</label>
            <select id="selectCargo" class="form-control" name="employee_cargo_id">
              <option value="0" selected>SELECCIONE EL CARGO</option>
              @foreach($cargos as $cargo)
                <option value="{{ $cargo->id }}">{{ $cargo->name }}</option>
              @endforeach
            </select>
          </div>

          <div class="col-4 form-group">
            <label for="selectStatus">Condición</label>
            <select id="selectStatus" class="form-control" name="employee_condicion_id">
              <option value="0" selected>SELECCIONE LA CONDICIÓN</option>
              @foreach($status as $condicion)
                <option value="{{ $condicion->id }}">{{ $condicion->name }}</option>
              @endforeach
            </select>
          </div>

          <div class="col-4 form-group">
            <label for="selectTipos">Tipo</label>
            <select id="selectTipos" class="form-control" name="employee_tipo_id">
              <option value="0" selected>SELECCIONE EL TIPO</option>
              @foreach($tipos as $tipo)
                <option value="{{ $tipo->id }}">{{ $tipo->name }}</option>
              @endforeach
            </select>
          </div>

          <div class="col-4 form-group">
            <label for="selectUbicaciones">Ubicación</label>
            <select id="selectUbicaciones" class="form-control" name="employee_location_id">
              <option value="0" selected>SELECCIONE LA UBICACIÓN</option>
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
                  name="codigo_patria"
                  value="NO DEFINIDO"
                  placeholder="Código del carnet patria"
            />
          </div>

          <div class="col-4 form-group">
            <label for="inputSerialPatria">Serial Patria</label>
            <input type="text"
                  class="form-control"
                  id="inputSerialPatria"
                  name="serial_patria"
                  value="NO DEFINIDO"
                  placeholder="Serial del carnet patria"
            />
          </div>

          <div class="col-4 form-group">
            <label for="inputReligion">Religión</label>
            <input type="text"
                  class="form-control"
                  id="inputReligion"
                  name="religion"
                  value="NO DEFINIDO"
                  placeholder="Religión prefesada por el empleado"
                  onkeyup="this.value = this.value.toUpperCase();"
            />
          </div>

          <div class="col-4 form-group">
            <label for="inputDeporte">Deporte</label>
            <input type="text"
                  class="form-control"
                  id="inputDeporte"
                  name="deporte"
                  value="NO DEFINIDO"
                  placeholder="Deporte practicado por el empleado"
                  onkeyup="this.value = this.value.toUpperCase();"
            />
          </div>

          <div class="col-4 form-group">
            <label for="inputLicencia">Licencia</label>
            <input type="text"
                  class="form-control"
                  id="inputLicencia"
                  name="licencia"
                  value="NO DEFINIDO"
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
    ///////////////////////////////////////////////////////////////////
    // variables globales
    ///////////////////////////////////////////////////////////////////
    
    var phones      = [];                                               // telefonos del empleado
    var addresses   = [];                                               // direcciones del empleado
    var formData    = new FormData();                                   // imagenes nuevas del empleado
    var municipios  = {{ Js::from($municipios) }};
    var parroquias  = {{ Js::from($parroquias) }};

    ///////////////////////////////////////////////////////////////////
    // configuracion de 'toatsr'
    ///////////////////////////////////////////////////////////////////

    toastr.options.closeButton = true;
    toastr.options.timeOut = 0;
    toastr.options.extendedTimeOut = 0;

    ///////////////////////////////////////////////////////////////////
    // cerrar pestaña de edicion
    ///////////////////////////////////////////////////////////////////

    $("#btnSalir").click(function() {
      window.close();
    });

    ///////////////////////////////////////////////////////////////////
    // al seleccionar la imagen del empleado
    ///////////////////////////////////////////////////////////////////

    $("#inputAvatar").change(function() {
      let imagen = this.files[0];
      let reader = new FileReader();

      reader.onload = function(e) {
        $("#imgAvatar").attr('src', e.target.result);
      };

      reader.readAsDataURL(imagen);
    });

    ///////////////////////////////////////////////////////////////////
    // mascara para el nombre
    ///////////////////////////////////////////////////////////////////

    $("#inputNombre").inputmask(lib_characterMask());

    ///////////////////////////////////////////////////////////////////
    // mascara para el numero de telefono
    ///////////////////////////////////////////////////////////////////

    $("#inputPhone").inputmask(lib_phoneMask());

    ///////////////////////////////////////////////////////////////////
    // mascara la zona postal
    ///////////////////////////////////////////////////////////////////

    $("#inputZonaPostal").inputmask(lib_digitMask());
    
    ///////////////////////////////////////////////////////////////////
    // agregar telefono
    ///////////////////////////////////////////////////////////////////

    $("#btnAddPhone").click(function() {
      let _number = $("#inputPhone").val();
      
      if(lib_isEmpty(_number)) {
        lib_toastr("Error: Debe ingresar un número de teléfono!");
      }
      else {
        phones.push({
          phone_type_id : $("#selectPhoneType :selected").val(),
          phoneTypeName : $("#selectPhoneType :selected").text(),
          number        : _number
        });

        showPhones();
        $("#inputPhone").val("");
      }
    });

    ///////////////////////////////////////////////////////////////////
    // eliminar telefono
    ///////////////////////////////////////////////////////////////////

    $(document).on('click', '.delPhone', function() {
      let phone_id = $(this).attr('id');
      
      phones = phones.filter((phone, index) => index != phone_id);
      showPhones();
    });

    ///////////////////////////////////////////////////////////////////
    // mostrar telefonos
    ///////////////////////////////////////////////////////////////////
    function showPhones() {
      let cadena = '';

      phones.forEach((phone, index) => {
        cadena += `
          <div class="col-6">
            <input type="hidden" class="form-control" name="phone_type_id[]" value="${phone.phone_type_id}" />
            <input type="text" class="form-control" value="${phone.phoneTypeName}" readonly />
          </div>

          <div class="col-6">
            <div class="input-group mb-2">
              <input type="text" class="form-control" name="phone_number[]" value="${phone.number}" readonly />
              <div class="input-group-append">
                <a class="delPhone btn btn-danger btn-sm" id="${index}"><i class="fas fa-trash-alt"></i></a>
              </div>
            </div>
          </div>
        `;
      });

      $("#divPhones").html(cadena);
    };

    ///////////////////////////////////////////////////////////////////
    // filtro de las parroquias
    ///////////////////////////////////////////////////////////////////

    $("#selectMunicipio").change(function() {
      let selectedOption = $(this).val();

      $("#selectParroquia").empty();
      $('#selectParroquia').append("<option value='0'>SELECCIONE LA PARROQUIA</option>");
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
    // agregar direccion
    ///////////////////////////////////////////////////////////////////

    $("#btnAddAddress").click(function() {
      let address = {
          address       : $("#inputAddress").val(),
          parroquia_id  : $("#selectParroquia :selected").val(),
          zona_postal   : $("#inputZonaPostal").val()
        };

        if(address.parroquia_id === undefined) {
          lib_toastr("Error: Debe seleccionar una parroquia!");
        }
        else if(lib_isEmpty(address.address)) {
          lib_toastr("Error: Debe ingresar una dirección!");
        }
        else if(lib_isEmpty(address.zona_postal)) {
          lib_toastr("Error: Debe ingresar la zona postal!");
        }
        else if(address.zona_postal.length > 10) {
          lib_toastr("Error: La zona postal no puede exceder de 10 caracteres!");
        }
        else {
          addresses.push(address);
          $("#inputAddress").val("");
          $("#inputZonaPostal").val("");
          showDirecciones();
        }
    });

    ///////////////////////////////////////////////////////////////////
    // eliminar direccion
    ///////////////////////////////////////////////////////////////////

    $(document).on('click', '.delAddress', function() {
      let address_id = $(this).attr('id');

      addresses = addresses.filter((address, index) => index != address_id);
      showDirecciones();
    });

    ///////////////////////////////////////////////////////////////////
    // mostrar direcciones
    ///////////////////////////////////////////////////////////////////

    function showDirecciones()
    {
      let cadena = '';

      addresses.forEach((address, index) => {
        cadena += `
          <div class="input-group mb-2">
            <input type="hidden" name="parroquia_id[]" value="${address.parroquia_id}" />
            <input type="hidden" name="zona_postal[]" value="${address.zona_postal}" />
            <input type="text" class="form-control" name="address[]" value="${address.address}" readonly />
            <div class="input-group-append">
              <a class="delAddress btn btn-danger btn-sm" id="${index}"><i class="fas fa-trash-alt"></i></a>
            </div>
          </div>`
      });

      $("#divAddresses").html(cadena);
    };

    ///////////////////////////////////////////////////////////////////
    // agregar una imagen
    ///////////////////////////////////////////////////////////////////

    $('#inputImage').on('change', function(e) {
      formData.append('images[]', e.target.files[0]);
      imprimirImagenes();
    });

    ///////////////////////////////////////////////////////////////////
    // eliminar una imagen
    ///////////////////////////////////////////////////////////////////

    $(document).on('click', '.deleteImagenNueva', function() {
      let imagesArray = Array.from(formData.getAll('images[]'));

      imagesArray.splice($(this).attr('id'), 1);
      formData.delete('images[]');
      imagesArray.forEach(image => formData.append('images[]', image));
      imprimirImagenes();
    });

    ///////////////////////////////////////////////////////////////////
    // imprimir imagenes nuevas
    ///////////////////////////////////////////////////////////////////

    function imprimirImagenes() {
      let contenedor = $("#divNewImages");

      contenedor.empty();
      for (let i = 0; i < formData.getAll('images[]').length; i++) {
        let div = $('<div class="col-3 text-center"></div>');
        let img = $('<img class="img-fluid img-thumbnail mt-2" width="200" height="250">');
        let botonEliminar = $(`<button class="deleteImagenNueva form-control btn-danger p-2" id="${i}">Eliminar</button>`);

        img.attr('src', URL.createObjectURL(formData.getAll('images[]')[i]));
        div.append(img);
        div.append(botonEliminar);
        contenedor.append(div);
      }
    };

    ///////////////////////////////////////////////////////////////////
    // agregar un empleado 
    ///////////////////////////////////////////////////////////////////

    $("#empleadoForm").submit(function(e) {
      e.preventDefault();

      if(phones.length < 1) {
        lib_toastr("Error: Debe ingresar al menos un número de teléfono!");
        return;
      }

      if(addresses.length < 1) {
        lib_toastr("Error: Debe ingresar al menos una dirección de ubicación!");
        return;
      }

      const data = new FormData(empleadoForm);
      
      fetch("{{ route('employees-adm.store') }}", {
        headers: {
          'Accept' : 'application/json'
        },
        method  : "POST",
        body: data
      })
      .then(response => {
        if(response.ok) {
          response.json().then(responseData => {
            if(formData.has('images[]')) {
              let postImagesRoute = "{{ route('employees-adm.add-images', ['id' => 'valor1', 'cedula' => 'valor2']) }}";

              postImagesRoute = postImagesRoute.replace('valor1', responseData.id);
              postImagesRoute = postImagesRoute.replace('valor2', responseData.cedula);

              fetch(postImagesRoute, {
                method  : "POST",
                headers : {
                  'X-CSRF-TOKEN'  : $('meta[name="csrf-token"]').attr('content'),
                },
                body : formData
              });
            }

            lib_ShowMensaje("Empleado Administrativo agregado!", 'mensaje')
            .then(response => window.close());
          });
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
    });
  });
</script>
@endsection