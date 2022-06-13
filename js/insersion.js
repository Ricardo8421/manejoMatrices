function generar(){
    let m = document.forms["poner"]["m"].value;
    let n = document.forms["poner"]["n"].value;

    //hacer la cadena para insertar el formulario para poder dar la matriz
    let formulario = "<form action='solucion.php' method='post'>";
    formulario += "<input type='hidden' name='m' value='"+m+"'>";
    formulario += "<input type='hidden' name='n' value='"+n+"'>";
    
    for (let i = 1; i <= m; i++) {
        for (let j = 1; j <= n; j++) {
            if (j!=1) {
                formulario += " + ";
            }
            formulario += "<input type='number' name='x"+i+"-"+j+"' class='me-2 rounded' style='width: 5%!important;'> x<sub>"+j+"</sub>";
        }
        
        formulario += " = <input type='number' name='b"+i+"' class='me-2 rounded' style='width: 5%!important;'>";
        formulario += "<br><br>";
    }
    
    formulario += "<input type='submit' value='Resolver' class='btn btn-lg btn-secondary fw-bold border-white bg-white text-black'>";
    formulario += "</form>";
    
    //insertar codigo html en js
    //reemplaza lo que ya tiene, asi que solo se necesita poner la cadena completa
    document.getElementById('identificador').innerHTML = formulario;
}

function generarMatriz(){
    let m = document.forms["poner"]["m"].value;
    let op = document.forms["poner"]["operacion"].value;
    
    let formulario = "";
    if(op=="cuadrado"){
        formulario = "<form action='solucionMC.php' method='post'>";
    }else if(op=="determinante"){
        formulario = "<form action='solucionMD.php' method='post'>";
    }
    else{
        formulario = "Hubo un error, vuelva a intentarlo mas tarde"
        document.getElementById('identificador').innerHTML = formulario;
        return;
    }
    
    formulario += "<input type='hidden' name='m' value='"+m+"'>";
    
    for (let i = 0; i < m; i++) {
        for (let j = 0; j < m; j++) {
            formulario += "<input type='number' name='"+i+"-"+j+"' class='me-2 rounded m-3' style='width: 5%!important;'>";
        }
        formulario += "<br><br>";
    }
    
    //Agregamos botones para hacer operaciones, en este caso necestiamos A^2, |A|, |A^a| (este una vez que se calcule) y A^-1
    formulario += "<input type='submit' value='Resolver' class='btn btn-lg btn-secondary fw-bold border-white bg-white text-black m-3'>";
    formulario += "</form>";
    
    document.getElementById('identificador').innerHTML = formulario;
}

function generarCombinacion(){
    let n = document.forms["poner"]["n"].value;
    let m = document.forms["poner"]["can"].value;
    
    let formulario = "";
    formulario = "<form action='solucionCL.php' method='post'>";
    
    formulario += "<input type='hidden' name='n' value='"+n+"'>";
    formulario += "<input type='hidden' name='can' value='"+m+"'>Vector u = ";
    for (let i = 0; i < n; i++) {
        formulario += "<input type='number' name='v"+i+"' class='me-2 rounded m-3' style='width: 5%!important;'>";
    }
    formulario += "<br><br>";
    formulario += "Combinación lineal:";
    formulario += "<br><br>";
    formulario += "<";
    for (let i = 0; i < m; i++) {
        formulario += "(";
        for (let j = 0; j < n; j++) {
            formulario += "<input type='number' name='"+i+"-"+j+"' class='me-2 rounded m-3' style='width: 5%!important;'>";
            if(j!=n-1){
                formulario += ",";
            }
        }
        formulario += ")";
        if(i!=n-1){
        }
        formulario += "<br><br>";
    }
    formulario += ">";
    formulario += "<br><br>";
    
    //Agregamos botones para hacer operaciones, en este caso necestiamos A^2, |A|, |A^a| (este una vez que se calcule) y A^-1
    formulario += "<input type='submit' value='Verificar' class='btn btn-lg btn-secondary fw-bold border-white bg-white text-black m-3'>";
    formulario += "</form>";

    document.getElementById('identificador').innerHTML = formulario;
}

