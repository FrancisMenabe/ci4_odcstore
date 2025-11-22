<?php
namespace App\Controllers;

use App\Models\ClientSolaireModel;
use App\Models\PaiementSolaireModel;
use App\Models\JournalCaisseModel;

class PaiementSolaire extends BaseController
{
    protected $clientsModel;
    protected $paiementsModel;
    protected $journalModel;

    public function __construct()
    {
        $this->clientsModel = new ClientSolaireModel();
        $this->paiementsModel = new PaiementSolaireModel();
        $this->journalModel  = new JournalCaisseModel();
    }

    // Liste des paiements
    public function index()
    {
        $data['paiements'] = $this->paiementsModel->getPaiementsWithClient();
        $data['page_title'] = 'Paiements Kits Solaires';
        return view('paiements_solaire/index', $data);
    }

    // Formulaire nouveau paiement
    public function create()
    {
        $data['clients'] = $this->clientsModel->findAll();
        $data['page_title'] = 'Ajouter Paiement';
        return view('paiements_solaire/create', $data);
    }

    // Enregistrer paiement
    public function store()
    {
        $client_id = $this->request->getPost('client_id');
        $montant = $this->request->getPost('montant');
        $ref = $this->request->getPost('ref_transaction');
        $mois_paye = $this->request->getPost('mois_paye');
        $responsable = session()->get('user_nom') ?? 'Admin';
        $date_paiement = date('Y-m-d H:i:s');

        // 🔹 Enregistrement du paiement
        $this->paiementsModel->save([
            'client_id'       => $client_id,
            'montant'         => $montant,
            'ref_transaction' => $ref,
            'mois_paye'       => $mois_paye,
            'responsable'     => $responsable,
            'date_paiement'   => $date_paiement
        ]);

        // 🔹 Ajouter automatiquement au journal de caisse
        $this->journal_add($client_id, $montant, $responsable, $mois_paye, $date_paiement);

        return redirect()->to('/paiements-solaire')
                         ->with('success', 'Paiement enregistré avec succès.');
    }

    // Supprimer paiement
    public function delete($id)
    {
        $this->paiementsModel->delete($id);
        return redirect()->to('/paiements-solaire')
                         ->with('success', 'Paiement supprimé.');
    }

    // -----------------------------
    // Journal de caisse pour paiement
    // -----------------------------
    private function journal_add($client_id, $montant, $responsable, $mois_paye, $date_paiement)
    {
        $client = $this->clientsModel->find($client_id);
        $libelle = "Paiement Client Solaire: {$client['nom_client']} — Mois: {$mois_paye}";

        $this->journalModel->save([
            'source'       => 'Paiement Solaire',
            'libelle'      => $libelle,
            'montant'      => $montant,
            'type'         => 'Entrée',
            'responsable'  => $responsable,
            'date_journal' => $date_paiement
        ]);
    }
}
