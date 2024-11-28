<!-- direcciones del trabajador -->

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