<!-- componente: datos academicos de los empleados -->

<div class="tab-pane fade" id="custom-tabs-one-estudios" role="tabpanel">
  <div class="card card-primary">
    <div class="card-header bg-lightblue">
      <h3 class="card-title">Formación académica del empleado</h3>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
      <div class="row">
        <div class="col-3 form-group">
          <label for="selectEstudioTipo">Tipo de grado académico</label>
          <select id="selectEstudioTipo" class="form-control" title="Tipo de estudio">
            <option value="0" selected>SELECCIONE EL TIPO</option>
            @foreach (\App\Models\EstudioType::orderBy('tipo')->get() as $item)
              <option value="{{ $item->id}}">{{ $item->tipo }}</option>
            @endforeach
          </select>
        </div>

        <div class="col-2 form-group">
          <label for="inputEstudioFecha">Fecha de obtención*</label>
          <input type="date" 
                class="form-control" 
                id="inputEstudioFecha"
                title="Fecha de obtención del título"
          />
        </div>

        <div class="col-7">
          <label for="inputEstudioDescripcion">Descripcón*</label>
          <div class="input-group">
            <input type="text" 
                class="form-control" 
                id="inputEstudioDescripcion"
                placeholder="Ingrese la descripción del grado académico"
                title="Descripción del grado académico"
                onkeyup="this.value = this.value.toUpperCase();"
            />
            <div class="input-group-append">
              <button type="button"
                      id="btnEstudiosAdd"
                      class="input-group-text btn btn-primary btn-sm"
                      title="Agregar ubicación del empleado"
              >
                <i class="fas fa-plus-square"></i>
              </button>
            </div>
          </div>
        </div>
      </div>

      <table id="estudiosDT" class="table table-hover border border-primary text-center" width="100%">
        <thead>
          <tr>
            <th>Tipo</th>
            <th>Fecha</th>
            <th>Descripción</th>
            <th></th>
          </tr>
        </thead>

        <tbody>
        </tbody>
      </table>
    </div>
  </div>
  <!-- /.card-body -->
</div>

{{-- <div class="tab-pane fade" id="custom-tabs-one-estudios" role="tabpanel" aria-labelledby="custom-tabs-one-estudios-tab">
            <div class="card card-primary">
              <div class="card-header bg-lightblue">
                <h3 class="card-title">Estudios del Empleado</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div class="d-flex justify-content-end">
                  <button type="button" 
                          class="btn btn-primary"
                          id="btnEstudioAdd"
                  ><i class="fas fa-plus-square"></i> Agregar estudio</button>
                </div>

                <table id="estudiosDT" class="table table-hover border border-primary text-center" width="100%">
                  <thead>
                    <tr>
                      <th>id</th>
                      <th>estudio_tipo_id</th>
                      <th>Tipo</th>
                      <th>Fecha</th>
                      <th>Descripción</th>
                      <th>status</th>
                      <th></th>
                    </tr>
                  </thead>

                  <tbody>
                    @foreach ($data['employee']->estudios as $item)
                      <tr>
                        <td>{{ $item->id}}</td>
                        <td>{{ $item->estudio_type_id }}</td>
                        <td>{{ $item->tipo->tipo }}</td>
                        <td>{{ $item->fecha }}</td>
                        <td>{{ $item->descripcion }}</td>
                        <td></td>
                        <td></td>
                      </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
            </div>
            <!-- /.card-body -->
          </div> --}}