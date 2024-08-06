@extends('adminlte::page')

@section('title', 'Empleado Obrero')

@section('content_header')
  <div class="row">
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
  <div class="card card-primary card-tabs">
    <!-- card-header -->
    <div class="card-header p-0 pt-1">
      <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
        <li class="nav-item">
          <a class="nav-link active" id="custom-tabs-one-home-tab" data-toggle="pill" href="#custom-tabs-one-home" role="tab" aria-controls="custom-tabs-one-home" aria-selected="true">Personales</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" id="custom-tabs-one-admin-tab" data-toggle="pill" href="#custom-tabs-one-admin" role="tab" aria-controls="custom-tabs-one-admin" aria-selected="false">Administrativos</a>
        </li>
      </ul>
    </div>
    <!-- fin de card-header -->

    <div class="card-body">
    <form id="formEmpleado">
      @csrf

      <div class="tab-content" id="custom-tabs-one-tabContent">      
        <!-- tab datos personales -->
        <div class="tab-pane fade active show" id="custom-tabs-one-home" role="tabpanel" aria-labelledby="custom-tabs-one-home-tab">

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
            <div class="col-6">
              <div class="card card-primary">
                <div class="card-header bg-lightblue">
                  <h3 class="card-title">Correo(s) del Empleado*</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                  <div class="row">
                    <div class="col-12">
                      <div class="input-group">
                        <input type="email"
                            class="form-control"
                            id="inputEmail"
                            placeholder="Ingresa el correo electrónico"
                            onkeyup="this.value = this.value.toLowerCase();"
                            title="Correo del empleado"
                        />

                        <div class="input-group-append">
                          <button type="button" 
                                  id="btnEmailAdd" 
                                  class="input-group-text btn btn-primary btn-sm"
                                  title="Agregar correo del empleado"
                          >
                            <i class="fas fa-plus-square"></i>
                          </button>    
                        </div>
                      </div>
                    </div>

                    <div class="col-12">
                      <table id="emailsDT" class="table table-hover border border-primary">
                        <thead class="text-center">
                          <tr>
                            <th scope="col">Correo</th>
                            <th scope="col"></th>
                          </tr>
                        </thead>
          
                        <tbody></tbody>
                      </table>
                    </div>
                  </div> 
                </div>
                <!-- /.card-body -->
              </div>
            </div>
            <!-- fin de correos del empleado-->

            <!-- telefonos del empleado -->
            <div class="col-6">
              <div class="card bg-light ">
                <div class="card-header bg-lightblue">
                  <h3 class="card-title">Teléfono(s) del Empleado*</h3>
                </div>

                <!-- /.card-header -->
                  <div class="card-body">
                    <div class="row">
                      <div class="col-6">
                        <select id="selectPhoneType" class="form-control" title="Tipo de número">
                          <option value="0" selected>SELECCIONE TIPO DE NÚMERO</option>
                          @foreach (App\Enums\PhoneTypeEnum::cases() as $case)
                            <option value="{{ $case->value }}">{{ $case->label() }}</option>
                          @endforeach
                          </select>
                      </div>

                      <div class="col-6">
                        <div class="input-group">
                          <input type="text"
                              class="form-control"
                              id="inputPhone"
                              placeholder="Ingresa el número de teléfono"
                              title="Teléfono del empleado"
                          />
    
                          <div class="input-group-append">
                            <button type="button" 
                                    id="btnPhoneAdd" 
                                    class="input-group-text btn btn-primary btn-sm"
                                    title="Agregar número de teléfono del empleado"
                            >
                              <i class="fas fa-plus-square"></i>
                            </button>
                          </div>
                        </div>
                      </div>
    
                      <div class="col-12">
                        <table id="phonesDT" class="table table-hover border border-primary">
                          <thead>
                            <tr>
                              <th scope="col">TipoID</th>
                              <th scope="col">Tipo</th>
                              <th scope="col">Número</th>
                              <th scope="col"></th>
                            </tr>
                          </thead>
            
                          <tbody></tbody>
                        </table>
                      </div>
                    </div>  
                  </div>
                  <!-- /.card-body -->
              </div>
            </div>
            <!-- fin de telefonos del empleado-->

            <!-- direcciones del empleado -->
            <div class="col-12">
              <div class="card bg-light">
                <div class="card-header bg-lightblue">
                  <h3 class="card-title">Dirección(es) de ubicación del Empleado*</h3>
                </div>
                <!-- /.card-header -->
                  <div class="card-body">
                    <div class="row">
                      <div class="col-6 mb-1">
                        <select id="selectEstados" class="form-control" title="Ubicación del empleado: Estado">
                          <option value="0" selected>SELECCIONE EL ESTADO</option>
                          @foreach ($estados as $estado)
                            <option value="{{ $estado->id_estado }}">{{ $estado->estado }}</option>
                          @endforeach
                          </select>
                        </select>
                      </div>

                      <div class="col-6">
                        <select id="selectMunicipios" class="form-control" title="Ubicación del empleado: Municipio"></select>
                      </div>

                      <div class="col-6 mb-1">
                        <select id="selectParroquias" class="form-control" title="Ubicación del empleado: Parroquia"></select>
                      </div>

                      <div class="col-6">
                        <div class="input-group">
                          <input type="text"
                              class="form-control"
                              id="inputAddress"
                              placeholder="Ingresa la dirección"
                              onkeyup="this.value = this.value.toUpperCase();"
                              title="Ubicación del empleado: Dirección"
                          />
    
                          <div class="input-group-append">
                            <button type="button"
                                    id="btnAddressAdd"
                                    class="input-group-text btn btn-primary btn-sm"
                                    title="Agregar ubicación del empleado"
                            >
                              <i class="fas fa-plus-square"></i>
                            </button>
                          </div>
                        </div>
                      </div>
    
                      <div class="col-12">
                        <table id="addressesDT" class="table table-hover border border-primary">
                          <thead>
                            <tr>
                              <th scope="col">Estado</th>
                              <th scope="col">Municipio</th>
                              <th scope="col">ParroquiaID</th>
                              <th scope="col">Parroquia</th>
                              <th scope="col">Dirección</th>
                              <th scope="col">Z. P.</th>
                              <th scope="col"></th>
                            </tr>
                          </thead>
            
                          <tbody></tbody>
                        </table>
                      </div>
                    </div>  
                  </div>
                  <!-- /.card-body -->
              </div>
            </div>
            <!-- fin de direcciones del empleado-->

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

        <!-- tab datos administrativos -->
        <div class="tab-pane fade" id="custom-tabs-one-admin" role="tabpanel" aria-labelledby="custom-tabs-one-admin-tab">
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
              <label for="selectCondicion">Condición*</label>
              <select id="selectCondicion" class="form-control" name="condicion_id" title="Condición actual del empleado">
                <option value="0" selected>SELECCIONE LA CONDICIÓN</option>
                @foreach($condiciones as $condicion)
                  <option value="{{ $condicion->id }}">{{ $condicion->name }}</option>
                @endforeach
              </select>
            </div>

            <div class="col-4 form-group">
              <label for="selectTipo">Tipo*</label>
              <select id="selectTipo" class="form-control" name="tipo_id" title="Tipo de empleado">
                <option value="0" selected>SELECCIONE EL TIPO</option>
                @foreach($tipos as $tipo)
                  <option value="{{ $tipo->id }}">{{ $tipo->name }}</option>
                @endforeach
              </select>
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
              <label for="inputPatria">Código del Carnet de la Patria*</label>
              <input type="text"
                    class="form-control"
                    id="inputPatria"
                    name="codigo_patria"
                    placeholder="Código del carnet patria"
                    title="Código del carnet de la patria"
              />
            </div>

            <div class="col-4 form-group">
              <label for="inputSerialPatria">Serial del Carnet de la Patria*</label>
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
              <label for="inputLicencia">Licencia</label>
              <input type="text"
                    class="form-control"
                    id="inputLicencia"
                    name="licencia"
                    placeholder="Ingrese la licencia"
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
        <!-- fin datos administrativos -->
      </div>
      <!-- fin de tab -->
    </form>
    </div>
    <!-- fin de card-body -->  
  </div>
