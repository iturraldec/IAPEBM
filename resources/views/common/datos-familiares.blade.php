<!-- familiares del empleado -->

<div class="tab-pane fade" id="custom-tabs-one-familia" role="tabpanel" aria-labelledby="custom-tabs-one-familia-tab">
  <div class="card card-primary">
    <div class="card-header bg-lightblue">
      <h3 class="card-title">Familiares</h3>
    </div>
    <!-- /.card-header -->

    <div class="card-body">
      <div class="row">
        <div class="col-3 form-group">
          <label for="inputFPNombre">Primer Nombre*</label>
          <input type="text" 
                class="form-control" 
                id="inputFPNombre"
                minlength="3"
                maxlength="50"
                placeholder="Ingresa su primer nombre"
                onkeyup="this.value = this.value.toUpperCase();"
                title="Primer nombre del familiar"
          />
        </div>

        <div class="col-3 form-group">
          <label for="inputFSNombre">Segundo Nombre</label>
          <input type="text" 
                class="form-control" 
                id="inputFSNombre"
                minlength="3"
                maxlength="50"
                placeholder="Ingresa su segundo nombre"
                onkeyup="this.value = this.value.toUpperCase();"
                title="Segundo nombre del familiar"
          />
        </div>

        <div class="col-3 form-group">
          <label for="inputFPApellido">Primer Apellido*</label>
          <input type="text" 
                class="form-control" 
                id="inputFPApellido"
                minlength="3"
                maxlength="50"
                placeholder="Ingresa su primer apellido"
                onkeyup="this.value = this.value.toUpperCase();"
                title="Primer apellido del familiar"
          />
        </div>

        <div class="col-3 form-group">
          <label for="inputFSApellido">Segundo Apellido</label>
          <input type="text" 
                class="form-control" 
                id="inputFSApellido"
                minlength="3"
                maxlength="50"
                placeholder="Ingresa su segundo apellido"
                onkeyup="this.value = this.value.toUpperCase();"
                title="Segundo apellido del familiar"
          />
        </div>

        <div class="col-3 form-group">
          <label for="selectParentesco">Parentesco</label>
          <select id="selectParentesco" class="form-control" name="parentesco_id" title="Parentesco">
            <option value="0" selected>SELECCIONE</option>
            @foreach (App\Enums\ParentescoEnum::cases() as $case)
              <option value="{{ $case->value }}">{{ $case->label() }}</option>
            @endforeach
          </select>
        </div>

        <div class="col-3 form-group d-flex">
          <button type="button"
                  id="btnFamiliarAdd"
                  class="form-control btn btn-primary mt-auto" 
                  title="Agregar familiar"
          >Agregar familiar</button>
        </div>

        <div class="col-12">
          <table id="familiaresDT" class="table table-hover border border-primary" width="100%">
            <thead class="text-center">
              <tr>
                <th>Parentesco</th>
                <th>Primer Nombre</th>
                <th>Segundo Nombre</th>
                <th>Primer Apellido</th>
                <th>Segundo Apellido</th>
                <th></th>
              </tr>
            </thead>

            <tbody>
            </tbody>
          </table>
        </div>
      </div>
    </div>
    <!-- /.card-body -->
  </div>
</div>
