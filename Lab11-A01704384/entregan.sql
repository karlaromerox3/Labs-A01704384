LOAD DATA INFILE 'entregan.csv'
INTO TABLE lab11.Entregan
FIELDS TERMINATED BY ','
(Clave,RFC,Numero, @Fecha,Cantidad)
SET Fecha = STR_TO_DATE(@Fecha, '%d/%m/%Y');