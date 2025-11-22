<?php
$session = session();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Entrer Produit | ODC STORE</title>
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
    <h2>Entrer Produit</h2>
    <form action="<?= base_url('/produits/store') ?>" method="post" class="row g-3">
        <div class="col-md-6">
            <label>Référence Produit</label>
            <input type="text" name="reference" class="form-control" required>
        </div>
        <div class="col-md-6">
            <label>Nom Produit</label>
            <input type="text" name="nom" class="form-control" required>
        </div>
        <div class="col-md-4">
            <label>Quantité</label>
            <input type="number" name="quantite" class="form-control" required>
        </div>
        <div class="col-md-4">
            <label>Prix Achat</label>
            <input type="number" step="0.01" name="prix_achat" class="form-control" required>
        </div>
        <div class="col-md-4">
            <label>Prix Vente</label>
            <input type="number" step="0.01" name="prix_vente" class="form-control" required>
        </div>
        <div class="col-md-6">
            <label>Fournisseur</label>
            <input type="text" name="fournisseur" class="form-control">
        </div>
        <div class="col-md-6">
            <label>Responsable</label>
            <input type="text" class="form-control" value="<?= $session->get('user_nom') ?>" disabled>
        </div>
        <div class="col-12">
            <label>Description</label>
            <textarea name="description" class="form-control"></textarea>
        </div>
        <div class="col-12">
            <button type="submit" class="btn btn-orange"><i class="fa-solid fa-plus"></i> Ajouter Produit</button>
        </div>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
