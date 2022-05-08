<?php
function checarDecimales($arreglo, $m, $n){
    $potencia = 1;
    $potenciasArreglo = array();
    for ($i=0; $i < $m; $i++) { 
        for ($j=0; $j < $n; $j++) { 
            $entero = intval($arreglo[$i][$j]);
            while($entero != $arreglo[$i][$j]){
                for ($k=0; $k < $n; $k++) { 
                    $arreglo[$i][$k]*=10;
                }
                $potencia*=10;
                $entero = intval($arreglo[$i][$j]);
            }
        }
        array_push($potenciasArreglo, $potencia);
        $potencia = 1;
    }
    $valoresRepetidos = array_count_values($potenciasArreglo)[1];
    if($valoresRepetidos != count($potenciasArreglo)){
        for ($i=0; $i < count($potenciasArreglo); $i++) { 
            if($potenciasArreglo[$i]!=1){
                ?><p>|<br>
                F<sub><?php echo $i+1 ?></sub> x <?php echo $potenciasArreglo[$i] ?><br><?php
            }
        }
        imprimir($arreglo, $m, $n);
    }
    return $arreglo;
}

function conseguirIndices($arreglo, $col){
    $n = count($arreglo);
    $posicionesOrdenadas = array();

    for ($i=0; $i < $n; $i++) { 
        array_push($posicionesOrdenadas, $i);
    }

    $ceros = 0;

    $pivote;
    $pivoteI; //pivote de indice

    for ($i=1+$col; $i < $n; $i++) { 
        $j=$i-1;
        $pivote = $arreglo[$i];
        $pivoteI = $posicionesOrdenadas[$i];

        while ($j>=$col and (($pivote[$col]<0) ? -$pivote[$col] : $pivote[$col])<(($arreglo[$j][$col]<0) ? -$arreglo[$j][$col] : $arreglo[$j][$col])) {

            $arreglo[$j+1] = $arreglo[$j];
            $posicionesOrdenadas[$j+1] = $posicionesOrdenadas[$j];
            $j--;
        }

        $arreglo[$j+1]=$pivote;
        $posicionesOrdenadas[$j+1] = $pivoteI;
    }
    
    for ($i=0+$col; $i < $n; $i++) { 
        if($arreglo[$i][$col] == 0){
            $ceros++;
        }
    }
    
    if ($ceros > 0) {
        $aux = $posicionesOrdenadas;
        $posicionesOrdenadas = array();
        for ($i=0; $i < $col; $i++) { 
            array_push($posicionesOrdenadas, $i);
        }
        for ($i=$ceros+$col; $i < $n; $i++) {
            array_push($posicionesOrdenadas, $aux[$i]);
        }
        $limite = count($aux) - count($posicionesOrdenadas);
        for ($i=$col; $i < $limite+$col; $i++) {
            array_push($posicionesOrdenadas, $aux[$i]);
        }
    }

    return $posicionesOrdenadas;
}

function ordenarConIndices($arregloParaOrdenar, $arregloIndices){
    $arregloOrdenado=array();
    $n = count($arregloIndices);
    for ($i=0; $i < $n; $i++) { 
        array_push($arregloOrdenado, $arregloParaOrdenar[$arregloIndices[$i]]);
    }
    return $arregloOrdenado;
}

function MCD($a, $b){
    if($a==0 or $b==0){
        return 0;
    }
    $aux;
    if ($a < 0) {
        $a=-$a;
    }
    if($b < 0){
        $b=-$b;
    }
    if($a<$b){
        $aux=$b;
        $b=$a;
        $a=$aux;
    }
    while($a % $b != 0){
        $aux=$a%$b;
        $a=$b;
        $b=$aux;
    }
    return $b;
}

function conseguirDivisores($arreglo){
    $arregloDivisores=array();
    for ($i=0; $i < count($arreglo); $i++) {
        $divisor=0;
        for ($j=0; $j < count($arreglo[$i]); $j++) { 
            if($divisor==0 and $arreglo[$i][$j]!=0){
                $divisor = $arreglo[$i][$j];
            }else{
                if($arreglo[$i][$j]!=0){
                    $divisor = MCD($divisor, $arreglo[$i][$j]);
                }
            }
        }
        if($divisor==0){
            array_push($arregloDivisores, 1);
        }else{
            array_push($arregloDivisores, $divisor);
        }
    }
    return $arregloDivisores;
}