function generarNI(){
    let m = document.forms["poner"]["m"].value;
    let n = document.forms["poner"]["n"].value;

    //hacer la cadena para insertar el formulario para poder dar la matriz
    let formulario = "<form action='solucionNI.php' method='post'>";
    formulario += "<input type='hidden' name='m' value='"+m+"'>";
    formulario += "<input type='hidden' name='n' value='"+n+"'>";
    
    for (let i = 1; i <= m; i++) {
        for (let j = 1; j <= n; j++) {
            formulario += "<input type='number' name='"+i+"-"+j+"' class='me-2 rounded m-3' style='width: 5%!important;'>";
        }
        
        formulario += "<br><br>";
    }
    
    formulario += "<input type='submit' value='Encontrar' class='btn btn-lg btn-secondary fw-bold border-white bg-white text-black'>";
    formulario += "</form>";
    
    //insertar codigo html en js
    //reemplaza lo que ya tiene, asi que solo se necesita poner la cadena completa
    document.getElementById('identificador').innerHTML = formulario;
}

function generarCambioB(){
    let m = document.forms["poner"]["n"].value;
    
    let formulario = "";
    formulario = "<form action='solucionCB.php' method='post'>";
    
    formulario += "<input type='hidden' name='n' value='"+m+"'>";
    
    formulario += "<h2>&beta;1=<br></h2>{";
    for (let i = 0; i < m; i++) {
        formulario += "(";
        for (let j = 0; j < m; j++) {
            formulario += "<input type='number' name='1-"+i+"-"+j+"' class='me-2 rounded m-3' style='width: 5%!important;'>";
            if(j!=m-1){
                formulario += ", ";
            }
        }
        formulario += ")";
        if(i!=m-1){
            formulario += ", ";
            formulario += "<br><br>";
        }
    }
    formulario += "}<br><br>";
    
    formulario += "<h2>&beta;2=<br></h2>{";
    for (let i = 0; i < m; i++) {
        formulario += "(";
        for (let j = 0; j < m; j++) {
            formulario += "<input type='number' name='2-"+i+"-"+j+"' class='me-2 rounded m-3' style='width: 5%!important;'>";
            if(j!=m-1){
                formulario += ", ";
            }
        }
        formulario += ")";
        if(i!=m-1){
            formulario += ", ";
            formulario += "<br><br>";
        }
    }
    formulario += "}<br><br>";
    
    formulario += "<h2>Vector (en base canonica):<br></h2>(";
    for (let i = 0; i < m; i++) {
        formulario += "<input type='number' name='v-"+i+"' class='me-2 rounded m-3' style='width: 5%!important;'>";
        if(i!=m-1){
            formulario += ", ";
        }
    }
    formulario += ")<br><br>";

    //Agregamos botones para hacer operaciones, en este caso necestiamos A^2, |A|, |A^a| (este una vez que se calcule) y A^-1
    formulario += "<input type='submit' value='Resolver' class='btn btn-lg btn-secondary fw-bold border-white bg-white text-black m-3'>";
    formulario += "</form>";
    
    document.getElementById('identificador').innerHTML = formulario;
}

// function generarPuntos(){
//     let m = document.forms["poner"]["cdp"].value;
//     let formulario = "";
//     formulario = "<form action='solucionG.php' method='post'>";
    
//     formulario += "<input type='hidden' name='cdp' value='"+m+"'><br>";
//     formulario += "<input type='hidden' name='cdt' value='0'><br>";
    
//     formulario += "<h2>Puntos:<br><br></h2>";
//     for (let i = 0; i < m; i++) {
//         formulario += "(<input type='number' name='1-"+i+"' class='me-2 rounded m-3' style='width: 5%!important;'>, <input type='number' name='2-"+i+"' class='me-2 rounded m-3' style='width: 5%!important;'>)";
//         if(i!=m-1){
//             formulario += "<br><br>";
//         }
//     }
//     formulario += "<br><br>";
    
//     formulario += "<input type='submit' value='Graficar' class='btn btn-lg btn-secondary fw-bold border-white bg-white text-black m-3'>";
//     formulario += "</form>";

//     document.getElementById('identificador').innerHTML = formulario;
// }

