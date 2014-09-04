<?php

use Phinx\Migration\AbstractMigration;

class CreateMaintenancesTable extends AbstractMigration
{
    /**
     * Change Method.
     *
     * More information on this method is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-change-method
     *
     */
    public function change()
    {
        $table = $this->table('maintenances');
        $table->addColumn('title', 'string', ['limit' => 15])
              ->create();
    }
    
    /**
     * Migrate Up.
     */
    public function up()
    {
    
    }

    /**
     * Migrate Down.
     */
    public function down()
    {

    }
}
