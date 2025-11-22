<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Détails Paiement</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<?= view('templates/sidebar') ?>
<?= view('templates/navbar') ?>

<div class="container mt-5">

    <h2>Détails du Paiement</h2>

    <div class="card p-3 mt-3">
        <p><strong>Client :</strong> <?= $paiement['client_nom'] ?></p>
        <p><strong>Mois Payé :</strong> <?= date('m/Y', strtotime($paiement['mois_paye'])) ?></p>
        <p><strong>Montant :</strong> <?= number_format($paiement['montant'], 0, ',', ' ') ?> Ar</p>
        <p><strong>Date :</strong> <?= $paiement['created_at'] ?></p>
    </div>

</div>

</body>
</html>
