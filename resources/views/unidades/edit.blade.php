<!-- editar unidad operativa -->
<form id="formEditUnidad">
  @method('PUT')
  @csrf

  <input type="hidden" id="padreId" name="padre_id">

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
          <div class="row">
            <div class="col-3">
              <div class="form-group">
                <h6>Código</h6>
                <input type="text" 
                      id="inputECode"
                      name="ecode"
                      class="form-control form-control-sm"
                      onkeyup="this.value = this.value.toUpperCase();"
                      title="Código de la Unidad Operativa Específica"
                      required
                >
              </div>
            </div>

            <div class="col-9">
              <div class="form-group">
                <h6>Nombre de la U.O. Específica</h6>
                <input type="text" 
                      id="inputEName" 
                      name="ename"
                      class="form-control form-control-sm"
                      onkeyup="this.value = this.value.toUpperCase();"
                      title="Nombre de la Unidad Operativa Específica"
                      required
                >
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-6">
              <h6>Latitud</h6>
              <div class="form-group">
                <input type="text"
                      id="inputELatitud" 
                      name="elatitud"
                      class="form-control form-control-sm"
                      title="Latitud"
                      required
                >
              </div>
            </div>

            <div class="col-6">
              <h6>Longitud</h6>
              <div class="input-group input-group-sm">
                <input type="text"
                    id="inputELongitud"
                    name="elongitud"
                    class="form-control"
                    title="Longitud"
                    required
                />
        
                <div class="input-group-append">
                  <button class="input-group-text btn btn-primary btn-sm" title="Agregar U.O. Específica"><i class="fas fa-plus-square"></i></button>
                </div>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col">
              <div class="card">
                <div class="card-header">
                  <h3 class="card-title">Unidades Operativas Específicas</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body p-0">
                  <table id="dt-unidades-e" class="table table-sm table-bordered table-hover">
                    <thead>
                      <tr>
                        <th>Código</th>
                        <th>Nombre</th>
                        <th>Latitud</th>
                        <th>Longitud</th>
                        <th scope="col" class="col-sm-2">Acción</th>
                      </tr>
                    </thead>
                    <tbody></tbody>
                  </table>
                </div>
                <!-- /.card-body -->
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</form>