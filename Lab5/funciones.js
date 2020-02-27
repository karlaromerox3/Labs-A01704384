
function comprobar() {
    let pass1 = document.getElementById("con1").value;
    let pass2 = document.getElementById("con2").value;
    
    if(pass1 == pass2){
        alert("Las contraseñas coinciden");
    }else alert("Las contraseñas no coinciden. Verifica de nuevo.");    
}

function tienda() {
    
    let rb = document.getElementById("rb").value;
    let sc = document.getElementById("sc").value;
    let airp = document.getElementById("airp").value;
    
    let totrb = 0;
    let totsc = 0;
    let totairp = 0;
    
    if(rb > 2){
        totrb = rb*599;
    }else totrb = rb*799;
    
    if(sc > 4){
        totsc = sc*299;
    }else totsc = sc*345;
    
    if(airp >3){
        totairp = airp*2999;
    }else totairp = airp*3459;
        
    var subtot = totrb + totsc + totairp;
    var iva = subtot*.16;
    var tot = subtot+iva;
    document.getElementById("subtot").innerHTML = "Subtotal: $ "+subtot;    
    document.getElementById("iva").innerHTML = "IVA: $ " + iva.toFixed(2);
    document.getElementById("tot").innerHTML = "Total: $ " + tot;
}

document.getElementById("myButton").onclick = tienda;





