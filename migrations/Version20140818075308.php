<?php

namespace Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

class Version20140818075308 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        $this->addSql(
            'CREATE TABLE IF NOT EXISTS `trips` (
                `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
                `vehicle_id` int(11) unsigned NOT NULL,
                `date` date NOT NULL,
                `distance` float(8,2) unsigned NOT NULL,
                PRIMARY KEY (`id`),
                KEY `vehicle_id` (`vehicle_id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;'
        ); 

        $this->addSql(
            'ALTER TABLE `trips`
                ADD CONSTRAINT `vehicle_trips`
                    FOREIGN KEY ( `vehicle_id` ) REFERENCES `vehicles` (`id`)
                        ON DELETE CASCADE
                        ON UPDATE CASCADE ;'
        );
    }

    public function down(Schema $schema)
    {
        $this->addSql('ALTER TABLE `trips` DROP FOREIGN KEY `vehicle_trips` ;');
        $this->addSql('DROP TABLE `trips` ;');
    }
}