function simplificarFilas($arreglo, $divisores){
    for ($i=0; $i < count($arreglo); $i++) { 
        if($divisores[$i]!=0){
            for ($j=0; $j < count($arreglo[$i]); $j++) { 
                $arreglo[$i][$j] = $arreglo[$i][$j]/$divisores[$i];
            }
        }
    }
    return $arreglo;
}

function restarFilasAbajo($arreglo, $m, $n, $col, $bandera){
    if($bandera!=2 and $bandera!=3){
        ?><p>|<br><?php
    }
    $multiplo1 = $arreglo[$col][$col];
    if($arreglo[$col][$col]!=0){
        for ($i=1+$col; $i < $m; $i++) { 
            $multiplo2 = -$arreglo[$i][$col];
            if($bandera!=2 and $bandera!=3){
                if ($multiplo1!=1 and $multiplo1!=-1) {
                    echo $multiplo1;
                }elseif($multiplo1==-1){
                    echo "-";
                }
                ?>F<sub><?php echo $i+1 ?></sub><?php
                if($multiplo2>=0){
                    echo "+";
                }else if ($multiplo2==-1){
                    echo "-";
                }
                if($multiplo2!=1 and $multiplo2!=-1){
                    echo $multiplo2;
                }
                ?>F<sub><?php echo $col+1 ?></sub> -> F<sub><?php echo $i+1 ?></sub><br><?php
            }
            if($bandera==0 or $bandera==3){
                $n=$n+1;
            }
            for ($j=0+$col; $j < $n; $j++) { 
                if(isset($arreglo[$i][$j])){
                    $arreglo[$i][$j] = $multiplo1*$arreglo[$i][$j] + $multiplo2*$arreglo[$col][$j];
                }
            }
        }
    }
    if($bandera!=2 and $bandera!=3){
        ?>↓</p><?php
    }
    return $arreglo;
}

function restarFilasArriba($arreglo, $m, $n, $col){
    $col = ($m-1)-$col;
    $multiplo1 = $arreglo[$col][$col];
    if($multiplo1!=0){
        ?><p>|<br><?php
        for ($i=$col-1; $i >= 0; $i--) { 
            $multiplo2 = -$arreglo[$i][$col];
            if ($multiplo1!=1 and $multiplo1!=-1) {
                echo $multiplo1;
            }elseif($multiplo1==-1){
                echo "-";
            }
            ?>F<sub><?php echo $i+1 ?></sub><?php
            if($multiplo2>=0){
                echo "+";
            }else if ($multiplo2==-1){
                echo "-";
            }
            if($multiplo2!=1 and $multiplo2!=-1){
                echo $multiplo2;
            }
            ?>F<sub><?php echo $col+1 ?></sub><br><?php
            for ($j=$n; $j >= 0; $j--) { 
                $arreglo[$i][$j] = $multiplo1*$arreglo[$i][$j] + $multiplo2*$arreglo[$col][$j];
            }
        }
        ?>↓</p><?php
    }
    return $arreglo;
}

function restarFilasArribaSI($arreglo, $m, $n, $col){
    $col = ($m-1)-$col;
    $multiplo1 = $arreglo[$col][$col];
    if($multiplo1!=0){
        for ($i=$col-1; $i >= 0; $i--) { 
            $multiplo2 = -$arreglo[$i][$col];
            for ($j=$n; $j >= 0; $j--) { 
                $arreglo[$i][$j] = $multiplo1*$arreglo[$i][$j] + $multiplo2*$arreglo[$col][$j];
            }
        }
    }
    return $arreglo;
}

function checarCeros($arreglo, $m, $n){
    $arregloSC = array(); // matriz sin [filas con solamente] ceros
    for ($i=0; $i < $m; $i++) { 
        if(isset(array_count_values($arreglo[$i])[0])){
            $valoresRepetidos = array_count_values($arreglo[$i])[0];
            if($valoresRepetidos != count($arreglo[$i])){
                array_push($arregloSC, $arreglo[$i]);
            }
        }else{
            array_push($arregloSC, $arreglo[$i]);
        }
    }

    //Revisamos si se quito algo
    if(count($arreglo)!=count($arregloSC)){
        ?><p>|<br>
        Quitando filas con solamente ceros<br>
        ↓</p>
        <?php
        $m = count($arregloSC);
        imprimir($arregloSC, $m, $n, 0);
    }


    return $arregloSC;
}

