<?php
function dibujoh($puntos){
    $imagen = imagecreatetruecolor(1000, 1000);

    $bgColor = imagecolorallocate($imagen, 255, 0, 0);

    imagefill($imagen, 0, 0, $bgColor);

    $coloh_imageh=imagecolorallocate($imagen, 255, 255, 255);

    imagepolygon($imagen, $puntos, count($puntos)/2, $coloh_imageh);

    ob_start();

    imagepng($imagen);

    $datos = ob_get_clean();

    imagedestroy($imagen);
    
    return $datos;
}
?>