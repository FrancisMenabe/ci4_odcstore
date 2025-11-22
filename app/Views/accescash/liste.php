<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Liste opérations | AccèsCash</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
<style>
.content { margin-left:220px; margin-top:70px; padding:20px; }
.btn-orange { background:#ff8c42; color:#fff; }
.table-hover tbody tr:hover { background:#ffe6cc; }
@media(max-width:992px){ .content { margin-left:0; margin-top:70px; } }
</style>
</head>
<body>
<?= view('templates/sidebar') ?>
<?= view('templates/navbar') ?>

<div class="content">
    <h2>Historique AccèsCash</h2>
    <a href="<?= base_url('/accescash/new') ?>" class="btn btn-orange mb-3"><i class="fa-solid fa-plus"></i> Nouvelle opération</a>

    <table class="table table-bordered table-hover">
        <thead class="table-light">
            <tr>
                <th>#</th>
                <th>Type</th>
                <th>Client</th>
                <th>Montant</th>
                <th>Compte</th>
                <th>Référence</th>
                <th>Motif</th>
                <th>Date</th>
                <th>Responsable</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach($operations as $op): ?>
            <tr>
                <td><?= $op['id'] ?></td>
                <td><?= ucfirst($op['type_operation']) ?></td>
                <td><?= $op['nom_client'] ?></td>
                <td><?= number_format($op['montant'],2) ?></td>
                <td><?= $op['compte'] ?></td>
                <td><?= $op['ref_transaction'] ?></td>
                <td><?= $op['motif'] ?></td>
                <td><?= date('d/m/Y H:i', strtotime($op['date_operation'])) ?></td>
                <td><?= $op['responsable'] ?></td>
                <td>
                    <form action="<?= base_url('/accescash/delete/'.$op['id']) ?>" method="post" style="display:inline;">
                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Voulez-vous supprimer cette opération ?')">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
