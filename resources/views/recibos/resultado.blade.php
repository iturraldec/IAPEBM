@extends('adminlte::page')

@section('title', 'Subir Recibos de Pago')

@section('content_header')
  <h3>Resultado de la carga de Recibos de Pago.</h3>
@endsection

@section('content')
  <div class="row justify-content-center">
    <div class="col-6">
      @if(! empty($resultado))
        <p class="text-danger h4">ERROR: No se encontraron los siguientes números de cédulas:</p>
        <table>
          <tr>
            <th>Nro. Cédula</th>
          </tr>

          <tbody>
            @foreach($resultado as $item)
              <tr><td>{{ $item }}</td></tr>
            @endforeach
          </tbody>
        </table>
      @else
        <h1 class="text-primary">Los datos se subieron correctamente!</h1>
      @endif
    </div>
  </div>
@endsection