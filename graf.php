<!DOCTYPE html>
<html lang="en">
<script src="js/insersion.js"></script>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Graficadora de transformaciones lineales</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>
    <body class="d-flex h-100 text-center text-white bg-dark row w-100">
        <div class="cover-container d-flex w-75 p-3 mx-auto flex-column fs-4">
            <!-- <form name="poner">
                Graficar un polígono de: <input type="number" name="cdp" placeholder="Cantidad de puntos" class="me-2 rounded w-25" min="3" max="10"> puntos
                <br>para realizar transformaciones lineales a los puntos
                <br><br>
                <input type="button" value="Generar entradas" onclick="generarPuntos()" class="btn btn-lg btn-secondary fw-bold border-white bg-white text-black"> -->
            <!-- </form> -->
            Graficar un polígono con los siguientes puntos para realizar transformaciones lineales a los puntos<br><br>
            <div class="cover-container d-flex w-75 p-3 mx-auto flex-column fs-6">
            <form action="solucionG.php" method="post" name="puntos">
                <input type="hidden" name="cdt" value="0">
                (<input type="number" name="1-0" class='me-2 rounded m-3' style='width: 5%!important;'>, <input type="number" name="2-0" class='me-2 rounded m-3' style='width: 5%!important;'>)
                <br><br>
                (<input type="number" name="1-1" class='me-2 rounded m-3' style='width: 5%!important;'>, <input type="number" name="2-1" class='me-2 rounded m-3' style='width: 5%!important;'>)
                <br><br>
                (<input type="number" name="1-2" class='me-2 rounded m-3' style='width: 5%!important;'>, <input type="number" name="2-2" class='me-2 rounded m-3' style='width: 5%!important;'>)
                <br><br>
                <div id="identificador">
                    <input type="hidden" name="cdp" value="3">
                    <input type="button" value="Agregar punto" onclick="agregarPunto()" class="btn btn-lg btn-secondary fw-bold border-white bg-white text-black m-1">
                    <br>
                    <input type="button" value="Triángulo isosceles" onclick="triangulo()" class="btn btn-lg btn-secondary fw-bold border-white bg-white text-black m-1">
                    <input type="button" value="Cuadrado" onclick="cuadrado()" class="btn btn-lg btn-secondary fw-bold border-white bg-white text-black m-1">
                    <input type="button" value="Pentagono regular" onclick="pentagono()" class="btn btn-lg btn-secondary fw-bold border-white bg-white text-black m-1">
                    <input type="button" value="Estrella" onclick="estrella()" class="btn btn-lg btn-secondary fw-bold border-white bg-white text-black m-1">
                    <input type="button" value="Silueta de gato" onclick="gato()" class="btn btn-lg btn-secondary fw-bold border-white bg-white text-black m-1">
                    <br>
                    <input type="submit" value="Graficar" class="btn btn-lg btn-secondary fw-bold border-white bg-white text-black m-1">
                </div>
                </form>
            </div>
        </div>
    </body>
</html>