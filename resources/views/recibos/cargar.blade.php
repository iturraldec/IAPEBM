@extends('adminlte::page')

@section('title', 'Subir Recibos de Pago')

@section('content_header')
  <h3>Cargar Recibos de Pago.</h3>
@endsection

@section('content')
  <div class="row justify-content-center">
    <div class="col-6 form-group">
      <form action="{{ route('rp.subir') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
          <label>Mes del recibo a cargar</label>
          <input type="text" name="mes" class="form-control" placeholder="AAAA-MM">
        </div>
        
        <div class="form-group">
          <p><label for="inputFile">Archivo Excel a cargar</label></p>
          <input type="file" id="inputFile" name="archivo">
        </div>
        <div class="text-center">
          <button class="btn btn-danger">Subir</button>
        </div>
      </form>
    </div>
  </div>
@endsection

@section('js')
<script>
  $(document).ready(function () {
    
  });
</script>
@endsection