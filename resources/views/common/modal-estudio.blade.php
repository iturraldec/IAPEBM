<!-- Modal -->
<div class="modal fade" id="estudioModal" tabindex="-1" role="dialog" data-backdrop="static">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="estudioModalTitle">?</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-12 form-group">
            <label for="selectEstudioTipo">Tipo de grado académico</label>
            <select id="selectEstudioTipo" class="form-control" title="Tipo de estudio">
              <option value="0" selected>SELECCIONE EL TIPO</option>
              @foreach (\App\Models\EstudioType::orderBy('tipo')->get() as $item)
                <option value="{{ $item->id}}">{{ $item->tipo }}</option>
              @endforeach
            </select>
          </div>
          
          <div class="col-5 form-group">
            <label for="inputEstudioFecha">Fecha de obtención*</label>
            <input type="date" 
                  class="form-control" 
                  id="inputEstudioFecha"
                  title="Fecha de obtención del título"
            />
          </div>

          <div class="col-12 form-group">
            <label for="inputEstudioDescripcion">Descripcion*</label>
            <input type="text" 
                  class="form-control" 
                  id="inputEstudioDescripcion"
                  placeholder="Ingrese la descripción del grado académico"
                  title="Descripción del grado académico"
                  onkeyup="this.value = this.value.toUpperCase();"
            />
          </div>
        </div>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Regresar</button>
        <button type="button" id="btnEstudioAceptar" class="btn btn-primary">Aceptar</button>
      </div>
    </div>
  </div>
</div>