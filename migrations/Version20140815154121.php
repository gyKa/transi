<?php

namespace Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

class Version20140815154121 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        $this->addSql(
            'CREATE TABLE IF NOT EXISTS `vehicles` (
                `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
                `title` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
                PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1;'
        );
    }

    public function down(Schema $schema)
    {
        $this->addSql('DROPTABLE `vehicles`;');
    }
}
