<?php

namespace App\Controllers;

use App\Models\ProduitModel;
use App\Models\VenteModel;

class Produits extends BaseController
{
    protected $produitModel;
    protected $venteModel;

    public function __construct()
    {
        $this->produitModel = new ProduitModel();
        $this->venteModel = new VenteModel();
        helper('form'); // si tu utilises form helper
    }

    // ---------------------------
    // Liste des produits
    // ---------------------------
    public function index()
    {
        $data['produits'] = $this->produitModel->findAll();
        $data['page_title'] = 'Produits';
        return view('produits/index', $data);
    }

    // ---------------------------
    // Formulaire ajout produit
    // ---------------------------
    public function create()
    {
        $data['page_title'] = 'Entrer produit';
        return view('produits/create', $data);
    }

    // ---------------------------
    // Enregistrer produit
    // ---------------------------
    public function store()
    {
        $session = session();

        $this->produitModel->save([
            'reference'    => $this->request->getPost('reference'),
            'nom'          => $this->request->getPost('nom'),
            'quantite'     => $this->request->getPost('quantite'),
            'prix_achat'   => $this->request->getPost('prix_achat'),
            'prix_vente'   => $this->request->getPost('prix_vente'),
            'description'  => $this->request->getPost('description'),
            'fournisseur'  => $this->request->getPost('fournisseur'),
            'responsable'  => $session->get('user_nom') ?? 'Inconnu',
            'date_creation'=> date('Y-m-d H:i:s')
        ]);

        return redirect()->to('/produits');
    }

     // ---------------------------
    // update produit
    // ---------------------------
    public function update($id)
    {
        $session = session();

        $this->produitModel->update($id, [
            'reference'   => $this->request->getPost('reference'),
            'nom'         => $this->request->getPost('nom'),
            'quantite'    => $this->request->getPost('quantite'),
            'prix_achat'  => $this->request->getPost('prix_achat'),
            'prix_vente'  => $this->request->getPost('prix_vente'),
            'description' => $this->request->getPost('description'),
            'fournisseur' => $this->request->getPost('fournisseur'),
            'responsable' => $session->get('user_nom') ?? 'Inconnu'
        ]);

        return redirect()->to('/produits');
    }

     // ---------------------------
    // delete produit
    // ---------------------------
    public function delete($id)
{
    // Vérifier si le produit existe
    $produit = $this->produitModel->find($id);
    if (!$produit) {
        return redirect()->to('/produits')->with('error', 'Produit introuvable.');
    }

    // Supprimer le produit
    $this->produitModel->delete($id);

    return redirect()->to('/produits')->with('success', 'Produit supprimé avec succès.');
}

    // ---------------------------
    // Page ventes (formulaire)
    // ---------------------------
// Page formulaire ventes
    public function ventes()
    {
        $data['produits'] = $this->produitModel->findAll();
        $data['page_title'] = 'Ventes';
        return view('produits/ventes', $data);
    }

    // Enregistrer une vente
    public function storeVente()
    {
        $session = session();

        $nom_client = $this->request->getPost('nom_client');
        $produits = $this->request->getPost('produit_id');
        $quantites = $this->request->getPost('quantite');

        if(empty($nom_client) || empty($produits) || empty($quantites)) {
            return redirect()->back()->with('error', 'Veuillez remplir tous les champs.');
        }

        $reference_vente = 'VENTE-' . date('YmdHis');

        foreach($produits as $index => $prod_id) {
            $qte = (int)$quantites[$index];
            if($qte <= 0) continue;

            $produit = $this->produitModel->find($prod_id);
            if(!$produit) continue;

            // Définir le fuseau horaire pour Madagascar
            date_default_timezone_set('Indian/Antananarivo');
            // Enregistrer la vente
            $this->venteModel->save([
                'reference_vente' => $reference_vente,
                'produit_id'      => $prod_id,
                'quantite'        => $qte,
                'nom_client'      => $nom_client,
                'responsable'     => $session->get('user_nom') ?? 'Inconnu',
                'date_vente'      => date('Y-m-d H:i:s')  // <-- ajoute la date et l'heure actuelles
            ]);

            // Mise à jour du stock
            $this->produitModel->update($prod_id, [
                'quantite' => $produit['quantite'] - $qte
            ]);
        }

        return redirect()->to('/ventes/recap/'.$reference_vente);
    }

    // Page récapitulatif d’une vente
    public function recap($reference_vente)
    {
        $builder = $this->venteModel->db->table('ventes v');
        $builder->select('v.*, p.nom as nom_produit, p.prix_vente, p.reference as ref_produit');
        $builder->join('produits p', 'p.id = v.produit_id');
        $builder->where('v.reference_vente', $reference_vente);
        $ventes = $builder->get()->getResult();

        $data['ventes'] = $ventes;
        $data['page_title'] = 'Reçu Vente';
        return view('produits/recap', $data);
    }

    
}
