<?php
$session = session();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Ventes Produits | ODC STORE</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
<style>
.content { margin-left:220px; margin-top:70px; padding:20px; }
@media(max-width:992px){ .content { margin-left:0; margin-top:70px; } }
</style>
</head>
<body>
<?= $this->include('templates/navbar') ?>
<?= $this->include('templates/sidebar') ?>
<div class="content">
    <div class="container-fluid mt-4">
        <h2 class="mb-4"><?= esc($page_title) ?></h2>

        <div class="card shadow-sm">
            <div class="card-header bg-orange text-white fw-bold">
                Historique des ventes
            </div>
            <div class="card-body p-0">
                <table class="table table-striped table-hover m-0">
                    <thead class="table-dark">
                        <tr>
                            <th>Référence Vente</th>
                            <th>Client</th>
                            <th>Responsable</th>
                            <th>Date</th>
                            <th>Total (€)</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if($ventes && count($ventes) > 0): ?>
                            <?php foreach($ventes as $v): ?>
                            <tr>
                                <td><?= esc($v->reference_vente) ?></td>
                                <td><?= esc($v->nom_client) ?></td>
                                <td><?= esc($v->responsable) ?></td>
                                <td><?= date('d/m/Y H:i', strtotime($v->date_vente)) ?></td>
                                <td><?= number_format($v->total,2) ?></td>
                                <td>
                                    <a href="<?= base_url('produits/recap/'.$v->reference_vente) ?>" 
                                    target="_blank" 
                                    class="btn btn-sm btn-info">
                                    <i class="fas fa-eye"></i> Voir
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" class="text-center">Aucune vente trouvée</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<style>
.table td, .table th { vertical-align: middle; }
.bg-orange { background-color: #FF8C42 !important; }
@media (max-width:768px){
    .table thead { display:none; }
    .table tr { display:block; margin-bottom:15px; }
    .table td { display:flex; justify-content:space-between; padding:8px; border:none; border-bottom:1px solid #dee2e6; }
    .table td::before { content: attr(data-label); font-weight:bold; }
}
</style>



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
