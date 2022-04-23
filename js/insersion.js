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
            formulario += "<br><br>";
        }
    }
    formulario += ">";
    formulario += "<br><br>";
    
    //Agregamos botones para hacer operaciones, en este caso necestiamos A^2, |A|, |A^a| (este una vez que se calcule) y A^-1
    formulario += "<input type='submit' value='Verificar' class='btn btn-lg btn-secondary fw-bold border-white bg-white text-black m-3'>";
    formulario += "</form>";

    document.getElementById('identificador').innerHTML = formulario;
}