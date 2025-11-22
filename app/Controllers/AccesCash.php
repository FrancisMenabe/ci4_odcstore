<?php

namespace App\Controllers;

use App\Models\AccesCashModel;
use App\Models\JournalCaisseModel; // Nouveau modèle pour le journal
use CodeIgniter\Controller;

class AccesCash extends BaseController
{
    protected $accesCash;
    protected $journalCaisse;

    public function __construct()
    {
        $this->accesCash = new AccesCashModel();
        $this->journalCaisse = new JournalCaisseModel(); // Initialisation du journal
        date_default_timezone_set('Indian/Antananarivo');
    }

    // -----------------------------
    // Formulaire Nouvelle Opération
    // -----------------------------
    public function create()
    {
        return view('accescash/new');
    }

    // -----------------------------
    // Enregistrer une opération
    // -----------------------------
    public function store()
    {
        $session = session();

        $data = [
            'type_operation' => $this->request->getPost('type_operation'),
            'nom_client'     => $this->request->getPost('nom_client'),
            'montant'        => $this->request->getPost('montant'),
            'compte'         => $this->request->getPost('compte'),
            'ref_transaction'=> $this->request->getPost('ref_transaction'),
            'motif'          => $this->request->getPost('motif'),
            'date_operation' => date("Y-m-d H:i:s"),
            'responsable'    => $session->get('user_nom') ?? 'Inconnu'
        ];

        // 🔶 Validation simple
        if (!$this->validate([
            'type_operation' => 'required',
            'nom_client'     => 'required',
            'montant'        => 'required|numeric',
            'compte'         => 'required',
            'ref_transaction'=> 'required'
        ])) {
            return redirect()->back()->with('error', 'Veuillez remplir tous les champs obligatoires.');
        }

        // 🔶 Enregistrement
        $this->accesCash->save($data);

        // 🔶 Ajouter l'opération dans le journal de caisse
        $this->journal_add($data);

        return redirect()->to(base_url('accescash/liste'))
                         ->with('success', 'Opération enregistrée avec succès.');
    }

    // -----------------------------
    // Ajouter dans le journal de caisse
    // -----------------------------
    private function journal_add($data)
    {
        $libelle = "AccèsCash - Client: {$data['nom_client']}";

        $this->journalCaisse->save([
            'source'       => 'AccèsCash',
            'libelle'      => $libelle,
            'montant'      => $data['montant'],
            'type'         => $data['type_operation'], // Entrée / Sortie
            'responsable'  => $data['responsable'],
            'date_journal' => $data['date_operation'],
            'reference'    => $data['ref_transaction']
        ]);
    }

    // -----------------------------
    // Liste des opérations
    // -----------------------------
    public function index()
    {
        $data['operations'] = $this->accesCash
            ->orderBy('id', 'DESC')
            ->findAll();

        return view('accescash/liste', $data);
    }

    // -----------------------------
    // Supprimer une opération
    // -----------------------------
    public function delete($id)
    {
        $this->accesCash->delete($id);

        return redirect()->to(base_url('accescash/liste'))
                         ->with('success', 'Opération supprimée.');
    }
}
