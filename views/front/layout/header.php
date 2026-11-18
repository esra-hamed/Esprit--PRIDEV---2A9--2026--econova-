<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- Description de la page (définie dans chaque vue avant l'include) -->
  <meta name="description" content="<?= htmlspecialchars($metaDescription ?? 'Vivora – Plateforme de santé et bien-être inclusif en Tunisie') ?>">

  <title><?= htmlspecialchars($titreOnglet ?? 'Vivora') ?> – Lieux & Événements accessibles</title>

  <!-- ── Favicon ──────────────────────────────────────────── -->
  <link rel="icon" href="<?= BASE_URL ?>public/assets/front/img/favicon.png" type="image/png">

  <!-- ── Bootstrap Icons ──────────────────────────────────── -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

  <!-- ── Medilab Template CSS ──────────────────────────────── -->
  <!-- Placer les fichiers CSS du template Medilab dans /public/assets/front/css/ -->
  <link rel="stylesheet" href="<?= BASE_URL ?>public/assets/front/vendor/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="<?= BASE_URL ?>public/assets/front/vendor/aos/aos.css">
  <link rel="stylesheet" href="<?= BASE_URL ?>public/assets/front/vendor/glightbox/css/glightbox.min.css">
  <link rel="stylesheet" href="<?= BASE_URL ?>public/assets/front/vendor/swiper/swiper-bundle.min.css">
  <link rel="stylesheet" href="<?= BASE_URL ?>public/assets/front/css/style.css">

  <!-- ── Surcharges Vivora (après les CSS du template) ─────── -->
  <link rel="stylesheet" href="<?= BASE_URL ?>public/assets/front/css/vivora-front.css">
</head>
<body>

  <!-- ══════════════════════════════════════════════════════════
       BARRE D'ACCESSIBILITÉ
       Réservée au Module 1 – Accessibilité numérique
       Les boutons A+/A−, contraste, lecture facile seront
       branchés par le responsable du module 1.
  ══════════════════════════════════════════════════════════ -->
  <div id="barre-accessibilite" role="complementary" aria-label="Outils d'accessibilité">
    <div class="container-fluid">
      <span>Accessibilité :</span>
      <!-- Module 1 : insérer ici les boutons d'accessibilité -->
      <button aria-label="Augmenter la taille du texte" title="Texte plus grand">A+</button>
      <button aria-label="Diminuer la taille du texte" title="Texte plus petit">A−</button>
      <button aria-label="Basculer le mode contraste élevé" title="Contraste élevé">◑</button>
      <button aria-label="Activer la lecture facile" title="Lecture facile">📖</button>
    </div>
  </div>

  <!-- ══════════════════════════════════════════════════════════
       EN-TÊTE ET NAVIGATION (Medilab style)
  ══════════════════════════════════════════════════════════ -->
  <header id="header" class="fixed-top" role="banner">
    <div class="container d-flex align-items-center">

      <!-- Logo Vivora -->
      <a href="<?= BASE_URL ?>index.php?controller=lieu&action=list" class="logo me-auto" aria-label="Vivora – Accueil">
        <span class="sitename" style="font-family: 'Lexend', sans-serif; font-size: 1.5rem; color: #fff;">
          Vivora
        </span>
      </a>

      <!-- Menu de navigation principal -->
      <nav id="navbar" class="navbar order-last order-lg-0" role="navigation" aria-label="Navigation principale">
        <ul>
          <!-- Liens des autres modules (à compléter par chaque équipier) -->
          <li><a href="<?= BASE_URL ?>index.php" class="nav-link scrollto">Accueil</a></li>
          <li><a href="#" class="nav-link scrollto">Santé</a></li>
          <li><a href="#" class="nav-link scrollto">Bien-être</a></li>

          <!-- ── MODULE 4 : Lieux & Événements ───────────────── -->
          <li class="dropdown">
            <a href="#" aria-haspopup="true" aria-expanded="false">
              <span>Lieux & Événements</span>
              <i class="bi bi-chevron-down" aria-hidden="true"></i>
            </a>
            <ul aria-label="Sous-menu Lieux et Événements">
              <li>
                <a href="<?= BASE_URL ?>index.php?controller=lieu&action=list">
                  <i class="bi bi-geo-alt me-1" aria-hidden="true"></i>
                  Lieux accessibles
                </a>
              </li>
              <li>
                <a href="<?= BASE_URL ?>index.php?controller=evenement&action=list">
                  <i class="bi bi-calendar-event me-1" aria-hidden="true"></i>
                  Événements
                </a>
              </li>
            </ul>
          </li>

          <li><a href="#" class="nav-link scrollto">Communauté</a></li>
        </ul>
        <!-- Bouton menu mobile -->
        <button class="mobile-nav-toggle" aria-label="Ouvrir/fermer le menu de navigation" aria-controls="navbar">
          <i class="bi bi-list" aria-hidden="true"></i>
        </button>
      </nav>

      <!-- Bouton CTA (connexion / espace back) -->
      <a href="<?= BASE_URL ?>index.php?controller=evenement&action=adminDashboard"
         class="getstarted scrollto ms-3"
         aria-label="Accéder à l'espace administration">
        Administration
      </a>

    </div>
  </header>

  <!-- Espace compensant la hauteur du header fixe -->
  <div style="margin-top: 72px;" aria-hidden="true"></div>

  <!-- ══════════════════════════════════════════════════════════
       CONTENU PRINCIPAL (begin)
       Chaque vue insérera son contenu ici.
  ══════════════════════════════════════════════════════════ -->
  <main id="main" role="main">
