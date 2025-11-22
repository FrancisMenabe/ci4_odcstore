<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Nouvelle Opération | Caisse - ODC STORE</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
<style>
body { background: #f8f9fa; }
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
    <h2>Nouvelle Opération</h2>
    <div class="card shadow-sm p-4 bg-white rounded">
        <form action="<?= base_url('caisse/store') ?>" method="post">
            <div class="mb-3">
                <label class="form-label">Type d'opération</label>
                <select name="type" class="form-control" required>
                    <option value="">— Sélectionner —</option>
                    <option value="entree">Entrée</option>
                    <option value="sortie">Sortie</option>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Montant</label>
                <input type="number" name="montant" class="form-control" step="0.01" placeholder="Ex: 50000" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Catégorie</label>
                <input type="text" name="categorie" class="form-control" placeholder="Ex: Achat, Paiement, Salaire" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Description</label>
                <textarea name="description" class="form-control" rows="3" placeholder="Détails de l'opération"></textarea>
            </div>

            <button type="submit" class="btn btn-orange">
                <i class="fa-solid fa-check"></i> Enregistrer
            </button>
            <a href="<?= base_url('caisse') ?>" class="btn btn-secondary ms-2">Annuler</a>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
