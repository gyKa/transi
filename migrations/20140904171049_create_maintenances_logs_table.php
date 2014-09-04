<?php

use Phinx\Migration\AbstractMigration;

class CreateMaintenancesLogsTable extends AbstractMigration
{
    /**
     * Change Method.
     *
     * More information on this method is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-change-method
     */
    public function change()
    {
        $table = $this->table('maintenances_logs');
        $table->addColumn('vehicle_id', 'integer')
              ->addColumn('maintenance_id', 'integer')
              ->addColumn('date', 'date')
              ->addForeignKey('vehicle_id', 'vehicles', 'id', ['delete'=> 'CASCADE', 'update'=> 'CASCADE'])
              ->addForeignKey('maintenance_id', 'maintenances', 'id', ['delete'=> 'CASCADE', 'update'=> 'CASCADE'])
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
