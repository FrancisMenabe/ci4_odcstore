<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateProduitsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'         => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'reference'  => ['type' => 'VARCHAR', 'constraint' => 50, 'unique' => true],
            'nom'        => ['type' => 'VARCHAR', 'constraint' => 100],
            'quantite'   => ['type' => 'INT', 'default' => 0],
            'prix_achat' => ['type' => 'DECIMAL', 'constraint' => '10,2', 'default' => 0.00],
            'prix_vente' => ['type' => 'DECIMAL', 'constraint' => '10,2', 'default' => 0.00],
            'description'=> ['type' => 'TEXT', 'null' => true],
            'fournisseur'=> ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'responsable'=> ['type' => 'VARCHAR', 'constraint' => 50],
            'date_creation' => ['type' => 'DATETIME', 'null' => true],
        ]);


        $this->forge->addKey('id', true);
        $this->forge->createTable('produits');
    }

    public function down()
    {
        $this->forge->dropTable('produits');
    }
}
