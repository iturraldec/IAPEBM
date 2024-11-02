<!-- componente: datos de los permisos de los empleados -->

<div class="tab-pane fade" id="custom-tabs-one-permisos" role="tabpanel">
  <div class="card card-primary">
    <div class="card-header bg-lightblue">
      <h3 class="card-title">Permisos del Empleado</h3>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
      <div class="row">
        <div class="col-2 form-group">
          <label for="inputPermisoDesde">Desde*</label>
          <input type="date" 
                class="form-control" 
                id="inputPermisoDesde" 
                value="{{ date('Y-m-d') }}"
                title="Fecha inicial del permiso"
          />
        </div>

        <div class="col-2 form-group">
          <label for="inputPermisoHasta">Hasta*</label>
          <input type="date" 
                class="form-control" 
                id="inputPermisoHasta"
                value="{{ date('Y-m-d') }}"
                title="Fecha final del permiso"
          />
        </div>

        <div class="col-8 form-group">
          <label for="inputPermisoMotivo">Motivo</label>
          <div class="input-group">
            <input type="text" 
                  class="form-control" 
                  id="inputPermisoMotivo"
                  placeholder="Ingrese el motivo"
                  onkeyup="this.value = this.value.toUpperCase();"
                  title="Motivo del permiso"
            />

            <div class="input-group-append">
              <div id="btnPermisoAdd" class="input-group-text" title="Agregar permiso"><i class="fas fa-plus-square"></i></div>
            </div>
          </div>
        </div>

        <div class="col-12">
          <table id="permisosDT" class="table table-hover border border-primary" width="100%">
            <thead class="text-center">
              <tr>
                <th>Desde</th>
                <th>Hasta</th>
                <th>Motivo</th>
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
<!-- fin de permisos -->