@extends('adminlte::page')

@section('title', 'prueba de fetch')

@section('content')
formulario de prueba
<form id="formulario">
  @method('PUT')
  nombre: <input type="text" name="nombre">
  <input type="file" name="imagen">

<button>enviar</button>
</form>
@endsection

@section('js')
<script>
  $("#formulario").submit(function(e) {
    e.preventDefault();

    let data = new FormData(formulario);

    fetch('{{ route('demos.update', ['id' => 323]) }}', {
      method  : "POST",
      headers : {
        'X-CSRF-TOKEN'  : $('meta[name="csrf-token"]').attr('content'),
        'Accept'        : 'application/json'
      },
      body : data
    })
    .then(response => {
      if(response.ok) {
        response.json().then(resp => console.log(resp));
      }
    });
  })
</script>
@endsection
