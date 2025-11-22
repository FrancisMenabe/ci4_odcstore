<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Modifier Utilisateur | ODC STORE</title>

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

.img-preview {
    width:100px;
    height:100px;
    object-fit:cover;
    border-radius:50%;
    margin-bottom:10px;
    border:2px solid #ff8c42;
}
</style>
</head>
<body>

<?= view('templates/sidebar') ?>
<?= view('templates/navbar') ?>

<div class="content">

    <h3 class="fw-bold mb-3">Modifier Utilisateur</h3>

    <div class="card card-form">

        <form action="<?= base_url('users/update/'.$user['id']) ?>" method="post" enctype="multipart/form-data">
            <?= csrf_field() ?>

            <div class="row g-3">

                <div class="col-md-6">
                    <label>Nom</label>
                    <input type="text" name="nom" class="form-control" value="<?= esc($user['nom']) ?>" required>
                </div>

                <div class="col-md-6">
                    <label>Pseudo</label>
                    <input type="text" name="pseudo" class="form-control" value="<?= esc($user['pseudo']) ?>" required>
                </div>

                <div class="col-md-6">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control" value="<?= esc($user['email']) ?>" required>
                </div>

                <div class="col-md-6">
                    <label>Rôle</label>
                    <select name="role" class="form-control" required>
                        <option value="caissier" <?= $user['role']=='caissier'?'selected':'' ?>>Caissier</option>
                        <option value="admin" <?= $user['role']=='admin'?'selected':'' ?>>Admin</option>
                    </select>
                </div>

                <div class="col-md-6">
                    <label>Statut</label>
                    <select name="statut" class="form-control" required>
                        <option value="actif" <?= $user['statut']=='actif'?'selected':'' ?>>Actif</option>
                        <option value="inactif" <?= $user['statut']=='inactif'?'selected':'' ?>>Inactif</option>
                    </select>
                </div>

                <div class="col-md-6">
                    <label>Mot de passe (laisser vide pour ne pas changer)</label>
                    <input type="password" name="password" class="form-control">
                </div>

                <div class="col-12">
                    <label>Photo de profil</label><br>
                    <?php if(!empty($user['profile'])): ?>
                        <img src="<?= base_url('uploads/'.$user['profile']) ?>" alt="Profil" class="img-preview">
                    <?php endif; ?>

                    <input type="file" name="profile" class="form-control">
                </div>

            </div>

            <div class="mt-3">
                <button class="btn btn-orange"><i class="fa fa-save"></i> Enregistrer les modifications</button>
            </div>

        </form>

    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
