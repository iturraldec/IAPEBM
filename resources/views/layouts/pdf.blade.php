<!DOCTYPE html>
<html lang="es">
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

  <title>@yield('title')</title>

  <link rel="stylesheet" href="{{ public_path('vendor/adminlte/dist/css/adminlte.min.css') }}">

</head>

<body>
  <table class="table table-borderless table-sm">
    <thead class="text-center">
      <tr>
        <th scope="col"><img src="{{ public_path('assets/images/escudo.png') }}" width="150" height="auto"></th>
        <th scope="col" colspan="2">
          <p class="mb-0" style="font-size:9;">Dirección de Recursos Humanos</p>
          <p class="mb-1" style="font-size:9;">Historial Personal de Funcionario Policial</p>
          <p  style="font-size:11;">DATOS PERSONALES</p>
        </th>
        <th scope="col"><img src="{{ public_path('assets/images/iapebm.png') }}" width="120" height="auto"></th>
      </tr>
    </thead>
  </table>

  <main>
    @yield('content')
  </main>

</body>
</html>