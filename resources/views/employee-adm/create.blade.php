@extends('adminlte::page')

@section('title', 'Empleado Administrativo')

@section('content_header')
  <div class="row">
    <div class="col-6">
      <h4>Agregar Datos del Empleado Administrativo</h4>
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
  <form id="empleadoForm">
    @csrf

    <div class="tab-content" id="custom-tabs-one-tabContent">      
      <!-- tab principal -->
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
            <input type="file" id="inputFotoFrente" name="imgFotoFrente" accept="image/*" style="display: none;" />
          </div>

          <div class="col-4 form-group text-center">
            <img src="{{ asset('assets/images/avatar.png') }}" 
                  id="imgFotoLIzquierdo" 
                  class="img-thumbnail border border-dark"
                  width="200"
                  height="250"
            >
            <label for="inputFotoLIzquierdo" class="form-control btn border mt-2">Lado Izquierdo</label>
            <input type="file" id="inputFotoLIzquierdo" name="imgLIzquierdo" accept="image/*" style="display: none;" />
          </div>

          <div class="col-4 form-group text-center">
            <img src="{{ asset('assets/images/avatar.png') }}" 
                  id="imgFotoLDerecho" 
                  class="img-thumbnail border border-dark"
                  width="200"
                  height="250"
            >
            <label for="inputFotoLDerecho" class="form-control btn border mt-2">Lado Derecho</label>
            <input type="file" id="inputFotoLDerecho" name="imgLDerecho" accept="image/*" style="display: none;" />
          </div>
        </div>
        <!-- fin de row -->

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
                  placeholder="Ingresa Nro. de cédula"
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
                  placeholder="Ingresa Nro. de R.I.F."
                  onkeyup="this.value = this.value.toUpperCase();"
            />
          </div>

          <div class="col-3 form-group">
            <label for="inputPNombre">Primer Nombre</label>
            <input type="text" 
                  class="form-control" 
                  id="inputPNombre"
                  name="first_name"
                  required
                  minlength="3"
                  maxlength="200"
                  placeholder="Ingresa su primer nombre"
                  onkeyup="this.value = this.value.toUpperCase();"
            />
          </div>

              <div class="col-3 form-group">
                <label for="inputSNombre">Segundo Nombre</label>
                <input type="text" 
                      class="form-control" 
                      id="inputSNombre"
                      name="second_name"
                      minlength="3"
                      maxlength="200"
                      placeholder="Ingresa su segundo nombre"
                      onkeyup="this.value = this.value.toUpperCase();"
                />
              </div>

              <div class="col-3 form-group">
                <label for="inputPApellido">Primer Apellido</label>
                <input type="text" 
                      class="form-control" 
                      id="inputPApellido"
                      name="first_last_name"
                      required
                      minlength="3"
                      maxlength="200"
                      placeholder="Ingresa su primer apellido"
                      onkeyup="this.value = this.value.toUpperCase();"
                />
              </div>

              <div class="col-3 form-group">
                <label for="inputSApellido">Segundo Apellido</label>
                <input type="text" 
                      class="form-control" 
                      id="inputSApellido"
                      name="second_last_name"
                      minlength="3"
                      maxlength="200"
                      placeholder="Ingresa su segundo apellido"
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
    
              <div class="col-3 form-group">
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
        </div>
        <!-- fin de row -->

        <!-- inicio de row -->
        <div class="row">
          
          <!-- correos del empleado -->
          <div class="col-6">
            <div class="card card-primary">
              <div class="card-header bg-lightblue">
                <h3 class="card-title">Correo(s) del Empleado</h3>
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
                      />

                      <div class="input-group-append">
                        <button type="button" id="btnEmailAdd" class="input-group-text btn btn-primary btn-sm"><i class="fas fa-plus-square"></i></button>    
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
                <h3 class="card-title">Teléfono(s) del Empleado</h3>
              </div>
              <!-- /.card-header -->
                <div class="card-body">
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
                      <div class="input-group">
                        <input type="text"
                            class="form-control"
                            id="inputPhone"
                            placeholder="Ingresa el número de teléfono"
                        />
  
                        <div class="input-group-append">
                          <button type="button" id="btnPhoneAdd" class="input-group-text btn btn-primary btn-sm"><i class="fas fa-plus-square"></i></button>
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

        </div>
        <!-- fin de row -->

        <div class="form-group">
          <label for="inputNotas">Observaciones</label>
          <textarea class="form-control"
                    id="inputNotas"
                    name="notes"
                    placeholder="Ingresa las observaciones"
                    rows="3"
                    onkeyup="this.value = this.value.toUpperCase();"
          /></textarea>
        </div>

      </div>
      <!-- fin de tab principal -->

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

          <div class="col-4 form-group">
            <label for="inputCtaBancaria">Nro. Cuenta Bancaria</label>
            <input type="text"
                  class="form-control"
                  id="inputCtaBancaria"
                  name="nro_cta_bancaria"
                  value="NO DEFINIDO"
                  placeholder="Nro. de cuenta bancaria"
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

    var addresses   = [];                                               // direcciones del empleado
    var municipios  = {{ Js::from($municipios) }};
    var parroquias  = {{ Js::from($parroquias) }};

    ///////////////////////////////////////////////////////////////////
    // configuracion de 'toatsr'
    ///////////////////////////////////////////////////////////////////

    toastr.options.closeButton = true;
    toastr.options.timeOut = 0;
    toastr.options.extendedTimeOut = 0;

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
            return '<button type="button" class="eliminar btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i></button>';
          },
          orderable: false
        }
      ]
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
      emailsDT.row($(this).parents())
              .remove()
              .draw();
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
            return '<button type="button" class="eliminar btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i></button>';
          },
          orderable: false
        }
      ]
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
      phonesDT.row($(this).parents())
              .remove()
              .draw();
    });

    ///////////////////////////////////////////////////////////////////
    // cerrar pestaña de edicion
    ///////////////////////////////////////////////////////////////////

    $("#btnSalir").click(function() {
      window.close();
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
    // agregar un empleado 
    ///////////////////////////////////////////////////////////////////

    $("#btnGrabar").click(function() {
      let data = new FormData(empleadoForm);

      emailsDT.column(0).data().each(correo => data.append('emails[]', correo));

      
      console.log(data);
      return;

      if(phones.length < 1) {
        lib_toastr("Error: Debe ingresar al menos un número de teléfono!");
        return;
      }

      if(addresses.length < 1) {
        lib_toastr("Error: Debe ingresar al menos una dirección de ubicación!");
        return;
      }

      //const data = new FormData(empleadoForm);
      
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