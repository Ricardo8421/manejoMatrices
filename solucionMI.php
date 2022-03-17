<?php
include 'funcionalidad.php';

ini_set('display_errors', 0);
error_reporting(E_ERROR | E_WARNING | E_PARSE);

$matriz = array();
$m = 0;

$aaux=array();

for ($i=0; $i < 10; $i++) { 
    for ($j=0; $j < 10; $j++) { 
        if(isset($_COOKIE[$i."-".$j])){
            array_push($aaux, floatval($_COOKIE[$i."-".$j]));
        }else{
            break;
        }
    }
    if(count($aaux)!=0){
        array_push($matriz, $aaux);
        $m++;
    }else{
        break;
    }
    $aaux=array();
}

if(isset($_COOKIE["determinante"])){
    $determinanteA = $_COOKIE["determinante"];
}else{
    $matriz=array();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <title>Solucion inversa</title>
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
        <p>
            <?php
            if(count($matriz)==0){
                echo "Ha ocurrido un error, vuelva a intentarlo mas tarde";
            }else{
                echo "Solución:";
            }
            ?>
        </p>
        <?php
        if(count($matriz)!=0){
            $matrizM=array();
            $matrizM = conseguirM($matriz, $m);

            echo "M=";
            imprimir($matrizM, count($matrizM), count($matrizM), 1);

            echo "<br><br>M^T=";
            $matrizM = conseguirMT($matrizM, count($matrizM));
            imprimir($matrizM, count($matrizM), count($matrizM), 1);

            echo "<br><br>|A|=".$_COOKIE["determinante"];
            
            echo "<br><br>A^-1=";
            $inversa = inversa($matrizM, count($matrizM), $determinanteA);
            imprimir($inversa, count($inversa), count($inversa), 1);
        }
        ?>
    </div>
</body>
</html>