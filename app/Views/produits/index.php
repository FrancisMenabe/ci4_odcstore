<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Liste Produits | ODC STORE</title>
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
    <h2>Liste des Produits</h2>
    <a href="<?= base_url('/produits/create') ?>" class="btn btn-orange mb-3"><i class="fa-solid fa-plus"></i> Ajouter Produit</a>

    <table class="table table-bordered table-hover">
        <thead class="table-light">
            <tr>
                <th>#</th>
                <th>Référence</th>
                <th>Nom</th>
                <th>Quantité</th>
                <th>Prix Achat</th>
                <th>Prix Vente</th>
                <th>Fournisseur</th>
                <th>Responsable</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach($produits as $produit): ?>
            <tr>
                <td><?= $produit['id'] ?></td>
                <td><?= $produit['reference'] ?></td>
                <td><?= $produit['nom'] ?></td>
                <td><?= $produit['quantite'] ?></td>
                <td><?= $produit['prix_achat'] ?></td>
                <td><?= $produit['prix_vente'] ?></td>
                <td><?= $produit['fournisseur'] ?></td>
                <td><?= $produit['responsable'] ?></td>
                <td>
                    <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#editModal<?= $produit['id'] ?>"><i class="fa-solid fa-pen"></i></button>
                    <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal<?= $produit['id'] ?>"><i class="fa-solid fa-trash"></i></button>
                </td>
            </tr>

            <!-- Modal Edit -->
            <div class="modal fade" id="editModal<?= $produit['id'] ?>" tabindex="-1">
                <div class="modal-dialog" style="margin-top: 100px;">
                    <div class="modal-content">
                        <form action="<?= base_url('/produits/update/'.$produit['id']) ?>" method="post">
                            <div class="modal-header" >
                                <h5 class="modal-title">Modifier Produit</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <input type="text" name="reference" class="form-control mb-2" value="<?= $produit['reference'] ?>" required>
                                <input type="text" name="nom" class="form-control mb-2" value="<?= $produit['nom'] ?>" required>
                                <input type="number" name="quantite" class="form-control mb-2" value="<?= $produit['quantite'] ?>" required>
                                <input type="number" step="0.01" name="prix_achat" class="form-control mb-2" value="<?= $produit['prix_achat'] ?>" required>
                                <input type="number" step="0.01" name="prix_vente" class="form-control mb-2" value="<?= $produit['prix_vente'] ?>" required>
                                <input type="text" name="fournisseur" class="form-control mb-2" value="<?= $produit['fournisseur'] ?>">
                                <textarea name="description" class="form-control"><?= $produit['description'] ?></textarea>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">Enregistrer</button>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Modal Delete -->
            <div class="modal fade" id="deleteModal<?= $produit['id'] ?>" tabindex="-1">
                <div class="modal-dialog" style="margin-top: 100px;">
                    <div class="modal-content">
                        <form action="<?= base_url('/produits/delete/'.$produit['id']) ?>" method="post">
                            <div class="modal-header">
                                <h5 class="modal-title">Supprimer Produit</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                Voulez-vous vraiment supprimer le produit <strong><?= $produit['nom'] ?></strong> ?
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-danger">Supprimer</button>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        <?php endforeach; ?>
        </tbody>
    </table>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
