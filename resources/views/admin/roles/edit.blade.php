<!-- agregar/editar rol -->
<form id="rolForm">
  <input type="hidden" id="input-id" name="id">

  <div class="modal fade" 
      id="modalForm" 
      data-backdrop="static"
      tabindex="-1" 
      aria-labelledby="staticBackdropLabel" 
      aria-hidden="true"
  >
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalTitle"></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

        <div class="modal-body">
          <div class="form-group">
            <input type="text" id="input-name" name="name" class="form-control">
          </div>

          <div class="row mt-2">
            <div class="col form-group">
              <label class="form-control mt-2">Seleccione los Permisos a asignarle</label>
              @foreach ($permissions as $permission)
                <p><input type="checkbox" name="permissions[]" value="{{ $permission->name }}"> {{ $permission->name }}</p>
              @endforeach
            </div>
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