function uno() {
    let n = prompt("Dame un número");
    let cuad= new Array(n);
    let cub = new Array(n);
    for (let i=1; i<=n; i++){
    cuad[i]=Math.pow(i,2);
    }
    
    for (let i=1; i<=n; i++){
    cub[i]=Math.pow(i,3);
    }
  
    var article = document.getElementsByTagName("article")[0];
 
  
    var tabla   = document.createElement("table");
    var tblBody = document.createElement("tbody");
 
  
    for (var i = 0; i <=1; i++) {
        var column = document.createElement("tr");
 
        for (var j = 0; j <= n; j++) {
   
            var celda = document.createElement("td");
            
            if(j==0 && i==0){
                var textoCelda = document.createTextNode("Cuadrados");
            }else if(j==0 && i==1){
                var textoCelda = document.createTextNode("Cubos");
            }else{
                if(i==0){
                    var textoCelda = document.createTextNode(cuad[j]);
                }else{
                   var textoCelda = document.createTextNode(cub[j]); 
                }
            }
            
            celda.appendChild(textoCelda);
            column.appendChild(celda);
        
        }
        tblBody.appendChild(column);
    }
 
  
    tabla.appendChild(tblBody);
    article.appendChild(tabla);
  
tabla.setAttribute("border", "1");
    
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

function problema(){
    alert("Para este ejercicio usaré un problema de la clase de algoritmos, donde se necesitaba un programa que creara una contraseña de tamaño n y con k letras iguales. Con la restricción de que no puede haber dos letras iguales juntas.");
    
    let n = prompt("Numero de caracteres: ");
    let k = prompt("Numero de letras repetidas");
    
    if (n<2 || n>100){
        return 0;
    }
    if(k<2 || (k>n || k>26)){
        return 0;
    }

    let letra=0;
    let pass="";
  
    
    for(let i=0; i<n; i++){
      if(i > (k-1)){
        letra = (parseInt((i%k))+parseInt(97));
          console.log(letra);
          pass = pass + String.fromCharCode(letra);
        console.log(pass);
      } else { 
        letra = (parseInt((i))+parseInt(97));
        pass = pass + String.fromCharCode(letra);
        console.log(pass);
      }
    }
    
    alert("La contraseña sugerida es: " + pass);
}



