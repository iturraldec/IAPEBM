@extends('layouts.edit-page')

@section('title', 'Empleado Obrero')

@section('content_header')
  <div class="row m-2 ">
    <div class="col-6">
      <h4>Agregar Datos del Empleado Obrero</h4>
    </div>
  
    <div class="col-6 d-flex justify-content-end">
      <button type="button" id="btnSalir" class="btn btn-secondary mr-2"><i class="fas fa-arrow-left"></i> Retornar</button>
      <button type="button" id="btnGrabar" class="btn btn-danger"><i class="fas fa-save"></i> Grabar Datos</button>
    </div>
  </div>
@endsection

@section('content')
  <div class="row m-2">
    <div class="col-12">
      <div class="card card-primary card-tabs">
        <!-- card-header -->
        <div class="card-header p-0 pt-1">
          <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
            <li class="nav-item">
              <a class="nav-link active" id="custom-tabs-one-home-tab" data-toggle="pill" href="#custom-tabs-one-home" role="tab" aria-controls="custom-tabs-one-home" aria-selected="true">Personales</a>
            </li>
            
            <li class="nav-item">
              <a class="nav-link" id="custom-tabs-one-admin-tab" data-toggle="pill" href="#custom-tabs-one-admin" role="tab" aria-controls="custom-tabs-one-admin" aria-selected="false">Laborales</a>
            </li>
    
            <li class="nav-item">
              <a class="nav-link" id="custom-tabs-one-fisio-tab" data-toggle="pill" href="#custom-tabs-one-fisio" role="tab" aria-controls="custom-tabs-one-fisio" aria-selected="false">Fisionomía</a>
            </li>
    
            <li class="nav-item">
              <a class="nav-link" id="custom-tabs-one-familia-tab" data-toggle="pill" href="#custom-tabs-one-familia" role="tab" aria-controls="custom-tabs-one-familia" aria-selected="false">Familiares</a>
            </li>
    
            <li class="nav-item">
              <a class="nav-link" id="custom-tabs-one-estudios-tab" data-toggle="pill" href="#custom-tabs-one-estudios" role="tab" aria-controls="custom-tabs-one-estudios" aria-selected="false">Académicos</a>
            </li>
    
          </ul>
        </div>
        <!-- fin de card-header -->
    
        <div class="card-body">
        <form id="formEmpleado">
          @csrf
    
          <div class="tab-content" id="custom-tabs-one-tabContent">      
            <!-- tab datos personales -->
            <div class="tab-pane fade active show" id="custom-tabs-one-home" role="tabpanel">
    
              <!-- inicio de row -->
              <div class="row d-flex justify-content-around">
                <div class="col-4 form-group text-center">
                  <img src="{{ asset('assets/images/avatar.png') }}" 
                        id="imgFotoFrente" 
                        class="img-thumbnail border border-dark"
                        width="200"
                        height="250"
                  >
                  <label for="inputFotoFrente" class="form-control btn border mt-2">De Frente</label>
                  <input type="file" id="inputFotoFrente" name="imagef" accept="image/*" style="display: none;" />
                </div>
    
                <div class="col-4 form-group text-center">
                  <img src="{{ asset('assets/images/avatar.png') }}" 
                        id="imgFotoLIzquierdo" 
                        class="img-thumbnail border border-dark"
                        width="200"
                        height="250"
                  >
                  <label for="inputFotoLIzquierdo" class="form-control btn border mt-2">Lado Izquierdo</label>
                  <input type="file" id="inputFotoLIzquierdo" name="imageli" accept="image/*" style="display: none;" />
                </div>
    
                <div class="col-4 form-group text-center">
                  <img src="{{ asset('assets/images/avatar.png') }}" 
                        id="imgFotoLDerecho" 
                        class="img-thumbnail border border-dark"
                        width="200"
                        height="250"
                  >
                  <label for="inputFotoLDerecho" class="form-control btn border mt-2">Lado Derecho</label>
                  <input type="file" id="inputFotoLDerecho" name="imageld" accept="image/*" style="display: none;" />
                </div>
              </div>
              <!-- fin de row -->
    
              <!-- inicio de row -->
              <div class="row">
                <div class="col-3 form-group">
                  <label for="inputCedula">Cédula*</label>
                  <input type="text" 
                        class="form-control" 
                        id="inputCedula" 
                        name="cedula"
                        minlength="7"
                        maxlength="15"
                        required
                        placeholder="Ingresa Nro. de cédula"
                        title="Nro. de Cédula"
                  />
                </div>
    
                <div class="col-3 form-group">
                  <label for="inputRif">R.I.F.*</label>
                  <input type="text" 
                        class="form-control" 
                        id="inputRif" 
                        name="rif"
                        maxlength="20"
                        required
                        placeholder="Ingresa Nro. de R.I.F."
                        onkeyup="this.value = this.value.toUpperCase();"
                        title="Nro. de R.I.F."
                  />
                </div>
    
                <div class="col-3 form-group">
                  <label for="inputPNombre">Primer Nombre*</label>
                  <input type="text" 
                        class="form-control" 
                        id="inputPNombre"
                        name="first_name"
                        required
                        minlength="3"
                        maxlength="50"
                        placeholder="Ingresa su primer nombre"
                        onkeyup="this.value = this.value.toUpperCase();"
                        title="Primer nombre del empleado"
                  />
                </div>
    
                <div class="col-3 form-group">
                  <label for="inputSNombre">Segundo Nombre</label>
                  <input type="text" 
                        class="form-control" 
                        id="inputSNombre"
                        name="second_name"
                        minlength="3"
                        maxlength="50"
                        placeholder="Ingresa su segundo nombre"
                        onkeyup="this.value = this.value.toUpperCase();"
                        title="Segundo nombre del empleado"
                  />
                </div>
    
                    <div class="col-3 form-group">
                      <label for="inputPApellido">Primer Apellido*</label>
                      <input type="text" 
                            class="form-control"
                            id="inputPApellido"
                            name="first_last_name"
                            required
                            minlength="3"
                            maxlength="50"
                            placeholder="Ingresa su primer apellido"
                            onkeyup="this.value = this.value.toUpperCase();"
                            title="Primer apellido del empleado"
                      />
                    </div>
    
                    <div class="col-3 form-group">
                      <label for="inputSApellido">Segundo Apellido</label>
                      <input type="text" 
                            class="form-control" 
                            id="inputSApellido"
                            name="second_last_name"
                            minlength="3"
                            maxlength="50"
                            placeholder="Ingresa su segundo apellido"
                            onkeyup="this.value = this.value.toUpperCase();"
                            title="Segundo apellido del empleado"
                      />
                    </div>
    
                    <div class="col-3 form-group">
                      <label for="selectSexo">Sexo*</label>
                      <select id="selectSexo" class="form-control" name="sex" title="Sexo del empleado">
                        <option value="0" selected>SELECCIONE EL SEXO</option>
                        <option value="M">MASCULINO</option>
                        <option value="F">FEMENINO</option>
                      </select>
                    </div>
          
                    <div class="col-3 form-group">
                      <label for="inputBirthday">Fecha de Nacimiento*</label>
                      <input type="date"
                            class="form-control" 
                            id="inputBirthday" 
                            name="birthday"
                            title="Fecha de nacimiento del empleado"
                            required
                      />
                    </div>
          
                    <div class="col-3 form-group">
                      <label for="inputPlaceOfBirth">Lugar de Nacimiento*</label>
                      <input type="text"
                            class="form-control"
                            id="inputPlaceOfBirth"
                            name="place_of_birth"
                            maxlength="255"
                            required
                            placeholder="Ingresa el lugar de nacimiento"
                            onkeyup="this.value = this.value.toUpperCase();"
                            title="Lugar de nacimiento del empleado"
                      />
                    </div>
    
                    <div class="col-3 form-group">
                      <label for="selectEstadoCivil">Estado Civil*</label>
                      <select id="selectEstadoCivil" class="form-control" name="civil_status_id" title="Estado Civil del empleado">
                        <option value="0" selected>SELECCIONE ESTADO CIVIL</option>
                        @foreach (App\Enums\CivilStatusEnum::cases() as $case)
                          <option value="{{ $case->value }}">{{ $case->label() }}</option>
                        @endforeach
                      </select>
                    </div>
          
                    <div class="col-3 form-group">
                      <label for="selectSangre">Tipo de Sangre*</label>
                      <select id="selectSangre" class="form-control" name="blood_type" title="Tipo sanguineo del empleado">
                        <option value="0" selected>SELECCIONE TIPO</option>
                        @foreach (App\Enums\BloodTypeEnum::cases() as $case)
                          <option value="{{ $case->value }}">{{ $case->value }}</option>
                        @endforeach
                      </select>
                    </div>
    
                    <div class="col-3 form-group">
                      <label for="inputPassport">Pasaporte Nro.</label>
                      <input type="text"
                            class="form-control"
                            id="inputPassport"
                            name="passport_nro"
                            maxlength="20"
                            placeholder="Ingresa número de pasaporte"
                            onkeyup="this.value = this.value.toUpperCase();"
                            title="Nro. de pasaporte del empleado"
                      />
                    </div>
              </div>
              <!-- fin de row -->
    
              <!-- inicio de row -->
              <div class="row">
                
                <!-- correos del empleado -->
                @include('common.datos-correos')
    
                <!-- telefonos del empleado -->
                @include('common.datos-tlfs')
    
                <!-- direcciones del empleado -->
                @include('common.datos-addresses')
    
                <!-- observaciones -->
                <div class="col">
                  <div class="card bg-light">
                    <div class="card-header bg-lightblue">
                      <h3 class="card-title">Observaciones generales</h3>
                    </div>
        
                    <div class="card-body">
                      <div class="form-group">
                        <textarea class="form-control"
                                  id="inputNotas"
                                  name="notes"
                                  placeholder="Ingresa las observaciones"
                                  rows="3"
                                  onkeyup="this.value = this.value.toUpperCase();"
                                  title="Observaciones generales"
                        /></textarea>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- fin de observaciones -->
              </div>
              <!-- fin de row -->
            </div>
            <!-- fin tab datos personales -->
    
            <!-- tab datos laborales -->
            <div class="tab-pane fade" id="custom-tabs-one-admin" role="tabpanel">
              <!-- inicio de row -->
              <div class="row">
                <div class="col-4 form-group">
                  <label for="inputCodigo">Código de Nómina*</label>
                  <input type="text" 
                        class="form-control" 
                        id="inputCodigo" 
                        name="codigo_nomina"
                        placeholder="Ingrese código de nómina"
                        title="Código de la nómina"
                  />
                </div>
    
                <div class="col-4 form-group">
                  <label for="inputFechaIngreso">Fecha de Ingreso*</label>
                  <input type="date"
                        class="form-control" 
                        id="inputFechaIngreso" 
                        name="fecha_ingreso"
                        title="Fecha de ingreso del empleado"
                  />
                </div>
    
                <div class="col-4 form-group">
                  <label for="selectCargo">Cargo*</label>
                  <select id="selectCargo" class="form-control" name="cargo_id" title="Cargo actual del empleado">
                    <option value="0" selected>SELECCIONE EL CARGO</option>
                    @foreach($cargos as $cargo)
                      <option value="{{ $cargo->id }}">{{ $cargo->name }}</option>
                    @endforeach
                  </select>
                </div>
    
                <div class="col-4 form-group">
                  <label>Condición</label>
                  <input type="text" class="form-control" value="ACTIVO" readonly>
                </div>
    
                <div class="col-4 form-group">
                  <label>Tipo</label>
                  <input type="text" class="form-control" value="OBRERO" readonly>
                </div>
    
                <div class="col-4 form-group">
                  <label for="selectUnidad">Unidad Operativa*</label>
                  <select id="selectUnidad" class="form-control" title="Ubicación del empleado">
                    <option value="0" selected>SELECCIONE LA UNIDAD</option>
                    @foreach($unidades as $unidad)
                      <option value="{{ $unidad->id }}">{{ $unidad->name }}</option>
                    @endforeach
                  </select>
                </div>
    
                <div class="col-4 form-group">
                  <label for="selectUnidadEspecifica">Unidad Operativa específica*</label>
                  <select id="selectUnidadEspecifica" class="form-control" name="unidad_id" title="Ubicación específica del empleado">
                  </select>
                </div>
                
                <div class="col-4 form-group">
                  <label for="inputPatria">Carnet de la Patria: Código*</label>
                  <input type="text"
                        class="form-control"
                        id="inputPatria"
                        name="codigo_patria"
                        placeholder="Código del carnet patria"
                        title="Código del carnet de la patria"
                  />
                </div>
    
                <div class="col-4 form-group">
                  <label for="inputSerialPatria">Carnet de la Patria: Serial*</label>
                  <input type="text"
                        class="form-control"
                        id="inputSerialPatria"
                        name="serial_patria"
                        placeholder="Serial del carnet patria"
                        title="Serial del carnet de la patria"
                  />
                </div>
    
                <div class="col-4 form-group">
                  <label for="inputReligion">Religión</label>
                  <input type="text"
                        class="form-control"
                        id="inputReligion"
                        name="religion"
                        placeholder="Religión prefesada por el empleado"
                        onkeyup="this.value = this.value.toUpperCase();"
                        title="Religión profesada por el empleado"
                  />
                </div>
    
                <div class="col-4 form-group">
                  <label for="inputDeporte">Deporte</label>
                  <input type="text"
                        class="form-control"
                        id="inputDeporte"
                        name="deporte"
                        placeholder="Deporte practicado por el empleado"
                        onkeyup="this.value = this.value.toUpperCase();"
                        title="Deporte practicado por el empleado"
                  />
                </div>
    
                <div class="col-4 form-group">
                  <label for="inputLicencia">Licencia de conducir</label>
                  <input type="text"
                        class="form-control"
                        id="inputLicencia"
                        name="licencia"
                        placeholder="Ingrese la licencia de conducir"
                        title="Licencia de conducir del empleado"
                  />
                </div>
    
                <div class="col-4 form-group">
                  <label for="inputCtaBancaria">Cuenta Bancaria Nro.*</label>
                  <input type="text"
                        class="form-control"
                        id="inputCtaBancaria"
                        name="cta_bancaria_nro"
                        placeholder="Ingresa número de cuenta bancaria"
                        title="Nro de cuentan bancaria del empleado"
                  />
                </div>
              </div>
              <!-- fin de row -->
            </div>
            <!-- fin datos laborales -->
    
            <!-- tab datos fisionomicos -->
            @include('common.datos-fisionomicos')
    
            <!-- datos familiaries -->
            @include('common.datos-familiares')
    
            <!-- datos academicos -->
            @include('common.datos-academicos')

          </div>
          <!-- fin de tab -->
        </form>
        </div>
        <!-- fin de card-body -->  
      </div>
    </div>
  </div>
