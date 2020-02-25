function comprobar(){
    let pass1 = document.getElementById("con1").value;
    let pass2 = document.getElementById("con2").value;
    
    if(pass1 == pass2){
        alert("Las contraseñas coinciden");
    }else alert("Las contraseñas no coinciden. Verifica de nuevo.");       
}