<?php
$session = session();
if(!$session->get('logged_in')) return redirect()->to('/login');
?>
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?= $page_title ?> | ODC STORE</title>

<!-- Bootstrap & FontAwesome -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

<style>
body { background: #f8f9fa; font-family:"Poppins",sans-serif; }
.content { margin-left:220px; margin-top:70px; padding:20px; }
@media(max-width:992px){ .content { margin-left:0; margin-top:70px; } }

/* Boutons filtre */
.filter-btn.active {
    background:#ff8c42 !important;
    color:white !important;
}

/* Carte graphique */
.chart-card {
    background:white;
    padding:25px;
    border-radius:10px;
    box-shadow:0 3px 8px rgba(0,0,0,0.1);
    margin-bottom:20px;
}
</style>
</head>
<body>

<?= view('templates/sidebar') ?>
<?= view('templates/navbar') ?>

<div class="content">

    <h2 class="mb-4"><?= $page_title ?></h2>

    <!-- 🔍 FILTRE TEMPS -->
    <div class="mb-3">
        <a href="?filter=day" class="btn btn-outline-dark filter-btn <?= ($filter=='day')?'active':'' ?>">Aujourd’hui</a>
        <a href="?filter=week" class="btn btn-outline-dark filter-btn <?= ($filter=='week')?'active':'' ?>">Cette semaine</a>
        <a href="?filter=month" class="btn btn-outline-dark filter-btn <?= ($filter=='month')?'active':'' ?>">Ce mois</a>
    </div>

    <!-- 📈 GRAPHIQUE -->
    <div class="chart-card">
        <h5 class="mb-3">Activité (Ventes, CashPoint, AccesCash)</h5>
        <canvas id="caisseChart" height="120"></canvas>
    </div>

</div>

<!-- JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
// Données Chart.js
const data = {
    labels: ["Ventes", "CashPoint", "AccesCash"],
    datasets: [{
        label: "Montants (Ar)",
        data: [
            <?= $dataGraph['vente'] ?>,
            <?= $dataGraph['cashpoint'] ?>,
            <?= $dataGraph['accescash'] ?>
        ],
        backgroundColor: ["#4CAF50","#2196F3","#FFC107"],
        borderWidth: 1
    }]
};

// Config et rendu du graphique
new Chart(document.getElementById('caisseChart'), {
    type: "bar",
    data: data,
    options: {
        responsive: true,
        plugins: {
            legend: { display: false }
        },
        scales: {
            y: { beginAtZero: true }
        }
    }
});
</script>

</body>
</html>
