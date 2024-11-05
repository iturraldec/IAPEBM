<div class="tab-pane fade" id="custom-tabs-one-vacaciones" role="tabpanel">
  <div class="card card-primary">
    <div class="card-header bg-lightblue">
      <h3 class="card-title">Vacaciones del Empleado</h3>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
      <div class="row">
        <div class="col-2 form-group">
          <label for="inputVacacionDesde">Desde*</label>
          <input type="date" 
                class="form-control" 
                id="inputVacacionDesde" 
                value="{{ date('Y-d-m') }}"
                title="Fecha inicial de las vacaciónes"
          />
        </div>

        <div class="col-2 form-group">
          <label for="inputVacacionHasta">Hasta*</label>
          <input type="date" 
                class="form-control" 
                id="inputVacacionHasta"
                value="{{ date('Y-d-m') }}"
                title="Fecha final de las vacaciones"
          />
        </div>

        <div class="col-8 form-group">
          <label>Periodo*</label>
            <div class="input-group">
                <input type="text" 
                      class="form-control" 
                      id="inputVacacionPeriodo" 
                      placeholder="Ingrese periodo de las vacaciones"
                      onkeyup="this.value = this.value.toUpperCase();"
                      title="Periodo de las vacaciones"
                >

                <div class="input-group-append">
                    <div id="btnVacacionesAdd" class="input-group-text" title="Agregar vacación"><i class="fas fa-plus-square"></i></div>
                </div>
            </div>
        </div>

        <div class="col-12">
          <table id="vacacionesDT" class="table table-hover border border-primary" width="100%">
            <thead class="text-center">
              <tr>
                <th scope="col">Desde</th>
                <th scope="col">Hasta</th>
                <th scope="col">Periodo</th>
                <th scope="col"></th>
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