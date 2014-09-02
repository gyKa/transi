<?php

use Phinx\Migration\AbstractMigration;

class CreateTripsTable extends AbstractMigration
{
    /**
     * Change Method.
     *
     * More information on this method is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-change-method
     */
    public function change()
    {
        $table = $this->table('trips');
        $table->addColumn('vehicle_id', 'integer')
              ->addColumn('date', 'date')
              ->addColumn('distance', 'float', array('limit' => '8,2'))
              ->addForeignKey('vehicle_id', 'vehicles', 'id', array('delete'=> 'CASCADE', 'update'=> 'CASCADE'))
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