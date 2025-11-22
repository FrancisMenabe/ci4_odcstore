<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateCashPointTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
    'id' => ['type'=>'INT','auto_increment'=>true,'unsigned'=>true],
    'type_operation' => ['type'=>'ENUM','constraint'=>['depot','retrait','transfert'],'default'=>'depot'],
    'nom_client' => ['type'=>'VARCHAR','constraint'=>100],
    'nom_beneficier' => ['type'=>'VARCHAR','constraint'=>100,'null'=>true],
    'telephone' => ['type'=>'VARCHAR','constraint'=>20,'null'=>true],
    'montant' => ['type'=>'DECIMAL','constraint'=>'10,2','default'=>0],
    'frais' => ['type'=>'DECIMAL','constraint'=>'10,2','default'=>0],
    'date_operation' => ['type'=>'DATETIME','default'=>null],
    'responsable' => ['type'=>'VARCHAR','constraint'=>100],
]);
$this->forge->addKey('id', true);
$this->forge->createTable('cashpoint');
    }

    public function down()
    {
        $this->forge->dropTable('cashpoint');
    }
}
