<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Liste des Clients Kits Solaires | ODC STORE</title>

<!-- Bootstrap -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">

<style>
    body { background: #f8f9fa; }
    .content { margin-left:220px; margin-top:70px; padding:20px; }
    @media(max-width:992px){ .content { margin-left:0; margin-top:70px; } }
    .btn-orange { background:#ff8c42; color:#fff; }
    .btn-orange:hover { background:#ff9f61; }
    table th, table td { vertical-align: middle; }
    .table-wrapper { overflow-x:auto; }
</style>
</head>
<body>

<?= view('templates/sidebar') ?>
<?= view('templates/navbar') ?>

<div class="content">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Liste des Clients Kits Solaires</h2>
        <a href="<?= base_url('clients-solaire/new') ?>" class="btn btn-orange">
            <i class="fa-solid fa-plus"></i> Nouveau Client
        </a>
    </div>

    <div class="table-wrapper">
        <table id="clientsTable" class="table table-bordered table-hover bg-white">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Nom</th>
                    <th>Téléphone</th>
                    <th>Adresse</th>
                    <th>Type Kit</th>
                    <th>Montant Mensuel</th>
                    <th>Date Inscription</th>
                    <th>Prochaine Échéance</th>
                </tr>
            </thead>
            <tbody>
            <?php if(!empty($clients)): ?>
                <?php foreach($clients as $c): ?>
                <tr>
                    <td><?= $c['id'] ?></td>
                    <td><?= $c['nom_client'] ?></td>
                    <td><?= $c['telephone'] ?></td>
                    <td><?= $c['adresse'] ?></td>
                    <td><?= $c['type_kit'] ?></td>
                    <td><?= number_format($c['montant_mensuel'], 0, ',', ' ') ?> Ar</td>
                    <td><?= date('d/m/Y', strtotime($c['date_debut'])) ?></td>
                    <td><?= date('d/m/Y', strtotime($c['prochaine_echeance'])) ?></td>
                </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="8" class="text-center text-muted">Aucun client enregistré.</td>
                </tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

<script>
$(document).ready(function() {
    $('#clientsTable').DataTable({
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.13.6/i18n/fr-FR.json"
        },
        "order": [[6, "desc"]], // Trier par date d'inscription décroissante
        "pageLength": 10,
        "lengthMenu": [5, 10, 25, 50]
    });
});
</script>

</body>
</html>
