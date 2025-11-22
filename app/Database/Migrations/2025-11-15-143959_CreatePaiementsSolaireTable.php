<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePaiementsSolaireTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'client_id' => [
                'type'       => 'INT',
                'unsigned'   => true,
            ],
            'montant' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
                'default'    => 0,
            ],
            'ref_transaction' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'null'       => true,
            ],
            'motif' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'date_operation' => [
                'type' => 'DATE',
                'null' => false,
            ],
            'responsable' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('client_id', 'clients_solaire', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('paiements_solaire');
    }

    public function down()
    {
        $this->forge->dropTable('paiements_solaire');
    }
}
