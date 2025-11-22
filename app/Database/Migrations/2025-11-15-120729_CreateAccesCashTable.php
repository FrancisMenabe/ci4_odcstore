<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateAccesCashTable extends Migration
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
            'type_operation' => [
                'type'       => 'VARCHAR',
                'constraint' => '50', // retrait / dépôt
            ],
            'nom_client' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'montant' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
            ],
            'compte' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
            ],
            'ref_transaction' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'null'       => true,
            ],
            'motif' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'date_operation' => [
                'type' => 'DATE',
            ],
            'responsable' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],

            // timestamps auto
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
        $this->forge->createTable('accescash');
    }

    public function down()
    {
        $this->forge->dropTable('accescash');
    }
}
