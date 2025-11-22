<?php

namespace App\Controllers;

use App\Models\JournalCaisseModel;

class Dashboard extends BaseController
{
    protected $journal;

    public function __construct()
    {
        $this->journal = new JournalCaisseModel();
    }

    // 📌 Page dashboard avec graphique
    public function index()
    {
        // ⏱ Valeur par défaut = données du jour
        $filter = $this->request->getGet('filter') ?? 'day';

        switch ($filter) {
            case 'week':
                $start = date('Y-m-d 00:00:00', strtotime('monday this week'));
                $end   = date('Y-m-d 23:59:59', strtotime('sunday this week'));
                break;

            case 'month':
                $start = date('Y-m-01 00:00:00');
                $end   = date('Y-m-t 23:59:59');
                break;

            default: // day
                $start = date('Y-m-d 00:00:00');
                $end   = date('Y-m-d 23:59:59');
        }

        // 📌 Récupérer statistiques réelles
        $stats = $this->journal->getStats($start, $end);

        // valeurs brutes
        $dataGraph = [
            'vente'     => 0,
            'cashpoint' => 0,
            'accescash' => 0
        ];

        foreach ($stats as $item) {
            if ($item['source'] == 'Vente') $dataGraph['vente'] = $item['total'];
            if ($item['source'] == 'CashPoint') $dataGraph['cashpoint'] = $item['total'];
            if ($item['source'] == 'AccesCash') $dataGraph['accescash'] = $item['total'];
        }

        return view('dashboard', [
            'page_title' => 'Dashboard',
            'filter' => $filter,
            'dataGraph' => $dataGraph
        ]);
    }
}
