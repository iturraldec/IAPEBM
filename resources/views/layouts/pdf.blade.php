<!DOCTYPE html>
<html lang="es">
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

  <style>
    body { font-family: DejaVu Sans; }

    .titulo {
      text-align: center;
      font-size: 30px;
    }
  </style>

  <title>@yield('title')</title>

</head>

<body>
  <table style="width: 100%">
    <thead>
      <tr>
        <th scope="col"><img src="{{ public_path('assets/images/escudo.png') }}" width="120" height="auto"></th>
        <th scope="col" colspan="2">
          <p class="titulo">Dirección de Recursos Humanos</p>
          <p class="titulo">@yield('encabezado')</p>
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