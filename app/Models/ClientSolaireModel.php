<?php
namespace App\Models;

use CodeIgniter\Model;

class ClientSolaireModel extends Model
{
    protected $table = 'clients_solaire';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'nom_client', 'telephone', 'adresse',
        'type_kit', 'prix_total', 'montant_mensuel',
        'nombre_mois', 'date_debut', 'prochaine_echeance',
        'retard_jours', 'responsable', 'date_inscription'
    ];

    // On désactive les timestamps automatiques car on a date_inscription
    protected $useTimestamps = false;

    /**
     * Met à jour les jours de retard pour tous les clients
     */
    public function updateRetard()
    {
        $clients = $this->findAll();
        foreach ($clients as $client) {
            $today = new \DateTime();
            $echeance = new \DateTime($client['prochaine_echeance']);
            $diff = $today->diff($echeance);
            $retard = ($today > $echeance) ? $diff->days : 0;
            $this->update($client['id'], ['retard_jours' => $retard]);
        }
    }
}
