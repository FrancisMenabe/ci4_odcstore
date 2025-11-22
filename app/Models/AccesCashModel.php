<?php

namespace App\Models;

use CodeIgniter\Model;

class AccesCashModel extends Model
{
    protected $table = 'accescash';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'type_operation',
        'nom_client',
        'montant',
        'compte',
        'ref_transaction',
        'motif',
        'date_operation',
        'responsable'
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
}
