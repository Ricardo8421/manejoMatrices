<?php
include "tesdos.php";

class punto{
    public $x;
    public $y;
    private $centro=NULL;

    public function __construct(int $x, int $y){
        $this->x=$x;
        $this->y=$y;
    }

    public function setCentro($centro){
        $this->centro=$centro;
    }

    public function getCentro(){
        return $this->centro;
    }

    public function getAngle(){
        return atan2($this->y-$this->centro->y, $this->x-$this->centro->x)+pi();
    }

    public function getDAC(){
        return sqrt(pow($this->x-$this->centro->x, 2)+pow($this->y-$this->centro->y, 2));
    }
}
// //C:\Users\sonic\Pictures\Screenshots\Screenshot (594).png
// $magia = new GmagickDraw("C:\Users\sonic\Pictures\Screenshots\Screenshot (594).png");

// $dibujo = new GmagicDraw();

// $dibujo->setFillColor("red");

$boolteado = false;

$puntos = array(
    new punto(300, 300), 
    new punto(300, 550), 
    new punto(1050, 550), 
    new punto(1050, 300)
);
$centroidelongo=new punto(0, 0);

for ($i=0; $i < count($puntos); $i++) { 
    $centroidelongo->x+=$puntos[$i]->x;
    $centroidelongo->y+=$puntos[$i]->y;
}
$centroidelongo->x/=(count($puntos));
$centroidelongo->y/=(count($puntos));

for ($i=0; $i < count($puntos); $i++) { 
    $puntos[$i]->setCentro($centroidelongo);
}

$organizar = "cmpBoolteado";

if(!$boolteado){
    $organizar=$organizar."nt";
}

var_dump($puntos);

usort($puntos, $organizar);

echo "<br>";
echo "<br>";
echo "<br>";
echo "<br>";
echo "<br>";
echo "<br>";
echo "<br>";
echo "<br>";
echo "<br>";
echo "<br>";
echo "<br>";
echo "<br>";
echo "<br>";
echo "<br>";
echo "<br>";
echo "<br>";
echo "<br>";
echo "<br>";
echo "<br>";
echo "<br>";
echo "<br>";
echo "<br>";
echo "<br>";
echo "<br>";
echo "<br>";
echo "<br>";
echo "<br>";
echo "<br>";
echo "<br>";
echo "<br>";
echo "<br>";
echo "<br>";
echo "<br>";
echo "<br>";
echo "<br>";
echo "<br>";
echo "<br>";
echo "<br>";
echo "<br>";
echo "<br>";
echo "<br>";
echo "<br>";
echo "<br>";
echo "<br>";
echo "<br>";
echo "<br>";
echo "<br>";
echo "<br>";
echo "<br>";
echo "<br>";
echo "<br>";
echo "<br>";
echo "<br>";
echo "<br>";
echo "<br>";
echo "<br>";
echo "<br>";
echo "<br>";
echo "<br>";
echo "<br>";
echo "<br>";
echo "<br>";
echo "<br>";
echo "<br>";
echo "<br>";
echo "<br>";
echo "<br>";
echo "<br>";
echo "<br>";
echo "<br>";
echo "<br>";
echo "<br>";
echo "<br>";
echo "<br>";
echo "<br>";
echo "<br>";
echo "<br>";
echo "<br>";
echo "<br>";
echo "<br>";
echo "<br>";
echo "<br>";
echo "<br>";
echo "<br>";
echo "<br>";
echo "<br>";
echo "<br>";
echo "<br>";
echo "<br>";
echo "<br>";
echo "<br>";
echo "<br>";
echo "<br>";
echo "<br>";
echo "<br>";
echo "<br>";
echo "<br>";
echo "<br>";

var_dump($puntos);

usort($puntos, "cmp");
echo "<br>";
echo "<br>";
echo "<br>";
echo "<br>";
echo "<br>";
echo "<br>";
echo "<br>";

var_dump($puntos);
echo "<br>";
echo "<br>";
echo "<br>";
echo "<br>";
echo "<br>";
echo "<br>";
echo "<br>";

$puntosPaImprimicionazilacizacion=array();

for ($i=0; $i < count($puntos); $i++) { 
    array_push($puntosPaImprimicionazilacizacion, $puntos[$i]->x);
    array_push($puntosPaImprimicionazilacizacion, $puntos[$i]->y);
}
$datos = dibujoh($puntosPaImprimicionazilacizacion);
// phpinfo();

function cmpBoolteadont($a, $b){
    return $a->getDAC()-$b->getDAC();
}

function cmpBoolteado($a, $b){
    return cmpBoolteadont($b, $a);

}

function cmp($a, $b){
    return $a->getAngle()-$b->getAngle();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tardes las buenas</title>
</head>
<body>
    funciona c:
    <?php echo '<img src="data:image/png;base64, '.base64_encode($datos).'" alt="" height=300 width=300>'?>
</body>
</html>