<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?= $page_title ?> | ODC STORE</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">

<style>
    body { background: #f8f9fa; }
    .content { margin-left:220px; margin-top:70px; padding:20px; }
    @media(max-width:992px){ .content { margin-left:0; margin-top:70px; } }
    .btn-orange { background:#ff8c42; color:#fff; }
    .btn-orange:hover { background:#ff9f61; }
    .table-wrapper { overflow-x:auto; }
    .table th, .table td { vertical-align: middle; }
    .fond-roulement { font-size:1.2rem; font-weight:600; margin-bottom:20px; }
</style>
</head>
<body>

<?= view('templates/sidebar') ?>
<?= view('templates/navbar') ?>

<div class="content">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2><?= $page_title ?></h2>

        <!-- Correction route -->
        <a href="<?= base_url('caisse/new') ?>" class="btn btn-orange">
            <i class="fa-solid fa-plus"></i> Nouvelle Opération
        </a>
    </div>

    <div class="fond-roulement">
        Fond de roulement actuel :
        <strong><?= number_format($fond_roulement, 0, ',', ' ') ?> Ar</strong>
    </div>

    <div class="table-wrapper">
        <table id="caisseTable" class="table table-bordered table-hover bg-white">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Type</th>
                    <th>Montant</th>
                    <th>Catégorie</th>
                    <th>Description</th>
                    <th>Responsable</th>
                    <th>Date</th>
                </tr>
            </thead>

            <tbody>
                <?php if(!empty($caisse)): ?>
                    <?php foreach($caisse as $op): ?>
                    <tr>
                        <td><?= $op['id'] ?></td>
                        <td><?= ucfirst($op['type']) ?></td>
                        <td><?= number_format($op['montant'], 0, ',', ' ') ?> Ar</td>
                        <td><?= $op['categorie'] ?></td>
                        <td><?= $op['description'] ?></td>
                        <td><?= $op['responsable'] ?></td>
                        <td><?= date('d/m/Y H:i', strtotime($op['date_operation'])) ?></td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7" class="text-center text-muted">Aucune opération enregistrée.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

<script>
$(document).ready(function() {
    $('#caisseTable').DataTable({
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.13.6/i18n/fr-FR.json"
        },
        "order": [[6, "desc"]]  // tri par date
    });
});
</script>

</body>
</html>