function agregarPunto(){
    let cdp = document.forms["puntos"]["cdp"].value;
    let formulario = "";
    let x;
    let y;
    for (let i = 3; i < cdp; i++) {
        try{
            x = document.forms["puntos"]["1-"+i].value;
        }catch(e){
            x="";
        }
        try{
            y = document.forms["puntos"]["2-"+i].value;
        }catch(e){
            y="";
        }
        formulario+="(<input type='number' name='1-"+i+"' class='me-2 rounded m-3' style='width: 5%!important;' value='"+x+"'>, ";
        formulario+="<input type='number' name='2-"+i+"' class='me-2 rounded m-3' style='width: 5%!important;' value='"+y+"'>)<br><br>";
    }
    cdp++;
    if(cdp<=10){
        formulario+="(<input type='number' name='1-"+(cdp-1)+"' class='me-2 rounded m-3' style='width: 5%!important;'>, ";
        formulario+="<input type='number' name='2-"+(cdp-1)+"' class='me-2 rounded m-3' style='width: 5%!important;'>)<br><br>";
    }else{
        cdp--;
    }
    formulario+='<input type="hidden" name="cdp" value="'+cdp+'">';
    if(cdp<10){
        formulario+='<input type="button" value="Agregar punto" onclick="agregarPunto()" class="btn btn-lg btn-secondary fw-bold border-white bg-white text-black">';
    }
    formulario+='<input type="button" value="Quitar punto" onclick="quitarPunto()" class="btn btn-lg btn-secondary fw-bold border-white bg-white text-black m-1">';
    formulario+='<br>';
    formulario+='<input type="button" value="Triángulo equilatero" onclick="triangulo()" class="btn btn-lg btn-secondary fw-bold border-white bg-white text-black m-1">';
    formulario+='<input type="button" value="Cuadrado" onclick="cuadrado()" class="btn btn-lg btn-secondary fw-bold border-white bg-white text-black m-1">';
    formulario+='<input type="button" value="Pentagono regular" onclick="pentagono()" class="btn btn-lg btn-secondary fw-bold border-white bg-white text-black m-1">';
    formulario+='<input type="button" value="Estrella" onclick="estrella()" class="btn btn-lg btn-secondary fw-bold border-white bg-white text-black m-1">';
    formulario+='<input type="button" value="Silueta de gato" onclick="gato()" class="btn btn-lg btn-secondary fw-bold border-white bg-white text-black m-1">';
    formulario+='<br>';
    formulario+='<input type="submit" value="Graficar" class="btn btn-lg btn-secondary fw-bold border-white bg-white text-black m-1">';

    document.getElementById('identificador').innerHTML = formulario;
}

function quitarPunto(){
    let cdp = document.forms["puntos"]["cdp"].value;
    let formulario = "";
    let x;
    let y;
    cdp--;
    if(cdp<3){
        cdp=3;
    }
    for (let i = 3; i < cdp; i++) {
        try{
            x = document.forms["puntos"]["1-"+i].value;
        }catch(e){
            x="";
        }
        try{
            y = document.forms["puntos"]["2-"+i].value;
        }catch(e){
            y="";
        }
        formulario+="(<input type='number' name='1-"+i+"' class='me-2 rounded m-3' style='width: 5%!important;' value='"+x+"'>, ";
        formulario+="<input type='number' name='2-"+i+"' class='me-2 rounded m-3' style='width: 5%!important;' value='"+y+"'>)<br><br>";
    }
    formulario+='<input type="hidden" name="cdp" value="'+cdp+'">';
    formulario+='<input type="button" value="Agregar punto" onclick="agregarPunto()" class="btn btn-lg btn-secondary fw-bold border-white bg-white text-black">';
    if(cdp>3){
        formulario+='<input type="button" value="Quitar punto" onclick="quitarPunto()" class="btn btn-lg btn-secondary fw-bold border-white bg-white text-black m-1">';
    }
    formulario+='<br>';
    formulario+='<input type="button" value="Triángulo equilatero" onclick="triangulo()" class="btn btn-lg btn-secondary fw-bold border-white bg-white text-black m-1">';
    formulario+='<input type="button" value="Cuadrado" onclick="cuadrado()" class="btn btn-lg btn-secondary fw-bold border-white bg-white text-black m-1">';
    formulario+='<input type="button" value="Pentagono regular" onclick="pentagono()" class="btn btn-lg btn-secondary fw-bold border-white bg-white text-black m-1">';
    formulario+='<input type="button" value="Estrella" onclick="estrella()" class="btn btn-lg btn-secondary fw-bold border-white bg-white text-black m-1">';
    formulario+='<input type="button" value="Silueta de gato" onclick="gato()" class="btn btn-lg btn-secondary fw-bold border-white bg-white text-black m-1">';
    formulario+='<br>';
    formulario+='<input type="submit" value="Graficar" class="btn btn-lg btn-secondary fw-bold border-white bg-white text-black m-1">';
    
    document.getElementById('identificador').innerHTML = formulario;
}

