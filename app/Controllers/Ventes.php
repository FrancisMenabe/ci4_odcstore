<?php

namespace App\Controllers;

use App\Models\VenteModel;
use App\Models\JournalCaisseModel;
use CodeIgniter\Controller;

class Ventes extends BaseController
{
    protected $venteModel;
    protected $journalModel;
    protected $db;
    protected $session;

    public function __construct()
    {
        $this->venteModel   = new VenteModel();
        $this->journalModel = new JournalCaisseModel();
        $this->db           = \Config\Database::connect();
        $this->session      = session();
    }

    // ----------------------------------------------------------
    // Formulaire nouvelle vente
    // ----------------------------------------------------------
    public function ventes()
    {
        $produits = $this->db->table('produits')->get()->getResultArray();
        return view('ventes/new', [
            'produits'   => $produits,
            'page_title' => 'Nouvelle vente'
        ]);
    }

    // ----------------------------------------------------------
    // Liste des ventes
    // ----------------------------------------------------------
    public function index()
    {
        $data['ventes'] = $this->venteModel->getVentesGrouped();
        $data['page_title'] = 'Liste des ventes';
        return view('ventes/index', $data);
    }

    // ----------------------------------------------------------
    // Ajouter un produit acheté (vente instantanée)
    // ----------------------------------------------------------
    public function storeVente()
{
    $session = session();
    $responsable = $session->get('user_nom') ?? 'Inconnu';

    $nomClient = trim($this->request->getPost('nom_client'));
    $produitId = $this->request->getPost('produit_id');
    $quantite  = $this->request->getPost('quantite');

    if (!$nomClient || !$produitId || !$quantite) {
        return $this->response->setJSON([
            'status' => 'error',
            'message' => 'Remplissez tous les champs.'
        ]);
    }

    // ----------------------------------------------------------
    // GESTION DE LA RÉFÉRENCE CLIENT (VALIDITÉ 10 MIN)
    // ----------------------------------------------------------
    $lastClient   = $session->get('ref_client_name');
    $lastRef      = $session->get('ref_vente');
    $lastTime     = $session->get('ref_time');

    $newReference = false;

    // condition pour nouvelle référence :
    // - client différent
    // - OU plus de 10 minutes écoulées
    if (!$lastClient || $lastClient !== $nomClient || (time() - $lastTime > 600)) {
        // générer nouvelle reference
        $date = date('Ymd');
        $random = rand(100, 999);
        $lastRef = "REF{$date}-{$random}";

        // stocker pour 10 minutes
        $session->set('ref_client_name', $nomClient);
        $session->set('ref_vente',       $lastRef);
        $session->set('ref_time',        time());

        $newReference = true;
    }

    $referenceVente = $lastRef;

    // ----------------------------------------------------------
    // Récupération produit
    // ----------------------------------------------------------
    $produit = $this->db->table('produits')->where('id', $produitId)->get()->getRow();
    if (!$produit) {
        return $this->response->setJSON([
            'status' => 'error',
            'message' => 'Produit introuvable.'
        ]);
    }

    $montant = intval($quantite) * $produit->prix_vente;
    $dateVente = date('Y-m-d H:i:s');

    // Enregistrer la vente
    $venteId = $this->venteModel->insert([
        'nom_client'       => $nomClient,
        'produit_id'       => $produitId,
        'quantite'         => $quantite,
        'montant'          => $montant,
        'date_vente'       => $dateVente,
        'responsable'      => $responsable,
        'reference_vente'  => $referenceVente
    ]);

    // Journal caisse
    $libelle = "Vente - {$produit->nom} ({$quantite} × {$produit->prix_vente} Ar) - Client: {$nomClient}";
    $this->journalModel->insert([
        'source'        => 'Vente',
        'reference_id'  => $produitId,
        'libelle'       => $libelle,
        'montant'       => $montant,
        'type'          => 'Entrée',
        'responsable'   => $responsable,
        'date_operation'=> $dateVente
    ]);

    return $this->response->setJSON([
        'status' => 'success',
        'new_reference' => $newReference,
        'message' => 'Produit ajouté avec succès.',
        'data' => [
            'reference'         => $produit->reference,
            'nom'               => $produit->nom,
            'prix'              => $produit->prix_vente,
            'quantite'          => $quantite,
            'montant'           => $montant,
            'reference_vente'   => $referenceVente
        ]
    ]);
}


    // ----------------------------------------------------------
    // Reçu / récapitulatif d'une vente (par reference_vente)
    // ----------------------------------------------------------
    public function recap($referenceVente)
    {
        $ventes = $this->venteModel->where('reference_vente', $referenceVente)->findAll();
        if (!$ventes) {
            return redirect()->back()->with('error', 'Vente introuvable.');
        }

        // Récupérer détails pour affichage
        $details = [];
        foreach ($ventes as $vente) {
            $prod = $this->db->table('produits')->where('id', $vente['produit_id'])->get()->getRowArray();
            if ($prod) {
                $details[] = [
                    'nom'       => $prod['nom'],
                    'reference' => $prod['reference'],
                    'prix'      => $prod['prix_vente'],
                    'quantite'  => $vente['quantite'],
                    'montant'   => $vente['montant']
                ];
            }
        }

        return view('ventes/recap', [
            'vente'          => $ventes[0], // info client / reference_vente
            'details'        => $details,
            'referenceVente' => $referenceVente,
            'page_title'     => 'Reçu de vente'
        ]);
    }
}
