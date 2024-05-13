<div class="modal fade" 
    id="modalForm" 
    data-backdrop="static"
    data-keyboard="false"
    tabindex="-1" 
    aria-labelledby="staticBackdropLabel" 
    aria-hidden="true"
>
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalTitle">?</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-body">

        <div class="card card-primary card-tabs">

          <div class="card-header p-0 pt-1">
            <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
              <li class="nav-item">
                <a class="nav-link active" id="custom-tabs-one-home-tab" data-toggle="pill" href="#custom-tabs-one-home" role="tab" aria-controls="custom-tabs-one-home" aria-selected="true">Datos Personales</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" id="custom-tabs-one-phones-tab" data-toggle="pill" href="#custom-tabs-one-phones" role="tab" aria-controls="custom-tabs-one-profile" aria-selected="false">Teléfono(s)</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" id="custom-tabs-one-adresses-tab" data-toggle="pill" href="#custom-tabs-one-adresses" role="tab" aria-controls="custom-tabs-one-adresses" aria-selected="false">Dirección(es)</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" id="custom-tabs-one-settings-tab" data-toggle="pill" href="#custom-tabs-one-settings" role="tab" aria-controls="custom-tabs-one-settings" aria-selected="false">Datos Administrativos</a>
              </li>
            </ul>
          </div>

          <div class="card-body">
            <div class="tab-content" id="custom-tabs-one-tabContent">
              
              <!-- tab home -->
              <div class="tab-pane fade active show" id="custom-tabs-one-home" role="tabpanel" aria-labelledby="custom-tabs-one-home-tab">
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
                    <button type="button" id="btnGrabar" class="btn btn-danger">Grabar</button>
                    <button class="btn btn-secondary" data-dismiss="modal">Salir</button>
                  </div>

                </div>
              </div>
              <!-- fin de tab home -->
              
              <!-- tab phones -->
              <div class="tab-pane fade" id="custom-tabs-one-phones" role="tabpanel" aria-labelledby="custom-tabs-one-phone-tab">
                <form id="phoneForm">
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
                          <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-plus-square"></i></button>
                        </div>
                      </div>
                    </div>
                  
                    <div id="divPhones"></div>
                  </div>
                </form>
              </div>
              <!-- fin de tab phones -->

              <!-- tab de direcciones -->
              <div class="tab-pane fade" id="custom-tabs-one-adresses" role="tabpanel" aria-labelledby="custom-tabs-one-adresses-tab">
                <form id="addressForm">
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
                        <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-plus-square"></i></button>
                      </div>
                    </div>

                  </div>

                  <div id="divAddresses"></div>
                  
                </form>
              </div>
              <!-- fin de tab de direcciones -->

              <div class="tab-pane fade" id="custom-tabs-one-settings" role="tabpanel" aria-labelledby="custom-tabs-one-settings-tab">
                  Pellentesque vestibulum commodo nibh nec blandit. Maecenas neque magna, iaculis tempus turpis ac, ornare sodales tellus. Mauris eget blandit dolor. Quisque tincidunt venenatis vulputate. Morbi euismod molestie tristique. Vestibulum consectetur dolor a vestibulum pharetra. Donec interdum placerat urna nec pharetra. Etiam eget dapibus orci, eget aliquet urna. Nunc at consequat diam. Nunc et felis ut nisl commodo dignissim. In hac habitasse platea dictumst. Praesent imperdiet accumsan ex sit amet facilisis.
              </div>
            </div>
          </div>
          <!-- /.card -->
        </div>
      </div>
    </div>
  </div>
</div>