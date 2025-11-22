<?php

namespace App\Models;
use CodeIgniter\Model;

class VenteModel extends Model
{
    protected $table      = 'ventes';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'reference_vente', 'produit_id', 'quantite', 'nom_client', 'responsable', 'date_vente'
    ];

    /**
     * Récupère les ventes groupées par référence et nom client
     */
    public function getVentesGrouped()
    {
        $builder = $this->db->table('ventes v');
        
        // Selection des colonnes nécessaires
        $builder->select('
            v.reference_vente, 
            v.nom_client, 
            v.responsable, 
            v.date_vente, 
            SUM(p.prix_vente * v.quantite) AS total
        ');
        
        // Jointure avec la table produits pour calcul du total
        $builder->join('produits p', 'p.id = v.produit_id', 'left');
        
        // Groupement par référence_vente et nom_client
        $builder->groupBy('v.reference_vente, v.nom_client, v.responsable, v.date_vente');
        
        // Tri décroissant par date
        $builder->orderBy('v.date_vente', 'DESC');

        // Retourne le résultat sous forme d'objets
        return $builder->get()->getResult();
    }

    /**
     * Récupère tous les produits pour une référence de vente (pour le récapitulatif)
     */
    public function getVenteDetails($reference_vente)
    {
        $builder = $this->db->table('ventes v');
        $builder->select('v.*, p.nom AS nom_produit, p.prix_vente');
        $builder->join('produits p', 'p.id = v.produit_id', 'left');
        $builder->where('v.reference_vente', $reference_vente);
        return $builder->get()->getResult();
    }
}
