<?php
include 'funcionalidad.php';
const REFLEXION=0;
const EXPANSION=1;
const CORTE=2;
const ROTACION=3;
const X=0;
const Y=1;

// ini_set('display_errors', 0);
// error_reporting(E_ERROR | E_WARNING | E_PARSE);

$puntos=array();
$puntosB=array();
$cdp =floatval($_POST["cdp"]); //cantidad de puntos
$cdt =floatval($_POST["cdt"])+1; //cantidad de transformaciones

$paux; //Punto auxiliar para agregar al arreglo
$pauxB; //Punto auxiliar para agregar al arreglo de respaldo

for ($i=0; $i < $cdp; $i++) { 
    $paux=new punto(floatval($_POST["1-".$i]), floatval($_POST["2-".$i]));
    $pauxB=new punto(floatval($_POST["1-".$i]), floatval($_POST["2-".$i]));
    array_push($puntos, $paux);
    array_push($puntosB, $pauxB);
}

$ttransformacion=array();
$vtransformacion=array();
$aaux=array();
for ($i=0; $i < $cdt; $i++) { 
    if(isset($_POST["t-".$i])){
        array_push($ttransformacion, intval($_POST["t-".$i]));
        array_push($aaux, intval($_POST["e-".$i]));
        array_push($aaux, floatval($_POST["v-".$i]));
        array_push($vtransformacion, $aaux);
        $aaux=array();
    }else{
        $cdt--;
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <script src="js/insersion.js"></script>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Respuesta con calidad</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
        <link href="/css/estilo.css" rel="stylesheet">
    </head>
    <!--:0 comentarios en html owo-->
    <body class="d-flex h-100 text-center text-white bg-dark row w-100">
        <div class="cover-container d-flex w-75 p-3 mx-auto flex-column fs-4">
            <p>Solución:</p>
            <?php
            // var_dump($vtransformacion);
            // var_dump($puntos);
            //Base para graficar
            // echo "<br>";
            $datos = dibujoh($puntos);
            echo '<img src="data:image/png;base64, '.base64_encode($datos).'" alt="Grafica 1" style="display: block; margin-left:auto; margin-right:auto;" width=60%>';
            
            for ($i=0; $i < $cdt; $i++) { 
                switch ($ttransformacion[$i]) {
                    case REFLEXION:
                        for ($j=0; $j < $cdp; $j++) { 
                            if($vtransformacion[$i][0]==X){
                                $puntos[$j]->y*=(-1);
                            }else{
                                $puntos[$j]->x*=(-1);
                            }
                        }
                        break;

                    case EXPANSION:
                        for ($j=0; $j < $cdp; $j++) { 
                            if($vtransformacion[$i][0]==X){
                                $puntos[$j]->x*=$vtransformacion[$i][1];
                            }else{
                                $puntos[$j]->y*=$vtransformacion[$i][1];
                            }
                        }
                        break;

                    case CORTE:
                        for ($j=0; $j < $cdp; $j++) { 
                            if($vtransformacion[$i][0]==X){
                                $puntos[$j]->x+=($vtransformacion[$i][1]*$puntos[$j]->y);
                            }else{
                                $puntos[$j]->y+=($vtransformacion[$i][1]*$puntos[$j]->x);
                            }
                        }
                        break;

                    case ROTACION:
                        for ($j=0; $j < $cdp; $j++) { 
                            $xb=$puntos[$j]->x;
                            $yb=$puntos[$j]->y;
                            $puntos[$j]->x = ($xb*cos(deg2rad($vtransformacion[$i][1])))+($yb*sin(deg2rad($vtransformacion[$i][1])));
                            $puntos[$j]->y = ($xb*(-sin(deg2rad($vtransformacion[$i][1]))))+($yb*cos(deg2rad($vtransformacion[$i][1])));
                        }
                        break;
                    
                    default:
                        break;
                }

                // var_dump($puntos);
                echo "<br><br>↓<br><br>";
                $datos = dibujoh($puntos);
                echo '<img src="data:image/png;base64, '.base64_encode($datos).'" alt="Grafica 1" style="display: block; margin-left:auto; margin-right:auto;" width=60%>';
            }
            ?>
            <br><br><br>
            <form name="poner" action="solucionG.php" method="post">
                <?php
                for ($i=0; $i < $cdp; $i++) { 
                    ?>
                    <input type="hidden" name="1-<?php echo $i ?>" value="<?php echo $puntosB[$i]->x ?>">
                    <input type="hidden" name="2-<?php echo $i ?>" value="<?php echo $puntosB[$i]->y ?>">
                    <?php
                }

                for ($i=0; $i < $cdt; $i++) { 
                    ?>
                    <input type="hidden" name="t-<?php echo $i ?>" value="<?php echo $ttransformacion[$i]?>">
                    <input type="hidden" name="e-<?php echo $i ?>" value="<?php echo $vtransformacion[$i][0]?>">
                    <input type="hidden" name="v-<?php echo $i ?>" value="<?php echo $vtransformacion[$i][1]?>">
                    <?php
                }

                //Ok, te falta:
                //Pasar las transformaciones lineales a para una siguiente instruccion
                //realizar las transformaciones lineales
                //Figuras predeterminadas
                ?>
                <input type="hidden" name="cdp" value=<?php echo $cdp ?>>
                <input type="hidden" name="cdt" value=<?php echo $cdt ?>>
                <h2>Aplicar la siguiente transformacion lineal:</h2>
                <select name="transformacion" class="form-select mx-auto" style='width: 15%!important;' align="center">
                    <option value="0">Reflexión</option>
                    <option value="1">Expansión</option>
                    <option value="2">Corte</option>
                    <option value="3">Rotación</option>
                </select>
                <br><br>
                <input type="button" value="Generar entradas" onclick="generarTransformacion()" class="btn btn-lg btn-secondary fw-bold border-white bg-white text-black">
                <br><br>
                <div id="identificador"></div>
            </form>
        </div>
    </body>
</html>