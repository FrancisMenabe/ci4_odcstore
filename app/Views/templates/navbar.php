<?php
$session = session();

// Vérification : si pas connecté -> login
if (!$session->has('user_nom') || empty($session->get('user_nom'))) {
    return redirect()->to(base_url('login'))->send();
    exit;
}

// Récupération des infos depuis la session
$user_nom = $session->get('user_nom');
$user_profile = $session->get('user_profile') ?? 'default.png'; // photo réelle ou default
$page_title = $page_title ?? 'Dashboard';
?>
<nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom fixed-top" style="height:70px; padding:0 20px; z-index:1100;">
    <div class="container-fluid">

        <!-- Hamburger toggle for mobile -->
        <button class="btn btn-orange d-lg-none me-2" type="button" id="sidebarToggle">
            <i class="fa-solid fa-bars"></i>
        </button>

        <span class="navbar-brand text-orange fw-bold d-none d-lg-block"><?= $page_title ?></span>

        <div class="dropdown ms-auto">
            <a class="d-flex align-items-center text-dark text-decoration-none dropdown-toggle"
               href="#"
               id="profileDropdown"
               role="button"
               data-bs-toggle="dropdown"
               aria-expanded="false">
                <!-- Photo réelle si existante, sinon default.png -->
                <img src="<?= base_url('uploads/' . ($user_profile ?: 'default.png')) ?>" class="rounded-circle" width="40" height="40">
                <span class="ms-2"><?= esc($user_nom) ?></span>
            </a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileDropdown">
                <li>
                    <a class="dropdown-item text-orange" href="<?= base_url('users/edit/' . $session->get('user_id')) ?>">
                        <i class="fa-solid fa-user-gear"></i> Modifier Profil
                    </a>
                </li>
                <li>
                    <a class="dropdown-item text-orange" href="<?= base_url('logout') ?>">
                        <i class="fa-solid fa-right-from-bracket"></i> Déconnexion
                    </a>
                </li>
            </ul>
        </div>

    </div>
</nav>

<style>
    .btn-orange { background-color: #ff8c42; border:none; color:#fff; }
    .btn-orange:hover { background-color: #e6772e; }
    .text-orange { color:#ff8c42; }
</style>

<script>
    // Toggle sidebar on mobile
    document.addEventListener('DOMContentLoaded', function(){
        const sidebar = document.querySelector('.sidebar');
        const toggleBtn = document.getElementById('sidebarToggle');
        toggleBtn.addEventListener('click', function(){
            sidebar.classList.toggle('show-sidebar');
        });
    });
</script>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
