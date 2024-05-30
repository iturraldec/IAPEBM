<div class="modal fade" 
    id="modalForm" 
    data-backdrop="static"
    data-keyboard="false"
    tabindex="-1" 
    aria-labelledby="staticBackdropLabel" 
    aria-hidden="true"
>
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalTitle">?</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-body">
          
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
                  <button class="btn btn-secondary" data-dismiss="modal">Salir</button>
                </div>

              </div>
            </form>
          </div>
          <!-- fin de tab principal -->
          
          <!-- tab phones -->
          <div class="tab-pane fade" id="custom-tabs-one-phones" role="tabpanel" aria-labelledby="custom-tabs-one-phone-tab">
            <div class="row">
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

              <div class="col-4 form-group">
                <label for="inputEscuela">Lugar de graducaión(Escuela)</label>
                <input type="text"
                      class="form-control"
                      id="inputEscuela"
                      name="inputEscuela"
                      placeholder="Ingrese la escuela"
                      onkeyup="this.value = this.value.toUpperCase();"
                />
              </div>

              <div class="col-4 form-group">
                <label for="inputFechaGrado">Fecha de Grado</label>
                <input type="date"
                      class="form-control"
                      id="inputFechaGrado"
                      name="inputFechaGrado"
                      placeholder="Ingrese fecha"
                />
              </div>

              <div class="col-4 form-group">
                <label for="inputCurso">Curso</label>
                <input type="text"
                      class="form-control"
                      id="inputCurso"
                      name="inputCurso"
                      placeholder="Ingrese el curso"
                />
              </div>
            </div>
          </div>
          <!-- fin de datos administrativos -->
        </div>
        <!-- fin de tab -->

      </div>
      <!-- fin de modal-body -->
    </div>
  </div>
</div>