<?php

namespace App\Models;

use CodeIgniter\Model;

class ProduitModel extends Model
{
    protected $table = 'produits';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'reference','nom','quantite','prix_achat','prix_vente','description','fournisseur','responsable'
    ];
}
