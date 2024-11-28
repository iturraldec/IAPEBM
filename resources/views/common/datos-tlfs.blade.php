<!-- telefonos de los trabajadores -->

<div class="col-6">
  <div class="card bg-light ">
    <div class="card-header bg-lightblue">
      <h3 class="card-title">Teléfono(s) del Empleado*</h3>
    </div>
    <!-- /.card-header -->
      <div class="card-body">
        <div class="row">
          <div class="col-6">
            <select id="selectPhoneType" class="form-control" title="Tipo de número">
              <option value="0" selected>SELECCIONE TIPO DE NÚMERO</option>
              @foreach (\App\Enums\PhoneTypeEnum::cases() as $case)
                <option value="{{ $case->value }}">{{ $case->label() }}</option>
              @endforeach
              </select>
          </div>

          <div class="col-6">
            <div class="input-group">
              <input type="text"
                  class="form-control"
                  id="inputPhone"
                  placeholder="Ingresa el número de teléfono"
                  title="Teléfono del empleado"
              />

              <div class="input-group-append">
                <button type="button" 
                        id="btnPhoneAdd" 
                        class="input-group-text btn btn-primary btn-sm"
                        title="Agregar número de teléfono del empleado"
                >
                  <i class="fas fa-plus-square"></i>
                </button>
              </div>
            </div>
          </div>

          <div class="col-12">
            <table id="phonesDT" class="table table-hover border border-primary">
              <thead>
                <tr>
                  <th scope="col">TipoID</th>
                  <th scope="col">Tipo</th>
                  <th scope="col">Número</th>
                  <th scope="col"></th>
                </tr>
              </thead>

              <tbody></tbody>
            </table>
          </div>
        </div>  
      </div>
      <!-- /.card-body -->
  </div>
</div>
