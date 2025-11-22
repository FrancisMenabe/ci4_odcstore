<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Détails Client | ODC STORE</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

<style>
.content { margin-left:220px; margin-top:70px; padding:20px; }
@media(max-width:992px){ .content { margin-left:0; margin-top:70px; } }

.card-info {
    border-radius: 15px;
    padding: 20px;
    background: #fff;
    box-shadow: 0 4px 15px rgba(0,0,0,0.05);
}
</style>
</head>
<body>

<?= view('templates/sidebar') ?>
<?= view('templates/navbar') ?>

<div class="content">

    <h3 class="fw-bold">Détails du Client</h3>

    <div class="card card-info mb-4">
        <h5 class="mb-3"><?= esc($client['nom_client']) ?></h5>

        <p><strong>Téléphone :</strong> <?= esc($client['telephone']) ?></p>
        <p><strong>Adresse :</strong> <?= esc($client['adresse']) ?></p>
        <p><strong>Kit :</strong> <?= esc($client['type_kit']) ?></p>
        <p><strong>Prix total :</strong> <?= esc($client['prix_total']) ?> Ar</p>
        <p><strong>Mensualité :</strong> <?= esc($client['montant_mensuel']) ?> Ar</p>
        <p><strong>Nombre de mois :</strong> <?= esc($client['nombre_mois']) ?></p>
        <p><strong>Début :</strong> <?= esc($client['date_debut']) ?></p>
        <p><strong>Prochaine échéance :</strong> <?= esc($client['prochaine_echeance']) ?></p>
        <p><strong>Retard :</strong> <?= esc($client['retard_jours']) ?> jours</p>
    </div>

    <h4>Paiements effectués</h4>

    <table class="table table-bordered table-hover">
        <thead class="table-light">
            <tr>
                <th>Mois payé</th>
                <th>Montant</th>
                <th>Date paiement</th>
                <th>Responsable</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach($paiements as $p): ?>
            <tr>
                <td><?= $p['mois_paye'] ?></td>
                <td><?= $p['montant'] ?> Ar</td>
                <td><?= $p['date_paiement'] ?></td>
                <td><?= $p['responsable'] ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
