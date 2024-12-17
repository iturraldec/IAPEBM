<!DOCTYPE html>
<html lang="es">
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

    <style>
      body {
        font-family: DejaVu Sans;
        margin: 0; /* Elimina márgenes por defecto */
        padding: 0; /* Elimina relleno por defecto */
        width: 100%; /* Asegura que el body ocupe el 100% de ancho */
        height: 100%; /* Asegura que el body ocupe el 100% de la altura */
      }

      .encabezado {
        text-align: center;
        font-size: 16px;
      }

      .encabezado p {
        margin: 0;
        margin-bottom: 0.5px;
      }

      .titulo {
        text-align: center;
        font-size: 30px;
        font-weight: bold;
        padding-top: 1rem;
        padding-bottom: 2rem;
      }
    </style>

    <title>@yield('title')</title>

  </head>

  <body>
    <header>
      <table style="width: 100%">
        <thead>
          <tr>
            <th scope="col"><img src="{{ public_path('assets/images/logo-gobernacion.png') }}" width="150" height="auto"></th>
            <th scope="col" class="encabezado">
              <p>República Bolivariana de Venezuela</p>
              <p>Gobernación del Estado Bolivariano de Mérida</p>
              <p>Instituto Autónomo de Policía del Estado Bolivariano de Mérida</p>
              <p>Oficina de Recursos Humanos</p>
            </th>
            <th scope="col"><img src="{{ public_path('assets/images/iapebm.png') }}" width="150" height="auto"></th>
          </tr>
        </thead>
      </table>
    </header>

    <main>
      <p class="titulo">@yield('encabezado')</p>

      @yield('content')
    </main>

  </body>
</html>