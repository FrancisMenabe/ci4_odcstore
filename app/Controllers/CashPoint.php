<?php

namespace App\Controllers;

use App\Models\CashPointModel;
use App\Models\JournalCaisseModel;

class CashPoint extends BaseController
{
    protected $cashPointModel;
    protected $journalModel;

    public function __construct()
    {
        $this->cashPointModel = new CashPointModel();
        $this->journalModel  = new JournalCaisseModel();
        date_default_timezone_set('Indian/Antananarivo');
    }

    // -----------------------------
    // Liste des opérations CashPoint
    // -----------------------------
    public function index()
    {
        $data['operations'] = $this->cashPointModel->orderBy('date_operation', 'DESC')->findAll();
        $data['page_title'] = 'Historique CashPoint';
        return view('cashpoint/index', $data);
    }

    // -----------------------------
    // Formulaire nouvelle opération
    // -----------------------------
    public function create()
    {
        $data['page_title'] = 'Nouvelle Opération CashPoint';
        return view('cashpoint/create', $data);
    }

    // -----------------------------
    // Enregistrer l'opération
    // -----------------------------
    public function store()
    {
        $session = session();
        $responsable = $session->get('user_nom') ?? 'Inconnu';

        $data = [
            'type_operation' => $this->request->getPost('type_operation'),
            'nom_client'     => $this->request->getPost('nom_client'),
            'nom_beneficier' => $this->request->getPost('nom_beneficier'),
            'telephone'      => $this->request->getPost('telephone'),
            'montant'        => $this->request->getPost('montant'),
            'frais'          => $this->request->getPost('frais'),
            'date_operation' => $this->request->getPost('date_operation') ?: date('Y-m-d H:i:s'),
            'responsable'    => $responsable,
        ];

        // 🔹 Enregistrement dans CashPoint
        $this->cashPointModel->save($data);

        // 🔹 Enregistrement dans le journal de caisse
        $this->journal_add($data);

        return redirect()->to('/cashpoint/liste')->with('success', 'Opération enregistrée avec succès.');
    }

    // -----------------------------
    // Supprimer une opération
    // -----------------------------
    public function delete($id)
    {
        $this->cashPointModel->delete($id);
        return redirect()->to('/cashpoint/liste')->with('success', 'Opération supprimée avec succès.');
    }

    // -----------------------------
    // Ajouter l'opération au journal
    // -----------------------------
    private function journal_add($data)
    {
        $libelle = "CashPoint - Client: {$data['nom_client']}";

        $this->journalModel->save([
            'source'       => 'CashPoint',
            'libelle'      => $libelle,
            'montant'      => $data['montant'],
            'type'         => $data['type_operation'], // Entrée ou Sortie
            'responsable'  => $data['responsable'],
            'date_journal' => $data['date_operation'],
        ]);
    }
}
