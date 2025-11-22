<?php $session = session(); ?>
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Nouvelle Vente | ODC STORE</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
<style>
.content { margin-left:220px; margin-top:70px; padding:20px; }
@media(max-width:992px){ .content { margin-left:0; margin-top:70px; } }
</style>
</head>
<body>

<?= $this->include('templates/navbar') ?>
<?= $this->include('templates/sidebar') ?>

<div class="content">
    <div class="container-fluid mt-4">
        <h2 class="mb-4"><?= esc($page_title) ?></h2>

        <!-- Nom du client -->
        <div class="mb-3">
            <label for="nom_client" class="form-label">Nom du client :</label>
            <input type="text" id="nom_client" class="form-control" placeholder="Entrez le nom du client" required>
        </div>

        <!-- Ajouter produit -->
        <div class="card mb-4 shadow-sm">
            <div class="card-header bg-orange fw-bold">Ajouter un produit</div>
            <div class="card-body row g-2 align-items-end">
                <div class="col-md-4">
                    <label for="select_produit" class="form-label">Référence :</label>
                    <select id="select_produit" class="form-select">
                        <option value="">Sélectionnez</option>
                        <?php foreach($produits as $produit): ?>
                            <option value="<?= $produit['id'] ?>" data-nom="<?= esc($produit['nom']) ?>" data-prix="<?= esc($produit['prix_vente']) ?>">
                                <?= esc($produit['reference']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="nom_produit" class="form-label">Nom produit :</label>
                    <input type="text" id="nom_produit" class="form-control" readonly>
                </div>
                <div class="col-md-2">
                    <label for="quantite" class="form-label">Quantité :</label>
                    <input type="number" id="quantite" class="form-control" min="1" value="1">
                </div>
                <div class="col-md-3">
                    <button id="btn_ajouter" class="btn btn-success w-100">
                        <i class="fas fa-plus"></i> Ajouter
                    </button>
                </div>
            </div>
        </div>

        <!-- Tableau des achats enregistrés -->
        <div class="card shadow-sm">
            <div class="card-header bg-secondary text-white fw-bold">Achats enregistrés</div>
            <div class="card-body p-0">
                <table class="table table-bordered table-striped m-0">
                    <thead class="table-dark">
                        <tr>
                            <th>Référence</th>
                            <th>Nom produit</th>
                            <th>Quantité</th>
                            <th>Prix unitaire</th>
                            <th>Montant</th>
                        </tr>
                    </thead>
                    <tbody id="table_achats"></tbody>
                    <tfoot>
                        <tr>
                            <th colspan="4" class="text-end">Total :</th>
                            <th id="total_achats">0</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <div class="card-footer text-end">
                <a id="btn_valider" class="btn btn-primary" href="#">
                    <i class="fas fa-check"></i> Valider la vente
                </a>
            </div>
        </div>

    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
    const selectProduit = document.getElementById('select_produit');
    const nomProduit = document.getElementById('nom_produit');
    const quantite = document.getElementById('quantite');
    const btnAjouter = document.getElementById('btn_ajouter');
    const tableBody = document.getElementById('table_achats');
    const nomClient = document.getElementById('nom_client');
    const totalCell = document.getElementById('total_achats');
    const btnValider = document.getElementById('btn_valider');

    let total = 0;
    let ventes = [];
    let referenceVente = null; // <-- stocke la référence de vente générée par le serveur

    selectProduit.addEventListener('change', function() {
        nomProduit.value = selectProduit.selectedOptions[0].dataset.nom || '';
    });

    btnAjouter.addEventListener('click', function(e) {
        e.preventDefault();

        const produitId = selectProduit.value;
        const qte = parseInt(quantite.value);
        const client = nomClient.value.trim();

        if (!produitId || !qte || !client) {
            alert('Remplissez tous les champs !');
            return;
        }

        fetch('<?= base_url('ventes/store') ?>', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: new URLSearchParams({
                produit_id: produitId,
                quantite: qte,
                nom_client: client
            })
        })
        .then(res => res.json())
        .then(data => {
            if(data.status === 'success') {
                const d = data.data;

                // Stocker la référence de vente si c'est la première fois
                if (!referenceVente) referenceVente = d.reference_vente;

                const tr = document.createElement('tr');
                tr.innerHTML = `
                    <td>${d.reference}</td>
                    <td>${d.nom}</td>
                    <td>${d.quantite}</td>
                    <td>${d.prix}</td>
                    <td>${d.montant}</td>
                `;
                tableBody.appendChild(tr);

                total += parseFloat(d.montant);
                totalCell.textContent = total.toFixed(2);

                ventes.push(d);
                quantite.value = 1;
            } else {
                alert(data.message);
            }
        });
    });

    btnValider.addEventListener('click', function(e) {
    e.preventDefault();
    if (ventes.length === 0) { 
        alert('Aucun produit ajouté'); 
        return; 
    }

    const referenceVente = ventes[0].reference_vente;

    // Ouvrir le reçu dans un nouvel onglet
    const url = '<?= base_url('ventes/recap') ?>/' + referenceVente;
    window.open(url, '_blank');
});

});

</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
