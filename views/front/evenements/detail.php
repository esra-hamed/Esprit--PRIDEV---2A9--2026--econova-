<?php
/**
 * VIVORA – Vue Front : Détail d'un événement
 * Affiche toutes les informations d'un événement avec le bouton "S'inscrire".
 * Variables attendues depuis EvenementController::show() :
 *   $evenement (Evenement|null) – objet Evenement (avec nom_lieu via JOIN)
 */

$titreEv        = $evenement ? $evenement->getTitre() : 'Événement';
$titreOnglet    = $titreEv;
$metaDescription = $evenement ? 'Détail de l\'événement : ' . $titreEv : '';

require __DIR__ . '/../layout/header.php';
?>

<!-- ── Fil d'Ariane ─────────────────────────────────────────── -->
<section class="breadcrumbs" aria-label="Fil d'Ariane">
  <div class="container">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="<?= BASE_URL ?>index.php">Accueil</a></li>
      <li class="breadcrumb-item">
        <a href="<?= BASE_URL ?>index.php?controller=evenement&action=list">Événements</a>
      </li>
      <li class="breadcrumb-item active" aria-current="page">
        <?= htmlspecialchars($titreEv) ?>
      </li>
    </ol>
    <h2><?= htmlspecialchars($titreEv) ?></h2>
  </div>
</section>

<!-- ── Contenu principal ────────────────────────────────────── -->
<section class="py-5">
  <div class="container">

    <?php if (!$evenement): ?>
      <div class="alert alert-warning" role="alert">
        <i class="bi bi-exclamation-triangle me-2" aria-hidden="true"></i>
        Cet événement n'existe pas ou a été supprimé.
        <a href="<?= BASE_URL ?>index.php?controller=evenement&action=list" class="ms-2">
          ← Retour à l'agenda
        </a>
      </div>

    <?php else: ?>

      <div class="row g-4">

        <!-- ── Colonne gauche : image ────────────────────────── -->
        <div class="col-lg-5">
          <figure>
            <?php if ($evenement->getImage()): ?>
              <img src="<?= BASE_URL ?>public/assets/front/img/evenements/<?= htmlspecialchars($evenement->getImage()) ?>"
                   class="img-fluid rounded shadow w-100"
                   alt="Affiche de l'événement : <?= htmlspecialchars($evenement->getTitre()) ?>"
                   style="height: 320px; object-fit: cover;">
            <?php else: ?>
              <img src="<?= BASE_URL ?>public/assets/front/img/evenement-placeholder.jpg"
                   class="img-fluid rounded shadow w-100"
                   alt="Aucune affiche disponible pour cet événement"
                   style="height: 320px; object-fit: cover;">
            <?php endif; ?>
          </figure>

          <!-- Encart "Date & Lieu" -->
          <div class="card border-0 shadow-sm mt-4"
               style="background-color: var(--vivora-sarcelle-clair);">
            <div class="card-body">
              <dl class="row mb-0">
                <dt class="col-5">
                  <i class="bi bi-calendar-event me-1" aria-hidden="true"></i> Date
                </dt>
                <dd class="col-7"><?= htmlspecialchars($evenement->getDateFormatee()) ?></dd>

                <dt class="col-5">
                  <i class="bi bi-clock me-1" aria-hidden="true"></i> Heure
                </dt>
                <dd class="col-7"><?= htmlspecialchars($evenement->getHeureCourte()) ?></dd>

                <?php if ($evenement->getNomLieu()): ?>
                <dt class="col-5">
                  <i class="bi bi-geo-alt me-1" aria-hidden="true"></i> Lieu
                </dt>
                <dd class="col-7"><?= htmlspecialchars($evenement->getNomLieu()) ?></dd>
                <?php endif; ?>

                <dt class="col-5">
                  <i class="bi bi-people me-1" aria-hidden="true"></i> Places
                </dt>
                <dd class="col-7">
                  <strong style="color: <?= $evenement->getNbPlaces() > 0 ? 'var(--vivora-sarcelle)' : '#dc3545' ?>">
                    <?= $evenement->getNbPlaces() ?>
                    place<?= $evenement->getNbPlaces() > 1 ? 's' : '' ?> disponible<?= $evenement->getNbPlaces() > 1 ? 's' : '' ?>
                  </strong>
                </dd>
              </dl>
            </div>
          </div>

        </div><!-- Fin col gauche -->

        <!-- ── Colonne droite : description + CTA ───────────── -->
        <div class="col-lg-7">

          <h1 style="font-family: 'Lexend', sans-serif; color: var(--vivora-vert-profond);">
            <?= htmlspecialchars($evenement->getTitre()) ?>
          </h1>

          <?php if ($evenement->getNomLieu()): ?>
            <p class="text-muted mb-4">
              <i class="bi bi-geo-alt-fill me-1" style="color: var(--vivora-sarcelle);" aria-hidden="true"></i>
              <a href="<?= BASE_URL ?>index.php?controller=lieu&action=show&id=<?= $evenement->getLieuId() ?>">
                <?= htmlspecialchars($evenement->getNomLieu()) ?>
              </a>
            </p>
          <?php endif; ?>

          <!-- Description -->
          <?php if ($evenement->getDescription()): ?>
            <div class="mb-4" style="font-size: 1.05rem; line-height: 1.8;">
              <?= nl2br(htmlspecialchars($evenement->getDescription())) ?>
            </div>
          <?php endif; ?>

          <hr>

          <!-- Bouton d'inscription -->
          <?php if ($evenement->getNbPlaces() > 0 && $evenement->estAVenir()): ?>
            <div class="mt-4">
              <a href="<?= BASE_URL ?>index.php?controller=evenement&action=inscription&id=<?= $evenement->getId() ?>"
                 class="btn btn-vivora-primary btn-lg"
                 aria-label="S'inscrire à l'événement : <?= htmlspecialchars($evenement->getTitre()) ?>">
                <i class="bi bi-pencil-square me-2" aria-hidden="true"></i>
                S'inscrire à cet événement
              </a>
              <p class="text-muted small mt-2">
                Il reste <strong><?= $evenement->getNbPlaces() ?> place<?= $evenement->getNbPlaces() > 1 ? 's' : '' ?></strong>.
                L'inscription est gratuite et ouverte à tous.
              </p>
            </div>

          <?php elseif (!$evenement->estAVenir()): ?>
            <div class="alert" style="background-color: #f0efeb; border: 1px solid #ccc;" role="status">
              <i class="bi bi-clock-history me-2" aria-hidden="true"></i>
              Cet événement est passé. Consultez l'<a href="<?= BASE_URL ?>index.php?controller=evenement&action=list">agenda</a> pour les prochains événements.
            </div>

          <?php else: ?>
            <div class="alert alert-danger" role="status">
              <i class="bi bi-x-circle me-2" aria-hidden="true"></i>
              Plus de places disponibles pour cet événement.
            </div>
          <?php endif; ?>

          <!-- Bouton retour -->
          <div class="mt-3">
            <a href="<?= BASE_URL ?>index.php?controller=evenement&action=list"
               class="btn btn-outline-secondary">
              <i class="bi bi-arrow-left me-1" aria-hidden="true"></i>
              Retour à l'agenda
            </a>
          </div>

        </div><!-- Fin col droite -->
      </div><!-- Fin row -->

    <?php endif; ?>

  </div><!-- Fin container -->
</section>

<?php require __DIR__ . '/../layout/footer.php'; ?>
