<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?= $page_title ?> | ODC STORE</title>
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
    <h2><?= $page_title ?></h2>

    <table class="table table-bordered table-hover">
        <thead class="table-light">
            <tr>
                <th>#</th>
                <th>Type</th>
                <th>Client</th>
                <th>Téléphone</th>
                <th>Montant</th>
                <th>Frais</th>
                <th>Responsable</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach($operations as $op): ?>
            <tr>
                <td><?= $op['id'] ?></td>
                <td><?= ucfirst($op['type_operation']) ?></td>
                <td><?= $op['nom_client'] ?></td>
                <td><?= $op['telephone'] ?></td>
                <td><?= number_format($op['montant'],2) ?> MGA</td>
                <td><?= number_format($op['frais'],2) ?> MGA</td>
                <td><?= $op['responsable'] ?></td>
                <td><?= $op['date_operation'] ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
