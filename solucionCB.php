<?php
include 'funcionalidad.php';

// ini_set('display_errors', 0);
// error_reporting(E_ERROR | E_WARNING | E_PARSE);

$matrizB1=array();
$matrizB2=array();
$matrizC=array();
$vector=array();
$m =floatval($_POST["n"]);
$n =floatval($_POST["n"]);

$aaux=array(); //Arreglo auxiliar para agregar a la matriz

for ($i=0; $i < $m; $i++) { 
    for ($j=0; $j < $n; $j++) { 
        array_push($aaux, intval($_POST["1-".$j."-".$i]));
    }
    array_push($matrizB1, $aaux);

    $aaux=array();
}

for ($i=0; $i < $m; $i++) { 
    for ($j=0; $j < $n; $j++) { 
        array_push($aaux, intval($_POST["2-".$j."-".$i]));
    }
    array_push($matrizB2, $aaux);

    $aaux=array();
}

for ($i=0; $i < $m; $i++) { 
    for ($j=0; $j < $n; $j++) { 
        if($i==$j){
            array_push($aaux, 1);
        }else{
            array_push($aaux, 0);
        }
    }
    array_push($matrizC, $aaux);

    $aaux=array();
}

for ($i=0; $i < $m; $i++) { 
    array_push($vector, $_POST["v-".$i]);
}