function imprimir($matriz, $m, $n, $bandera){
    ?><br>
    <table class="matriz w-50 text-center fs-3" align="center">
        <?php
        for ($i=0; $i < $m; $i++) { 
            ?><tr>
                <?php
                for ($j=0; $j < $n; $j++) {
                    ?><td class="elemento"><?php echo $matriz[$i][$j] ?></td><?php
                }
                if($bandera==0){
                    ?><td class="elemento">| <?php echo $matriz[$i][$j] ?></td><?php
                }
                ?>
            </tr><?php
        }
        ?>
    </table><br>
<?php 
} 

function imprimirCambio($indices){
    ?><p>|<br><?php
    for ($i=0; $i < count($indices); $i++) { 
        if ($indices[$i]!=$i) {
            ?>F<sub><?php echo $i+1 ?></sub> → F<sub><?php echo $indices[$i]+1 ?></sub><br><?php
        }
    }
    ?>↓</p><?php
}

function imprimirDivisores($divisores){
    ?><p>|<br><?php
    for ($i=0; $i < count($divisores); $i++) { 
        if ($divisores[$i]!=1) {
            ?>F<sub><?php echo $i+1 ?></sub>/<?php echo $divisores[$i] ?><br><?php
        }
    }
    ?>↓</p><?php
}

//Funcionalidad de actualizacion
function cuadrado($arreglo, $m){
    $respuesta = array();
    $aaux=array();
    $numero=0;
    for ($i=0; $i < $m; $i++) { 
        for ($j=0; $j < $m; $j++) { 
            for ($k=0; $k < $m; $k++) { 
                $numero += $arreglo[$i][$k]*$arreglo[$k][$j];
            }
            array_push($aaux, $numero);
            $numero = 0;
        }
        array_push($respuesta, $aaux);
        $aaux = array();
    }
    return $respuesta;
}

function checarIntercambio($arreglo, $col){
    $indice=$col;
    if($arreglo[$col][$col]==0){
        while ($arreglo[$indice][$col]==0){
            $indice++;
            if(!isset($arreglo[$indice][$col])){
                break;
            }
        };
    }
    return $indice;
}

function dividir($arreglo, $indice){
    $divisor=$arreglo[$indice][$indice];
    for ($i=0; $i < count($arreglo[$indice]); $i++) { 
        $arreglo[$indice][$i]=$arreglo[$indice][$i]/$divisor;
    }
    return $arreglo;
}

//funcionalidad del calculo de la matriz inversa
function determinante($matriz, $m){
    //Mismo algoritmo que en solucionMD, pero sin imprimir valores
    $coeficientes=array();
    $bandera=0;
    for ($i=0; $i < $m-1; $i++) { 
        $cambio = checarIntercambio($matriz, $i);
        if($cambio>=$m){
            return 0;
        }
        if($cambio!=$i){
            array_push($coeficientes, -1);

            $aaux = $matriz[$i];
            $matriz[$i] = $matriz[$cambio];
            $matriz[$cambio] = $aaux;
        }

        if($matriz[$i][$i]!=1){
            array_push($coeficientes, $matriz[$i][$i]);
            
            $matriz = dividir($matriz, $i);

        }
        
        $matriz = restarFilasAbajo($matriz, $m, $m, $i, 2);
    }
    $resultado = 1;
    for ($i=0; $i < $m; $i++) { 
        $resultado*=$matriz[$i][$i];
    }
    for ($i=0; $i < count($coeficientes); $i++) { 
        $resultado*=$coeficientes[$i];
    }

    return $resultado;
}

function conseguirM($arreglo, $m){
    $matrizM=array();
    $maaux=array();
    $arregloParaDeterminante=array();
    $aaux=array();
    $determinante=0;
    $mi=1;
    $mj=1;
    for ($i=0; $i < $m; $i++) { 
        for ($j=0; $j < $m; $j++) { 
            for ($k=0; $k < $m; $k++) { 
                if($i!=$k){
                    for ($l=0; $l < $m; $l++) { 
                        if($j!=$l){
                            array_push($aaux, $arreglo[$k][$l]);
                        }
                    }
                }
                if(count($aaux)!=0){
                    array_push($arregloParaDeterminante, $aaux);
                }

                $aaux=array();
            }
            $determinante = determinante($arregloParaDeterminante, count($arregloParaDeterminante));
            $mi=$i+1;
            $mj=$j+1;
            if(($mi*$mj)%2 == 0){
                array_push($maaux, $determinante);
            }else{
                array_push($maaux, -$determinante);
            }
            $arregloParaDeterminante=array();
        }
        array_push($matrizM, $maaux);
        $maaux=array();
    }
    return $matrizM;
}

