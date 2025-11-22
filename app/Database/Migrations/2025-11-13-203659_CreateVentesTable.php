<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateVentesTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'               => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'reference_vente'  => ['type' => 'VARCHAR', 'constraint' => 50],
            'produit_id'       => ['type' => 'INT', 'unsigned' => true],
            'quantite'         => ['type' => 'INT', 'default' => 0],
            'nom_client'       => ['type' => 'VARCHAR', 'constraint' => 100],
            'responsable'      => ['type' => 'VARCHAR', 'constraint' => 50],
            'date_vente' => ['type' => 'DATETIME', 'null' => true],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('produit_id', 'produits', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('ventes');
    }

    public function down()
    {
        $this->forge->dropTable('ventes');
    }
}