@endsection

@section('js')
  <script>
  $(document).ready(function () {
    ///////////////////////////////////////////////////////////////////
    // tabla de emails
    ///////////////////////////////////////////////////////////////////
    
    var emails = [];

    ///////////////////////////////////////////////////////////////////
    // tabla de telefonos
    ///////////////////////////////////////////////////////////////////

    var phones = [];

    ///////////////////////////////////////////////////////////////////
    // tabla de direcciones
    ///////////////////////////////////////////////////////////////////

    var addresses = [];

    ///////////////////////////////////////////////////////////////////
    // tabla de familiares
    ///////////////////////////////////////////////////////////////////

    var familiares = [];

    ///////////////////////////////////////////////////////////////////
    // tabla de datos academicos
    ///////////////////////////////////////////////////////////////////

    var estudios = [];

    //
    initForm();

    ///////////////////////////////////////////////////////////////////
    // inicializar formulario
    ///////////////////////////////////////////////////////////////////
    
    function initForm() {
      // configurar 'toastr'
      toastr.options.closeButton = true;
      toastr.options.timeOut = 0;
      toastr.options.extendedTimeOut = 0;

      // mascara para el nombre
      $("#inputPNombre").inputmask(lib_characterMask());
      $("#inputSNombre").inputmask(lib_characterMask());
      $("#inputPApellido").inputmask(lib_characterMask());
      $("#inputSApellido").inputmask(lib_characterMask());

      // mascara para el numero de telefono
      $("#inputPhone").inputmask(lib_phoneMask());
    }

    ///////////////////////////////////////////////////////////////////
    // foto frontal del empleado
    ///////////////////////////////////////////////////////////////////

    $("#inputFotoFrente").change(function() {
      let imagen = this.files[0];
      let reader = new FileReader();

      reader.onload = function(e) {
        $("#imgFotoFrente").attr('src', e.target.result);
      };

      reader.readAsDataURL(imagen);
    });

    ///////////////////////////////////////////////////////////////////
    // foto del lado izquierdo del empleado
    ///////////////////////////////////////////////////////////////////

    $("#inputFotoLIzquierdo").change(function() {
      let imagen = this.files[0];
      let reader = new FileReader();

      reader.onload = function(e) {
        $("#imgFotoLIzquierdo").attr('src', e.target.result);
      };

      reader.readAsDataURL(imagen);
    });

    ///////////////////////////////////////////////////////////////////
    // foto del lado derecho del empleado
    ///////////////////////////////////////////////////////////////////

    $("#inputFotoLDerecho").change(function() {
      let imagen = this.files[0];
      let reader = new FileReader();

      reader.onload = function(e) {
        $("#imgFotoLDerecho").attr('src', e.target.result);
      };

      reader.readAsDataURL(imagen);
    });

    ///////////////////////////////////////////////////////////////////
    // emails: pintar
    ///////////////////////////////////////////////////////////////////
    
    function emailsDraw() {
      let fila = '';

      $("#emailsDT tbody").empty();
      emails.forEach(item => {
        fila = `<tr>
                  <td>${item.email}</td>
                  <td>
                    <button type="button" class="eliminar btn btn-danger btn-sm" title="Eliminar correo"><i class="fas fa-trash-alt"></i></button>
                  </td>
                </tr>`;
      
        $('#emailsDT tbody').append(fila);
      });
    };

    ///////////////////////////////////////////////////////////////////
    // emails: agregar
    ///////////////////////////////////////////////////////////////////

    $("#btnEmailAdd").click(function () {
      let correo = $("#inputEmail").val();

      if(lib_isEmpty(correo)) {
        lib_toastr("Error: Debe ingresar la dirección de correo!");
      }
      else {
        emails.push({'email' : correo, 'status' : 'C'});
        $("#inputEmail").val('');
        emailsDraw();
      }
    });

    ///////////////////////////////////////////////////////////////////
    // emails: eliminar
    ///////////////////////////////////////////////////////////////////

    $("#emailsDT tbody").on("click", ".eliminar", function() {
      let fila = $(this).closest("tr");
      let correo = fila.find("td").eq(0).text();

      emails = emails.filter(item => item.email != correo);
      emailsDraw();
    });

    ///////////////////////////////////////////////////////////////////
    // phones: pintar
    ///////////////////////////////////////////////////////////////////
    
    function phonesDraw() {
      let fila = '';

      $("#phonesDT tbody").empty();
      phones.forEach(item => {
        fila = `<tr>
                  <td>${item.type}</td>
                  <td>${item.number}</td>
                  <td>
                    <button type="button" class="eliminar btn btn-danger btn-sm" title="Eliminar correo"><i class="fas fa-trash-alt"></i></button>
                  </td>
                </tr>`;
      
        $('#phonesDT tbody').append(fila);
      });
    };

    ///////////////////////////////////////////////////////////////////
    // phones: agregar
    ///////////////////////////////////////////////////////////////////

    $("#btnPhoneAdd").click(function() {
      let numeroTipo = $("#selectPhoneType :selected").val();
      let numero = $("#inputPhone").val();
      
      if(numeroTipo == '0') {
        lib_toastr("Error: Debe seleccionar un tipo de número de teléfono!");
      }
      else if(lib_isEmpty(numero)) {
        lib_toastr("Error: Debe ingresar un número de teléfono!");
      }
      else {
        phones.push({
          'phone_type_id' : numeroTipo,
          'type'          : $("#selectPhoneType :selected").text(),
          'number'        : numero,
          'status'        : 'C'
        });
        $("#inputPhone").val("");
        phonesDraw();
      }
    });

    ///////////////////////////////////////////////////////////////////
    // phones: eliminar
    ///////////////////////////////////////////////////////////////////

    $("#phonesDT tbody").on("click", ".eliminar", function() {
      let fila = $(this).closest("tr");
      let numero = fila.find("td").eq(1).text();

      phones = phones.filter(item => item.number != numero);
      phonesDraw();
    });

    ///////////////////////////////////////////////////////////////////
    // cargar municipios
    ///////////////////////////////////////////////////////////////////

    $("#selectEstados").change(function() {
      let estado_id = $(this).val();
      let ruta = "{{ route('ubicacion.municipios', ['estado_id' => '.valor']) }}";

      ruta = ruta.replace('.valor', estado_id);
      fetch(ruta)
      .then(response => response.json())
      .then(r => {
        $("#selectMunicipios").empty();
        $("#selectMunicipios").append('<option value="0">SELECCIONE EL MUNICIPIO</option>');
        r.municipios.forEach(element => {
          $("#selectMunicipios").append(`<option value="${element.id_municipio}">${element.municipio}</option>`);
        });
      });
    });

    ///////////////////////////////////////////////////////////////////
    // cargar parroquias
    ///////////////////////////////////////////////////////////////////

    $("#selectMunicipios").change(function() {
      let municipio_id = $(this).val();
      let ruta = "{{ route('ubicacion.parroquias', ['municipio_id' => '.valor']) }}";

      ruta = ruta.replace('.valor', municipio_id);
      fetch(ruta)
      .then(response => response.json())
      .then(r => {
        $("#selectParroquias").empty();
        $("#selectParroquias").append('<option value="0">SELECCIONE LA PARROQUIA</option>');
        r.parroquias.forEach(element => {
          $("#selectParroquias").append(`<option value="${element.id_parroquia}">${element.parroquia}</option>`);
        });
      });
    });

    ///////////////////////////////////////////////////////////////////
    // direcciones: pintar
    ///////////////////////////////////////////////////////////////////
    
    function addressesDraw() {
      let fila = '';

      $("#addressesDT tbody").empty();
      addresses.forEach(item => {
        fila = `<tr>
                  <td>${item.estado}</td>
                  <td>${item.municipio}</td>
                  <td>${item.parroquia}</td>
                  <td>${item.address}</td>
                  <td>${item.zona_postal}</td>
                  <td>
                    <button type="button" class="eliminar btn btn-danger btn-sm" title="Eliminar correo"><i class="fas fa-trash-alt"></i></button>
                  </td>
                </tr>`;
  
        $('#addressesDT tbody').append(fila);
      });
    };

    ///////////////////////////////////////////////////////////////////
    // direcciones: agregar
    ///////////////////////////////////////////////////////////////////

    $("#btnAddressAdd").click(function() {
      let estado    = $("#selectEstados :selected").val();
      let municipio = $("#selectMunicipios :selected").val();
      let parroquia = $("#selectParroquias :selected").val();
      let address   = $("#inputAddress").val();
      let zp        = $("#inputZonaPostal").val();
      
      if(estado == '0') {
        lib_toastr("Error: Debe seleccionar un Estado!");
      }
      else if(municipio == '0') {
        lib_toastr("Error: Debe seleccionar un Municipio!");
      }
      else if(parroquia == '0') {
        lib_toastr("Error: Debe seleccionar una Parroquia!");
      }
      else if(lib_isEmpty(address)) {
        lib_toastr("Error: Debe ingresar una dirección!");
      }
      else if(lib_isEmpty(zp)) {
        lib_toastr("Error: Debe ingresar la zona postal de la dirección!");
      }
      else {
        addresses.push({
          'estado'        : $("#selectEstados :selected").text(),
          'municipio'     : $("#selectMunicipios :selected").text(),
          'parroquia_id'  : $("#selectParroquias :selected").val(),
          'parroquia'     : $("#selectParroquias :selected").text(),
          'address'       : address,
          'zona_postal'   : zp,
          'status'        : 'C'
        });
        $("#inputAddress").val("");
        $("#inputZonaPostal").val("5101");
        addressesDraw();
      }
    });

    ///////////////////////////////////////////////////////////////////
    // direcciones: eliminar
    ///////////////////////////////////////////////////////////////////

    $("#addressesDT tbody").on("click", ".eliminar", function() {
      let fila = $(this).closest("tr");
      let address = fila.find("td").eq(3).text();

      addresses = addresses.filter(item => item.address != address);
      addressesDraw();
    });

    ///////////////////////////////////////////////////////////////////
    // cargar unidades especificas de una unidad general
    ///////////////////////////////////////////////////////////////////

    $("#selectUnidad").change(function() {
      let unidad_id = $(this).val();
      let ruta = "{{ route('unidades-e.getAll', ['padre_id' => '.valor']) }}";

      ruta = ruta.replace('.valor', unidad_id);
      fetch(ruta)
      .then(response => response.json())
      .then(r => {
        $("#selectUnidadEspecifica").empty();
        $("#selectUnidadEspecifica").append('<option value="0">SELECCIONE LA U.O.E.</option>');
        r.data.forEach(element => {
          $("#selectUnidadEspecifica").append(`<option value="${element.id}">${element.name}</option>`);
        });
      });
    });

    ///////////////////////////////////////////////////////////////////
    // familia: pintar
    ///////////////////////////////////////////////////////////////////
    
    function familiaresDraw() {
      let fila = '';

      $("#familiaresDT tbody").empty();
      familiares.forEach(item => {
        fila = `<tr>
                  <td>${item.parentesco}</td>
                  <td>${item.first_name}</td>
                  <td>${item.second_name}</td>
                  <td>${item.first_last_name}</td>
                  <td>${item.second_last_name}</td>
                  <td>
                    <button type="button" class="eliminar btn btn-danger btn-sm" title="Eliminar correo"><i class="fas fa-trash-alt"></i></button>
                  </td>
                </tr>`;
      
        $('#familiaresDT tbody').append(fila);
      });
    };

    ///////////////////////////////////////////////////////////////////
    // familia: agregar
    ///////////////////////////////////////////////////////////////////

    $("#btnFamiliarAdd").click(function() {
      let ok = true;
      let pnombre = $("#inputFPNombre").val();
      let snombre = $("#inputFSNombre").val();
      let papellido = $("#inputFPApellido").val();
      let sapellido = $("#inputFSApellido").val();
      let parentesco = $("#selectParentesco").val();
      
      if(lib_isEmpty(pnombre)) {
        lib_toastr("Error: Debe ingresar el primer nombre del familiar!");
        ok = false;
      }
      if(lib_isEmpty(papellido)) {
        lib_toastr("Error: Debe ingresar el primer apellido del familiar!");
        ok = false;
      }
      if(parentesco == '0') {
        lib_toastr("Error: Debe seleccionar el parentesco del familiar!");
        ok = false;
      }
      if(ok) {
        familiares.push({
          'parentesco_id'     : parentesco,
          'parentesco'        : $("#selectParentesco :selected").text(),
          'first_name'        : pnombre,
          'second_name'       : snombre,
          'first_last_name'   : papellido,
          'second_last_name'  : sapellido,
          'status'            : 'C'
        });
        $("#inputFPNombre").val('');
        $("#inputFSNombre").val('');
        $("#inputFPApellido").val('');
        $("#inputFSApellido").val('');
        familiaresDraw();
      }
    });

    ///////////////////////////////////////////////////////////////////
    // familia: eliminar
    ///////////////////////////////////////////////////////////////////

    $("#familiaresDT tbody").on("click", ".eliminar", function() {
      let fila = $(this).closest("tr");
      let nombre = fila.find("td").eq(1).text();

      familiares = familiares.filter(item => item.first_name != nombre);
      familiaresDraw();
    });

    ///////////////////////////////////////////////////////////////////
    // estudios: pintar
    ///////////////////////////////////////////////////////////////////
    
    function estudiosDraw() {
      let fila = '';

      $("#estudiosDT tbody").empty();
      estudios.forEach(item => {
        fila = `<tr>
                  <td>${item.tipo}</td>
                  <td>${item.fecha}</td>
                  <td>${item.descripcion}</td>
                  <td>
                    <button type="button" class="eliminar btn btn-danger btn-sm" title="Eliminar correo"><i class="fas fa-trash-alt"></i></button>
                  </td>
                </tr>`;
      
        $('#estudiosDT tbody').append(fila);
      });
    };

    ///////////////////////////////////////////////////////////////////
    // estudios: agregar
    ///////////////////////////////////////////////////////////////////

    $("#btnEstudiosAdd").click(function() {
      let ok = true;
      let tipo = $("#selectEstudioTipo").val();
      let fecha = $("#inputEstudioFecha").val();
      let descripcion = $("#inputEstudioDescripcion").val();
      
      if(tipo == '0') {
        lib_toastr("Error: Debe seleccionar el tipo de estudio!");
        ok = false;
      }
      if(lib_isEmpty(fecha)) {
        lib_toastr("Error: Debe ingresar la fecha del titulo!");
        ok = false;
      }
      if(lib_isEmpty(descripcion)) {
        lib_toastr("Error: Debe ingresar una descripción del titulo!");
        ok = false;
      }
      
      if(ok) {
        estudios.push({
          'tipo_id'     : tipo,
          'tipo'        : $("#selectEstudioTipo :selected").text(),
          'fecha'       : fecha,
          'descripcion' : descripcion,
          'status'      : 'C'
        });
        $("#selectEstudioTipo").val('0');
        $("#inputEstudioFecha").val('');
        $("#inputEstudioDescripcion").val('');
        estudiosDraw();
      }
    });

    ///////////////////////////////////////////////////////////////////
    // estudios: eliminar
    ///////////////////////////////////////////////////////////////////

    $("#estudiosDT tbody").on("click", ".eliminar", function() {
      let fila = $(this).closest("tr");
      let descripcion = fila.find("td").eq(2).text();

      estudios = estudios .filter(item => item.descripcion != descripcion);
      estudiosDraw();
    });

    ///////////////////////////////////////////////////////////////////
    // agregar empleado administrativo
    ///////////////////////////////////////////////////////////////////

    $("#btnGrabar").click(function() {
      // validaciones
      const data = new FormData(formEmpleado);

      data.append('emails', JSON.stringify(emails));
      data.append('phones', JSON.stringify(phones));
      data.append('addresses', JSON.stringify(addresses));
      data.append('family', JSON.stringify(familiares));
      data.append('estudios', JSON.stringify(estudios));

      fetch("{{ route('employees-obrero.store') }}", {
        headers: {
          'Accept' : 'application/json'
        },
        method  : "POST",
        body: data
      })
      .then(response => {
        if(response.ok) {
          lib_ShowMensaje("Empleado Obrero agregado!", 'mensaje')
          .then(response => window.close());
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

    ///////////////////////////////////////////////////////////////////
    // cerrar pestaña de actual
    ///////////////////////////////////////////////////////////////////

    $("#btnSalir").click(function() {
      window.close();
    });
  });
  </script>
@endsection