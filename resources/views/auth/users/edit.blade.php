<!-- agregar/editar usuario -->
<form id="form-user">
  <input type="hidden" id="idInput" name="id">

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
            <label for="documentInput">Documento de Identificación</label>
            <input type="text" id="documentInput" name="document_number" class="form-control">
          </div>

          <div class="form-group">
            <label for="nameInput">Nombre del usuario</label>
            <input type="text" id="nameInput" name="name" class="form-control">
          </div>

          <div class="form-group">
            <label for="emailInput">Correo del usuario</label>
            <input type="text" id="emailInput" name="email" class="form-control">
          </div>

          <div class="row mt-2">
            <div class="col form-group">
              <label for="roles[]" class="mt-2">Seleccione los Roles a asignarle</label>
              @foreach ($roles as $rol)
                <p><input type="checkbox" name="roles[]" value="{{ $rol->name }}"> {{ $rol->name }}</p>
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