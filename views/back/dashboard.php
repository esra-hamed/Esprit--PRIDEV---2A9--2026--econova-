<?php
/**
 * VIVORA – Vue Back : Tableau de bord du Module 4
 * Affiche les 4 cartes de statistiques du module Lieux & Événements.
 * Variables attendues depuis EvenementController::adminDashboard() :
 *   $stats (array) – nb_lieux, nb_evenements, evenements_a_venir, lieux_accessibles
 */

$titreOnglet = 'Tableau de bord – Lieux & Événements';
$pageActive  = 'dashboard';
$menuActif   = 'lieux-evenements';

require __DIR__ . '/layout/header.php';
?>

<!-- ── En-tête de la page ────────────────────────────────────── -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">
          <i class="bi bi-speedometer2 me-2" aria-hidden="true"></i>
          Tableau de bord
        </h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right" aria-label="Fil d'Ariane">
          <li class="breadcrumb-item"><a href="<?= BASE_URL ?>index.php">Site</a></li>
          <li class="breadcrumb-item active">Tableau de bord</li>
        </ol>
      </div>
    </div>
  </div>
</div>

<!-- ── Contenu ───────────────────────────────────────────────── -->
<section class="content">
  <div class="container-fluid">

    <!-- ── Cartes statistiques (Small Boxes AdminLTE) ────────── -->
    <div class="row">

      <!-- Carte 1 : Nombre de lieux -->
      <div class="col-lg-3 col-6">
        <div class="small-box bg-vivora-vert"
             role="region" aria-label="Statistique : nombre de lieux">
          <div class="inner">
            <h3><?= (int) ($stats['nb_lieux'] ?? 0) ?></h3>
            <p>Lieux enregistrés</p>
          </div>
          <div class="icon" aria-hidden="true">
            <i class="bi bi-geo-alt-fill"></i>
          </div>
          <a href="<?= BASE_URL ?>index.php?controller=lieu&action=adminList"
             class="small-box-footer">
            Gérer les lieux
            <i class="fas fa-arrow-circle-right ms-1" aria-hidden="true"></i>
          </a>
        </div>
      </div>

      <!-- Carte 2 : Nombre d'événements -->
      <div class="col-lg-3 col-6">
        <div class="small-box bg-vivora-sarcelle"
             role="region" aria-label="Statistique : nombre d'événements">
          <div class="inner">
            <h3><?= (int) ($stats['nb_evenements'] ?? 0) ?></h3>
            <p>Événements au total</p>
          </div>
          <div class="icon" aria-hidden="true">
            <i class="bi bi-calendar-event-fill"></i>
          </div>
          <a href="<?= BASE_URL ?>index.php?controller=evenement&action=adminList"
             class="small-box-footer">
            Gérer les événements
            <i class="fas fa-arrow-circle-right ms-1" aria-hidden="true"></i>
          </a>
        </div>
      </div>

      <!-- Carte 3 : Événements à venir -->
      <div class="col-lg-3 col-6">
        <div class="small-box bg-vivora-corail"
             role="region" aria-label="Statistique : événements à venir">
          <div class="inner">
            <h3><?= (int) ($stats['evenements_a_venir'] ?? 0) ?></h3>
            <p>Événements à venir</p>
          </div>
          <div class="icon" aria-hidden="true">
            <i class="bi bi-clock-fill"></i>
          </div>
          <a href="<?= BASE_URL ?>index.php?controller=evenement&action=adminList"
             class="small-box-footer">
            Voir l'agenda
            <i class="fas fa-arrow-circle-right ms-1" aria-hidden="true"></i>
          </a>
        </div>
      </div>

      <!-- Carte 4 : Lieux 100 % accessibles -->
      <div class="col-lg-3 col-6">
        <div class="small-box bg-vivora-clair"
             role="region" aria-label="Statistique : lieux 100 % accessibles">
          <div class="inner">
            <h3><?= (int) ($stats['lieux_accessibles'] ?? 0) ?></h3>
            <p>Lieux 100 % accessibles</p>
          </div>
          <div class="icon" aria-hidden="true">
            <i class="bi bi-award-fill" style="color: var(--vivora-vert-profond);"></i>
          </div>
          <a href="<?= BASE_URL ?>index.php?controller=lieu&action=adminList"
             class="small-box-footer"
             style="color: var(--vivora-vert-profond);">
            Voir les lieux
            <i class="fas fa-arrow-circle-right ms-1" aria-hidden="true"></i>
          </a>
        </div>
      </div>

    </div><!-- Fin row cartes stats -->

    <!-- ── Section actions rapides ───────────────────────────── -->
    <div class="row">

      <!-- Accès rapide Lieux -->
      <div class="col-md-6">
        <div class="card">
          <div class="card-header">
            <h2 class="card-title">
              <i class="bi bi-geo-alt me-2" aria-hidden="true"></i>
              Gestion des lieux
            </h2>
            <div class="card-tools">
              <a href="<?= BASE_URL ?>index.php?controller=lieu&action=adminList"
                 class="btn btn-sm btn-vivora">
                Voir tout
              </a>
            </div>
          </div>
          <div class="card-body">
            <p>Ajoutez, modifiez ou supprimez des lieux accessibles et renseignez leurs critères d'accessibilité PMR.</p>
            <div class="d-flex gap-2 flex-wrap">
              <a href="<?= BASE_URL ?>index.php?controller=lieu&action=adminCreate"
                 class="btn btn-vivora-cta">
                <i class="bi bi-plus-circle me-1" aria-hidden="true"></i>
                Ajouter un lieu
              </a>
              <a href="<?= BASE_URL ?>index.php?controller=lieu&action=adminList"
                 class="btn btn-vivora">
                <i class="bi bi-list-ul me-1" aria-hidden="true"></i>
                Liste des lieux
              </a>
            </div>
          </div>
        </div>
      </div>

      <!-- Accès rapide Événements -->
      <div class="col-md-6">
        <div class="card">
          <div class="card-header">
            <h2 class="card-title">
              <i class="bi bi-calendar-event me-2" aria-hidden="true"></i>
              Gestion des événements
            </h2>
            <div class="card-tools">
              <a href="<?= BASE_URL ?>index.php?controller=evenement&action=adminList"
                 class="btn btn-sm btn-vivora">
                Voir tout
              </a>
            </div>
          </div>
          <div class="card-body">
            <p>Planifiez des événements accessibles, gérez les inscriptions et consultez la liste des participants.</p>
            <div class="d-flex gap-2 flex-wrap">
              <a href="<?= BASE_URL ?>index.php?controller=evenement&action=adminCreate"
                 class="btn btn-vivora-cta">
                <i class="bi bi-plus-circle me-1" aria-hidden="true"></i>
                Ajouter un événement
              </a>
              <a href="<?= BASE_URL ?>index.php?controller=evenement&action=adminList"
                 class="btn btn-vivora">
                <i class="bi bi-list-ul me-1" aria-hidden="true"></i>
                Liste des événements
              </a>
            </div>
          </div>
        </div>
      </div>

    </div><!-- Fin row actions rapides -->

    <!-- ── Note de développement ─────────────────────────────── -->
    <div class="callout callout-info" role="note" aria-label="Note de développement">
      <h3 class="h5">
        <i class="bi bi-info-circle me-2" aria-hidden="true"></i>
        Les statistiques
      </h3>
      <p class="mb-0">
        Les chiffres affichés seront calculés dynamiquement depuis la base de données
        lors de l'implémentation du CRUD (étape suivante).
        Pour l'instant, ils affichent <strong>0</strong> (valeurs par défaut).
      </p>
    </div>

  </div><!-- Fin container-fluid -->
</section>

<?php require __DIR__ . '/layout/footer.php'; ?>
