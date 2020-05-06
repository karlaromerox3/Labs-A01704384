DROP PROCEDURE IF EXISTS `nuevoIncidente` ;
DELIMITER ;;
CREATE PROCEDURE `nuevoIncidente` (uidLugar INT(11) , uidTipo INT(11))
BEGIN
    INSERT INTO incidente(idLugar, idTipo) VALUES (uidLugar, uidTipo);
END ;;
DELIMITER ;

