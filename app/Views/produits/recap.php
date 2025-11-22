<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Reçu Vente | ODC STORE</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
body { font-family:"Poppins",sans-serif; padding:20px; }
</style>
</head>
<body onload="window.print()">
    <h2>ODC STORE</h2>
    <p>Adresse Boutique</p>
    <hr>
    <p><strong>Client :</strong> <?= $ventes[0]->nom_client ?></p>
    <p><strong>Responsable :</strong> <?= $ventes[0]->responsable ?></p>
    <p><strong>Date :</strong> <?= date('d/m/Y H:i', strtotime($ventes[0]->date_vente)) ?></p>
    <hr>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Produit</th>
                <th>Quantité</th>
                <th>Prix Unitaire</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
        <?php $total=0; foreach($ventes as $v): 
            $sous_total = $v->quantite * $v->prix_vente;
            $total += $sous_total;
        ?>
            <tr>
                <td><?= $v->nom_produit ?></td>
                <td><?= $v->quantite ?></td>
                <td><?= $v->prix_vente ?></td>
                <td><?= $sous_total ?></td>
            </tr>
        <?php endforeach; ?>
            <tr>
                <td colspan="3"><strong>Total</strong></td>
                <td><strong><?= $total ?></strong></td>
            </tr>
        </tbody>
    </table>
    <p>Merci pour votre achat !</p>
</body>
</html>
