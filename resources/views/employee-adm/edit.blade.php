@extends('layouts.edit-page')

@section('title', 'Empleados Administrativos')

@section('css')
<style>
  .min-table {
    font-size: 12px
  }
</style>
@endsection

@section('content_header')
  <div class="row m-2">
    <div class="col-6">
      <h4>Editar Datos de Empleado Administrativo</h4>
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
      <!-- inicio de card -->
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
              <a class="nav-link" id="custom-tabs-one-fisio-tab" data-toggle="pill" href="#custom-tabs-one-fisio" role="tab" aria-controls="custom-tabs-one-fisio" aria-selected="false">Fisionómicos</a>
            </li>
    
            <li class="nav-item">
              <a class="nav-link" id="custom-tabs-one-familia-tab" data-toggle="pill" href="#custom-tabs-one-familia" role="tab" aria-controls="custom-tabs-one-familia" aria-selected="false">Familiares</a>
            </li>
    
            <li class="nav-item">
              <a class="nav-link" id="custom-tabs-one-estudios-tab" data-toggle="pill" href="#custom-tabs-one-estudios" role="tab" aria-controls="custom-tabs-one-estudios" aria-selected="false">Académicos</a>
            </li>
    
            <li class="nav-item">
              <a class="nav-link" id="custom-tabs-one-permisos-tab" data-toggle="pill" href="#custom-tabs-one-permisos" role="tab" aria-controls="custom-tabs-one-permisos" aria-selected="false">Permisos</a>
            </li>
    
            <li class="nav-item">
              <a class="nav-link" id="custom-tabs-one-reposos-tab" data-toggle="pill" href="#custom-tabs-one-reposos" role="tab" aria-controls="custom-tabs-one-reposos" aria-selected="false">Reposos</a>
            </li>
    
            <li class="nav-item">
              <a class="nav-link" id="custom-tabs-one-vacaciones-tab" data-toggle="pill" href="#custom-tabs-one-vacaciones" role="tab" aria-controls="custom-tabs-one-vacaciones" aria-selected="false">Vacaciones</a>
            </li>
          </ul>
        </div>
        <!-- fin de card-header -->
    
        <div class="card-body">
        <form id="formEmpleado">
          @method('PUT')
          @csrf
    
          <div class="tab-content" id="custom-tabs-one-tabContent">      
            <!-- tab datos personales -->
            <div class="tab-pane fade active show" id="custom-tabs-one-home" role="tabpanel"  aria-labelledby="custom-tabs-one-home-tab">
    
              <!-- inicio de row -->
              <div class="row d-flex justify-content-around">
                <div class="col-4 form-group text-center">
                  <img src="{{ asset($data['person']['imagef']) }}" 
                        id="imgFotoFrente" 
                        class="img-thumbnail border border-dark"
                        width="200"
                        height="250"
                  >
                  <label for="inputFotoFrente" class="form-control btn border mt-2">De Frente</label>
                  <input type="file" id="inputFotoFrente" name="imagef" accept="image/*" style="display: none;" />
                </div>
    
                <div class="col-4 form-group text-center">
                  <img src="{{ asset($data['person']['imageli']) }}" 
                        id="imgFotoLIzquierdo" 
                        class="img-thumbnail border border-dark"
                        width="200"
                        height="250"
                  >
                  <label for="inputFotoLIzquierdo" class="form-control btn border mt-2">Lado Izquierdo</label>
                  <input type="file" id="inputFotoLIzquierdo" name="imageli" accept="image/*" style="display: none;" />
                </div>
    
                <div class="col-4 form-group text-center">
                  <img src="{{ asset($data['person']['imageld']) }}" 
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
                        value="{{ $data['person']['cedula'] }}"
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
                        value="{{ $data['employee']['rif'] }}"
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
                        value="{{ $data['person']['first_name'] }}"
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
                            value="{{ $data['person']['second_name'] }}"
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
                            value="{{ $data['person']['first_last_name'] }}"
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
                            value="{{ $data['person']['second_last_name'] }}"
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
                        <option value="0">SELECCIONE EL SEXO</option>
                        <option value="M" {{ $data['person']['sex'] == 'M' ? 'selected':'' }}>MASCULINO</option>
                        <option value="F" {{ $data['person']['sex'] == 'F' ? 'selected' : '' }}>FEMENINO</option>
                      </select>
                    </div>
          
                    <div class="col-3 form-group">
                      <label for="inputBirthday">Fecha de Nacimiento*</label>
                      <input type="date"
                            class="form-control" 
                            id="inputBirthday" 
                            name="birthday"
                            value = "{{ $data['person']['birthday'] }}"
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
                            value = "{{ $data['person']['place_of_birth'] }}"
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
                          <option value="{{ $case->value }}" {{ $data['person']['civil_status_id'] == $case->value ? 'selected':''}}>{{ $case->label() }}</option>
                        @endforeach
                      </select>
                    </div>
          
                    <div class="col-3 form-group">
                      <label for="selectSangre">Tipo de Sangre*</label>
                      <select id="selectSangre" class="form-control" name="blood_type" title="Tipo sanguineo del empleado">
                        <option value="0" selected>SELECCIONE TIPO</option>
                        @foreach (App\Enums\BloodTypeEnum::cases() as $case)
                          <option value="{{ $case->value }}" {{ $data['person']['blood_type'] == $case->value ? 'selected':''}}>{{ $case->value }}</option>
                        @endforeach
                      </select>
                    </div>
    
                    <div class="col-3 form-group">
                      <label for="inputPassport">Pasaporte Nro.</label>
                      <input type="text"
                            class="form-control"
                            id="inputPassport"
                            name="passport_nro"
                            value = "{{ $data['employee']['passport_nro'] }}"
                            maxlength="20"
                            placeholder="Ingresa el numero de pasaporte"
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
    
                        <div class="col-12 mt-1">
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
                              @foreach (\App\Enums\PhoneTypeEnum::cases() as $case)
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
        
                          <div class="col-12 mt-1">
                            <table id="phonesDT" class="table table-hover border border-primary">
                              <thead>
                                <tr>
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
    
                          <div class="col-4">
                            <div class="input-group">
                              <input type="text"
                                  class="form-control"
                                  id="inputAddress"
                                  placeholder="Ingresa la dirección"
                                  onkeyup="this.value = this.value.toUpperCase();"
                                  title="Ubicación del empleado: Dirección"
                              />
                            </div>
                          </div>

                          <div class="col-2">
                            <div class="input-group">
                              <input type="text"
                                  class="form-control"
                                  id="inputZonaPostal"
                                  value="5101"
                                  maxlength="4"
                                  placeholder="Z.P."
                                  title="Ubicación del empleado: Zona Postal"
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
        
                          <div class="col-12 mt-1">
                            <table id="addressesDT" class="table table-hover border border-primary">
                              <thead>
                                <tr>
                                  <th scope="col">Estado</th>
                                  <th scope="col">Municipio</th>
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
                <div class="col-12">
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
                        />{{ $data['person']['notes'] }}</textarea>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- fin de observaciones -->
              </div>
              <!-- fin de row -->
            </div>
            <!-- fin de tab datos personales -->
    
            <!-- tab datos laborales -->
            <div class="tab-pane fade" id="custom-tabs-one-admin" role="tabpanel" aria-labelledby="custom-tabs-one-admin-tab">
              <div class="row">
                <div class="col-4 form-group">
                  <label for="inputCodigo">Código de Nómina*</label>
                  <input type="text" 
                        class="form-control" 
                        id="inputCodigo" 
                        name="codigo_nomina"
                        value="{{ $data['employee']['codigo_nomina'] }}"
                        placeholder="No. de código de nómina"
                        title="Código de la nómina"
                  />
                </div>
    
                <div class="col-4 form-group">
                  <label for="inputFechaIngreso">Fecha de Ingreso*</label>
                  <input type="date"
                        class="form-control" 
                        id="inputFechaIngreso" 
                        name="fecha_ingreso"
                        value="{{ $data['employee']['fecha_ingreso'] }}"
                        title="Fecha de ingreso del empleado"
                  />
                </div>
    
                <div class="col-4 form-group">
                  <label for="selectCargo">Cargo*</label>
                  <select id="selectCargo" class="form-control" name="cargo_id" title="Cargo actual del empleado">
                    <option value="0" selected>SELECCIONE EL CARGO</option>
                    @foreach($cargos as $cargo)
                      <option value="{{ $cargo->id }}" {{ ($data['employee']['cargo_id'] == $cargo->id) ? 'selected' : '' }}>
                        {{ $cargo->name }}
                      </option>
                    @endforeach
                  </select>
                </div>
    
                <div class="col-4 form-group">
                  <label for="selectCondicion">Condición*</label>
                  <select id="selectCondicion" class="form-control" name="condicion_id" title="Condición actual del empleado">
                    <option value="0" selected>SELECCIONE LA CONDICIÓN</option>
                    @foreach($condiciones as $condicion)
                      <option value="{{$condicion->id}}" {{$data['employee']['condicion_id'] == $condicion->id ? 'selected' : ''}}>
                        {{ $condicion->name }}
                      </option>
                    @endforeach
                  </select>
                </div>
    
                <div class="col-4 form-group">
                  <label for="selectTipo">Tipo*</label>
                  <select id="selectTipo" class="form-control" name="tipo_id" title="Tipo de empleado">
                    <option value="0" selected>SELECCIONE EL TIPO</option>
                    @foreach($tipos as $tipo)
                      <option value="{{ $tipo->id }}" {{ ($data['employee']['tipo_id'] == $tipo->id) ? 'selected' : '' }}>
                        {{ $tipo->name }}
                      </option>
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
                  <label for="selectUnidadEspecifica">Unidad Operativa específica</label>
                  <select id="selectUnidadEspecifica" class="form-control" name="unidad_id" title="Ubicación específica del empleado">
                    <option value="{{ $data['employee']['unidad_id'] }}">{{ $data['employee']['unidadEspecifica']->name }}</option>
                  </select>
                </div>
                
                <div class="col-4 form-group">
                  <label for="inputPatria">Código del carnet de la Patria*</label>
                  <input type="text"
                        class="form-control"
                        id="inputPatria"
                        name="codigo_patria"
                        value="{{ $data['employee']['codigo_patria'] }}"
                        placeholder="Código del carnet patria"
                        title="Código del carnet de la patria"
                  />
                </div>
    
                <div class="col-4 form-group">
                  <label for="inputSerialPatria">Serial del carnet de la Patria*</label>
                  <input type="text"
                        class="form-control"
                        id="inputSerialPatria"
                        name="serial_patria"
                        value="{{ $data['employee']['serial_patria'] }}"
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
                        value="{{ $data['employee']['religion'] }}"
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
                        value="{{ $data['employee']['deporte'] }}"
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
                        value="{{ $data['employee']['licencia'] }}"
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
                        value="{{ $data['employee']['cta_bancaria_nro'] }}"
                        placeholder="Nro. de cuenta bancaria"
                        title="Nro de cuentan bancaria del empleado"
                  />
                </div>
              </div>
            </div>
            <!-- fin de datos laborales -->
    
            <!-- tab datos fisionomicos -->
            <div class="tab-pane fade" id="custom-tabs-one-fisio" role="tabpanel" aria-labelledby="custom-tabs-one-fisio-tab">
              <div class="row">
                @forEach($data['employee']->fisionomia as $item)
                  <div class="col-3 form-group">
                    <label>{{ $item->fisionomia->descripcion }}</label>
                    <input type="hidden" name="fisionomia_id[]" value="{{ $item->fisionomia_id }}">
                    <input type="text" 
                          class="form-control" 
                          name="fisionomia[]"
                          value="{{ $item->info }}"
                          title="Datos fisionómicos"
                    />
                </div>
                @endforeach
              </div>
            </div>
            <!-- fin de datos fisionomicos -->
    
            <!-- datos familiaries -->
            <div class="tab-pane fade" id="custom-tabs-one-familia" role="tabpanel" aria-labelledby="custom-tabs-one-familia-tab">
              <div class="card card-primary">
                <div class="card-header bg-lightblue">
                  <h3 class="card-title">Familiares</h3>
                </div>
                <!-- /.card-header -->
    
                <div class="card-body">
                  <div class="row">
                    <div class="col-3 form-group">
                      <label for="inputFPNombre">Primer Nombre*</label>
                      <input type="text" 
                            class="form-control" 
                            id="inputFPNombre"
                            minlength="3"
                            maxlength="50"
                            placeholder="Ingresa su primer nombre"
                            onkeyup="this.value = this.value.toUpperCase();"
                            title="Primer nombre del familiar"
                      />
                    </div>
    
                    <div class="col-3 form-group">
                      <label for="inputFSNombre">Segundo Nombre</label>
                      <input type="text" 
                            class="form-control" 
                            id="inputFSNombre"
                            minlength="3"
                            maxlength="50"
                            placeholder="Ingresa su segundo nombre"
                            onkeyup="this.value = this.value.toUpperCase();"
                            title="Segundo nombre del familiar"
                      />
                    </div>
    
                    <div class="col-3 form-group">
                      <label for="inputFPApellido">Primer Apellido*</label>
                      <input type="text" 
                            class="form-control" 
                            id="inputFPApellido"
                            minlength="3"
                            maxlength="50"
                            placeholder="Ingresa su primer apellido"
                            onkeyup="this.value = this.value.toUpperCase();"
                            title="Primer apellido del familiar"
                      />
                    </div>
    
                    <div class="col-3 form-group">
                      <label for="inputFSApellido">Segundo Apellido</label>
                      <input type="text" 
                            class="form-control" 
                            id="inputFSApellido"
                            minlength="3"
                            maxlength="50"
                            placeholder="Ingresa su segundo apellido"
                            onkeyup="this.value = this.value.toUpperCase();"
                            title="Segundo apellido del familiar"
                      />
                    </div>
    
                    <div class="col-3 form-group">
                      <label for="selectParentesco">Parentesco</label>
                      <select id="selectParentesco" class="form-control" name="parentesco_id" title="Parentesco">
                        <option value="0" selected>SELECCIONE</option>
                        @foreach (App\Enums\ParentescoEnum::cases() as $case)
                          <option value="{{ $case->value }}">{{ $case->label() }}</option>
                        @endforeach
                      </select>
                    </div>
    
                    <div class="col-3 form-group d-flex">
                      <button type="button"
                              id="btnFamiliarAdd"
                              class="form-control btn btn-primary mt-auto" 
                              title="Agregar familiar"
                      >Agregar familiar</button>
                    </div>
    
                    <div class="col-12">
                      <table id="familiaresDT" class="table table-hover border border-primary" width="100%">
                        <thead class="text-center">
                          <tr>
                            <th>Parentesco</th>
                            <th>Primer Nombre</th>
                            <th>Segundo Nombre</th>
                            <th>Primer Apellido</th>
                            <th>Segundo Apellido</th>
                            <th></th>
                          </tr>
                        </thead>
          
                        <tbody>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
                <!-- /.card-body -->
              </div>
            </div>
            <!-- fin de datos familiares -->
    
            <!-- datos estudiantiles -->
            @include('common.datos-academicos')
    
            <!-- datos de los permisos -->
            @include('common.datos-permisos')
    
            <!-- reposos -->
            <div class="tab-pane fade" id="custom-tabs-one-reposos" role="tabpanel" aria-labelledby="custom-tabs-one-reposos-tab">
              <div class="card card-primary">
                <div class="card-header bg-lightblue">
                  <h3 class="card-title">Reposos del Empleado</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                  <div class="d-flex justify-content-end">
                    <button type="button" 
                            class="btn btn-primary"
                            id="btnReposoAdd"
                    ><i class="fas fa-plus-square"></i> Agregar reposo</button>
                  </div>

                  <table id="repososDT" class="table table-hover border border-primary min-table text-center" width="100%">
                    <thead>
                      <tr>
                        <th>id</th>
                        <th>Desde</th>
                        <th>Hasta</th>
                        <th>Fecha Notificación</th>
                        <th>Dr CI</th>
                        <th>Dr Nombre</th>
                        <th>Dr MPPS</th>
                        <th>Dr CMS</th>
                        <th>reposo_id</th>
                        <th>reposo_codigo</th>
                        <th>reposo</th>
                        <th>Fecha Convalidación</th>
                        <th>Dr CI</th>
                        <th>Dr Nombre</th>
                        <th>Dr MPPS</th>
                        <th>Dr CMS</th>
                        <th>status</th>
                        <th></th>
                      </tr>
                    </thead>

                    <tbody>
                      @foreach ($data['employee']->reposos as $reposo)
                        <tr>
                          <td>{{ $reposo->id}}</td>
                          <td>{{ $reposo->desde }}</td>
                          <td>{{ $reposo->hasta }}</td>
                          <td>{{ $reposo->noti_fecha }}</td>
                          <td>{{ $reposo->noti_dr_ci }}</td>
                          <td>{{ $reposo->noti_dr_nombre }}</td>
                          <td>{{ $reposo->noti_dr_mpps }}</td>
                          <td>{{ $reposo->noti_dr_cms }}</td>
                          <td>{{ $reposo->reposo_id }}</td>
                          <td>{{ is_null($reposo->reposo_id) ? '' : $reposo->reposo->codigo }}</td>
                          <td>{{ is_null($reposo->reposo_id) ? '' : $reposo->reposo->diagnostico }}</td>
                          <td>{{ $reposo->conva_fecha }}</td>
                          <td>{{ $reposo->conva_dr_ci }}</td>
                          <td>{{ $reposo->conva_dr_nombre }}</td>
                          <td>{{ $reposo->conva_dr_mpps }}</td>
                          <td>{{ $reposo->conva_dr_cms }}</td>
                          <td></td>
                          <td></td>
                        </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- fin de reposos -->
    
            <!-- datos vacaciones -->
            @include('common.datos-vacaciones')
    
          </div>
          <!-- fin de tab -->
        </form>
        </div>
        <!-- fin de card-body -->  
      </div>
      <!-- fin de card -->

      <!-- modal de reposos -->
      @include('employee-adm.reposos')

    </div>
  </div>
