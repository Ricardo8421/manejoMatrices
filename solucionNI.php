<?php
include 'funcionalidad.php';

ini_set('display_errors', 0);
error_reporting(E_ERROR | E_WARNING | E_PARSE);

$matriz=array();
$m =floatval($_POST["m"]);
$mBack=$m;
$n =floatval($_POST["n"]);

$aaux=array(); //Arreglo auxiliar para agregar a la matriz

for ($i=0; $i < $m; $i++) { 
    for ($j=0; $j < $n; $j++) { 
        array_push($aaux, intval($_POST[($i+1)."-".($j+1)]));
    }
    array_push($aaux, 0);
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
            <p>Solución:</p>
            <?php
            imprimir($matriz, $m, $n, 0);
            $matrizB=$matriz;
            $indicesFM=array();
            for ($i=0; $i < $m; $i++) { 
                array_push($indicesFM, $i);
            }

            checarDecimales($matriz, $m, $n);
            
            $arreglox=array();
            for ($i=0; $i < $n; $i++) { 
                array_push($arreglox, $i+1);
            }

            //No se paso a funcionalidad.php porque requiere 2 return's, pero no se como pasar por referencia
            $valoresRepetidos=0; 
            $checar=$n;
            for ($i=0; $i < $checar; $i++) { 
                for ($j=0; $j < $m; $j++) { 
                    if($matriz[$j][$i]==0){
                        $valoresRepetidos++;
                    }
                }
                if($valoresRepetidos==count($matriz)){
                    for ($j=1; $j < $n; $j++) {
                        if($arreglox[$j]<$arreglox[$j-1]){
                            break;
                        }
                    }
                    for ($k=$i; $k < $j-1; $k++) { 
                        $valoresRepetidos=$arreglox[$k];
                        $arreglox[$k]=$arreglox[$k+1];
                        $arreglox[$k+1]=$valoresRepetidos;
                    }
                    ?>
                    <p>
                    |<br>
                    C<sub><?php echo $i+1 ?></sub> → C<sub><?php echo $j ?></sub><br>
                    ↓
                    </p>
                    <?php
                    $checar--;
                    $matrizaux=array();
                    for ($j=0; $j < $m; $j++) { 
                        for ($k=0; $k < $n; $k++) { 
                            array_push($aaux, $matriz[$j][$arreglox[$k]-1]);
                        }
                        array_push($aaux, 0);
                        array_push($matrizaux, $aaux);
                        
                        $aaux=array();
                    }
                    $matriz=$matrizaux;
                    imprimir($matriz, $m, $n, 0);
                }
                $valoresRepetidos=0;
            }


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
                        $indicesFM = ordenarConIndices($indicesFM, $indices);
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
            $inter = 0; //interpretacion
            $pl=0;
            if($m != ($m-$rangoN)){
                echo "<br><h1>No hay soluciones</h1>";
                $inter = 3;
            }elseif($m == $n){
                echo "<br><h1>Hay solucion unica</h1><br>";
                $inter = 1;
            }else{
                echo "<br><h1>Tiene infinidad de soluciones</h1><br>";
                echo "<p>P=# variables - R(A) = ".$n." - ".$m." = ".($n-$m)."</p>";
                $pl=($n-$m);
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

            //Si se movieron los subindices se tiene que imprimir de manera diferente
            //en el for hacer que se tomen en cuenta los indices de arreglo x y si es menor al que se tiene actualmente se le ponga lamnda y ya
            $vectoresNulos=array();
            $aaux=array();
            switch ($inter) {
                case 3:
                    break;

                case 1:
                    for ($i=0; $i < $m; $i++) { 
                        array_push($aaux, $matriz[$i][$n]);
                    }
                    array_push($vectoresNulos, $aaux);
                    break;
                    
                case 2:
                    ?><br><h1>
                        <?php
                        $contador=0;
                        for ($i=0; $i < $m; $i++) { 
                            if($arreglox[$contador]==$i+1){
                                for ($j=$m; $j < $n; $j++) {
                                    array_push($aaux, -$matriz[$i][$j]);
                                }
                                array_push($vectoresNulos, $aaux);
                                $aaux=array();
                                $contador++;
                            }else{
                                $m++;
                                for ($j=0; $j < $n-$m-1; $j++) { 
                                    array_push($aaux, 0);
                                }
                                array_push($aaux, 1);
                                array_push($vectoresNulos, $aaux);
                                $aaux=array();
                            }
                        }
                        for ($i=$m; $i < $n; $i++) {
                            for ($j=0; $j < $pl; $j++) { 
                                if($i-$m==$j){
                                    array_push($aaux, 1);
                                }else{
                                    array_push($aaux, 0);
                                }
                            }
                            array_push($vectoresNulos, $aaux);
                            $aaux=array();
                        }
                        ?>
                    </h1>
                    <?php
                    break;
                        
                default:
                    echo "<p>Hubo un error</p>";
                    break;
            }
            ?><br>
            <h1>El espacio nulo de la matriz es: <
            <?php
            for ($i=0; $i < $pl; $i++) {
                echo "("; 
                for ($j=0; $j < $n; $j++) { 
                    if(isset($vectoresNulos[$j][$i])){
                        echo $vectoresNulos[$j][$i];
                    }else{
                        echo "0";
                    }
                    if($j!=$n-1){
                        echo ", ";
                    }
                }
                echo ")";
                if($i!=$pl-1){
                    echo ", ";
                }
            }
            if($pl==0){
                echo "(";
                for ($i=0; $i < $n; $i++) { 
                    echo "0";
                    if($i!=$n-1){
                        echo ", ";
                    }
                }
                echo ")";
            }
            ?> >
            </h1>

            <h2>
                <br>
                Para conocer la dimensión de la imágen se sigue el teorema de rango-nulidad:
                <br>
                Dim(Im(A)) = n - Dim(Nu(A)) = <?php echo $n ?> - <?php echo $pl ?> = <?php echo $n-$pl ?>
                <br><br>
            </h2>
            <h1>
                <?php
                $limite=$n-$pl;
                $vectoresImagen=array();
                $contador=0;
                for ($i=0; $i < $limite; $i++) { 
                    $aaux=array();
                    if(isset($matriz[$i][$i+$contador])){
                        if($matriz[$i][$i+$contador]==0){
                            $contador++;
                            $i--;
                        }else{
                            for ($j=0; $j < $mBack; $j++) { 
                                array_push($aaux, $matrizB[$j][$i+$contador]);
                            }
                            array_push($vectoresImagen, $aaux);
                        }
                    }
                }
                if(count($vectoresImagen)!=($n-$pl)){
                    ?>No se puede generar un espacio imagen<?php
                }else{
                    ?>
                    Así se requieren <?php echo $n-$pl ?> vectores linealmente independientes para generar la imagen de A, los cuales son:
                    <<?php
                    for ($i=0; $i < $n-$pl; $i++) { 
                        echo "(";
                        for ($j=0; $j < $mBack; $j++) { 
                            echo $vectoresImagen[$i][$j];
                            if($j!=$mBack-1){
                                echo ", ";
                            }
                        }
                        echo ")";
                        if($i!=($n-$pl)-1){
                            echo", ";
                        }
                    }
                    ?>><?php
                }
                ?>
                <br>
            </h1>
        </div>
    </body>
</html>