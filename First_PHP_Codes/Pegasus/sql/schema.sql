CREATE TABLE `pegasusmedical`.`usuarios` (`id` INT(4) NOT NULL AUTO_INCREMENT , `nombre` VARCHAR(20) NOT NULL , `email` VARCHAR(50) NOT NULL , `password` VARCHAR(255) NOT NULL , `rol` ENUM('Administrador','Gestor_General','Gestor_de_Hospital','Gestor_de_Planta','Usuario_de_Botiquín') NOT NULL ) ENGINE = InnoDB;

CREATE TABLE `pegasusmedical`.`hospitales` (`id` INT(4) NOT NULL AUTO_INCREMENT , `nombre` VARCHAR(50) NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;

CREATE TABLE `pegasusmedical`.`hospital_usuario` (`id` INT(4) NOT NULL AUTO_INCREMENT , `id_usuario` INT(4) NOT NULL , `id_hospital` INT(4) NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;

ALTER TABLE `hospital_usuario` ADD CONSTRAINT `usuario_hospital_fk` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios`(`id`) ON DELETE RESTRICT ON UPDATE RESTRICT; ALTER TABLE `hospital_usuario` ADD CONSTRAINT `hospital_usuario_fk` FOREIGN KEY (`id_hospital`) REFERENCES `hospitales`(`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

CREATE TABLE `pegasusmedical`.`plantas` (`id` INT(4) NOT NULL AUTO_INCREMENT , `nombre` VARCHAR(20) NOT NULL , `id_hospital` INT(4) NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;

ALTER TABLE `plantas` ADD CONSTRAINT `planta_hospital_fk` FOREIGN KEY (`id_hospital`) REFERENCES `hospitales`(`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

CREATE TABLE `pegasusmedical`.`planta_usuario` (`id` INT NOT NULL AUTO_INCREMENT , `id_usuario` INT(4) NOT NULL , `id_planta` INT(4) NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;

ALTER TABLE `planta_usuario` ADD CONSTRAINT `usuario_planta_fk` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios`(`id`) ON DELETE RESTRICT ON UPDATE RESTRICT; ALTER TABLE `planta_usuario` ADD CONSTRAINT `planta_usuario_fk` FOREIGN KEY (`id_planta`) REFERENCES `plantas`(`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

CREATE TABLE `pegasusmedical`.`almacenes` (`id` INT(4) NOT NULL AUTO_INCREMENT , `id_planta` INT(4) NOT NULL , `tipo` ENUM('General','Almacenillo','','') NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;

ALTER TABLE `almacenes` ADD CONSTRAINT `almacen_planta_fk` FOREIGN KEY (`id_planta`) REFERENCES `plantas`(`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

CREATE TABLE `pegasusmedical`.`almacen_usuario` (`id` INT(4) NOT NULL AUTO_INCREMENT , `id_usuario` INT(4) NOT NULL , `id_almacen` INT(4) NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;

ALTER TABLE `almacen_usuario` ADD CONSTRAINT `usuario_almacen_fk` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios`(`id`) ON DELETE RESTRICT ON UPDATE RESTRICT; ALTER TABLE `almacen_usuario` ADD CONSTRAINT `almacen_usuario.fk` FOREIGN KEY (`id_almacen`) REFERENCES `almacenes`(`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

CREATE TABLE `pegasusmedical`.`botiquines` (`id` INT(4) NOT NULL AUTO_INCREMENT , `nombre` VARCHAR(50) NOT NULL , `id_planta` INT(4) NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;

ALTER TABLE `botiquines` ADD CONSTRAINT `botiquin_planta` FOREIGN KEY (`id_planta`) REFERENCES `plantas`(`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

CREATE TABLE `pegasusmedical`.`botiquin_usuario` (`id` INT(4) NOT NULL AUTO_INCREMENT , `id_usuario` INT(4) NOT NULL , `id_botiquin` INT(4) NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;

ALTER TABLE `botiquin_usuario` ADD CONSTRAINT `usuario_botiquin_fk` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios`(`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

CREATE TABLE `pegasusmedical`.`productos` (`id` INT(4) NOT NULL AUTO_INCREMENT , `codigo` INT(4) NOT NULL , `descripcion` VARCHAR(150) NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;

CREATE TABLE `pegasusmedical`.`stocks_almacenes` (`id` INT(4) NOT NULL AUTO_INCREMENT , `id_producto` INT(4) NOT NULL , `id_almacen` INT(4) NOT NULL , `cantidad` INT(4) NOT NULL , `cantidad_minima` INT(4) NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;

ALTER TABLE `stocks_almacenes` ADD CONSTRAINT `stock_producto_de_almacen_fk` FOREIGN KEY (`id_producto`) REFERENCES `productos`(`id`) ON DELETE RESTRICT ON UPDATE RESTRICT; ALTER TABLE `stocks_almacenes` ADD CONSTRAINT `stock_almacen_fk` FOREIGN KEY (`id_almacen`) REFERENCES `almacenes`(`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

CREATE TABLE `pegasusmedical`.`reposiciones_almacenes` (`id` INT(4) NOT NULL AUTO_INCREMENT , `id_producto` INT(4) NOT NULL , `id_almacen_general` INT(4) NOT NULL , `id_almacenillo` INT(4) NOT NULL , `_repuesta` INT(4) NOT NULL , `fecha` DATETIME NOT NULL , `estado` ENUM('pendiente','realizada','cancelada') NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;

ALTER TABLE `reposiciones_almacenes` ADD CONSTRAINT `reposicion_almacenillo_fk` FOREIGN KEY (`id_almacenillo`) REFERENCES `almacenes`(`id`) ON DELETE RESTRICT ON UPDATE RESTRICT; ALTER TABLE `reposiciones_almacenes` ADD CONSTRAINT `reposicion_general_fk` FOREIGN KEY (`id_almacen_general`) REFERENCES `almacenes`(`id`) ON DELETE RESTRICT ON UPDATE RESTRICT; ALTER TABLE `reposiciones_almacenes` ADD CONSTRAINT `reposicion_producto_almacen_fk` FOREIGN KEY (`id_producto`) REFERENCES `productos`(`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

CREATE TABLE `pegasusmedical`.`stocks_botiquines` (`id` INT(4) NOT NULL AUTO_INCREMENT , `id_producto` INT(4) NOT NULL , `id_botiquin` INT(4) NOT NULL , `cantidad` INT(4) NOT NULL , `cantidad_minima` INT(4) NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;

ALTER TABLE `stocks_botiquines` ADD CONSTRAINT `stock_producto_de_botiquin_fk` FOREIGN KEY (`id_producto`) REFERENCES `productos`(`id`) ON DELETE RESTRICT ON UPDATE RESTRICT; ALTER TABLE `stocks_botiquines` ADD CONSTRAINT `stock_botiquin_fk` FOREIGN KEY (`id_botiquin`) REFERENCES `botiquines`(`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

CREATE TABLE `pegasusmedical`.`reposiciones_botiquines` (`id` INT(4) NOT NULL AUTO_INCREMENT , `id_producto` INT(4) NOT NULL , `id_almacenillo` INT(4) NOT NULL , `id_botiquin` INT(4) NOT NULL , `_repuesta` INT(4) NOT NULL , `fecha` DATETIME NOT NULL , `estado` ENUM('pendiente','realizada','cancelada') NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;

ALTER TABLE `reposiciones_botiquines` ADD CONSTRAINT `reposicion_almacenilllo_fk` FOREIGN KEY (`id_almacenillo`) REFERENCES `almacenes`(`id`) ON DELETE RESTRICT ON UPDATE RESTRICT; ALTER TABLE `reposiciones_botiquines` ADD CONSTRAINT `reposicion_botiquin_fk` FOREIGN KEY (`id_botiquin`) REFERENCES `botiquines`(`id`) ON DELETE RESTRICT ON UPDATE RESTRICT; ALTER TABLE `reposiciones_botiquines` ADD CONSTRAINT `reposicion_producto_botiquin_fk` FOREIGN KEY (`id_producto`) REFERENCES `productos`(`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

CREATE TABLE `pegasusmedical`.`consumiciones` (`id` INT(4) NOT NULL AUTO_INCREMENT , `id_botiquin` INT(4) NOT NULL , `id_producto` INT(4) NOT NULL , `cantidad_consumida` INT(4) NOT NULL , `fecha` DATETIME NOT NULL , `realizada_por` INT(4) NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;

ALTER TABLE `consumiciones` ADD CONSTRAINT `consumicion_botiquin_fk` FOREIGN KEY (`id_botiquin`) REFERENCES `botiquines`(`id`) ON DELETE RESTRICT ON UPDATE RESTRICT; ALTER TABLE `consumiciones` ADD CONSTRAINT `consumicion_producto_fk` FOREIGN KEY (`id_producto`) REFERENCES `productos`(`id`) ON DELETE RESTRICT ON UPDATE RESTRICT; ALTER TABLE `consumiciones` ADD CONSTRAINT `consumicion_usuario_fk` FOREIGN KEY (`realizada_por`) REFERENCES `usuarios`(`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

CREATE TABLE `pegasusmedical`.`etiquetas` (`id` INT(4) NOT NULL AUTO_INCREMENT , `id_producto` INT(4) NOT NULL , `tipo` ENUM('informativa','RFID') NOT NULL , `prioridad` ENUM('normal','urgente') NOT NULL , `impresa` BOOLEAN NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;

ALTER TABLE `etiquetas` ADD CONSTRAINT `etiqueta_producto_fk` FOREIGN KEY (`id_producto`) REFERENCES `productos`(`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

