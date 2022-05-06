<!DOCTYPE html>
<html lang="en">
<head>
    <script src="js/insersion.js"></script>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nulidad e imagen</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>
<body class="d-flex h-100 text-center text-white bg-dark row w-100">
    <div class="cover-container d-flex w-75 p-3 mx-auto flex-column fs-4">
        <form name="poner">
            Encontrar el espacio nulo e imagen de una matriz de tamaño: <input type="number" name="m" placeholder="m" class="me-2 rounded w-25" min="2" max="10">x <input class="me-2 rounded w-25" type="number" name="n" placeholder="n" min="2" max="10">
            <br><br>
            <input type="button" value="Generar entradas" onclick="generarNI()" class="btn btn-lg btn-secondary fw-bold border-white bg-white text-black">
        </form>
    </div>
    <div id="identificador" class="cover-container d-flex w-75 p-3 mx-auto flex-column fs-6"></div>
</body>
</html>