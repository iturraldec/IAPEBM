<div class="modal fade" id="modalForm" 
    data-backdrop="static"
    tabindex="-1" 
    aria-labelledby="staticBackdropLabel" 
    aria-hidden="true"
>
  <div class="modal-dialog">
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
                <a class="nav-link active" id="custom-tabs-one-home-tab" data-toggle="pill" href="#custom-tabs-one-home" role="tab" aria-controls="custom-tabs-one-home" aria-selected="true">Identificación</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" id="custom-tabs-one-phones-tab" data-toggle="pill" href="#custom-tabs-one-phones" role="tab" aria-controls="custom-tabs-one-profile" aria-selected="false">Teléfono(s)</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" id="custom-tabs-one-adresses-tab" data-toggle="pill" href="#custom-tabs-one-adresses" role="tab" aria-controls="custom-tabs-one-adresses" aria-selected="false">Dirección(es)</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" id="custom-tabs-one-settings-tab" data-toggle="pill" href="#custom-tabs-one-settings" role="tab" aria-controls="custom-tabs-one-settings" aria-selected="false">Settings</a>
              </li>
            </ul>
          </div>
          <div class="card-body">
            <div class="tab-content" id="custom-tabs-one-tabContent">
              
              <!-- tab home -->
              <div class="tab-pane fade active show" id="custom-tabs-one-home" role="tabpanel" aria-labelledby="custom-tabs-one-home-tab">
                <div class="row">
                  <div class="col-4 form-group">
                    <label for="inputCodigo">Código</label>
                  </div>

                  <div class="col-8">
                    <input type="text" class="form-control" id="inputCodigo" readonly>
                  </div>

                  <div class="col-4 form-group">
                    <label for="inputCedula">Cédula</label>
                  </div>

                  <div class="col-8">
                    <input type="text" class="form-control" id="inputCedula" readonly>
                  </div>

                  <div class="col-4 form-group">
                    <label for="inputRif">R.I.F.</label>
                  </div>

                  <div class="col-8">
                    <input type="text" class="form-control" id="inputRif" readonly>
                  </div>

                  <div class="col-4 form-group">
                    <label for="inputTlf">Teléfono</label>
                  </div>

                  <div class="col-8">
                    <input type="text" class="form-control" id="inputTlf" readonly>
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
                        @foreach ($municipios as $municipio)
                          <option value="{{ $municipio->id }}">{{ $municipio->name }}</option>
                        @endforeach
                      </select>
                    </div>

                    <div class="col-6">
                      <label for="selectParroquia">Parroquia</label>
                      <select id="selectParroquia" class="form-control">
                        @foreach ($parroquias as $parroquia)
                          <option value="{{ $parroquia->id }}">{{ $parroquia->name }}</option>
                        @endforeach
                      </select>
                    </div>

                    <div class="col input-group my-2">
                      <input type="text" id="inputAddress" name="inputAddress" class="form-control" placeholder="Ingresa la dirección">
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