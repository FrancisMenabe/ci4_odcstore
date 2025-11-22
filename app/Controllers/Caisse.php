<?php

namespace App\Controllers;

use App\Models\CaisseModel;
use App\Models\JournalCaisseModel;

class Caisse extends BaseController
{
    protected $caisseModel;
    protected $journalModel;

    public function __construct()
    {
        $this->caisseModel = new CaisseModel();
        $this->journalModel = new JournalCaisseModel();
    }

    // Page principale : historique + fond de roulement
    public function index()
    {
        $data = [
            'page_title'      => 'Historique Caisse',
            'fond_roulement'  => $this->calculFondRoulement(),
            'caisse'          => $this->caisseModel->orderBy('date_operation', 'DESC')->findAll(),
        ];

        return view('caisse/index', $data);
    }

    // Formulaire création opération
    public function create()
    {
        $data = [
            'page_title' => 'Nouvelle Opération',
        ];

        return view('caisse/create', $data);
    }

    // Sauvegarde
    public function store()
    {
        $session = session();
        $responsable = $session->get('user_nom') ?? 'Inconnu';

        $data = [
            'type'          => $this->request->getPost('type'),
            'montant'       => $this->request->getPost('montant'),
            'categorie'     => $this->request->getPost('categorie'),
            'description'   => $this->request->getPost('description'),
            'date_operation'=> $this->request->getPost('date_operation') ?: date('Y-m-d H:i:s'),
            'responsable'   => $responsable,
        ];

        // Sauvegarde de l'opération dans la caisse
        $this->caisseModel->save($data);

        // 🔹 Ajouter l'opération dans le journal
        $this->journal_add($data);

        return redirect()->to('/caisse');
    }

    // Fonction qui calcule le fond de roulement réel
    private function calculFondRoulement()
    {
        $entrees = (clone $this->caisseModel)
            ->selectSum('montant')
            ->where('type', 'Entrée')
            ->first()['montant'];

        $sorties = (clone $this->caisseModel)
            ->selectSum('montant')
            ->where('type', 'Sortie')
            ->first()['montant'];

        return ($entrees ?? 0) - ($sorties ?? 0);
    }

    // 🔹 Méthode pour ajouter au journal
    private function journal_add($data)
    {
        
        $this->journalModel->save([
            'source'       => 'Caisse',
            'libelle'      => $data['description'],
            'montant'      => $data['montant'],
            'type'         => $data['type'],  // Entrée ou Sortie
            'responsable'  => $data['responsable'],
            'date_journal' => $data['date_operation'],
        ]);
    }
}
