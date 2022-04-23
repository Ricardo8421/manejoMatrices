<?php
include 'funcionalidad.php';

ini_set('display_errors', 0);
error_reporting(E_ERROR | E_WARNING | E_PARSE);

$matriz=array();
$m =floatval($_POST["can"]);
$n =floatval($_POST["n"]);

$aaux=array();

for ($i=0; $i < $n; $i++) { 
    for ($j=0; $j < $m; $j++) { 
        array_push($aaux, intval($_POST[$j."-".$i]));
    }
    array_push($aaux, intval($_POST["v".$i]));
    array_push($matriz, $aaux);

    $aaux=array();
}

$matrizBack=$matriz;

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Respuesta con calidad</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
        <link href="/css/estilo.css" rel="stylesheet">
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
    <!--:0 comentarios en html owo-->
    <body class="d-flex h-100 text-center text-white bg-dark row w-100">
        <div class="cover-container d-flex w-75 p-3 mx-auto flex-column fs-4">
            <p>¿El vector pertenece a la combinación lineal?</p>
            <?php
            imprimir($matriz, $m, $n, 0);

            checarDecimales($matriz, $m, $n);
            
            $valoresRepetidos; 
            for ($j=0; $j < $m-1; $j++) {
                //MDC para toda las filas
                $divisores = conseguirDivisores($matriz);

                //Revisar cambio algo
                if(isset(array_count_values($divisores)[1])){
                    $valoresRepetidos = array_count_values($divisores)[1];
                    if($valoresRepetidos != count($divisores)){
                        imprimirDivisores($divisores);
                        $matriz = simplificarFilas($matriz, $divisores);
                        imprimir($matriz, $m, $n, 0);
                    }
                }
                
                //algoritmo de ordenamiento en base a la columna
                $indices = conseguirIndices($matriz, $j); //El segundo parametro avanza conforme se tomen en cuenta menos filas
                
                //Revisar si cambio algo
                for ($k=0; $k < count($indices); $k++) { 
                    if($indices[$k] != $k){
                        imprimirCambio($indices);
                        $matriz = ordenarConIndices($matriz, $indices);
                        imprimir($matriz, $m, $n, 0);
                        break;
                    }
                }
                
                //Gauss-Jordan
                $matriz = restarFilasAbajo($matriz, $m, $n, $j, 0);  //El segundo parametro avanza conforme se tomen en cuenta las filas
                imprimir($matriz, $m, $n, 0);
                
                //Checar si hay filas en ceros
                $matriz = checarCeros($matriz, $m, $n);
                $m = count($matriz);

            }

            //Ultimo MDC para toda las filas
            $divisores = conseguirDivisores($matriz);

            //Revisar cambio algo
            $valoresRepetidos = array_count_values($divisores)[1];
            if($valoresRepetidos != count($divisores)){
                imprimirDivisores($divisores);
                $matriz = simplificarFilas($matriz, $divisores);
                imprimir($matriz, $m, $n, 0);
            }
            
            //Checamos el rango negativo
            $rangoN=0; //Rango negativo (para restar al rango de A* y obtener el rango de A)
            for ($i=0; $i < $m; $i++) { 
                if(isset(array_count_values($matriz[$i])[0])){
                    $valoresRepetidos = array_count_values($matriz[$i])[0];
                    if($valoresRepetidos == count($matriz[$i])-1 and $matriz[$i][$n]!=0){
                        $rangoN++;
                    }
                }
            }
            
            //Comparar rangos para definir si no hay soluciones, hay una unica solucion o tiene infinidad de soluciones
            //El rango de A es m-rangoN
            //El rango de A* es m
            $inter = 0;
            if($m != ($m-$rangoN)){
                echo "<br><h1>No hay soluciones</h1>";
                echo "<br><h1>Por lo tanto el vector no pertenece a la combinación lineal</h1><br><br>";
                $inter = 3;
            }elseif($m == $n){
                echo "<br><h1>Hay solucion unica</h1><br>";
                echo "<br><h1>Por lo tanto el vector pertenece a la combinación lineal</h1><br><br>";
                $inter = 1;
            }else{
                echo "<br><h1>Tiene infinidad de soluciones</h1><br>";
                echo "<br><h1>Por lo tanto el vector pertenece a la combinación lineal</h1><br><br>";
                echo "<p>P=# variables - R(A) = ".$n." - ".$m." = ".($n-$m)."</p>";
                $inter = 2;
            }
            if($inter == 1 or $inter == 2){
                imprimir($matriz, $m, $n, 0);
                for ($i=0; $i < $m-1; $i++) { 
                    $matriz = restarFilasArriba($matriz, $m, $n, $i);
                    imprimir($matriz, $m, $n, 0);
                    
                    //MDC para toda las filas
                    $divisores = conseguirDivisores($matriz);
                    
                    //Revisar cambio algo
                    $valoresRepetidos = array_count_values($divisores)[1];
                    if($valoresRepetidos != count($divisores)){
                        imprimirDivisores($divisores);
                        $matriz = simplificarFilas($matriz, $divisores);
                        imprimir($matriz, $m, $n, 0);
                    }
                }

                $divisores = array();
                for ($i=0; $i < $m; $i++) { 
                    array_push($divisores, $matriz[$i][$i]);
                }

                imprimirDivisores($divisores);
                $matriz = simplificarFilas($matriz, $divisores);
                imprimir($matriz, $m, $n, 0);

            }

            // //Gauss-Jordan para arriba
            switch ($inter) {
                case 3:
                    break;

                case 1:

                    ?><br><h1>
                        <?php
                        for ($i=0; $i < $m; $i++) { 
                            ?>x<sub><?php echo $i+1 ?></sub> = <?php echo $matriz[$i][$n] ?><br><?php
                        }
                        ?>
                    </h1><?php
                    break;
                    
                case 2:

                    ?><br><h1>
                        <?php
                        for ($i=0; $i < $m; $i++) { 
                            ?>x<sub><?php echo $i+1 ?></sub> = <?php echo $matriz[$i][$n];
                            for ($j=$m; $j < $n; $j++) { 
                                if(-$matriz[$i][$j] >= 0){
                                    echo " +";
                                }
                                echo -$matriz[$i][$j]."λ<sub>".($n-$j)."</sub>";
                            }
                            echo "<br>";
                        }
                        for ($i=$m; $i < $n; $i++) { 
                            ?>x<sub><?php echo $i+1 ?></sub> = λ<sub><?php echo ($n-$i) ?></sub><?php
                            echo "<br>";
                        }
                        ?>
                    </h1><?php
                    break;
                        
                default:
                    echo "<p>Hubo un error</p>";
                    break;
            }
            ?>
        </div>
        <div class="cover-container d-flex w-75 p-3 mx-auto flex-column fs-4">
            <p>¿La combinación lineal genera a R<sup><?php echo $n ?></sup>?</p>
            <?php
            $matriz=$matrizBack;
            for ($l=0; $l < $n; $l++) { 
                $matriz[$l][$m]=0;
            }
            $matrizBack=$matriz;
            //no pz si te vas a tener que aventar un metodo para poder manejar minimo literales lineales e imprimirlas ;-;
            $variables =array();
            for ($l=0; $l < $n; $l++) { 
                for ($ahmNoTengoMasVariables=0; $ahmNoTengoMasVariables < $n; $ahmNoTengoMasVariables++) { 
                    if($l==$ahmNoTengoMasVariables){
                        $aaux[$ahmNoTengoMasVariables]=1;
                    }else{
                        $aaux[$ahmNoTengoMasVariables]=0;
                    }
                }
                array_push($variables, $aaux);
                $aaux=array();
            }

            imprimirG($matriz, $m, $n, 0, $variables);

            checarDecimales($matriz, $m, $n);
            
            $valoresRepetidos; 
            for ($j=0; $j < $m-1; $j++) {
                //MDC para toda las filas
                $divisores = conseguirDivisores($matriz);

                //Revisar cambio algo
                if(isset(array_count_values($divisores)[1])){
                    $valoresRepetidos = array_count_values($divisores)[1];
                    if($valoresRepetidos != count($divisores)){
                        imprimirDivisores($divisores);

                        $matriz = simplificarFilas($matriz, $divisores);
                        $variables = simplificarFilas($variables, $divisores);
                        imprimirG($matriz, $m, $n, 0, $variables);
                    }
                }
                
                //algoritmo de ordenamiento en base a la columna
                $indices = conseguirIndices($matriz, $j); //El segundo parametro avanza conforme se tomen en cuenta menos filas
                
                //Revisar si cambio algo
                for ($k=0; $k < count($indices); $k++) { 
                    if($indices[$k] != $k){
                        imprimirCambio($indices);

                        $matriz = ordenarConIndices($matriz, $indices);
                        $variables = ordenarConIndices($variables, $indices);
                        imprimirG($matriz, $m, $n, 0, $variables);
                        break;
                    }
                }
                
                //Gauss-Jordan
                $variables = restarFilasAbajoG($matriz, $m, $n, $j, $variables);
                $matriz = restarFilasAbajo($matriz, $m, $n, $j, 0);
                imprimirG($matriz, $m, $n, 0, $variables);
                
                //Checar si hay filas en ceros
                $variables = checarCerosV($matriz, $m, $n, $variables);
                $matriz = checarCerosG($matriz, $m, $n, $variables);
                $m = count($matriz);

            }

            //Ultimo MDC para toda las filas
            $divisores = conseguirDivisores($matriz);

            //Revisar cambio algo
            $valoresRepetidos = array_count_values($divisores)[1];
            if($valoresRepetidos != count($divisores)){
                imprimirDivisores($divisores);

                $matriz = simplificarFilas($matriz, $divisores);
                $variables = simplificarFilas($variables, $divisores);
                imprimirG($matriz, $m, $n, 0, $variables);
            }
            
            //Checamos el rango negativo
            $rangoN=0; //Rango negativo (para restar al rango de A* y obtener el rango de A)
            for ($i=0; $i < $m; $i++) { 
                if(isset(array_count_values($matriz[$i])[0])){
                    $valoresRepetidos = array_count_values($matriz[$i])[0];
                    if($valoresRepetidos == count($matriz[$i])-1 and $matriz[$i][$n]!=0){
                        $rangoN++;
                    }
                }
            }
            
            //Comparar rangos para definir si no hay soluciones, hay una unica solucion o tiene infinidad de soluciones
            //El rango de A es m-rangoN
            //El rango de A* es m
            $generador = false;
            if($m != ($m-$rangoN)){
                echo "<br><h1>No hay soluciones</h1>";
                echo "<br><h1>Por lo tanto la combinación lineal no genera a R<sup>".$n."</sup></h1><br>";
            }elseif($m == $n){
                echo "<br><h1>Hay solucion unica</h1><br>";
                echo "<br><h1>Por lo tanto la combinación lineal genera a R<sup>".$n."</sup></h1><br>";
                $generador = true;
            }else{
                echo "<br><h1>Tiene infinidad de soluciones</h1><br>";
                echo "<br><h1>Por lo tanto la combinación lineal genera a R<sup>".$n."</sup></h1><br>";
                $generador = true;
            }
            ?>
        </div>
        <div class="cover-container d-flex w-75 p-3 mx-auto flex-column fs-4">
            <p>¿La combinación lineal es linealmente independiente?</p>
            <?php
            $matriz=$matrizBack;

            imprimir($matriz, $m, $n, 0);

            checarDecimales($matriz, $m, $n);
            
            $valoresRepetidos; 
            for ($j=0; $j < $m-1; $j++) {
                //MDC para toda las filas
                $divisores = conseguirDivisores($matriz);

                //Revisar cambio algo
                if(isset(array_count_values($divisores)[1])){
                    $valoresRepetidos = array_count_values($divisores)[1];
                    if($valoresRepetidos != count($divisores)){
                        imprimirDivisores($divisores);
                        $matriz = simplificarFilas($matriz, $divisores);
                        imprimir($matriz, $m, $n, 0);
                    }
                }
                
                //algoritmo de ordenamiento en base a la columna
                $indices = conseguirIndices($matriz, $j); //El segundo parametro avanza conforme se tomen en cuenta menos filas
                
                //Revisar si cambio algo
                for ($k=0; $k < count($indices); $k++) { 
                    if($indices[$k] != $k){
                        imprimirCambio($indices);
                        $matriz = ordenarConIndices($matriz, $indices);
                        imprimir($matriz, $m, $n, 0);
                        break;
                    }
                }
                
                //Gauss-Jordan
                $matriz = restarFilasAbajo($matriz, $m, $n, $j, 0);  //El segundo parametro avanza conforme se tomen en cuenta las filas
                imprimir($matriz, $m, $n, 0);
                
                //Checar si hay filas en ceros
                $matriz = checarCeros($matriz, $m, $n);
                $m = count($matriz);

            }

            //Ultimo MDC para toda las filas
            $divisores = conseguirDivisores($matriz);

            //Revisar cambio algo
            $valoresRepetidos = array_count_values($divisores)[1];
            if($valoresRepetidos != count($divisores)){
                imprimirDivisores($divisores);
                $matriz = simplificarFilas($matriz, $divisores);
                imprimir($matriz, $m, $n, 0);
            }
            
            //Checamos el rango negativo
            $rangoN=0; //Rango negativo (para restar al rango de A* y obtener el rango de A)
            for ($i=0; $i < $m; $i++) { 
                if(isset(array_count_values($matriz[$i])[0])){
                    $valoresRepetidos = array_count_values($matriz[$i])[0];
                    if($valoresRepetidos == count($matriz[$i])-1 and $matriz[$i][$n]!=0){
                        $rangoN++;
                    }
                }
            }
            
            //Comparar rangos para definir si no hay soluciones, hay una unica solucion o tiene infinidad de soluciones
            //El rango de A es m-rangoN
            //El rango de A* es m
            $li = false;
            if($m == $n){
                echo "<br><h1>Hay solucion unica</h1><br>";
                echo "<br><h1>Por lo tanto  la combinación lineal es linealmente independiente</h1><br>";
                $li=true;
            }else{
                echo "<br><h1>Tiene infinidad de soluciones</h1><br>";
                echo "<br><h1>Por lo tanto la combinación lineal es linealmente dependiente</h1><br><br>";
            }
            ?>
        </div>
        <div class="cover-container d-flex w-75 p-3 mx-auto flex-column fs-4">
            <p>¿La combinación lineal es base de R<sup><?php echo $n ?></sup>?</p>
            <?php
            if($generador && $li){
                echo"<br><h1>Ya que es generador de R<sup>".$n."</sup> y es linealmente independiente, entonces sí es base de R<sup>".$n."</sup></h1>";
            }elseif($generador){
                echo"<br><h1>Ya que es linealmente dependiente, no es base de R<sup>".$n."</sup></h1>";
            }elseif ($li) {
                echo"<br><h1>Ya que no es generador de R<sup>".$n."</sup>, no es base de R<sup>".$n."</sup></h1>";
            }else{
                echo"<br><h1>Ya que no es generador de R<sup>".$n."</sup> y es linealmente dependiente, no es base de R<sup>".$n."</sup></h1>";
            }
            ?>
        </div>
    </body>
</html>