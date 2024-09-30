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

      .pre-footer {
        text-align: center;
        font-size: 20px;
        margin: 0;
        margin-top: 10rem;
      }

      .pre-footer p {
        margin: 0;
        margin-bottom: 0.5px;
      }

      footer {
        position: absolute; /* Fijo en la parte inferior */
        bottom: 5px; /* Alineado al fondo */
        left: 0; /* Alineado a la izquierda */
        right: 0; /* Alineado a la derecha */
        text-align: center;
        font-size: 14px;
      }

      footer p {
        font-size: 14px; /* Tamaño de fuente (ajusta según sea necesario) */
        margin: 0;
        margin-bottom: 1px;
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

    <footer>
      <hr>
      <p>Prolongación Av. Urdaneta, Sector Glorias Patrias, Edificio IAPEBM, Mérida Estado Bolivariano de Mérida.</p>
      <p>RIF G-20010389-2 - Teléfono de contacto (0274) 2630462 Ext. 225 y 107 - Zona Postal 5101</p>
      <p>direccionpolimer@gmail.com - www.polimer.gob.ve - 0800polimer</p>
    </footer>

    <main>
      <p class="titulo">@yield('encabezado')</p>

      @yield('content')
    </main>

    <div class="pre-footer">
      <strong>
        <p>{{ config('app_config.rrhh.director') }}</p>
        <p>{{ config('app_config.rrhh.rango') }}</p>
        <p>Director de la Oficina de Recursos Humanos</p>
        <p>del Instituto Autónomo de Policía del Estado Bolivariano de Mérida</p>
      </strong>
      <p>Designado mediante {{ config('app_config.rrhh.documento') }} del Director General del IAPEBM de fecha {{ config('app_config.rrhh.documento_fecha') }}</p>
    </div>

  </body>
</html>