function triangulo(){
    document.forms["puntos"]["1-0"].value=1;
    document.forms["puntos"]["2-0"].value=-1;
    document.forms["puntos"]["1-1"].value=-1;
    document.forms["puntos"]["2-1"].value=-1;
    document.forms["puntos"]["1-2"].value=0;
    document.forms["puntos"]["2-2"].value=2;
    let formulario='<input type="hidden" name="cdp" value="3">';
    formulario+='<input type="button" value="Agregar punto" onclick="agregarPunto()" class="btn btn-lg btn-secondary fw-bold border-white bg-white text-black">';
    formulario+='<br>';
    formulario+='<input type="button" value="Triángulo equilatero" onclick="triangulo()" class="btn btn-lg btn-secondary fw-bold border-white bg-white text-black m-1">';
    formulario+='<input type="button" value="Cuadrado" onclick="cuadrado()" class="btn btn-lg btn-secondary fw-bold border-white bg-white text-black m-1">';
    formulario+='<input type="button" value="Pentagono regular" onclick="pentagono()" class="btn btn-lg btn-secondary fw-bold border-white bg-white text-black m-1">';
    formulario+='<input type="button" value="Estrella" onclick="estrella()" class="btn btn-lg btn-secondary fw-bold border-white bg-white text-black m-1">';
    formulario+='<input type="button" value="Silueta de gato" onclick="gato()" class="btn btn-lg btn-secondary fw-bold border-white bg-white text-black m-1">';
    formulario+='<br>';
    formulario+='<input type="submit" value="Graficar" class="btn btn-lg btn-secondary fw-bold border-white bg-white text-black m-1">';

    document.getElementById('identificador').innerHTML = formulario;
}

function cuadrado(){
    document.forms["puntos"]["1-0"].value=1;
    document.forms["puntos"]["2-0"].value=1;
    document.forms["puntos"]["1-1"].value=1;
    document.forms["puntos"]["2-1"].value=-1;
    document.forms["puntos"]["1-2"].value=-1;
    document.forms["puntos"]["2-2"].value=1;
    let formulario="(<input type='number' name='1-3' class='me-2 rounded m-3' style='width: 5%!important;' value='-1'>, ";
    formulario+="<input type='number' name='2-3' class='me-2 rounded m-3' style='width: 5%!important;' value='-1'>)";
    formulario+="<br><br>";
    formulario+='<input type="hidden" name="cdp" value="4">';
    formulario+='<input type="button" value="Agregar punto" onclick="agregarPunto()" class="btn btn-lg btn-secondary fw-bold border-white bg-white text-black">';
    formulario+='<input type="button" value="Quitar punto" onclick="quitarPunto()" class="btn btn-lg btn-secondary fw-bold border-white bg-white text-black m-1">';
    formulario+='<br>';
    formulario+='<input type="button" value="Triángulo equilatero" onclick="triangulo()" class="btn btn-lg btn-secondary fw-bold border-white bg-white text-black m-1">';
    formulario+='<input type="button" value="Cuadrado" onclick="cuadrado()" class="btn btn-lg btn-secondary fw-bold border-white bg-white text-black m-1">';
    formulario+='<input type="button" value="Pentagono regular" onclick="pentagono()" class="btn btn-lg btn-secondary fw-bold border-white bg-white text-black m-1">';
    formulario+='<input type="button" value="Estrella" onclick="estrella()" class="btn btn-lg btn-secondary fw-bold border-white bg-white text-black m-1">';
    formulario+='<input type="button" value="Silueta de gato" onclick="gato()" class="btn btn-lg btn-secondary fw-bold border-white bg-white text-black m-1">';
    formulario+='<br>';
    formulario+='<input type="submit" value="Graficar" class="btn btn-lg btn-secondary fw-bold border-white bg-white text-black m-1">';
    
    document.getElementById('identificador').innerHTML = formulario;
}

