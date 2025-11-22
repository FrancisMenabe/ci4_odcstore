<?php
namespace App\Models;

use CodeIgniter\Model;

class PaiementSolaireModel extends Model
{
    protected $table = 'paiements_solaire';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'client_id', 'mois_paye', 'montant', 'ref_transaction', 'responsable', 'date_paiement'
    ];

    // Récupérer les paiements avec le nom du client
    public function getPaiementsWithClient()
    {
        return $this->db->table('paiements_solaire p')
            ->select('p.*, c.nom_client as client_nom, c.telephone as client_tel')
            ->join('clients_solaire c', 'c.id = p.client_id')
            ->orderBy('date_paiement', 'DESC')
            ->get()
            ->getResultArray();
    }
}