@endsection

@section('js')
  <script>
  $(document).ready(function () {
    ///////////////////////////////////////////////////////////////////
    // tabla de emails
    ///////////////////////////////////////////////////////////////////

    var emailsDT = $('#emailsDT').DataTable({
      info: false,
      paging: false,
      searching: false,
      columns: [
        {
          data: 'correo',
          orderable: false,
          width: '95%'
        },
        {
          data: null,
          render: function ( data, type, row, meta ) {
            return '<button type="button" class="eliminar btn btn-danger btn-sm" title="Eliminar correo"><i class="fas fa-trash-alt"></i></button>';
          },
          orderable: false
        }
      ]
    });

    ///////////////////////////////////////////////////////////////////
    // tabla de telefonos
    ///////////////////////////////////////////////////////////////////

    var phonesDT = $('#phonesDT').DataTable({
      info: false,
      paging: false,
      searching: false,
      columns: [
        {
          data: 'id',
          visible: false
        },
        {
          data: 'tipo',
          width: '50%',
          orderable: false
        },
        {
          data: 'numero',
          width: '45%',
          orderable: false
        },
        {
          data: null,
          render: function ( data, type, row, meta ) {
            return '<button type="button" class="eliminar btn btn-danger btn-sm" title="Eliminar teléfono"><i class="fas fa-trash-alt"></i></button>';
          },
          orderable: false
        }
      ]
    });

    ///////////////////////////////////////////////////////////////////
    // tabla de direcciones
    ///////////////////////////////////////////////////////////////////

    var addressesDT = $('#addressesDT').DataTable({
      info: false,
      paging: false,
      searching: false,
      columns: [
        {
          data: 'estado',
          orderable: false
        },
        {
          data: 'municipio',
          orderable: false
        },
        {
          data: 'parroquiaId',
          visible: false
        },
        {
          data: 'parroquia',
          orderable: false
        },
        {
          data: 'direccion',
          orderable: false
        },
        {
          data: 'zona_postal',
          orderable: false,
          width: "5%"
        },
        {
          data: null,
          render: function ( data, type, row, meta ) {
            return '<button type="button" class="eliminar btn btn-danger btn-sm" title="Eliminar dirección"><i class="fas fa-trash-alt"></i></button>';
          },
          orderable: false
        }
      ]
    });

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

      // mascara la zona postal
      // POR REVISAR, COMO ASIGNAR MASCARA A ARRAY
      //$("#inputZonaPostal[]").inputmask(lib_digitMask());
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
    // agregar un email
    ///////////////////////////////////////////////////////////////////

    $("#btnEmailAdd").click(function () {
      emailsDT.row.add({'correo' : $("#inputEmail").val()}).draw();
      $("#inputEmail").val('');
    });

    ///////////////////////////////////////////////////////////////////
    // eliminar un email
    ///////////////////////////////////////////////////////////////////

    $("#emailsDT tbody").on("click",".eliminar",function() {
      emailsDT.row($(this).parents()).remove().draw();
    });

    ///////////////////////////////////////////////////////////////////
    // agregar telefono
    ///////////////////////////////////////////////////////////////////

    $("#btnPhoneAdd").click(function() {
      let _number = $("#inputPhone").val();
      
      if(lib_isEmpty(_number)) {
        lib_toastr("Error: Debe ingresar un número de teléfono!");
      }
      else {
        phonesDT.row.add({
          'id'    : $("#selectPhoneType :selected").val(),
          'tipo'  : $("#selectPhoneType :selected").text(),
          'numero': _number
        })
        .draw();
        $("#inputPhone").val("");
      }
    });

    ///////////////////////////////////////////////////////////////////
    // eliminar telefono
    ///////////////////////////////////////////////////////////////////

    $("#phonesDT tbody").on("click",".eliminar",function() {
      phonesDT.row($(this).parents()).remove().draw();
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
    // agregar direccion
    ///////////////////////////////////////////////////////////////////

    $("#btnAddressAdd").click(function() {
      let address = $("#inputAddress").val();
      
      if(lib_isEmpty(address)) {
        lib_toastr("Error: Debe ingresar una dirección!");
      }
      else {
        addressesDT.row.add({
          'estado'      : $("#selectEstados :selected").text(),
          'municipio'   : $("#selectMunicipios :selected").text(),
          'parroquiaId' : $("#selectParroquias :selected").val(),
          'parroquia'   : $("#selectParroquias :selected").text(),
          'direccion'   : address,
          'zona_postal' : '<input type="text" name="zona_postal[]" value="0000" maxlength="4" size="4" title="Zona Postal" />'
        })
        .draw();
        $("#inputAddress").val("");
      }
    });

    ///////////////////////////////////////////////////////////////////
    // eliminar direccion
    ///////////////////////////////////////////////////////////////////

    $("#addressesDT tbody").on("click",".eliminar",function() {
      addressesDT.row($(this).parents()).remove().draw();
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
    // agregar un empleado 
    ///////////////////////////////////////////////////////////////////

    $("#btnGrabar").click(function() {
      const data = new FormData(formEmpleado);

      emailsDT.column(0).data().each(correo => data.append('emails[]', correo));
      phonesDT.column(0).data().each(phone_type_id => data.append('phones_type_id[]', phone_type_id));
      phonesDT.column(2).data().each(phone => data.append('phones[]', phone));
      addressesDT.column(2).data().each(parroquia_id => data.append('parroquias_id[]', parroquia_id));
      addressesDT.column(4).data().each(address => data.append('addresses[]', address));

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