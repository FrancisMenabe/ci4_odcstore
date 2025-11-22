<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Journal de Caisse | ODC STORE</title>

<!-- Bootstrap -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

<!-- DataTables -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css">

<style>
body { background: #f8f9fa; }
.content { margin-left:220px; margin-top:70px; padding:20px; }
@media(max-width:992px){ .content { margin-left:0; margin-top:70px; } }
.btn-orange { background:#ff8c42; color:#fff; }
.btn-orange:hover { background:#ff9f61; }
.table-wrapper { overflow-x:auto; }
.table th, .table td { vertical-align: middle; }
.solde { font-size:1.2rem; font-weight:600; margin-bottom:20px; }
</style>
</head>
<body>

<?= view('templates/sidebar') ?>
<?= view('templates/navbar') ?>

<div class="content">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Journal de Caisse</h2>
        <a href="<?= base_url('journal/create') ?>" class="btn btn-orange">
            <i class="fa-solid fa-plus"></i> Nouvelle Entrée
        </a>
    </div>

    <!-- 🔎 Formulaire de filtre date -->
    <form class="row g-3 mb-4" method="get" action="">
        <div class="col-md-4">
            <label class="form-label">Date début</label>
            <input type="date" name="start_date" value="<?= $start_date ?? '' ?>" class="form-control">
        </div>

        <div class="col-md-4">
            <label class="form-label">Date fin</label>
            <input type="date" name="end_date" value="<?= $end_date ?? '' ?>" class="form-control">
        </div>

        <div class="col-md-4 d-flex align-items-end gap-2">
            <button type="submit" class="btn btn-primary w-50">
                <i class="fa fa-search"></i> Filtrer
            </button>
            <a href="<?= base_url('journal-caisse') ?>" class="btn btn-secondary w-50">
                Réinitialiser
            </a>
        </div>
    </form>

    <?php
    $totalEntrees = 0;
    $totalSorties = 0;
    $totalMouvements = 0;

    foreach($journal as $op){
        $type = strtolower($op['type']);
        if($type === 'entrée' || $type === 'entree')      $totalEntrees += $op['montant'];
        elseif($type === 'sortie')  $totalSorties += $op['montant'];
        else                        $totalMouvements += $op['montant'];
    }

    $solde = $totalEntrees - $totalSorties + $totalMouvements;
    ?>

    <!-- Totaux filtrés -->
    <div class="solde">
        Total Entrées : <strong><?= number_format($totalEntrees,0,',',' ') ?> Ar</strong> |
        Total Sorties : <strong><?= number_format($totalSorties,0,',',' ') ?> Ar</strong> |
        Total Mouvement : <strong><?= number_format($totalMouvements,0,',',' ') ?> Ar</strong> |
        Solde : <strong><?= number_format($solde,0,',',' ') ?> Ar</strong>
    </div>

    <div class="table-wrapper">
        <table id="journalTable" class="table table-bordered table-hover bg-white display responsive nowrap" style="width:100%">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Date</th>
                    <th>Libellé</th>
                    <th>Type</th>
                    <th>Montant</th>
                    <th>Responsable</th>
                </tr>
            </thead>

            <tbody>
                <?php foreach($journal as $op): ?>
                <tr>
                    <td><?= $op['id'] ?></td>
                    <td><?= date('d/m/Y H:i', strtotime($op['date_operation'])) ?></td>
                    <td><?= $op['libelle'] ?></td>
                    <td><?= ucfirst($op['type']) ?></td>
                    <td><?= number_format($op['montant'],0,',',' ') ?> Ar</td>
                    <td><?= $op['responsable'] ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>

        </table>
    </div>

</div>

<!-- JS -->
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

<!-- Responsive -->
<script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>

<!-- Buttons -->
<script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.bootstrap5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>

<script>
$(document).ready(function() {

    $('#journalTable').DataTable({
        responsive: true,
        dom: 'Bfrtip',
        buttons: [
            { extend: 'excel', text: '📊 Excel' },
            { extend: 'pdf', text: '📄 PDF' },
            { extend: 'print', text: '🖨 Imprimer' }
        ],
        language: {
            url: "//cdn.datatables.net/plug-ins/1.13.6/i18n/fr-FR.json",
            emptyTable: "Aucune opération trouvée."
        },
        order: [[1, "desc"]]
    });

});
</script>

</body>
</html>
