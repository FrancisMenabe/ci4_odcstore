<?php

use App\Models\JournalCaisseModel;

function journal_add($source, $refId, $libelle, $type, $montant, $responsable)
{
    $journal = new JournalCaisseModel();

    $journal->insert([
        'source'        => $source,              // ex : vente
        'reference_id'  => $refId,               // ID vente
        'libelle'       => $libelle,             // "Vente du produit X"
        'type'          => $type,                // entree ou sortie
        'montant'       => $montant,
        'responsable'   => $responsable,
        'date_operation'=> date('Y-m-d H:i:s')
    ]);
}
