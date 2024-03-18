<!-- editar permiso -->
<div class="modal fade" id="modalForm" 
    data-backdrop="static"
    tabindex="-1" 
    aria-labelledby="staticBackdropLabel" 
    aria-hidden="true"
>
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalTitle">Actualizar permiso</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body form-group">					
        <label for="input_permission">Permiso</label>
        <input type="text" id="input_permission" class="form-control" data-id="" placeholder="Ingresa nuevo Permiso">
      </div>
      <div class="modal-footer">
        <button type="button" id="btn-update" class="btn btn-danger" data-dismiss="modal">Grabar</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Salir</button>
      </div>
    </div>
  </div>
</div>