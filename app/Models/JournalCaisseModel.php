<?php

namespace App\Models;

use CodeIgniter\Model;

class JournalCaisseModel extends Model
{
    protected $table = 'journal_caisse';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'source',
        'reference_id',
        'libelle',
        'type',
        'montant',
        'responsable',
        'date_operation'
    ];

    // 🔍 Récupérer les montants groupés selon la période
    public function getStats($start, $end)
    {
        return $this->select("
                source,
                SUM(montant) as total
            ")
            ->where('date_operation >=', $start)
            ->where('date_operation <=', $end)
            ->groupBy('source')
            ->findAll();
    }
}
