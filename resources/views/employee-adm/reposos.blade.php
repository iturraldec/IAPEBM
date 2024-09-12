<div class="col-2 form-group">
  <label for="inputReposoDesde">Desde*</label>
  <input type="date" 
        class="form-control" 
        id="inputReposoDesde" 
        value="{{ date('Y-d-m') }}"
        title="Fecha inicial del reposo"
  />
</div>

<div class="col-2 form-group">
  <label for="inputReposoHasta">Hasta*</label>
  <input type="date" 
        class="form-control" 
        id="inputReposoHasta"
        value="{{ date('Y-d-m') }}"
        title="Fecha final del reposo"
  />
</div>

<div class="col-2 form-group">
  <label>Código*</label>
  <input type="text" 
        class="form-control" 
        id="inputReposoCodigo" 
        placeholder="Código del reposo"
        onkeyup="this.value = this.value.toUpperCase();"
        title="Código del reposo"
  >
</div>

<div class="col-6 form-group">
  <label for="selectReposo">Reposo</label>
  <select id="selectReposo" class="form-control" title="Reposo">
  </select>
</div>

<div class="col-12 form-group">
  <label for="inputReposoObservacion">Observación</label>
  <div class="input-group">
    <input type="text" 
          class="form-control" 
          id="inputReposoObservacion"
          placeholder="Ingrese observaciones"
          onkeyup="this.value = this.value.toUpperCase();"
          title="Observaciones del reposo"
    />

    <div class="input-group-append">
      <div id="btnReposoAdd" class="input-group-text" title="Agregar reposo"><i class="fas fa-plus-square"></i></div>
    </div>
  </div>
</div>
