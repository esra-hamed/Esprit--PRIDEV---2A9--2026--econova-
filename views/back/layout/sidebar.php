<!-- ══════════════════════════════════════════════════════════
     SIDEBAR AdminLTE – Vivora Back Office
     Contient tous les modules du projet.
     Chaque équipier ajoute son entrée dans sa section.
══════════════════════════════════════════════════════════ -->
<aside class="main-sidebar sidebar-dark-primary elevation-4" role="complementary" aria-label="Menu de navigation latéral">

  <!-- Logo / Nom de l'application -->
  <a href="<?= BASE_URL ?>index.php?controller=evenement&action=adminDashboard"
     class="brand-link"
     aria-label="Vivora – Tableau de bord">
    <span class="brand-image elevation-3"
          style="display:inline-flex; align-items:center; justify-content:center;
                 width:33px; height:33px; background:#1F7A72; border-radius:50%; font-size:1rem; color:#fff;"
          aria-hidden="true">V</span>
    <span class="brand-text fw-bold ms-2">Vivora</span>
  </a>

  <!-- Conteneur de la sidebar -->
  <div class="sidebar">

    <!-- Profil utilisateur (emplacement réservé – module authentification) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image">
        <span style="display:inline-flex; align-items:center; justify-content:center;
                     width:34px; height:34px; background:#E07A5F; border-radius:50%;
                     color:#fff; font-size:0.9rem; font-family:'Lexend',sans-serif;"
              aria-hidden="true">A</span>
      </div>
      <div class="info">
        <span class="d-block" style="color:rgba(246,244,238,0.85);">Administrateur</span>
      </div>
    </div>

    <!-- Barre de recherche dans la sidebar (optionnel) -->
    <div class="form-inline">
      <div class="input-group" data-widget="sidebar-search">
        <input class="form-control form-control-sidebar"
               type="search"
               placeholder="Rechercher..."
               aria-label="Rechercher dans le menu">
        <div class="input-group-append">
          <button class="btn btn-sidebar" type="button" aria-label="Lancer la recherche">
            <i class="fas fa-search fa-fw" aria-hidden="true"></i>
          </button>
        </div>
      </div>
    </div>

    <!-- ── Menu de navigation ──────────────────────────── -->
    <nav class="mt-2" aria-label="Menus du back office">
      <ul class="nav nav-pills nav-sidebar flex-column"
          data-widget="treeview"
          role="menu"
          data-accordion="false">

        <!-- ── Tableau de bord ──────────────────────────── -->
        <li class="nav-item">
          <a href="<?= BASE_URL ?>index.php?controller=evenement&action=adminDashboard"
             class="nav-link <?= (isset($pageActive) && $pageActive === 'dashboard') ? 'active' : '' ?>">
            <i class="nav-icon fas fa-tachometer-alt" aria-hidden="true"></i>
            <p>Tableau de bord</p>
          </a>
        </li>

        <!-- ══════════════════════════════════════════════
             MODULE 4 – LIEUX & ÉVÉNEMENTS
        ══════════════════════════════════════════════ -->
        <li class="nav-header" style="color:rgba(246,244,238,0.5); font-size:0.72rem; letter-spacing:1px;">
          MODULE 4 – LIEUX &amp; ÉVÉNEMENTS
        </li>

        <!-- Sous-menu Lieux & Événements -->
        <li class="nav-item <?= (isset($menuActif) && $menuActif === 'lieux-evenements') ? 'menu-open' : '' ?>">
          <a href="#" class="nav-link <?= (isset($menuActif) && $menuActif === 'lieux-evenements') ? 'active' : '' ?>"
             aria-haspopup="true">
            <i class="nav-icon bi bi-geo-alt-fill" aria-hidden="true"></i>
            <p>
              Lieux &amp; Événements
              <i class="right fas fa-angle-left" aria-hidden="true"></i>
            </p>
          </a>
          <ul class="nav nav-treeview" role="menu">

            <!-- Dashboard du module -->
            <li class="nav-item">
              <a href="<?= BASE_URL ?>index.php?controller=evenement&action=adminDashboard"
                 class="nav-link <?= (isset($pageActive) && $pageActive === 'module-dashboard') ? 'active' : '' ?>">
                <i class="far fa-circle nav-icon" aria-hidden="true"></i>
                <p>Statistiques du module</p>
              </a>
            </li>

            <!-- Gestion des lieux -->
            <li class="nav-item">
              <a href="<?= BASE_URL ?>index.php?controller=lieu&action=adminList"
                 class="nav-link <?= (isset($pageActive) && $pageActive === 'lieux-liste') ? 'active' : '' ?>">
                <i class="far fa-circle nav-icon" aria-hidden="true"></i>
                <p>Gestion des lieux</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?= BASE_URL ?>index.php?controller=lieu&action=adminCreate"
                 class="nav-link <?= (isset($pageActive) && $pageActive === 'lieux-ajouter') ? 'active' : '' ?>">
                <i class="far fa-circle nav-icon" aria-hidden="true"></i>
                <p>Ajouter un lieu</p>
              </a>
            </li>

            <!-- Gestion des événements -->
            <li class="nav-item">
              <a href="<?= BASE_URL ?>index.php?controller=evenement&action=adminList"
                 class="nav-link <?= (isset($pageActive) && $pageActive === 'evenements-liste') ? 'active' : '' ?>">
                <i class="far fa-circle nav-icon" aria-hidden="true"></i>
                <p>Gestion des événements</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?= BASE_URL ?>index.php?controller=evenement&action=adminCreate"
                 class="nav-link <?= (isset($pageActive) && $pageActive === 'evenements-ajouter') ? 'active' : '' ?>">
                <i class="far fa-circle nav-icon" aria-hidden="true"></i>
                <p>Ajouter un événement</p>
              </a>
            </li>

          </ul>
        </li><!-- Fin nav-item Lieux & Événements -->

        <!-- ══════════════════════════════════════════════
             AUTRES MODULES (emplacement réservé)
             Chaque équipier ajoute son entrée ici.
        ══════════════════════════════════════════════ -->
        <li class="nav-header" style="color:rgba(246,244,238,0.5); font-size:0.72rem; letter-spacing:1px;">
          AUTRES MODULES
        </li>

        <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-universal-access" aria-hidden="true"></i>
            <p>Module 1 – Accessibilité</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-heartbeat" aria-hidden="true"></i>
            <p>Module 2 – Santé</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-leaf" aria-hidden="true"></i>
            <p>Module 3 – Bien-être</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-users" aria-hidden="true"></i>
            <p>Module 5 – Communauté</p>
          </a>
        </li>

      </ul>
    </nav><!-- Fin nav -->

  </div><!-- Fin .sidebar -->
</aside><!-- Fin main-sidebar -->
