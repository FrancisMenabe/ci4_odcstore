<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Ajouter Client Solaire | ODC STORE</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

<style>
.content { margin-left:220px; margin-top:70px; padding:20px; }
@media(max-width:992px){ .content { margin-left:0; margin-top:70px; } }

.card-form {
    padding:25px;
    border-radius: 15px;
    box-shadow: 0 4px 18px rgba(0,0,0,0.07);
}

.btn-orange { background:#ff8c42; color:#fff; }
.btn-orange:hover { background:#ffa05e; }
</style>
</head>
<body>

<?= view('templates/sidebar') ?>
<?= view('templates/navbar') ?>

<div class="content">

    <h3 class="fw-bold mb-3">Ajouter un Client Solaire</h3>

    <div class="card card-form">

        <form action="<?= base_url('clients-solaire/store') ?>" method="post">

            <div class="row g-3">
                <div class="col-md-6">
                    <label>Nom du client</label>
                    <input type="text" name="nom_client" class="form-control" required>
                </div>

                <div class="col-md-6">
                    <label>Téléphone</label>
                    <input type="text" name="telephone" class="form-control" required>
                </div>

                <div class="col-12">
                    <label>Adresse</label>
                    <input type="text" name="adresse" class="form-control" required>
                </div>

                <div class="col-md-6">
                    <label>Type de Kit</label>
                    <input type="text" name="type_kit" class="form-control" required>
                </div>

                <div class="col-md-6">
                    <label>Prix total</label>
                    <input type="number" name="prix_total" class="form-control" required>
                </div>

                <div class="col-md-6">
                    <label>Mensualité</label>
                    <input type="number" name="montant_mensuel" class="form-control" required>
                </div>

                <div class="col-md-6">
                    <label>Nombre de mois</label>
                    <input type="number" name="nombre_mois" class="form-control" required>
                </div>
            </div>

            <div class="mt-3">
                <button class="btn btn-orange"><i class="fa fa-save"></i> Enregistrer</button>
            </div>
        </form>

    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
