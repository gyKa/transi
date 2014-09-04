<?php

use Phinx\Migration\AbstractMigration;

class SeedMaintenancesTable extends AbstractMigration
{    
    /**
     * Migrate Up.
     */
    public function up()
    {
        $this->execute("INSERT INTO maintenances (title) VALUES ('Tyre pressure')");
    }

    /**
     * Migrate Down.
     */
    public function down()
    {
        $this->execute("DELETE FROM maintenances WHERE title = 'Tyre pressure'");
    }
}
