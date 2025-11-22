<?php
namespace App\Controllers;

use App\Models\ClientSolaireModel;
use App\Models\PaiementSolaireModel;
use App\Models\JournalCaisseModel;

class ClientSolaire extends BaseController
{
    protected $clientModel;
    protected $paiementModel;
    protected $journalModel;

    public function __construct()
    {
        $this->clientModel   = new ClientSolaireModel();
        $this->paiementModel = new PaiementSolaireModel();
        $this->journalModel  = new JournalCaisseModel();
    }

    // -----------------------------
    // Liste des clients
    // -----------------------------
    public function index()
    {
        $data['clients'] = $this->clientModel->findAll();
        return view('clients_solaire/index', $data);
    }

    // -----------------------------
    // Formulaire création client
    // -----------------------------
    public function create()
    {
        return view('clients_solaire/create');
    }

    // -----------------------------
    // Enregistrement client
    // -----------------------------
    public function store()
    {
        $responsable = session()->get('user_nom') ?? 'Admin';
        $date_debut = date('Y-m-d');
        $prochaine = date('Y-m-d', strtotime('+1 month'));

        $this->clientModel->insert([
            'nom_client'        => $this->request->getPost('nom_client'),
            'telephone'         => $this->request->getPost('telephone'),
            'adresse'           => $this->request->getPost('adresse'),
            'type_kit'          => $this->request->getPost('type_kit'),
            'prix_total'        => $this->request->getPost('prix_total'),
            'montant_mensuel'   => $this->request->getPost('montant_mensuel'),
            'nombre_mois'       => $this->request->getPost('nombre_mois'),
            'date_debut'        => $date_debut,
            'prochaine_echeance'=> $prochaine,
            'mois_restants'     => $this->request->getPost('nombre_mois'),
            'total_paye'        => 0,
            'reste'             => $this->request->getPost('nombre_mois'),
            'responsable'       => $responsable
        ]);

        return redirect()->to('/clients-solaire');
    }

    // -----------------------------
    // Page détails + paiements
    // -----------------------------
    public function show($id)
    {
        $client = $this->clientModel->find($id);
        $paiements = $this->paiementModel->where('client_id', $id)->findAll();

        return view('clients_solaire/show', [
            'client'    => $client,
            'paiements' => $paiements
        ]);
    }

    // -----------------------------
    // Ajouter un paiement
    // -----------------------------
    public function addPaiement()
    {
        $session = session();
        $client_id = $this->request->getPost('client_id');
        $montant   = $this->request->getPost('montant');
        $mois_paye = $this->request->getPost('mois_paye');
        $responsable = $session->get('user_nom') ?? 'Admin';
        $date_paiement = date('Y-m-d H:i:s');

        // 🔹 Enregistrer paiement
        $paiement_id = $this->paiementModel->insert([
            'client_id'     => $client_id,
            'montant'       => $montant,
            'mois_paye'     => $mois_paye,
            'date_paiement' => $date_paiement,
            'responsable'   => $responsable
        ]);

        // 🔹 Mettre à jour le client (total payé et reste)
        $client = $this->clientModel->find($client_id);
        $total_paye = ($client['total_paye'] ?? 0) + $montant;
        $reste = ($client['prix_total'] ?? 0) - $total_paye;
        $mois_restants = ceil($reste / $client['montant_mensuel']);

        $this->clientModel->update($client_id, [
            'total_paye'    => $total_paye,
            'reste'         => $reste,
            'mois_restants' => $mois_restants,
            'prochaine_echeance' => date('Y-m-d', strtotime('+1 month'))
        ]);

        // 🔹 Ajouter au journal de caisse
        $this->journal_add($client_id, $montant, $responsable, $mois_paye, $date_paiement);

        return redirect()->back()->with('success', 'Paiement enregistré.');
    }

    // -----------------------------
    // Journal de caisse pour paiement client
    // -----------------------------
    private function journal_add($client_id, $montant, $responsable, $mois_paye, $date_paiement)
    {
        $client = $this->clientModel->find($client_id);
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
