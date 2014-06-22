<?php

class m140621_200809_mysql_base extends CDbMigration
{
	public function up()
	{
            $this->execute("SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0");
            $this->execute("SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0");
            $this->execute("SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES'");
            
            //load the database config file to work out what database to use
            $dbname = 'videome';

            //drops the schema run for the very first time
            $this->execute("DROP SCHEMA IF EXISTS `" . $dbname . "`");
            $this->execute("CREATE SCHEMA IF NOT EXISTS `" . $dbname . "` DEFAULT CHARACTER SET utf8");     
            
            $this->execute("USE ". $dbname);       
            
            //create the migration table, this handles all migration data
            $this->createTable("yii_migration", array(
                "version"       => "VARCHAR(255) CHARACTER SET 'utf8' NOT NULL",
                "apply_time" => "INT(11) NOT NULL"
            ));
            
            //-- Table `yii_session`
            $this->execute("DROP TABLE IF EXISTS `yii_session`");
            $this->createTable("yii_session", array(
                "id"    => "CHAR(32) NOT NULL",
                "expire"=> "INT NULL",
                "data"  => "LONGBLOB NULL",
            ), "ENGINE = InnoDB DEFAULT CHARACTER SET = utf8 AUTO_INCREMENT = 0");
            
            //-- Table `user`
            $this->execute("DROP TABLE IF EXISTS `video`");
            $this->createTable("video", array(
                "uuid"              => "VARCHAR(255) NOT NULL PRIMARY KEY",
                "uuidCamera"        => "VARCHAR(255) NOT NULL",
                "urlThumbnail"      => "VARCHAR(255) NULL DEFAULT NULL",
                "urlThumbnailSmall" => "VARCHAR(255) NULL DEFAULT NULL",
                "urlVideo"          => "VARCHAR(255) NULL DEFAULT NULL",
                "status"            => "VARCHAR(50) NOT NULL",
                "timestamp"         => "TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP",
            ), "ENGINE = InnoDB DEFAULT CHARACTER SET = utf8 AUTO_INCREMENT = 0");
            
            $this->execute("SET SQL_MODE=@OLD_SQL_MODE");
            $this->execute("SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS");
            $this->execute("SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS");
	}

	public function down()
	{
		echo "m140621_200809_mysql_base does not support migration down.\n";
		return false;
	}

}