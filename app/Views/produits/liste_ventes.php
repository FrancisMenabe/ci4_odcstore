<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Liste Ventes | ODC STORE</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
<style>
.content { margin-left:220px; margin-top:70px; padding:20px; }
@media(max-width:992px){ .content { margin-left:0; margin-top:70px; } }
</style>
</head>
<body>
<?= view('templates/sidebar') ?>
<?= view('templates/navbar') ?>

<div class="content">
    <h2>Liste des Ventes</h2>

    <table class="table table-bordered table-hover">
        <thead class="table-light">
            <tr>
                <th>Référence Vente</th>
                <th>Nom Client</th>
                <th>Total Produits</th>
                <th>Date Dernière Vente</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach($ventes as $vente): ?>
            <tr>
                <td><?= $vente->reference_vente ?></td>
                <td><?= $vente->nom_client ?></td>
                <td><?= $vente->total_produit ?></td>
                <td><?= date('d/m/Y H:i', strtotime($vente->date_dernier)) ?></td>
                <td>
                    <a href="<?= base_url('/produits/recap/'.$vente->reference_vente) ?>" class="btn btn-sm btn-success">
                        <i class="fa-solid fa-file-invoice"></i> Reçu
                    </a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
