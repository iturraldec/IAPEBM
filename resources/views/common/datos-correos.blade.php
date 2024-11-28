<!-- correos de los trabajadores -->

<div class="col-6">
  <div class="card card-primary">
    <div class="card-header bg-lightblue">
      <h3 class="card-title">Correo(s) del Empleado*</h3>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
      <div class="row">
        <div class="col-12">
          <div class="input-group">
            <input type="email"
                class="form-control"
                id="inputEmail"
                placeholder="Ingresa el correo electrónico"
                onkeyup="this.value = this.value.toLowerCase();"
                title="Correo del empleado"
            />

            <div class="input-group-append">
              <button type="button" 
                      id="btnEmailAdd" 
                      class="input-group-text btn btn-primary btn-sm"
                      title="Agregar correo del empleado"
              >
                <i class="fas fa-plus-square"></i>
              </button>    
            </div>
          </div>
        </div>

        <div class="col-12">
          <table id="emailsDT" class="table table-hover border border-primary">
            <thead class="text-center">
              <tr>
                <th scope="col">Correo</th>
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