function pentagono(){
    document.forms["puntos"]["1-0"].value=0;
    document.forms["puntos"]["2-0"].value=4;
    document.forms["puntos"]["1-1"].value=4;
    document.forms["puntos"]["2-1"].value=1;
    document.forms["puntos"]["1-2"].value=2;
    document.forms["puntos"]["2-2"].value=-3;
    let formulario="(<input type='number' name='1-3' class='me-2 rounded m-3' style='width: 5%!important;' value='-2'>, ";
    formulario+="<input type='number' name='2-3' class='me-2 rounded m-3' style='width: 5%!important;' value='-3'>)";
    formulario+="<br><br>";
    formulario+="(<input type='number' name='1-4' class='me-2 rounded m-3' style='width: 5%!important;' value='-4'>, ";
    formulario+="<input type='number' name='2-4' class='me-2 rounded m-3' style='width: 5%!important;' value='1'>)";
    formulario+="<br><br>";
    formulario+='<input type="hidden" name="cdp" value="5">';
    formulario+='<input type="button" value="Agregar punto" onclick="agregarPunto()" class="btn btn-lg btn-secondary fw-bold border-white bg-white text-black">';
    formulario+='<input type="button" value="Quitar punto" onclick="quitarPunto()" class="btn btn-lg btn-secondary fw-bold border-white bg-white text-black m-1">';
    formulario+='<br>';
    formulario+='<input type="button" value="Triángulo equilatero" onclick="triangulo()" class="btn btn-lg btn-secondary fw-bold border-white bg-white text-black m-1">';
    formulario+='<input type="button" value="Cuadrado" onclick="cuadrado()" class="btn btn-lg btn-secondary fw-bold border-white bg-white text-black m-1">';
    formulario+='<input type="button" value="Pentagono regular" onclick="pentagono()" class="btn btn-lg btn-secondary fw-bold border-white bg-white text-black m-1">';
    formulario+='<input type="button" value="Estrella" onclick="estrella()" class="btn btn-lg btn-secondary fw-bold border-white bg-white text-black m-1">';
    formulario+='<input type="button" value="Silueta de gato" onclick="gato()" class="btn btn-lg btn-secondary fw-bold border-white bg-white text-black m-1">';
    formulario+='<br>';
    formulario+='<input type="submit" value="Graficar" class="btn btn-lg btn-secondary fw-bold border-white bg-white text-black m-1">';
    
    document.getElementById('identificador').innerHTML = formulario;
}

