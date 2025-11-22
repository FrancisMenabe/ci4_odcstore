<?php
$session = session();
$currentURL = current_url(true)->getPath(); // chemin complet
$segment1 = current_url(true)->getSegment(1); // premier segment
$userId = $session->get('user_id');

// --- Menu HTML réutilisable ---
$menuHTML = '
<a href="'.base_url('dashboard').'" class="sidebar-link '.($segment1=="dashboard"?"active":"").'"><i class="fa-solid fa-gauge me-2"></i> Dashboard</a>

<a class="sidebar-link" data-bs-toggle="collapse" href="#caisseMenu" aria-expanded="'.(strpos($currentURL,"caisse")!==false?"true":"false").'"><i class="fa-solid fa-cash-register me-2"></i> Caisse</a>
<div class="collapse '.(strpos($currentURL,"caisse")!==false||strpos($currentURL,"journal-caisse")!==false?"show":"").'" id="caisseMenu">
    <a class="dropdown-item '.($currentURL=="caisse/new"?"active":"").'" href="'.base_url('caisse/new').'">Nouvelle Opération</a>
    <a class="dropdown-item '.($currentURL=="caisse"?"active":"").'" href="'.base_url('caisse').'">Historique Caisse</a>
    <a class="dropdown-item '.($currentURL=="journal-caisse"?"active":"").'" href="'.base_url('journal-caisse').'">Journal de Caisse</a>
</div>

<a href="'.base_url('produits').'" class="sidebar-link '.($currentURL=="produits"?"active":"").'"><i class="fa-solid fa-box me-2"></i> Produits</a>

<a href="'.base_url('ventes').'" class="sidebar-link '.($currentURL=="ventes"?"active":"").'"><i class="fa-solid fa-cart-shopping me-2"></i> Ventes</a>
<a href="'.base_url('listevente').'" class="sidebar-link '.($currentURL=="listevente"?"active":"").'"><i class="fa-solid fa-list-check me-2"></i> Liste Ventes</a>

<a class="sidebar-link" data-bs-toggle="collapse" href="#cashpointMenu" aria-expanded="'.(strpos($currentURL,"cashpoint")!==false?"true":"false").'"><i class="fa-solid fa-money-bill-transfer me-2"></i> CashPoint</a>
<div class="collapse '.(strpos($currentURL,"cashpoint")!==false?"show":"").'" id="cashpointMenu">
    <a class="dropdown-item '.($currentURL=="cashpoint/new"?"active":"").'" href="'.base_url('cashpoint/new').'">Nouvelle Opération</a>
    <a class="dropdown-item '.($currentURL=="cashpoint/liste"?"active":"").'" href="'.base_url('cashpoint/liste').'">Historique</a>
</div>

<a class="sidebar-link" data-bs-toggle="collapse" href="#accescashMenu" aria-expanded="'.(strpos($currentURL,"accescash")!==false?"true":"false").'"><i class="fa-solid fa-building-columns me-2"></i> AccèsCash</a>
<div class="collapse '.(strpos($currentURL,"accescash")!==false?"show":"").'" id="accescashMenu">
    <a class="dropdown-item '.($currentURL=="accescash/new"?"active":"").'" href="'.base_url('accescash/new').'">Nouvelle Opération</a>
    <a class="dropdown-item '.($currentURL=="accescash/liste"?"active":"").'" href="'.base_url('accescash/liste').'">Historique</a>
</div>

<a class="sidebar-link" data-bs-toggle="collapse" href="#clientsSolaireMenu" aria-expanded="'.(strpos($currentURL,"clients-solaire")!==false?"true":"false").'"><i class="fa-solid fa-solar-panel me-2"></i> Kits Solaires</a>
<div class="collapse '.(strpos($currentURL,"clients-solaire")!==false?"show":"").'" id="clientsSolaireMenu">
    <a class="dropdown-item '.($currentURL=="clients-solaire/new"?"active":"").'" href="'.base_url('clients-solaire/new').'">Nouveau Client</a>
    <a class="dropdown-item '.($currentURL=="clients-solaire"?"active":"").'" href="'.base_url('clients-solaire').'">Liste Clients</a>
</div>

<a class="sidebar-link" data-bs-toggle="collapse" href="#paiementsSolaireMenu" aria-expanded="'.(strpos($currentURL,"paiements-solaire")!==false?"true":"false").'"><i class="fa-solid fa-money-bill-wave me-2"></i> Paiements Solaire</a>
<div class="collapse '.(strpos($currentURL,"paiements-solaire")!==false?"show":"").'" id="paiementsSolaireMenu">
    <a class="dropdown-item '.($currentURL=="paiements-solaire/new"?"active":"").'" href="'.base_url('paiements-solaire/new').'">Nouveau Paiement</a>
    <a class="dropdown-item '.($currentURL=="paiements-solaire"?"active":"").'" href="'.base_url('paiements-solaire').'">Historique Paiements</a>
</div>

<a href="'.base_url('users/edit/'.$userId).'" class="sidebar-link mb-4 '.(strpos($currentURL,"users/edit")!==false?"active":"").'">
    <i class="fa-solid fa-user-gear me-2"></i> Modifier Profil
</a>
';
?>

<!-- Sidebar desktop -->
<div class="sidebar d-none d-lg-block position-fixed vh-100 start-0 top-0" style="width:220px; overflow-y:auto; z-index:1000; background:#ff8c42;">
    <div class="logo p-3 text-center fw-bold text-white" style="height:70px; line-height:70px; font-size:1.2rem; background:#ff8c42;">
        ODC STORE
    </div>
    <nav class="mt-2">
        <?= $menuHTML ?>
    </nav>
</div>

<!-- Sidebar mobile Offcanvas -->
<div class="offcanvas offcanvas-start d-lg-none" tabindex="-1" id="offcanvasSidebar" aria-labelledby="offcanvasSidebarLabel" style="background:#ff8c42;">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title text-white" id="offcanvasSidebarLabel">ODC STORE</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"></button>
    </div>
    <div class="offcanvas-body p-0">
        <nav class="mt-2">
            <?= $menuHTML ?>
        </nav>
    </div>
</div>

<!-- Bouton menu mobile -->
<nav class="d-lg-none navbar navbar-light bg-white shadow-sm fixed-top">
    <div class="container-fluid">
        <button class="btn btn-orange" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasSidebar">
            <i class="fa-solid fa-bars"></i>
        </button>
        <span class="fw-bold ms-2">ODC STORE</span>
    </div>
</nav>

<style>
.sidebar, .offcanvas-body { color: white; }
.sidebar-link, .dropdown-item { display:block; padding:12px 20px; color:white; text-decoration:none; font-weight:500; transition: background 0.3s; }
.sidebar-link:hover, .sidebar-link.active, .dropdown-item:hover, .dropdown-item.active { background: #ff9f61; }
.sidebar::-webkit-scrollbar { width:6px; }
.sidebar::-webkit-scrollbar-thumb { background:#ff9f61; border-radius:3px; }
.sidebar::-webkit-scrollbar-track { background:#ff8c42; }
.btn-orange { color:white; background:#ff8c42; border:none; }
.offcanvas-backdrop.show { background-color: rgba(0,0,0,0.5); }
</style>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
