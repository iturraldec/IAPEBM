<!-- Modal constancia laboral -->
<div class="modal fade" id="constanciaLaboralModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"  data-backdrop="static">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Constancia de Trabajo</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <label for="inputConstanciaLaboralCedula">Nro. de Cédula</label>
          <input type="text" id="inputConstanciaLaboralCedula" class="form-control" placeholder="Ingrese Nro. de Cédula">
        </div>

        <div class="form-group">
          <label for="inputConstanciaLaboralMotivo">Motivo</label>
          <input type="text" 
                id="inputConstanciaLaboralMotivo"
                class="form-control" 
                onkeyup="this.value = this.value.toUpperCase();"
                placeholder="Ingrese el motivo"
          >
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        <button type="button" id="btnConstanciaLaboralGenerar" class="btn btn-primary">Generar</button>
      </div>
    </div>
  </div>
</div>