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

if(count($matriz)==0){
    $matriz = array();
    $m = intval($_POST["m"]);
    for ($i=0; $i < $m; $i++) { 
        for ($j=0; $j < $m; $j++) { 
            array_push($aaux, floatval($_POST[$i."-".$j]));
            setcookie($i."-".$j, floatval($_POST[$i."-".$j]));
        }
        array_push($matriz, $aaux);
        
        $aaux=array();
    }    
}

$resultado = 0;

$resultado = determinante($matriz, $m);

if($resultado!=0){
    if(isset($_COOKIE["determinante"])){
            unset($_COOKIE["determinante"]);
            setcookie("determinante", '', time() - 3600);
    }
    setcookie("determinante", $resultado);
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
        <title>Solucion |A|</title>
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
        
        $bandera=0;
        $coeficientes=array();
        for ($i=0; $i < $m-1; $i++) { 
            //ahora ordenar solamente si es que se hizo 0 la posicion ixi, reduciendo coeficientes
            $cambio = checarIntercambio($matriz, $i);
            if($cambio>=$m){
                echo "La diagonal tiene cero, por lo tanto |A|=0";
                $bandera =2;
                break;
            }
            if($cambio!=$i){
                ?><p>|<br>F<sub><?php echo $i+1 ?></sub> ↔ F<sub><?php echo $cambio+1 ?></sub><br>↓</p><?php
                array_push($coeficientes, -1);

                //Realizar el cambio
                $aaux = $matriz[$i];
                $matriz[$i] = $matriz[$cambio];
                $matriz[$cambio] = $aaux;

                imprimir($matriz, $m, $m, 1);
            }

            if($matriz[$i][$i]!=1){
                ?><p>|<br>F<sub><?php echo $i+1 ?></sub> * 1/<?php echo $matriz[$i][$i] ?><br>↓</p><?php
                array_push($coeficientes, $matriz[$i][$i]);
                
                $matriz = dividir($matriz, $i);
                imprimir($matriz, $m, $m, 1);

            }


            //Por ultimo realizamos la diagonalizacion
            $matriz = restarFilasAbajo($matriz, $m, $m, $i, 1);
            imprimir($matriz, $m, $m, 1);
        }

        //Imprimir el resultado
        if($bandera!=2){
            ?>|A|=<?php
            $resultado = 1;
            for ($i=0; $i < $m; $i++) { 
                $resultado*=$matriz[$i][$i];
                echo "*(".$matriz[$i][$i].")";
            }
            for ($i=0; $i < count($coeficientes); $i++) { 
                $resultado*=$coeficientes[$i];
                echo "*(".$coeficientes[$i].")";
            }
            echo "=".$resultado;
        }

        if($resultado!=0){
            ?><br><br><p>
                <a href="solucionMI.php" class="btn btn-lg btn-secondary fw-bold border-white bg-white text-black w-25 m-3">Conseguir la inversa de la matriz</a>
            </p><?php
        }
        ?>
    </div>
</body>
</html>