function conseguirMT($arreglo, $m){
    $arregloT=array();
    $aaux=array();
    for ($i=0; $i < $m; $i++) { 
        for ($j=0; $j < $m; $j++) { 
            array_push($aaux, $arreglo[$j][$i]);
        }
        array_push($arregloT, $aaux);

        $aaux=array();
    }

    return $arregloT;
}

function inversa($arreglo, $m, $determinante){
    for ($i=0; $i < $m; $i++) { 
        for ($j=0; $j < $m; $j++) { 
            $arreglo[$i][$j]=$arreglo[$i][$j]/$determinante;
        }
    }
    return $arreglo;
}

//funcionalidad de combinaciones lineales (falta :c)
function imprimirG($matriz, $m, $n, $bandera, $variables){
    ?><br>
    <table class="matriz w-50 text-center fs-3" align="center">
        <?php
        for ($i=0; $i < $m; $i++) { 
            ?><tr>
                <?php
                for ($j=0; $j < $n; $j++) {
                    ?><td class="elemento"><?php echo $matriz[$i][$j] ?></td><?php
                }
                if($bandera==0){
                    ?><td class="elemento">| <?php 
                    for ($j=0; $j < $m; $j++) { 
                        if($variables[$i][$j]==1){
                            echo "+";
                        }elseif ($variables[$i][$j]==-1) {
                            echo "-";
                        }elseif ($variables[$i][$j]<0) {
                            echo $variables[$i][$j];
                        }elseif ($variables[$i][$j]>0) {
                            echo "+".$variables[$i][$j];
                        }
                        if($variables[$i][$j]!=0){
                            switch ($j) {
                                case 0:
                                    echo "x";
                                    break;
        
                                case 1:
                                    echo "y";
                                    break;
        
                                case 2:
                                    echo "z";
                                    break;
        
                                case 3:
                                    echo "w";
                                    break;
        
                                case 4:
                                    echo "v";
                                    break;
        
                                case 5:
                                    echo "u";
                                    break;
        
                                case 6:
                                    echo "t";
                                    break;
        
                                case 7:
                                    echo "s";
                                    break;
        
                                case 8:
                                    echo "r";
                                    break;
        
                                case 9:
                                    echo "q";
                                    break;
                            }
                        }
                    }
                    ?></td><?php
                }
                ?>
            </tr><?php
        }
        ?>
    </table><br>
<?php 
} 

function restarFilasAbajoG($arreglo, $m, $n, $col, $variables){
    for ($i=1+$col; $i < $m; $i++) { 
        $multiplo1 = $arreglo[$col][$col];
        $multiplo2 = -$arreglo[$i][$col];
        for ($j=0; $j < $m; $j++) { 
            $variables[$i][$j] = $multiplo1*$variables[$i][$j] + $multiplo2*$variables[$col][$j];
        }
    }
    return $variables;
}

function checarCerosG($arreglo, $m, $n, $variables){
    $arregloSC = array(); // matriz sin [filas con solamente] ceros
    for ($i=0; $i < $m; $i++) { 
        if(isset(array_count_values($arreglo[$i])[0]) && isset(array_count_values($variables[$i])[0])){
            $valoresRepetidos = array_count_values($arreglo[$i])[0];
            $valoresRepetidosV = array_count_values($variables[$i])[0];
            if($valoresRepetidos != count($arreglo[$i]) || $valoresRepetidosV != count($variables[$i])){
                array_push($arregloSC, $arreglo[$i]);
            }
        }else{
            array_push($arregloSC, $arreglo[$i]);
        }
    }

    //Revisamos si se quito algo
    if(count($arreglo)!=count($arregloSC)){
        ?><p>|<br>
        Quitando filas con solamente ceros<br>
        ↓</p>
        <?php
        $m = count($arregloSC);
        imprimirG($arregloSC, $m, $n, 0, $variables);
    }


    return $arregloSC;
}

function checarCerosV($arreglo, $m, $n, $variables){
    $arregloSCV = array(); // matriz sin [filas con solamente] ceros
    for ($i=0; $i < $m; $i++) { 
        if(isset(array_count_values($arreglo[$i])[0]) && isset(array_count_values($variables[$i])[0])){
            $valoresRepetidos = array_count_values($arreglo[$i])[0];
            $valoresRepetidosV = array_count_values($variables[$i])[0];
            if($valoresRepetidos != count($arreglo[$i]) || $valoresRepetidosV != count($variables[$i])){
                array_push($arregloSCV, $variables[$i]);
            }
        }else{
            array_push($arregloSCV, $variables[$i]);
        }
    }

    return $arregloSCV;
}
?>