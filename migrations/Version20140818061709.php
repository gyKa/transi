<?php

namespace Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

class Version20140818061709 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        $this->addSql('ALTER TABLE `vehicles` ADD `initial_mileage` INT( 11 ) UNSIGNED NOT NULL DEFAULT "0";');
    }

    public function down(Schema $schema)
    {
        $this->addSql('ALTER TABLE `vehicles` DROP `initial_mileage`;');
    }
}
