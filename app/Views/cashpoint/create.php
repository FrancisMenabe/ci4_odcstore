<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Nouvelle Opération | ODC STORE</title>
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
    <h2>Nouvelle Opération CashPoint</h2>
    <form action="<?= base_url('cashpoint/store') ?>" method="post">
        <div class="row g-3">
            <div class="col-md-4">
                <label class="form-label">Type d'opération</label>
                <select name="type_operation" class="form-select" required>
                    <option value="">Sélectionner</option>
                    <option value="depot">Dépôt</option>
                    <option value="retrait">Retrait</option>
                    <option value="transfert">Transfert</option>
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label">Nom du client</label>
                <input type="text" name="nom_client" class="form-control" required>
            </div>
            <div class="col-md-4">
                <label class="form-label">Nom du bénéficiaire</label>
                <input type="text" name="nom_beneficier" class="form-control">
            </div>
            <div class="col-md-4">
                <label class="form-label">Téléphone</label>
                <input type="text" name="telephone" class="form-control">
            </div>
            <div class="col-md-4">
                <label class="form-label">Montant</label>
                <input type="number" step="0.01" name="montant" class="form-control" required>
            </div>
            <div class="col-md-4">
                <label class="form-label">Frais</label>
                <input type="number" step="0.01" name="frais" class="form-control">
            </div>
            <div class="col-md-4">
                <label class="form-label">Date de l'opération</label>
                <input type="datetime-local" name="date_operation" class="form-control" value="<?= date('Y-m-d\TH:i') ?>" required>
            </div>
        </div>

        <div class="mt-3">
            <button type="submit" class="btn btn-orange"><i class="fa-solid fa-floppy-disk"></i> Enregistrer</button>
            <a href="<?= base_url('cashpoint/liste') ?>" class="btn btn-secondary">Annuler</a>
        </div>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
