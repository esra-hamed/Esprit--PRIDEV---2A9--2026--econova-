<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">

  <title><?= htmlspecialchars($titreOnglet ?? 'Administration') ?> | Vivora Back Office</title>

  <!-- ── Favicon ──────────────────────────────────────────── -->
  <link rel="icon" href="<?= BASE_URL ?>public/assets/front/img/favicon.png" type="image/png">

  <!-- ── Bootstrap Icons ──────────────────────────────────── -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

  <!-- ── Font Awesome (AdminLTE en a besoin) ──────────────── -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

  <!-- ── AdminLTE CSS ──────────────────────────────────────── -->
  <!-- Placer les fichiers CSS AdminLTE dans /public/assets/back/css/ -->
  <link rel="stylesheet" href="<?= BASE_URL ?>public/assets/back/css/adminlte.min.css">

  <!-- ── Surcharges Vivora (après AdminLTE) ───────────────── -->
  <link rel="stylesheet" href="<?= BASE_URL ?>public/assets/back/css/vivora-back.css">
</head>
<body class="hold-transition sidebar-mini layout-fixed">

<div class="wrapper">

  <!-- ══════════════════════════════════════════════════════════
       BARRE DE NAVIGATION SUPÉRIEURE (AdminLTE Navbar)
  ══════════════════════════════════════════════════════════ -->
  <nav class="main-header navbar navbar-expand navbar-dark" role="navigation" aria-label="Barre de navigation administration">

    <!-- Bouton toggle sidebar (gauche) -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button" aria-label="Ouvrir/fermer le menu latéral">
          <i class="fas fa-bars" aria-hidden="true"></i>
        </a>
      </li>
      <!-- Lien vers le front office -->
      <li class="nav-item d-none d-sm-inline-block">
        <a href="<?= BASE_URL ?>index.php?controller=lieu&action=list" class="nav-link" target="_blank">
          <i class="bi bi-box-arrow-up-right me-1" aria-hidden="true"></i>
          Voir le site
        </a>
      </li>
    </ul>

    <!-- Éléments à droite de la navbar -->
    <ul class="navbar-nav ms-auto">
      <!-- Notifications (emplacement réservé) -->
      <li class="nav-item">
        <a class="nav-link" href="#" aria-label="Notifications">
          <i class="far fa-bell" aria-hidden="true"></i>
        </a>
      </li>
      <!-- Toggle sidebar droite -->
      <li class="nav-item">
        <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button" aria-label="Paramètres">
          <i class="fas fa-th-large" aria-hidden="true"></i>
        </a>
      </li>
    </ul>

  </nav><!-- Fin main-header -->

  <!-- ══════════════════════════════════════════════════════════
       SIDEBAR (incluse séparément pour modularité)
  ══════════════════════════════════════════════════════════ -->
  <?php require __DIR__ . '/sidebar.php'; ?>

  <!-- ══════════════════════════════════════════════════════════
       CONTENU PRINCIPAL (begin)
       Chaque vue back insérera son contenu ici.
  ══════════════════════════════════════════════════════════ -->
  <div class="content-wrapper">
