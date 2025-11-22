<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateClientsSolaireTable extends Migration
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
            'nom_client' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            'telephone' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
            ],
            'adresse' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'type_kit' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
            ],
            'prix_total' => [
                'type'    => 'DECIMAL',
                'constraint' => '10,2',
                'default' => 0,
            ],
            'montant_mensuel' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
                'default'    => 0,
            ],
            'nombre_mois' => [
                'type'    => 'INT',
                'default' => 0,
            ],
            'date_debut' => [
                'type' => 'DATE',
                'null' => true,
            ],
            'prochaine_echeance' => [
                'type' => 'DATE',
                'null' => true,
            ],
            'retard_jours' => [
                'type'    => 'INT',
                'default' => 0,
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
        $this->forge->createTable('clients_solaire');
    }

    public function down()
    {
        $this->forge->dropTable('clients_solaire');
    }
}
