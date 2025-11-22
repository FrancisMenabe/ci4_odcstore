<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Nouveau Paiement | ODC STORE</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
<style>
.content { margin-left:220px; margin-top:70px; padding:20px; }
@media(max-width:992px){ .content { margin-left:0; margin-top:70px; } }
.btn-orange { background:#ff8c42; color:#fff; }
.btn-orange:hover { background:#ff9f61; }
</style>
</head>
<body>
<?= view('templates/sidebar') ?>
<?= view('templates/navbar') ?>

<div class="content">
    <h2>Nouveau Paiement</h2>
    <form action="<?= base_url('/paiements-solaire/store') ?>" method="post">
        <div class="row g-3 mb-3">
            <div class="col-md-6">
                <label class="form-label">Client</label>
                <select name="client_id" class="form-control" required>
                    <option value="">— Sélectionner —</option>
                    <?php foreach($clients as $c): ?>
                        <option value="<?= $c['id'] ?>">
                            <?= $c['nom_client'] ?> — <?= $c['telephone'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="col-md-6">
                <label class="form-label">Mois Payé</label>
                <input type="month" name="mois_paye" class="form-control" required>
            </div>

            <div class="col-md-6">
                <label class="form-label">Montant</label>
                <input type="number" step="0.01" name="montant" class="form-control" required>
            </div>

            <div class="col-md-6">
                <label class="form-label">Référence Transaction</label>
                <input type="text" name="ref_transaction" class="form-control" placeholder="Optionnel">
            </div>
        </div>

        <button type="submit" class="btn btn-orange"><i class="fa-solid fa-save"></i> Enregistrer</button>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
