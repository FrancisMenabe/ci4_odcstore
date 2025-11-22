<?php

namespace App\Controllers;

use App\Models\JournalCaisseModel;

class JournalCaisse extends BaseController
{
    protected $journalModel;

    public function __construct()
    {
        $this->journalModel = new JournalCaisseModel();
        date_default_timezone_set('Indian/Antananarivo');
    }

    /**
     * Page principale : journal de caisse avec filtre entre deux dates
     */
    public function index()
    {
        $start = $this->request->getGet('start_date');
        $end   = $this->request->getGet('end_date');

        if ($start && $end) {
            $start_date = $start . ' 00:00:00';
            $end_date   = $end   . ' 23:59:59';

            $journal = $this->journalModel
                ->where('date_operation >=', $start_date)
                ->where('date_operation <=', $end_date)
                ->orderBy('date_operation', 'DESC')
                ->findAll();

            $filter_active = true;
        } else {
            $journal = $this->journalModel
                ->orderBy('date_operation', 'DESC')
                ->findAll();

            $filter_active = false;
        }

        // 🔹 Calculer les totaux filtrés
        $totalEntrees = 0;
        $totalSorties = 0;
        $totalMouvements = 0;

        foreach ($journal as $op) {
            $type = strtolower($op['type']); // normaliser
            if ($type === 'entrée' || $type === 'entree') $totalEntrees += $op['montant'];
            elseif ($type === 'sortie') $totalSorties += $op['montant'];
            else $totalMouvements += $op['montant'];
        }

        $solde = $totalEntrees - $totalSorties + $totalMouvements;

        $data = [
            'journal'         => $journal,
            'filter_active'   => $filter_active,
            'start_date'      => $start ?? '',
            'end_date'        => $end ?? '',
            'totalEntrees'    => $totalEntrees,
            'totalSorties'    => $totalSorties,
            'totalMouvements' => $totalMouvements,
            'solde'           => $solde,
            'page_title'      => 'Journal de Caisse'
        ];

        return view('journal/index', $data);
    }

    /**
     * Ajouter une opération dans le journal
     */
    public function journal_add($type, $libelle, $montant, $responsable = null)
    {
        $responsable = $responsable ?? (session()->get('user_nom') ?? 'Admin');

        $this->journalModel->save([
            'type'           => $type,
            'libelle'        => $libelle,
            'montant'        => $montant,
            'responsable'    => $responsable,
            'date_operation' => date('Y-m-d H:i:s')
        ]);

        return true;
    }
}
