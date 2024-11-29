<!-- reposos del empleado -->
<div class="tab-pane fade" id="custom-tabs-one-reposos" role="tabpanel" aria-labelledby="custom-tabs-one-reposos-tab">
  <div class="card card-primary">
    <div class="card-header bg-lightblue">
      <h3 class="card-title">Reposos del Empleado</h3>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
      <div class="d-flex justify-content-end">
        <button type="button" 
                class="btn btn-primary"
                id="btnReposoAdd"
        ><i class="fas fa-plus-square"></i> Agregar reposo</button>
      </div>

      <table id="repososDT" class="table table-hover border border-primary min-table text-center reposos-table" width="100%">
        <thead>
          <tr>
            <th>id</th>
            <th>Desde</th>
            <th>Hasta</th>
            <th>Fecha Notificación</th>
            <th>Dr CI</th>
            <th>Dr Nombre</th>
            <th>Dr MPPS</th>
            <th>Dr CMS</th>
            <th>reposo_id</th>
            <th>reposo_codigo</th>
            <th>reposo</th>
            <th>Fecha Convalidación</th>
            <th>Dr CI</th>
            <th>Dr Nombre</th>
            <th>Dr MPPS</th>
            <th>Dr CMS</th>
            <th>status</th>
            <th></th>
          </tr>
        </thead>

        <tbody>
          @foreach ($data['employee']->reposos as $reposo)
            <tr>
              <td>{{ $reposo->id}}</td>
              <td>{{ $reposo->desde }}</td>
              <td>{{ $reposo->hasta }}</td>
              <td>{{ $reposo->noti_fecha }}</td>
              <td>{{ $reposo->noti_dr_ci }}</td>
              <td>{{ $reposo->noti_dr_nombre }}</td>
              <td>{{ $reposo->noti_dr_mpps }}</td>
              <td>{{ $reposo->noti_dr_cms }}</td>
              <td>{{ $reposo->reposo_id }}</td>
              <td>{{ is_null($reposo->reposo_id) ? '' : $reposo->reposo->codigo }}</td>
              <td>{{ is_null($reposo->reposo_id) ? '' : $reposo->reposo->diagnostico }}</td>
              <td>{{ $reposo->conva_fecha }}</td>
              <td>{{ $reposo->conva_dr_ci }}</td>
              <td>{{ $reposo->conva_dr_nombre }}</td>
              <td>{{ $reposo->conva_dr_mpps }}</td>
              <td>{{ $reposo->conva_dr_cms }}</td>
              <td></td>
              <td></td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
  <!-- /.card-body -->
</div>
<!-- fin de reposos -->