function estrella(){
    document.forms["puntos"]["1-0"].value=0;
    document.forms["puntos"]["2-0"].value=16;
    document.forms["puntos"]["1-1"].value=15;
    document.forms["puntos"]["2-1"].value=3;
    document.forms["puntos"]["1-2"].value=8;
    document.forms["puntos"]["2-2"].value=-12;
    let formulario="(<input type='number' name='1-3' class='me-2 rounded m-3' style='width: 5%!important;' value='-8'>, ";
    formulario+="<input type='number' name='2-3' class='me-2 rounded m-3' style='width: 5%!important;' value='-12'>)";
    formulario+="<br><br>";
    formulario+="(<input type='number' name='1-4' class='me-2 rounded m-3' style='width: 5%!important;' value='-15'>, ";
    formulario+="<input type='number' name='2-4' class='me-2 rounded m-3' style='width: 5%!important;' value='3'>)";
    formulario+="<br><br>";

    formulario+="(<input type='number' name='1-5' class='me-2 rounded m-3' style='width: 5%!important;' value='5'>, ";
    formulario+="<input type='number' name='2-5' class='me-2 rounded m-3' style='width: 5%!important;' value='6'>)";
    formulario+="<br><br>";
    formulario+="(<input type='number' name='1-6' class='me-2 rounded m-3' style='width: 5%!important;' value='-5'>, ";
    formulario+="<input type='number' name='2-6' class='me-2 rounded m-3' style='width: 5%!important;' value='6'>)";
    formulario+="<br><br>";
    formulario+="(<input type='number' name='1-7' class='me-2 rounded m-3' style='width: 5%!important;' value='-7'>, ";
    formulario+="<input type='number' name='2-7' class='me-2 rounded m-3' style='width: 5%!important;' value='-2'>)";
    formulario+="<br><br>";
    formulario+="(<input type='number' name='1-8' class='me-2 rounded m-3' style='width: 5%!important;' value='7'>, ";
    formulario+="<input type='number' name='2-8' class='me-2 rounded m-3' style='width: 5%!important;' value='-2'>)";
    formulario+="<br><br>";
    formulario+="(<input type='number' name='1-9' class='me-2 rounded m-3' style='width: 5%!important;' value='0'>, ";
    formulario+="<input type='number' name='2-9' class='me-2 rounded m-3' style='width: 5%!important;' value='-6'>)";
    formulario+="<br><br>";

    formulario+='<input type="hidden" name="cdp" value="10">';
    formulario+='<input type="button" value="Quitar punto" onclick="quitarPunto()" class="btn btn-lg btn-secondary fw-bold border-white bg-white text-black m-1">';
    formulario+='<br>';
    formulario+='<input type="button" value="Triángulo equilatero" onclick="triangulo()" class="btn btn-lg btn-secondary fw-bold border-white bg-white text-black m-1">';
    formulario+='<input type="button" value="Cuadrado" onclick="cuadrado()" class="btn btn-lg btn-secondary fw-bold border-white bg-white text-black m-1">';
    formulario+='<input type="button" value="Pentagono regular" onclick="pentagono()" class="btn btn-lg btn-secondary fw-bold border-white bg-white text-black m-1">';
    formulario+='<input type="button" value="Estrella" onclick="estrella()" class="btn btn-lg btn-secondary fw-bold border-white bg-white text-black m-1">';
    formulario+='<input type="button" value="Silueta de gato" onclick="gato()" class="btn btn-lg btn-secondary fw-bold border-white bg-white text-black m-1">';
    formulario+='<br>';
    formulario+='<input type="submit" value="Graficar" class="btn btn-lg btn-secondary fw-bold border-white bg-white text-black m-1">';
    
    document.getElementById('identificador').innerHTML = formulario;
}

