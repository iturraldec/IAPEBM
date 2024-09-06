<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Document</title>
</head>
<body>
  init de prueba de file
  <form action="prueba-file/store" method="post" enctype="multipart/form-data">
    @csrf
    selecciona archivo:
    <input type="file" name="prueba">
    <button>subir</button>
  </form>
</body>
</html>