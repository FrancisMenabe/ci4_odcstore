<?php

namespace App\Models;

use CodeIgniter\Model;

class CashPointModel extends Model
{
    protected $table      = 'cashpoint';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'type_operation',
        'nom_client',
        'telephone',
        'montant',
        'frais',
        'benefice',
        'responsable',
        'date_operation'
    ];

    public function calculFraisBenefice($montant, $pourcentage = 2)
    {
        $frais = ($montant * $pourcentage) / 100;
        return [
            'frais'     => $frais,
            'benefice'  => $frais
        ];
    }

    public function historique()
    {
        return $this->orderBy('date_operation', 'DESC')->findAll();
    }
}
