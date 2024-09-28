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
        height: 100%; /* Asegura que el body ocupe el 100% de la altura */
      }

      footer {
        position: fixed; /* Fijo en la parte inferior */
        bottom: 10px; /* Alineado al fondo */
        left: 0; /* Alineado a la izquierda */
        right: 0; /* Alineado a la derecha */
        height: 35px; /* Aumenta la altura para que el texto tenga espacio */
        text-align: center;
        line-height: 25px; /* Centra el texto verticalmente */
        font-size: 16px;
        font-weight: bold;
        border: 1px solid black; /* Define el borde */
        padding: 5px; /* Espacio entre el texto y el borde */
        margin: 0;
      }

      .titulo {
        text-align: center;
        font-size: 30px;
      }
    </style>

    <title>@yield('title')</title>

  </head>

  <body>
    <header>
      <table style="width: 100%">
        <thead>
          <tr>
            <th scope="col"><img src="{{ public_path('assets/images/logo-gobernacion.png') }}" width="120" height="auto"></th>
            <th scope="col" colspan="2">
              <p class="titulo">Dirección de Recursos Humanos</p>
              <p class="titulo">@yield('encabezado')</p>
            </th>
            <th scope="col"><img src="{{ public_path('assets/images/iapebm.png') }}" width="120" height="auto"></th>
          </tr>
        </thead>
      </table>
    </header>

    <footer>
      IAPEBM - {{ date('d/m/Y - H:i:s') }}
    </footer>

    <main>
      @yield('content')
    </main>

    <script type="text/php">
      if ( isset($pdf) ) {
          $pdf->page_script('
            $font = $fontMetrics->get_font("DejaVu Sans", "bold");
            $size = 6;
            $y = 791; // Ajusta la posición vertical
            $x = 354; // Ajusta la posición horizontal
            $pdf->text($x, $y, " | Página " . $PAGE_NUM . " de " . $PAGE_COUNT, $font, $size);
          ');
      }
    </script>

  </body>
</html>