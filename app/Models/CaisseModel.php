<?php
namespace App\Models;

use CodeIgniter\Model;

class CaisseModel extends Model
{
    protected $table      = 'caisse';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'type',         // 'entree' ou 'sortie'
        'montant',
        'categorie',
        'description',
        'responsable',
        'date_operation'
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'date_operation';
    protected $updatedField  = '';

    /**
     * Calculer le fond de roulement actuel
     */
    public function getFondDeRoulement()
    {
        $builder = $this->db->table($this->table);

        $entrees = $builder->selectSum('montant')
                            ->where('type', 'entree')
                            ->get()
                            ->getRowArray();

        $sorties = $builder->selectSum('montant')
                            ->where('type', 'sortie')
                            ->get()
                            ->getRowArray();

        $total_entrees = $entrees['montant'] ?? 0;
        $total_sorties = $sorties['montant'] ?? 0;

        return $total_entrees - $total_sorties;
    }

    /**
     * Récupérer toutes les opérations triées par date décroissante
     */
    public function getOperations()
    {
        return $this->orderBy('date_operation', 'DESC')->findAll();
    }
}
