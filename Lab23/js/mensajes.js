mensaje = document.getElementById("mensaje");

if(mensaje != null)
{
	setTimeout(borrar, 3000);
	console.log(mensaje);
}



function borrar()
{
	mensaje.parentNode.removeChild(mensaje);
}