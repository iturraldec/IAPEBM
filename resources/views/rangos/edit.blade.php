<!-- agregar/editar rango -->
<form id="rangoForm">
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
            <div class="form-group">
              <label for="inputRango">Rango</label>
              <input type="text" 
                    id="inputRango" 
                    name="name"
                    class="form-control @error('name') is-invalid @enderror"
                    onkeyup="this.value = this.value.toUpperCase();"
              >
            </div>
          </div>

          <div class="modal-footer">
            <button type="submit" class="btn btn-danger">Grabar</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Salir</button>
          </div>
        </div>
      </div>
  </div>
</form>