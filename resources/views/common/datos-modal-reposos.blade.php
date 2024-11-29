<!-- modal de los reposos de los empleados -->
<div class="modal fade" id="reposoModal" tabindex="-1" role="dialog" data-backdrop="static">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="reposoModalTitle">?</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-3 form-group">
            <label for="inputReposoDesde">Desde*</label>
            <input type="date" 
                  class="form-control" 
                  id="inputReposoDesde" 
                  title="Fecha inicial del reposo"
            />
          </div>
          
          <div class="col-3 form-group">
            <label for="inputReposoHasta">Hasta*</label>
            <input type="date" 
                  class="form-control" 
                  id="inputReposoHasta"
                  title="Fecha final del reposo"
            />
          </div>
        </div>

          <div class="card card-info">
            <div class="card-header">
              <h3 class="card-title">Datos de la Notificación</h3>
            </div>
            <!-- /.card-header -->

            <div class="card-body">
              <div class="row">
                <div class="col-3 form-group">
                  <label>Fecha*</label>
                  <input type="date" 
                        class="form-control" 
                        id="inputReposoNotiFecha"
                        value="{{ date('Y-d-m') }}"
                        title="Notificicación: Fecha"
                  />
                </div>
  
                <div class="col-3 form-group">
                  <label>Dr. C.I.*</label>
                  <input type="text" 
                        class="form-control" 
                        id="inputReposoNotiCi" 
                        placeholder="Dr CI"
                        title="Notificación: Dr. C.I."
                  >
                </div>

                <div class="col-6 form-group">
                  <label>Dr. Nombre*</label>
                  <input type="text" 
                        class="form-control" 
                        id="inputReposoNotiNombre"
                        onkeyup="this.value = this.value.toUpperCase();"
                        placeholder="Dr Nombre"
                        title="Notificación: Dr. Nombre"
                  >
                </div>

                <div class="col-3 form-group">
                  <label>Dr. M.P.P.S*</label>
                  <input type="text" 
                        class="form-control" 
                        id="inputReposoNotiMpps" 
                        placeholder="Dr M.P.P.S."
                        title="Notificación: Dr. M.P.P.S."
                  >
                </div>

                <div class="col-3 form-group">
                  <label>Dr. C.M.S.*</label>
                  <input type="text" 
                        class="form-control" 
                        id="inputReposoNotiCms" 
                        placeholder="Dr C.M.S."
                        title="Notificación: Dr. C.M.S."
                  >
                </div>
              </div>
            </div>
            <!-- /.card-body -->
          </div>

          <div class="card card-info">
            <div class="card-header">
              <h3 class="card-title">Datos de la Convalidación</h3>
            </div>
            <!-- /.card-header -->

            <div class="card-body">
              <div class="row">
                <div class="col-3 form-group">
                  <label>Código</label>
                  <div class="input-group">
                    <input type="text" 
                        class="form-control" 
                        id="inputReposoCodigo" 
                        placeholder="Código"
                        onkeyup="this.value = this.value.toUpperCase();"
                        title="Código del reposo"
                    >

                    <div class="input-group-append">
                      <div id="btnReposoBuscar" class="input-group-text" title="Buscar reposo"><i class="fas fa-search"></i></div>
                    </div>
                  </div>
                </div>

                <div class="col-9 form-group">
                  <label>Reposo</label>
                  <input type="hidden" id="inputReposoId">
                  <input type="text" id="inputReposo" class="form-control" readonly>
                </div>

                <div class="col-3 form-group">
                  <label>Fecha</label>
                  <input type="date" 
                        class="form-control" 
                        id="inputReposoConvaFecha"
                        title="Convalidación: Fecha"
                  />
                </div>
  
                <div class="col-3 form-group">
                  <label>Dr. C.I.</label>
                  <input type="text" 
                        class="form-control" 
                        id="inputReposoConvaCi" 
                        placeholder="Dr CI"
                        title="Convalidación: Dr. C.I."
                  >
                </div>

                <div class="col-6 form-group">
                  <label>Dr. Nombre</label>
                  <input type="text" 
                        class="form-control" 
                        id="inputReposoConvaNombre" 
                        onkeyup="this.value = this.value.toUpperCase();"
                        placeholder="Dr Nombre"
                        title="Convalidación: Dr. Nombre"
                  >
                </div>

                <div class="col-3 form-group">
                  <label>Dr. M.P.P.S</label>
                  <input type="text" 
                        class="form-control" 
                        id="inputReposoConvaMpps" 
                        placeholder="Dr M.P.P.S."
                        title="Convalidación: Dr. M.P.P.S."
                  >
                </div>

                <div class="col-3 form-group">
                  <label>Dr. C.M.S.</label>
                  <input type="text" 
                        class="form-control" 
                        id="inputReposoConvaCms" 
                        placeholder="Dr C.M.S."
                        title="Convalidación: Dr. C.M.S."
                  >
                </div>
              </div>
            </div>
            <!-- /.card-body -->
          </div>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Regresar</button>
        <button type="button" id="btnReposoAceptar" class="btn btn-primary">Aceptar</button>
      </div>
    </div>
  </div>
</div>
