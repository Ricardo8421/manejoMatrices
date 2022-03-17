<?php
include 'funcionalidad.php';

ini_set('display_errors', 0);
error_reporting(E_ERROR | E_WARNING | E_PARSE);

$matriz = array();
$m = intval($_POST["m"]);

$aaux = array();

//Poner cookies para poder calcular la determinante de |A^2|
//Volver a utilizar solucionMD, entonces validar de que llegue algun dato, si no mandar un mensaje de error
for ($i=0; $i < $m; $i++) { 
    for ($j=0; $j < $m; $j++) { 
        array_push($aaux, floatval($_POST[$i."-".$j]));
        setcookie($i."-".$j, floatval($_POST[$i."-".$j]));
    }
    array_push($matriz, $aaux);

    $aaux=array();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <title>Solución A*A</title>
</head>
<style>
        .matriz{
            position: relative;
        }

        .matriz:before,
        .matriz:after{
            content: "";
            position: absolute;
            top: 0;
            border: 1px solid #FFF;
            width: 1%;
            height: 100%;
        }

        .matriz:before{
            left: -6px;
            border-right: 0;
        }

        .matriz:after{
            right: -6px;
            border-left: 0;
        }

        .elemento{
            padding-right: 5px;
            padding-left: 5px;
        }
</style>
<body class="d-flex h-100 text-center text-white bg-dark row w-100">
    <div class="cover-container d-flex w-75 p-3 mx-auto flex-column fs-4">
        <p>Solución:</p>
        <?php
        imprimir($matriz, $m, $m, 1);
        ?>
        <br>
        X
        <br>
        <?php
        imprimir($matriz, $m, $m, 1);
        ?>
        <br>=<br>
        <?php
        $resultado = cuadrado($matriz, $m);
        imprimir($resultado, $m, $m, 1);
        ?>
    </div>
    <p class="lead">
        <a href="solucionMD.php" class="btn btn-lg btn-secondary fw-bold border-white bg-white text-black w-25 m-3">Resolver su determinante</a>
    </p>
</body>
</html>