$determinanteB1=0;
$determinanteB2=0;
$determinanteB1=determinante($matrizB1, $n);
$determinanteB2=determinante($matrizB2, $n);
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

        .supsub {
            display: inline-block;
        }

        .supsub sup,
        .supsub sub {
            position: relative;
            display: block;
            font-size: .5em;
            line-height: 1.2;
        }

        .supsub sub {
            top: .3em;
        }
    </style>
    <!--:0 comentarios en html owo-->
    <body class="d-flex h-100 text-center text-white bg-dark row w-100">
        <div class="cover-container d-flex w-75 p-3 mx-auto flex-column fs-4">
            <p>Solucion:</p>
            <h2>Para generar las matrices de cambio de bases vamos a comprobar que &beta;1 y &beta;2 son bases:</h2><br>
            <?php
            imprimir($matrizB1, $m, $n, 1);
            ?>
            <h1>|&beta;1|=<?php echo $determinanteB1 ?></h1><br>
            <?php
            imprimir($matrizB2, $m, $n, 1);
            ?>
            <h1>|&beta;2|=<?php echo $determinanteB2 ?></h1><br>
            <?php
            if($determinanteB1!=0 && $determinanteB2!=0){
                ?><h2>
                    Siendo que las 2 combinaciones lineales son bases, podemos hacer las matrices de cambio de base:<br>
                    Haciendo la primera matriz de cambio de base de una base canonica a &beta;1:
                </h2><?php
                for ($l=0; $l < $n; $l++) {
                    $matrizBack=array();
                    for ($i=0; $i < $m; $i++) { 
                        for ($j=0; $j < $n; $j++) { 
                            array_push($aaux, $matrizB1[$i][$j]);
                        }
                        array_push($aaux, $matrizC[$i][$l]);
                        array_push($matrizBack, $aaux);
                        
                        $aaux=array();
                    }
                    
                    // imprimir($matrizBack, $m, $n, 0);
        
                    checarDecimales($matrizBack, $m, $n);
                    
                    $valoresRepetidos; 
                    $purosCeros;
                    for ($j=0; $j < $m-1; $j++) {
                        //MDC para toda las filas
                        $divisores = conseguirDivisores($matrizBack);
        
                        //Revisar cambio algo
                        if(isset(array_count_values($divisores)[1]) && isset(array_count_values($divisores)[0])){
                            $valoresRepetidos = array_count_values($divisores)[1];
                            if($valoresRepetidos != count($divisores) && $purosCeros==0){
                                // imprimirDivisores($divisores);
                                $matrizBack = simplificarFilas($matrizBack, $divisores);
                                // imprimir($matrizBack, $m, $n, 0);
                            }
                        }
                        
                        //algoritmo de ordenamiento en base a la columna
                        $indices = conseguirIndices($matrizBack, $j); //El segundo parametro avanza conforme se tomen en cuenta menos filas
                        
                        //Revisar si cambio algo
                        for ($k=0; $k < count($indices); $k++) { 
                            if($indices[$k] != $k){
                                // imprimirCambio($indices);
                                $matrizBack = ordenarConIndices($matrizBack, $indices);
                                // imprimir($matrizBack, $m, $n, 0);
                                break;
                            }
                        }
                        
                        //Gauss-Jordan
                        $matrizBack = restarFilasAbajo($matrizBack, $m, $n, $j, 3);  //El segundo parametro avanza conforme se tomen en cuenta las filas
                        // imprimir($matrizBack, $m, $n, 0);
                        
                        //Checar si hay filas en ceros
                        $matrizBack = checarCeros($matrizBack, $m, $n);
                        $m = count($matrizBack);
        
                    }
        
                    //Ultimo MDC para toda las filas
                    $divisores = conseguirDivisores($matrizBack);
        
                    //Revisar cambio algo
                    $valoresRepetidos = 0;
                    if(isset(array_count_values($divisores)[1])){
                        $valoresRepetidos = array_count_values($divisores)[1];
                    }
                    if($valoresRepetidos != count($divisores)){
                        // imprimirDivisores($divisores);
                        $matrizBack = simplificarFilas($matrizBack, $divisores);
                        // imprimir($matriz, $m, $n, 0);
                    }
                    
                    //Checamos el rango negativo
                    $rangoN=0; //Rango negativo (para restar al rango de A* y obtener el rango de A)
                    for ($i=0; $i < $m; $i++) { 
                        if(isset(array_count_values($matrizBack[$i])[0])){
                            $valoresRepetidos = array_count_values($matrizBack[$i])[0];
                            if($valoresRepetidos == count($matrizBack[$i])-1 and $matrizBack[$i][$n]!=0){
                                $rangoN++;
                            }
                        }
                    }
                    
                    //Comparar rangos para definir si no hay soluciones, hay una unica solucion o tiene infinidad de soluciones
                    //El rango de A es m-rangoN
                    //El rango de A* es m
                    $inter = 0;
                    if($m != ($m-$rangoN)){
                        echo "<br><h1>Algo salio mal</h1>";
                        $inter = 3;
                    }elseif($m == $n){
                        $inter = 1;
                    }else{
                        echo "<br><h1>Algo salio mal</h1><br>";
                        $inter = 2;
                    }
                    if($inter == 1){
                        // imprimir($matriz, $m, $n, 0);
                        for ($i=0; $i < $m-1; $i++) { 
                            $matrizBack = restarFilasArribaSI($matrizBack, $m, $n, $i);
                            // imprimir($matriz, $m, $n, 0);
                            
                            //MDC para toda las filas
                            $divisores = conseguirDivisores($matrizBack);
                            
                            //Revisar cambio algo
                            $valoresRepetidos = array_count_values($divisores)[1];
                            if($valoresRepetidos != count($divisores)){
                                // imprimirDivisores($divisores);
                                $matrizBack = simplificarFilas($matrizBack, $divisores);
                                // imprimir($matriz, $m, $n, 0);
                            }
                        }
                        
                        imprimir($matrizBack, $m, $n, 0);
                        $divisores = array();
                        for ($i=0; $i < $m; $i++) { 
                            array_push($divisores, $matrizBack[$i][$i]);
                        }
        
                        imprimirDivisores($divisores);
                        $matrizBack = simplificarFilas($matrizBack, $divisores);
                        imprimir($matrizBack, $m, $n, 0);
        
                        ?><br><h1>u = 
                            <?php
                            for ($i=0; $i < $m; $i++) { 
                                if($matrizBack[$i][$n]<0){
                                    echo $matrizBack[$i][$n];
                                }else{
                                    echo "+".$matrizBack[$i][$n];
                                }
                                ?>v<sub><?php echo $i+1 ?></sub><?php
                            }
                            ?>
                        </h1><br><?php
                    }
                    $matrizBack=$matrizB1;
                }
            }else if($determinanteB1==0){
                ?><h1>La primer combinación lineal no es una base, por lo tanto no se puede hacer la matriz de cambio de base</h1><?php
            }else if($determinanteB2==0){
                ?><h1>La segunda combinación lineal no es una base, por lo tanto no se puede hacer la matriz de cambio de base</h1><?php
            }else{
                ?><h1>Ninguna combinación lineal es una base, por lo tanto no se puede hacer la matriz de cambio de base</h1><?php
            }
            ?>

            <!-- Sugerencia de uso -->
            <br><br>
            <h2>Veamos si sigue funcionando: A<span class="supsub"><sup>&beta;1</sup><sub>&beta;2</sub></span> owo</h2>
        </div>
    </body>
</html>