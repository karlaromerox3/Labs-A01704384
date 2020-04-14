
select * from materiales
where clave=1000

/*Output
Clave   Descripcion     Costo
1000    Varilla 3/16    100.00
Aparece solo 1 registro
*/


select clave,rfc,fecha from entregan

/*Output
Clave    rfc        fecha
1000  AAAA800101 1998-07-08
1000  FFFF800101 2020-04-01
1010  BBBB800101 2020-04-09
Aparecen todos los registros
*/

