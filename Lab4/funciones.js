function uno() {
    let n = prompt("Dame un número");
    for (let i=1; i<=n; i++){
    document.write(Math.pow(i,2)+", ");
    }
    
    for (let i=1; i<=n; i++){
    document.write(Math.pow(i,3)+", ");
    }
    
}

function dos() {
    let n = Math.floor(Math.random() * (30 - 1)) + 1;
    let m = Math.floor(Math.random() * (30 - 1)) + 1;
        
    let resp = prompt("Cuál es el resultado de " + n + " + " + m + "?" );
}