@endsection

@section('js')
<script>
  $(document).ready(function () {

    ///////////////////////////////////////////////////////////////////
    // ruta de la entidad a actualizar
    ///////////////////////////////////////////////////////////////////

    var ruta =  "{{ route('employees-adm.update', ['employees_adm' => $data['employee']]) }}";

    ///////////////////////////////////////////////////////////////////
    // tabla de emails
    ///////////////////////////////////////////////////////////////////
    
    let temp = {{ Js::from($data['person']['emails']) }};

    var emails = temp.map(item => {
                    return {id: item.id, email: item.email, status: ''}
                  });

    ///////////////////////////////////////////////////////////////////
    // tabla de telefonos
    ///////////////////////////////////////////////////////////////////
    
    temp = {{ Js::from($data['person']['phones']) }};

    var phones = temp.map(item => {
                    return {
                            id: item.id,
                            phone_type_id: item.phone_type_id,
                            phone_type: item.phone_type,
                            number: item.number,
                            status: ''
                          }
                  });

    ///////////////////////////////////////////////////////////////////
    // tabla de direcciones
    ///////////////////////////////////////////////////////////////////

    temp = {{ Js::from($data['person']['fullAddresses']) }};

    var addresses = temp.map(item => {
                      return {
                        id            : item.id,
                        estado        : item.estado,
                        municipio     : item.municipio,
                        parroquia_id  : item.parroquia_id,
                        parroquia     : item.parroquia,
                        address       : item.address,
                        zona_postal   : item.zona_postal,
                        status        : ''
                      }                
                    });

    ///////////////////////////////////////////////////////////////////
    // tabla de familiares
    ///////////////////////////////////////////////////////////////////

    temp = {{ Js::from($data['employee']->familiaresFull()) }};
    
    var familiares = temp.map(item => ({...item, status: ''}));

    ///////////////////////////////////////////////////////////////////
    // index de fila de tabla al agregar/modificar
    ///////////////////////////////////////////////////////////////////

    var datatableRow = -1;

    ///////////////////////////////////////////////////////////////////
    // tabla de estudios
    ///////////////////////////////////////////////////////////////////

    temp = {{ Js::from($data['employee']->estudiosFull()) }};

    var estudios = temp.map(item => {
                        return {
                            'id'          : item.id,
                            'tipo_id'     : item.estudio_type_id,
                            'tipo'        : item.estudio_type.tipo,
                            'fecha'       : item.fecha,
                            'descripcion' : item.descripcion,
                            'status'      : ''
                        };
                    });

    ///////////////////////////////////////////////////////////////////
    // tabla de permisos
    ///////////////////////////////////////////////////////////////////

    temp = {{ Js::from($data['employee']->permisos) }};

    var permisos = temp.map(item => {
                        return {
                            'id'      : item.id,
                            'desde'   : item.desde,
                            'hasta'   : item.hasta,
                            'motivo'  : item.motivo,
                            'status'  : ''
                        };
                    });

    ///////////////////////////////////////////////////////////////////
    // tabla de reposos
    ///////////////////////////////////////////////////////////////////

    var repososDT = $('#repososDT').DataTable({
      info        : false,
      paging      : false,
      searching   : false,
      autofix     : true,
      rowCallback : function(row, data, index) {
                      if (data.status == 'D') {
                        $(row).find('td').each(function() {
                          $(this).html('<del class="bg-danger">' + $(this).html() + '</del>');
                        });
                      }
                    },
      columns: [
        {data: 'id', visible: false},
        {data: 'desde'},
        {data: 'hasta'},
        {data: 'noti_fecha'},
        {data: 'noti_dr_ci'},
        {data: 'noti_dr_nombre'},
        {data: 'noti_dr_mpps'},
        {data: 'noti_dr_cms'},
        {data: 'reposo_id', visible: false},
        {data: 'reposo_codigo', visible: false},
        {data: 'reposo', visible: false},
        {data: 'conva_fecha'},
        {data: 'conva_dr_ci'},
        {data: 'conva_dr_nombre'},
        {data: 'conva_dr_mpps'},
        {data: 'conva_dr_cms'},
        {data: 'status', visible:false},
        {
          data: null,
          orderable: false,
          render: function ( data, type, row, meta ) {
            let botones = `
                  <div class="d-flex flex-row">
                    <button type="button" class="editar btn btn-primary btn-sm mr-1"><i class="fas fa-edit"></i></button>
                    <button type="button" class="eliminar btn btn-danger btn-sm" title="Eliminar reposo"><i class="fas fa-trash-alt"></i></button>
                  </div>
                `;
            
            return botones;
          },
        }
      ]
    });

    ///////////////////////////////////////////////////////////////////
    // tabla de vacaciones
    ///////////////////////////////////////////////////////////////////

    temp = {{ Js::from($data['employee']->vacaciones) }};

    var vacaciones = temp.map(item => {
                        return {
                            'id'      : item.id,
                            'desde'   : item.desde,
                            'hasta'   : item.hasta,
                            'periodo' : item.periodo,
                            'status'  : ''
                        };
                    });

    // iniciamos el formulario
    initForm();

    ///////////////////////////////////////////////////////////////////
    // inicializar formulario
    ///////////////////////////////////////////////////////////////////

    function initForm() {
      let addresses = {{ Js::from($data['person']['fullAddresses']) }};

      // configurar 'toastr'
      toastr.options.closeButton = true;
      toastr.options.timeOut = 0;
      toastr.options.extendedTimeOut = 0;

      // pintar emails
      emailsDraw();

      // pintar telefonos
      phonesDraw();

      // pintar direcciones
      addressesDraw();

      // pintar familiares
      familyDraw();

      // pintar estudios
      estudiosDraw();

      // pintar vacaciones
      vacacionesDraw();

      // pintar permisos
      permisosDraw();
      
      // mascara para el nombre
      $("#inputPNombre").inputmask(lib_characterMask());
      $("#inputSNombre").inputmask(lib_characterMask());
      $("#inputPApellido").inputmask(lib_characterMask());
      $("#inputSApellido").inputmask(lib_characterMask());

      // mascara para el numero de telefono
      $("#inputPhone").inputmask(lib_phoneMask());

      // notificacion de reposos: mascara del nombre del dr 
      $("#inputReposoNotiNombre").inputmask(lib_characterMask());

      // convalidacion de reposos: mascara del nombre del dr 
      $("#inputReposoConvaNombre").inputmask(lib_characterMask());
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
        if(item.status != 'D') {
          fila = `<tr>
                    <td>${item.email}</td>
                    <td>
                      <button type="button" class="eliminar btn btn-danger btn-sm" title="Eliminar correo"><i class="fas fa-trash-alt"></i></button>
                    </td>
                  </tr>`;
      
          $('#emailsDT tbody').append(fila);
        }
      });
    }

    ///////////////////////////////////////////////////////////////////
    // emails: agregar
    ///////////////////////////////////////////////////////////////////

    $("#btnEmailAdd").click(function () {
      let correo = $("#inputEmail").val();

      if(lib_isEmpty(correo)) {
        lib_toastr("Error: Debe ingresar la dirección de correo!");
      }
      else {
        emails.push({'id': 0, 'email' : correo, 'status' : 'C'});
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

      emails.forEach(item => {
        if(item.email == correo) {
          item.status = 'D';
        }
        
        return item;
      });
      emailsDraw();
    });

    ///////////////////////////////////////////////////////////////////
    // telefonos: pintar
    ///////////////////////////////////////////////////////////////////
    
    function phonesDraw() {
      let fila = '';

      $("#phonesDT tbody").empty();
      phones.forEach(item => {
        if(item.status != 'D') {
          fila = `<tr>
                      <td>${item.phone_type}</td>
                      <td>${item.number}</td>
                      <td>
                        <button type="button" class="eliminar btn btn-danger btn-sm" title="Eliminar correo"><i class="fas fa-trash-alt"></i></button>
                      </td>
                    </tr>`;
        
          $('#phonesDT tbody').append(fila);
        }
      });
    };

    ///////////////////////////////////////////////////////////////////
    // telefonos: agregar
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
          'id'            : 0,
          'phone_type_id' : numeroTipo,
          'phone_type'    : $("#selectPhoneType :selected").text(),
          'number'        : numero,
          'status'        : 'C'
        });
        $("#inputPhone").val("");
        phonesDraw();
      }
    });

    ///////////////////////////////////////////////////////////////////
    // telefonos: eliminar
    ///////////////////////////////////////////////////////////////////

    $("#phonesDT tbody").on("click", ".eliminar", function() {
      let fila = $(this).closest("tr");
      let numero = fila.find("td").eq(1).text();

      phones.forEach(item => {
        if(item.number == numero) {
          item.status = 'D';
        }
      });
      phonesDraw();
    });

    ///////////////////////////////////////////////////////////////////
    // cargar municipios
    ///////////////////////////////////////////////////////////////////

    $("#selectEstados").change(function() {
      let estado_id = $(this).val();
      let ruta = "{{ route('ubicacion.municipios', ['estado_id' => 'valor']) }}";

      ruta = ruta.replace('valor', estado_id);
      fetch(ruta)
      .then(response => response.json())
      .then(r => {
        $("#selectMunicipios").empty();
        $("#selectMunicipios").append('<option value="0">SELECCIONE UN MUNICIPIO</option>');
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
      let ruta = "{{ route('ubicacion.parroquias', ['municipio_id' => 'valor']) }}";

      ruta = ruta.replace('valor', municipio_id);
      fetch(ruta)
      .then(response => response.json())
      .then(r => {
        $("#selectParroquias").empty();
        $("#selectParroquias").append('<option value="0">SELECCIONE UNA PARROQUIA</option>');
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
        if(item.status != 'D') {
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
        }
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
          'id'            : 0,
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

      addresses.forEach(item => {
        if(item.address == address) {
          item.status = 'D';
        }
      });
      addressesDraw();
    });

    ///////////////////////////////////////////////////////////////////
    // familiares: pintar
    ///////////////////////////////////////////////////////////////////
    
    function familyDraw() {
      let fila = '';

      $("#familiaresDT tbody").empty();
      familiares.forEach(item => {
        if(item.status != 'D') {
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
        }
      });
    };

    ///////////////////////////////////////////////////////////////////
    // familiares: agregar
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
        familyDraw();
      }
    });

    ///////////////////////////////////////////////////////////////////
    // familiares: eliminar
    ///////////////////////////////////////////////////////////////////

    $("#familiaresDT tbody").on("click", ".eliminar", function() {
      let fila = $(this).closest("tr");
      let nombre = fila.find("td").eq(1).text();

      familiares.forEach(item => {
        if(item.first_name == nombre) {
          item.status = 'D';
        }
      });
      familyDraw();
    });

    ///////////////////////////////////////////////////////////////////
    // estudios: pintar
    ///////////////////////////////////////////////////////////////////
    
    function estudiosDraw() {
      let fila = '';

      $("#estudiosDT tbody").empty();
      estudios.forEach(item => {
        if(item.status != 'D') {
          fila = `<tr>
                    <td>${item.tipo}</td>
                    <td>${item.fecha}</td>
                    <td>${item.descripcion}</td>
                    <td>
                      <button type="button" class="eliminar btn btn-danger btn-sm" title="Eliminar correo"><i class="fas fa-trash-alt"></i></button>
                    </td>
                  </tr>`;
        
          $('#estudiosDT tbody').append(fila);
        }
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
          'id'          : 0,
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

      estudios.forEach(item => {
          if(item.descripcion == descripcion) {
            item.status = 'D';
          }
      });
      estudiosDraw();
    });

    ///////////////////////////////////////////////////////////////////
    // permisos: pintar
    ///////////////////////////////////////////////////////////////////
    
    function permisosDraw() {
      let fila = '';

      $("#permisosDT tbody").empty();
      permisos.forEach(item => {
        if(item.status != 'D') {
          fila = `<tr>
                    <td>${item.desde}</td>
                    <td>${item.hasta}</td>
                    <td>${item.motivo}</td>
                    <td>
                      <button type="button" class="eliminar btn btn-danger btn-sm" title="Eliminar correo"><i class="fas fa-trash-alt"></i></button>
                    </td>
                  </tr>`;
        
          $('#permisosDT tbody').append(fila);
        }
      });
    };

    ///////////////////////////////////////////////////////////////////
    // permisos: agregar
    ///////////////////////////////////////////////////////////////////

    $("#btnPermisoAdd").click(function() {
      let ok = true;
      let desde = $("#inputPermisoDesde").val();
      let hasta = $("#inputPermisoHasta").val();
      let motivo = $("#inputPermisoMotivo").val();
      
      if(lib_isEmpty(desde)) {
        lib_toastr("Error: Debe ingresar la fecha de inicio del permiso!");
        ok = false;
      }
      if(lib_isEmpty(hasta)) {
        lib_toastr("Error: Debe ingresar la fecha final del permiso!");
        ok = false;
      }
      if(lib_isEmpty(motivo)) {
        lib_toastr("Error: Debe ingresar el motivo del permiso!");
        ok = false;
      }
      
      if(ok) {
        permisos.push({
          'id'      : 0,
          'desde'   : desde,
          'hasta'   : hasta,
          'motivo'  : motivo,
          'status'  : 'C'
        });
        $("#inputPermisoDesde").val('');
        $("#inputPermisoHasta").val('');
        $("#inputPermisoMotivo").val('');
        permisosDraw();
      }
    });

    ///////////////////////////////////////////////////////////////////
    // permisos: eliminar
    ///////////////////////////////////////////////////////////////////

    $("#permisosDT tbody").on("click", ".eliminar", function() {
      let fila = $(this).closest("tr");
      let motivo = fila.find("td").eq(2).text();

      permisos.forEach(item => {
          if(item.motivo == motivo) {
            item.status = 'D';
          }
      });
      permisosDraw();
    });

    ///////////////////////////////////////////////////////////////////
    // reposos: agregar
    ///////////////////////////////////////////////////////////////////

    $("#btnReposoAdd").click(function() {
      datatableRow = -1;
      $('#reposoModalTitle').html('Agregar reposo');
      $('#inputReposoDesde').val('');
      $('#inputReposoHasta').val('');
      $('#inputReposoNotiFecha').val('');
      $('#inputReposoNotiCi').val('');
      $('#inputReposoNotiNombre').val('');
      $('#inputReposoNotiMpps').val('');
      $('#inputReposoNotiCms').val('');
      $('#inputReposoCodigo').val(''),
      $("#inputReposoId").val('');
      $("#inputReposo").val('');
      $("#inputReposoConvaFecha").val('');
      $('#inputReposoConvaCi').val('');
      $('#inputReposoConvaNombre').val('');
      $('#inputReposoConvaMpps').val('');
      $('#inputReposoConvaCms').val('');
      $('#reposoModal').modal('show');
    });

    ///////////////////////////////////////////////////////////////////
    // reposos: editar
    ///////////////////////////////////////////////////////////////////

    $("#repososDT tbody").on("click", ".editar", function() {
      let data = repososDT.row($(this).parents()).data();
      
      datatableRow = repososDT.row($(this).parents('tr')).index();
      $('#reposoModalTitle').html('Editar reposo');
      $('#inputReposoDesde').val(data.desde);
      $('#inputReposoHasta').val(data.hasta);
      $('#inputReposoNotiFecha').val(data.noti_fecha);
      $('#inputReposoNotiCi').val(data.noti_dr_ci);
      $('#inputReposoNotiNombre').val(data.noti_dr_nombre);
      $('#inputReposoNotiMpps').val(data.noti_dr_mpps);
      $('#inputReposoNotiCms').val(data.noti_dr_cms);
      $('#inputReposoId').val(data.reposo_id);
      $('#inputReposoCodigo').val(data.reposo_codigo);
      $('#inputReposo').val(data.reposo);
      $('#inputReposoConvaFecha').val(data.conva_fecha);
      $('#inputReposoConvaCi').val(data.conva_dr_ci);
      $('#inputReposoConvaNombre').val(data.conva_dr_nombre);
      $('#inputReposoConvaMpps').val(data.conva_dr_mpps);
      $('#inputReposoConvaCms').val(data.conva_dr_cms);
      $('#reposoModal').modal('show');
    });

    ///////////////////////////////////////////////////////////////////
    // reposos: codigo
    ///////////////////////////////////////////////////////////////////

    $("#inputReposoCodigo").on('keypress', function() {
      $("#inputReposo").val('');
    });

    ///////////////////////////////////////////////////////////////////
    // reposos: buscar por codigo
    ///////////////////////////////////////////////////////////////////

    $("#btnReposoBuscar").click(function() {
      let ruta = "{{ route('reposos.get-by-code', ['search' => '.valor']) }}";

      if($("#inputReposoCodigo").val() == '') {
        lib_toastr("Error: Debe ingresar el código del reposo!");
      }
      else {
        fetch(ruta.replace('.valor', $("#inputReposoCodigo").val()))
        .then(response => response.json())
        .then(r => {
          if(!r.success) {
            lib_toastr("Error: Código de reposo inexistente!");
          }
          else {
            $("#inputReposoId").val(r.data.id);
            $("#inputReposo").val(r.data.diagnostico);
            $("#inputReposo").attr('title', r.data.diagnostico);
          }
        });
      }
    });

    ///////////////////////////////////////////////////////////////////
    // reposos: salvar en tabla
    ///////////////////////////////////////////////////////////////////

    $("#btnReposoAceptar").click(function() {
      let ok = true;
      
      if(lib_isEmpty($('#inputReposoDesde').val())) {
        ok = false;
        lib_toastr("Error: Debe ingresar la fecha de inicio del reposo!");
      }
      
      if(lib_isEmpty($('#inputReposoHasta').val())) {
        ok = false;
        lib_toastr("Error: Debe ingresar la fecha de finalización del reposo!");
      }
      
      if(lib_isEmpty($('#inputReposoNotiFecha').val())) {
        ok = false;
        lib_toastr("Error: Debe ingresar la fecha de notificación!");
      }

      if(lib_isEmpty($('#inputReposoNotiCi').val())) {
        ok = false;
        lib_toastr("Error: Debe ingresar la C.I. del Dr!");
      }

      if(lib_isEmpty($('#inputReposoNotiNombre').val())) {
        ok = false;
        lib_toastr("Error: Debe ingresar el nombre del Dr!");
      }

      if(lib_isEmpty($('#inputReposoNotiMpps').val())) {
        ok = false;
        lib_toastr("Error: Debe ingresar el M.P.P.S. del Dr!");
      }

      if(lib_isEmpty($('#inputReposoNotiCms').val())) {
        ok = false;
        lib_toastr("Error: Debe ingresar el C.M.S. del Dr!");
      }

      if(ok) {
        if(datatableRow == -1) {
          repososDT.row.add({
            'id'              : '0',
            'desde'           : $('#inputReposoDesde').val(),
            'hasta'           : $('#inputReposoHasta').val(),
            'noti_fecha'      : $('#inputReposoNotiFecha').val(),
            'noti_dr_ci'      : $('#inputReposoNotiCi').val(),
            'noti_dr_nombre'  : $('#inputReposoNotiNombre').val(),
            'noti_dr_mpps'    : $('#inputReposoNotiMpps').val(),
            'noti_dr_cms'     : $('#inputReposoNotiCms').val(),
            'reposo_id'       : $('#inputReposoId').val(),
            'reposo_codigo'   : $('#inputReposoCodigo').val(),
            'reposo'          : $('#inputReposo').val(),
            'conva_fecha'     : $('#inputReposoConvaFecha').val(),
            'conva_dr_ci'     : $('#inputReposoConvaCi').val(),
            'conva_dr_nombre' : $('#inputReposoConvaNombre').val(),
            'conva_dr_mpps'   : $('#inputReposoConvaMpps').val(),
            'conva_dr_cms'    : $('#inputReposoConvaCms').val(),
            'status'          : 'C',
          })
          .draw();
        }
        else {
          let repososId = repososDT.row(datatableRow).data().id;

          repososDT.row(datatableRow).data({
            'id'              : repososId,
            'desde'           : $('#inputReposoDesde').val(),
            'hasta'           : $('#inputReposoHasta').val(),
            'noti_fecha'      : $('#inputReposoNotiFecha').val(),
            'noti_dr_ci'      :  $('#inputReposoNotiCi').val(),
            'noti_dr_nombre'  : $('#inputReposoNotiNombre').val(),
            'noti_dr_mpps'    : $('#inputReposoNotiMpps').val(),
            'noti_dr_cms'     : $('#inputReposoNotiCms').val(),
            'reposo_id'       : $('#inputReposoId').val(),
            'reposo_codigo'   : $('#inputReposoCodigo').val(),
            'reposo'          : $('#inputReposo').val(),
            'conva_fecha'     : $('#inputReposoConvaFecha').val(),
            'conva_dr_ci'     : $('#inputReposoConvaCi').val(),
            'conva_dr_nombre' : $('#inputReposoConvaNombre').val(),
            'conva_dr_mpps'   : $('#inputReposoConvaMpps').val(),
            'conva_dr_cms'    : $('#inputReposoConvaCms').val(),
            'status'          : 'U',
          }).draw();
        }
        $('#reposoModal').modal('hide');
      }
    });

    ///////////////////////////////////////////////////////////////////
    // reposos: eliminar
    ///////////////////////////////////////////////////////////////////

    $("#repososDT tbody").on("click",".eliminar",function() {
      let row = repososDT.row($(this).parents());
      let data = row.data();

      data.status = 'D';
      row.data(data);
      repososDT.draw();
    });

    ////////////////////////////////////////////////////////////////////
    // vacaciones: pintar
    ///////////////////////////////////////////////////////////////////
    
    function vacacionesDraw() {
      let fila = '';

      $("#vacacionesDT tbody").empty();
        vacaciones.forEach(item => {
        if(item.status != 'D') {
          fila = `<tr>
                    <td>${item.desde}</td>
                    <td>${item.hasta}</td>
                    <td>${item.periodo}</td>
                    <td>
                      <button type="button" class="eliminar btn btn-danger btn-sm" title="Eliminar correo"><i class="fas fa-trash-alt"></i></button>
                    </td>
                  </tr>`;
        
          $('#vacacionesDT tbody').append(fila);
        }
      });
    };

    ///////////////////////////////////////////////////////////////////
    // vacaciones: agregar
    ///////////////////////////////////////////////////////////////////

    $("#btnVacacionesAdd").click(function() {
      let ok = true;
      let desde = $("#inputVacacionDesde").val();
      let hasta = $("#inputVacacionHasta").val();
      let periodo = $("#inputVacacionPeriodo").val();
      
      if(lib_isEmpty(desde)) {
        lib_toastr("Error: Debe ingresar la fecha de inicio del permiso!");
        ok = false;
      }
      if(lib_isEmpty(hasta)) {
        lib_toastr("Error: Debe ingresar la fecha final del permiso!");
        ok = false;
      }
      if(lib_isEmpty(periodo)) {
        lib_toastr("Error: Debe ingresar el periodo de las vacaciones!");
        ok = false;
      }
      
      if(ok) {
        vacaciones.push({
          'id'      : 0,
          'desde'   : desde,
          'hasta'   : hasta,
          'periodo'  : periodo,
          'status'  : 'C'
        });
        $("#inputVacacionDesde").val('');
        $("#inputVacacionHasta").val('');
        $("#inputVacacionPeriodo").val('');
        vacacionesDraw();
      }
    });

    ///////////////////////////////////////////////////////////////////
    // vacaciones: eliminar
    ///////////////////////////////////////////////////////////////////

    $("#vacacionesDT tbody").on("click", ".eliminar", function() {
      let fila = $(this).closest("tr");
      let periodo = fila.find("td").eq(2).text();

      vacaciones.forEach(item => {
          if(item.periodo == periodo) {
            item.status = 'D';
          }
      });
      vacacionesDraw();
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
    // actualizar empleado administrativo 
    ///////////////////////////////////////////////////////////////////

    $("#btnGrabar").click(function() {
      // validaciones
      let data = new FormData(formEmpleado);

      data.append('emails', JSON.stringify(emails));
      data.append('phones', JSON.stringify(phones));
      data.append('addresses', JSON.stringify(addresses));
      data.append('family', JSON.stringify(familiares));
      data.append('estudios', JSON.stringify(estudios));
      data.append('permisos', JSON.stringify(permisos));
      data.append('repososDT', JSON.stringify(repososDT.rows().data().toArray()));
      data.append('vacaciones', JSON.stringify(vacaciones));
      
      fetch(ruta, {
        headers: {
          'Accept' : 'application/json'
        },
        method  : "POST",
        body: data
      })
      .then(response => {
        if(response.ok) {
          lib_ShowMensaje("Empleado Administrativo modificado!", 'mensaje')
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
    // cerrar pestaña de edicion
    ///////////////////////////////////////////////////////////////////

    $("#btnSalir").click(function() {
      window.close();
    });
  });
</script>
@endsection