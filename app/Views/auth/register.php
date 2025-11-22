<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Inscription | ODC STORE</title>

  <!-- Bootstrap 5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Font Awesome -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

  <style>
    body {
      background: #fffaf3;
      font-family: "Poppins", sans-serif;
    }
    .card {
      border: none;
      border-radius: 1rem;
      box-shadow: 0 0 20px rgba(0,0,0,0.1);
    }
    .btn-orange {
      background-color: #ff8c42;
      border: none;
      color: white;
    }
    .btn-orange:hover {
      background-color: #e6772e;
    }
    .text-orange {
      color: #ff8c42;
    }
  </style>
</head>
<body>

  <div class="container d-flex align-items-center justify-content-center vh-100">
    <div class="card p-4" style="max-width: 480px; width: 100%;">
      <div class="text-center mb-4">
        <h2 class="text-orange fw-bold"><i class="fa-solid fa-store"></i> ODC STORE</h2>
      </div>
      <form action="<?= base_url('register') ?>" method="post">
        <div class="mb-3">
          <label class="form-label">Nom complet</label>
          <input type="text" class="form-control" name="nom" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Pseudo</label>
          <input type="text" class="form-control" name="pseudo" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Email</label>
          <input type="email" class="form-control" name="email" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Mot de passe</label>
          <input type="password" class="form-control" name="password" required>
        </div>
        <button type="submit" class="btn btn-orange w-100 mt-2">
          <i class="fa-solid fa-user-plus"></i> S’inscrire
        </button>
      </form>

      <div class="text-center mt-3">
        <p>Déjà inscrit ? <a href="<?= base_url('login') ?>" class="text-orange fw-bold">Se connecter</a></p>
      </div>

      <footer class="text-center text-muted mt-3" style="font-size: 0.9rem;">
        &copy; Francis 2025
      </footer>
    </div>
  </div>

</body>
</html>
