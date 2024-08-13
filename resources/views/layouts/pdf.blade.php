<!DOCTYPE html>
<html lang="es">
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

  <style>
    table, th, td {
      border: 1px solid black;
      border-collapse: collapse;
    }
  </style>

  <title>@yield('title')</title>

</head>

<body>
  <table class="table table-borderless table-sm">
    <thead class="text-center">
      <tr>
        <th scope="col"><img src="{{ public_path('assets/images/escudo.png') }}" width="50" height="auto"></th>
        <th scope="col" colspan="2">
          <p style="font-size:9;">Dirección de Recursos Humanos</p>
          <p style="font-size:9;">Historial Personal de Funcionario Policial</p>
          <p style="font-size:11;">@yield('encabezado')</p>
        </th>
        <th scope="col"><img src="{{ public_path('assets/images/iapebm.png') }}" width="50" height="auto"></th>
      </tr>
    </thead>
  </table>

  <main>
    @yield('content')
  </main>

</body>
</html>