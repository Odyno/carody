<?php

if (!class_exists('Carody_DB_Definition')) :

  class Carody_DB_Definition {

    static function DDLs($databasePre="") {
      $dbSchema = array(
          $databasePre . "Macchina" => "CREATE TABLE `" . $databasePre . "Macchina` ( `idMacchina` INT(11) NOT NULL AUTO_INCREMENT , `Marca` VARCHAR(45) NULL , `Modello` VARCHAR(45) NULL , `MaxSerbatoioLitri` INT(11) NULL , `ConsumoMedio` FLOAT NULL , PRIMARY KEY (`idMacchina`) , UNIQUE INDEX `idMacchina_UNIQUE` (`idMacchina` ASC) ) ENGINE = MyISAM DEFAULT CHARACTER SET = utf8",
          $databasePre . "Utente_Macchina" => "CREATE TABLE `" . $databasePre . "Utente_Macchina` ( `idUtente_Macchina` INT NOT NULL AUTO_INCREMENT , `Users_ID` BIGINT(20) UNSIGNED NOT NULL , `Macchina_idMacchina` INT(11) NOT NULL ,`Priority` INT(10) NOT NULL DEFAULT -1 , PRIMARY KEY (`idUtente_Macchina`) , INDEX `fk_Utente_Macchina_wp_users` (`Users_ID` ASC) , INDEX `fk_Utente_Macchina_Macchina1` (`Macchina_idMacchina` ASC) ) ENGINE = MyISAM DEFAULT CHARACTER SET = utf8",
          $databasePre . "Fuel" => "CREATE TABLE `" . $databasePre . "Fuel` ( `idFuel` INT(11) NOT NULL AUTO_INCREMENT , `DataTime` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP , `TotKm` INT(11) NOT NULL , `PrezzoAlLitro` DOUBLE NOT NULL , `PrezzoRifornimento` DOUBLE NOT NULL , `Utente_Macchina_idUtente_Macchina` INT NOT NULL , PRIMARY KEY (`idFuel`) , UNIQUE INDEX `idFuel_UNIQUE` (`idFuel` ASC) , INDEX `fk_Fuel_Utente_Macchina1` (`Utente_Macchina_idUtente_Macchina` ASC) ) ENGINE = MyISAM DEFAULT CHARACTER SET = utf8",
          $databasePre . "C_Almanacco" => "CREATE TABLE `" . $databasePre . "C_Almanacco` (  `idEvento` INT NOT NULL AUTO_INCREMENT , `idMacchina` INT(11) NOT NULL, `data` DATETIME NOT NULL ,  `km` INT NOT NULL ,  `idManutenzione` INT NOT NULL ,  `descrizione` VARCHAR(256) NULL ,  `azione` ENUM('Eseguito','Sostituito','Controllato','Rabboccato','Rimandato') NOT NULL DEFAULT 'Eseguito' ,  `prezzo` INT NULL ,  PRIMARY KEY (`idEvento`) ) ENGINE = MyISAM DEFAULT CHARACTER SET = utf8",
          $databasePre . "C_Manutenzione" => "CREATE TABLE `" . $databasePre . "C_Manutenzione` ( `idManutenzione` INT NOT NULL AUTO_INCREMENT , `descrizione` VARCHAR(45) NOT NULL , PRIMARY KEY (`idManutenzione`) )  ENGINE = MyISAM DEFAULT CHARACTER SET = utf8",
      );
      return $dbSchema;
    }

    static function DataFill($databasePre="") {
      $dataFill = array(
          $databasePre . "C_Manutenzione" => array(
              array('idManutenzione' => null, 'descrizione' => 'Tagliando'),
              array('idManutenzione' => null, 'descrizione' => 'Olio motore'),
              array('idManutenzione' => null, 'descrizione' => 'Filtro olio'),
              array('idManutenzione' => null, 'descrizione' => 'Filtro aria'),
              array('idManutenzione' => null, 'descrizione' => 'Filtro benzina/gasolio'),
              array('idManutenzione' => null, 'descrizione' => 'Filtro antipolline'),
              array('idManutenzione' => null, 'descrizione' => 'Ric. climatizzatore'),
              array('idManutenzione' => null, 'descrizione' => 'Revis. climatizzatore'),
              array('idManutenzione' => null, 'descrizione' => 'Candele/Candelette'),
              array('idManutenzione' => null, 'descrizione' => 'Iniettori/Pompa Iniezione'),
              array('idManutenzione' => null, 'descrizione' => 'Turbina Motore'),
              array('idManutenzione' => null, 'descrizione' => 'Olio cambio/differenziale'),
              array('idManutenzione' => null, 'descrizione' => 'Liquido servosterzo'),
              array('idManutenzione' => null, 'descrizione' => 'Antigelo'),
              array('idManutenzione' => null, 'descrizione' => 'Pompa acqua'),
              array('idManutenzione' => null, 'descrizione' => 'Ammortizzatore anteriore'),
              array('idManutenzione' => null, 'descrizione' => 'Ammortizzatore posteriore'),
              array('idManutenzione' => null, 'descrizione' => 'Testine sterzo'),
              array('idManutenzione' => null, 'descrizione' => 'Bracci oscillanti'),
              array('idManutenzione' => null, 'descrizione' => 'Cinghia distribuzione'),
              array('idManutenzione' => null, 'descrizione' => 'Cuscin. tendicinghia'),
              array('idManutenzione' => null, 'descrizione' => 'Cinghia unica Alt-Serv-Climatizz'),
              array('idManutenzione' => null, 'descrizione' => 'Cinghia altro'),
              array('idManutenzione' => null, 'descrizione' => 'Liquido freni'),
              array('idManutenzione' => null, 'descrizione' => 'Pastiglie freni anteriore'),
              array('idManutenzione' => null, 'descrizione' => 'Pastiglie freni posteriori'),
              array('idManutenzione' => null, 'descrizione' => 'Dischi freni anteriore'),
              array('idManutenzione' => null, 'descrizione' => 'Dischi freni posteriore'),
              array('idManutenzione' => null, 'descrizione' => 'Cilindretti freni'),
              array('idManutenzione' => null, 'descrizione' => 'Pompa freni'),
              array('idManutenzione' => null, 'descrizione' => 'Cuscinetti anteriore'),
              array('idManutenzione' => null, 'descrizione' => 'Cuscinetti posteriore'),
              array('idManutenzione' => null, 'descrizione' => 'Frizione'),
              array('idManutenzione' => null, 'descrizione' => 'Impiatto GPL'),
              array('idManutenzione' => null, 'descrizione' => 'Impiatto Metano'),
              array('idManutenzione' => null, 'descrizione' => 'Batteria'),
              array('idManutenzione' => null, 'descrizione' => 'Rev. motorino avv.'),
              array('idManutenzione' => null, 'descrizione' => 'Rev. motorino altern.'),
              array('idManutenzione' => null, 'descrizione' => 'Sonda lambda'),
              array('idManutenzione' => null, 'descrizione' => 'Marmitta anteriore'),
              array('idManutenzione' => null, 'descrizione' => 'Marmitta centrale'),
              array('idManutenzione' => null, 'descrizione' => 'Marmitta posteriore'),
              array('idManutenzione' => null, 'descrizione' => 'Sost. Debimetro'),
              array('idManutenzione' => null, 'descrizione' => 'Filtro antiparticolato'),
              array('idManutenzione' => null, 'descrizione' => 'Controllo Gas Scarico'),
              array('idManutenzione' => null, 'descrizione' => 'Spazzole tergicristalo'),
              array('idManutenzione' => null, 'descrizione' => 'Temostato'),
              array('idManutenzione' => null, 'descrizione' => 'Gomme'),
              array('idManutenzione' => null, 'descrizione' => 'Equilibbratura'),
              array('idManutenzione' => null, 'descrizione' => 'Convergenza'),
              array('idManutenzione' => null, 'descrizione' => 'Inversione')
          )
      );
      return $dataFill;
    }

  }

  endif;
?>