function gato(){
    document.forms["puntos"]["1-0"].value=-4;
    document.forms["puntos"]["2-0"].value=4;
    document.forms["puntos"]["1-1"].value=3;
    document.forms["puntos"]["2-1"].value=4;
    document.forms["puntos"]["1-2"].value=0;
    document.forms["puntos"]["2-2"].value=-3;
    let formulario="(<input type='number' name='1-3' class='me-2 rounded m-3' style='width: 5%!important;' value='-9'>, ";
    formulario+="<input type='number' name='2-3' class='me-2 rounded m-3' style='width: 5%!important;' value='0'>)";
    formulario+="<br><br>";
    formulario+="(<input type='number' name='1-4' class='me-2 rounded m-3' style='width: 5%!important;' value='-6'>, ";
    formulario+="<input type='number' name='2-4' class='me-2 rounded m-3' style='width: 5%!important;' value='2'>)";
    formulario+="<br><br>";

    formulario+="(<input type='number' name='1-5' class='me-2 rounded m-3' style='width: 5%!important;' value='-2'>, ";
    formulario+="<input type='number' name='2-5' class='me-2 rounded m-3' style='width: 5%!important;' value='3'>)";
    formulario+="<br><br>";
    formulario+="(<input type='number' name='1-6' class='me-2 rounded m-3' style='width: 5%!important;' value='1'>, ";
    formulario+="<input type='number' name='2-6' class='me-2 rounded m-3' style='width: 5%!important;' value='3'>)";
    formulario+="<br><br>";
    formulario+="(<input type='number' name='1-7' class='me-2 rounded m-3' style='width: 5%!important;' value='5'>, ";
    formulario+="<input type='number' name='2-7' class='me-2 rounded m-3' style='width: 5%!important;' value='2'>)";
    formulario+="<br><br>";
    formulario+="(<input type='number' name='1-8' class='me-2 rounded m-3' style='width: 5%!important;' value='8'>, ";
    formulario+="<input type='number' name='2-8' class='me-2 rounded m-3' style='width: 5%!important;' value='0'>)";
    formulario+="<br><br>";

    formulario+='<input type="hidden" name="cdp" value="9">';
    formulario+='<input type="button" value="Agregar punto" onclick="agregarPunto()" class="btn btn-lg btn-secondary fw-bold border-white bg-white text-black">';
    formulario+='<input type="button" value="Quitar punto" onclick="quitarPunto()" class="btn btn-lg btn-secondary fw-bold border-white bg-white text-black m-1">';
    formulario+='<br>';
    formulario+='<input type="button" value="Triángulo equilatero" onclick="triangulo()" class="btn btn-lg btn-secondary fw-bold border-white bg-white text-black m-1">';
    formulario+='<input type="button" value="Cuadrado" onclick="cuadrado()" class="btn btn-lg btn-secondary fw-bold border-white bg-white text-black m-1">';
    formulario+='<input type="button" value="Pentagono regular" onclick="pentagono()" class="btn btn-lg btn-secondary fw-bold border-white bg-white text-black m-1">';
    formulario+='<input type="button" value="Estrella" onclick="estrella()" class="btn btn-lg btn-secondary fw-bold border-white bg-white text-black m-1">';
    formulario+='<input type="button" value="Silueta de gato" onclick="gato()" class="btn btn-lg btn-secondary fw-bold border-white bg-white text-black m-1">';
    formulario+='<br>';
    formulario+='<input type="submit" value="Graficar" class="btn btn-lg btn-secondary fw-bold border-white bg-white text-black m-1">';
    
    document.getElementById('identificador').innerHTML = formulario;
}

function generarTransformacion(){
    let op = document.forms["poner"]["transformacion"].value;
    let cdt = document.forms["poner"]["cdt"].value;
    let formulario = '<input type="hidden" name="t-'+cdt+'" value="'+op+'">';

    switch (op) {
        case '0':
            formulario += 'Respecto al eje:';
            formulario += '<select name="e-'+cdt+'" class="form-select mx-auto" style="width: 15%!important;" align="center">';
            formulario += '<option value="0">x</option>';
            formulario += '<option value="1">y</option>';
            formulario += '</select>';
            formulario += '<input type="hidden" name="v-'+cdt+'" value="0">';
            break;

        case '1':
            formulario += 'Respecto al eje:';
            formulario += '<select name="e-'+cdt+'" class="form-select mx-auto" style="width: 15%!important;" align="center">';
            formulario += '<option value="0">x</option>';
            formulario += '<option value="1">y</option>';
            formulario += '</select>';
            formulario += '<br>';
            formulario += 'Con la constante c = <input type="number" name="v-'+cdt+'" placeholder="Constante c" class="me-2 rounded w-25">';
            break;

        case '2':
            formulario += 'Respecto al eje:';
            formulario += '<select name="e-'+cdt+'" class="form-select mx-auto" style="width: 15%!important;" align="center">';
            formulario += '<option value="0">x</option>';
            formulario += '<option value="1">y</option>';
            formulario += '</select>';
            formulario += '<br>';
            formulario += 'Con la constante c = <input type="number" name="v-'+cdt+'" placeholder="Constante c" class="me-2 rounded w-25">';
            break;

        case '3':
            formulario += '<input type="hidden" name="e-'+cdt+'" value="0">';
            formulario += 'Con el angulo (en grados) &theta; = <input type="number" name="v-'+cdt+'" placeholder="Angulo" class="me-2 rounded w-25">';
            break;
    
        default:
            formulario += 'Ocurrio un error';
            break;
    }

    formulario += "<br><br>";
    formulario += "<input type='submit' value='Transformar' class='btn btn-lg btn-secondary fw-bold border-white bg-white text-black m-3'>";

    document.getElementById('identificador').innerHTML = formulario;
}