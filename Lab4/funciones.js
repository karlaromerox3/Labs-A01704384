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
    let t1 = Date.now();
    
    let resp = prompt("Cuál es el resultado de " + n + " + " + m + "?" );
    
    let t2 = Date.now();
    
    let suma = n+ m;
    
    let tiempo = (t2-t1)/1000;
    
    if(resp == suma){
        document.write("Correcto! \n Tiempo: " + tiempo+" segundos");
    }else document.write("Incorrecto \n Tiempo: " + tiempo + " segundos");
}

function contador(arr) {
    let neg=0, pos = 0, cero = 0;
    for(let i = 0; i<arr.length; i++){
        if(arr[i] < 0){
            neg++;
        }
        if(arr[i]==0){
            cero++;
        }
        if(arr[i] > 0){
            pos++;
        }
    }
    document.write("Array: " + arr + " Negativos: " + neg + " Ceros: " + cero + " Positivos: " + pos);
}

function promedios(mat) {
    console.log(mat);
    let proms = [
        [0],
        [0],
        [0],
        [0],
    ]
    
    for(let m = 0; m<4; m++){ //columnas
        for (let n = 0; n<4; n++){
             proms[m][0]= proms[m][0] + mat[m][n];
            }
        proms[m][0] = proms[m][0]/4 + " ";
        }
    
    document.write("Matriz 4x4: " + mat + " Promedios: por columna: " + proms);
}

function invertido(){
    let n = prompt("Dame un número");
    let inv="";
    while((n/10) != 0){
        inv += n%10;
        n = parseInt(n/10);
    }  
    document.write("Invertido: " + inv);    
}



