<?php
/**
 * VIVORA – Vue Front : Liste des événements
 * Affiche les événements sous forme de cartes avec date, lieu et places restantes.
 * Variables attendues depuis EvenementController::list() :
 *   $evenements (array) – liste des objets Evenement (avec nom_lieu via JOIN)
 */

$titreOnglet    = 'Événements';
$metaDescription = 'Agenda des événements accessibles en Tunisie : forums, ateliers, concerts et activités sportives adaptées.';

require __DIR__ . '/../layout/header.php';
?>

<!-- ── Fil d'Ariane ─────────────────────────────────────────── -->
<section class="breadcrumbs" aria-label="Fil d'Ariane">
  <div class="container">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="<?= BASE_URL ?>index.php">Accueil</a></li>
      <li class="breadcrumb-item active" aria-current="page">Événements</li>
    </ol>
    <h2>Agenda des événements</h2>
  </div>
</section>

<!-- ── Contenu principal ────────────────────────────────────── -->
<section class="py-5">
  <div class="container">

    <!-- En-tête de section -->
    <div class="text-center mb-5">
      <h1 style="font-family: 'Lexend', sans-serif; color: var(--vivora-vert-profond);">
        Événements accessibles
      </h1>
      <p class="lead text-muted">
        Découvrez les prochains événements organisés dans des lieux entièrement accessibles en Tunisie.
      </p>
    </div>

    <?php if (empty($evenements)): ?>
      <!-- Message si aucun événement -->
      <div class="alert text-center py-5" style="background-color: var(--vivora-sarcelle-clair);" role="status">
        <i class="bi bi-calendar-x" style="font-size: 3rem; color: var(--vivora-sarcelle);" aria-hidden="true"></i>
        <h3 class="mt-3" style="font-family: 'Lexend', sans-serif; color: var(--vivora-vert-profond);">
          Aucun événement à venir
        </h3>
        <p class="text-muted">Revenez bientôt pour découvrir de nouveaux événements !</p>
      </div>

      <!-- Cartes de démonstration -->
      <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4" aria-label="Aperçu des événements (démonstration)">
        <?php
        $exemples = [
          ['titre' => 'Exposition : Art Inclusif',      'lieu' => 'Centre Culturel Ibn Rachiq', 'date' => '2027-01-15', 'heure' => '10:00', 'places' => 80],
          ['titre' => 'Forum Emploi & Handicap',         'lieu' => 'Espace Capacités Ariana',    'date' => '2027-01-28', 'heure' => '09:00', 'places' => 120],
          ['titre' => 'Conférence : Villes Inclusives',  'lieu' => 'Palais des Congrès, Sousse', 'date' => '2027-03-05', 'heure' => '09:30', 'places' => 300],
        ];
        foreach ($exemples as $ex):
        $ts = strtotime($ex['date']);
        $moisFr = ['','jan.','fév.','mar.','avr.','mai','juin','juil.','août','sept.','oct.','nov.','déc.'];
        ?>
        <div class="col">
          <article class="card card-evenement h-100">
            <img src="<?= BASE_URL ?>public/assets/front/img/evenement-placeholder.jpg"
                 class="card-img-top"
                 alt="Affiche de l'événement : <?= htmlspecialchars($ex['titre']) ?>"
                 loading="lazy">
            <div class="card-body">
              <!-- Date en bandeau -->
              <div class="d-flex align-items-center gap-3 mb-3">
                <div class="text-center rounded p-2"
                     style="background-color: var(--vivora-sarcelle-clair); min-width: 56px;">
                  <div style="font-family: 'Lexend', sans-serif; font-size: 1.5rem; color: var(--vivora-vert-profond); line-height: 1;">
                    <?= date('d', $ts) ?>
                  </div>
                  <div style="font-size: 0.72rem; color: var(--vivora-sarcelle); font-weight: 600; text-transform: uppercase;">
                    <?= $moisFr[(int)date('n', $ts)] ?>
                  </div>
                  <div style="font-size: 0.7rem; color: var(--vivora-vert-profond);">
                    <?= date('Y', $ts) ?>
                  </div>
                </div>
                <div>
                  <h3 class="card-title h6 mb-0"><?= htmlspecialchars($ex['titre']) ?></h3>
                </div>
              </div>

              <!-- Lieu -->
              <p class="text-muted small mb-1">
                <i class="bi bi-geo-alt me-1" aria-hidden="true"></i>
                <?= htmlspecialchars($ex['lieu']) ?>
              </p>

              <!-- Heure et places -->
              <div class="d-flex justify-content-between align-items-center">
                <span class="small text-muted">
                  <i class="bi bi-clock me-1" aria-hidden="true"></i>
                  <?= htmlspecialchars($ex['heure']) ?>
                </span>
                <span class="badge" style="background-color: var(--vivora-corail); color: #fff;">
                  <?= $ex['places'] ?> places
                </span>
              </div>
            </div>
            <div class="card-footer bg-transparent border-0">
              <a href="<?= BASE_URL ?>index.php?controller=evenement&action=show&id=1"
                 class="btn btn-vivora-secondary w-100">
                Voir l'événement
                <i class="bi bi-arrow-right ms-1" aria-hidden="true"></i>
              </a>
            </div>
          </article>
        </div>
        <?php endforeach; ?>
      </div><!-- Fin row démo -->

    <?php else: ?>

      <!-- ── Grille des événements réels ───────────────────── -->
      <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
        <?php foreach ($evenements as $evenement):
          $ts = strtotime($evenement->getDateEvenement());
          $moisFr = ['','jan.','fév.','mar.','avr.','mai','juin','juil.','août','sept.','oct.','nov.','déc.'];
        ?>
        <div class="col">
          <article class="card card-evenement h-100"
                   aria-label="Événement : <?= htmlspecialchars($evenement->getTitre()) ?>">

            <!-- Image de l'événement -->
            <?php if ($evenement->getImage()): ?>
              <img src="<?= BASE_URL ?>public/assets/front/img/evenements/<?= htmlspecialchars($evenement->getImage()) ?>"
                   class="card-img-top"
                   alt="Affiche de <?= htmlspecialchars($evenement->getTitre()) ?>"
                   loading="lazy">
            <?php else: ?>
              <img src="<?= BASE_URL ?>public/assets/front/img/evenement-placeholder.jpg"
                   class="card-img-top"
                   alt="Aucune affiche disponible pour cet événement"
                   loading="lazy">
            <?php endif; ?>

            <div class="card-body">
              <!-- Bloc date + titre -->
              <div class="d-flex align-items-center gap-3 mb-3">
                <div class="text-center rounded p-2 flex-shrink-0"
                     style="background-color: var(--vivora-sarcelle-clair); min-width: 56px;">
                  <div style="font-family: 'Lexend', sans-serif; font-size: 1.5rem; color: var(--vivora-vert-profond); line-height: 1;">
                    <?= date('d', $ts) ?>
                  </div>
                  <div style="font-size: 0.72rem; color: var(--vivora-sarcelle); font-weight: 600; text-transform: uppercase;">
                    <?= $moisFr[(int)date('n', $ts)] ?>
                  </div>
                  <div style="font-size: 0.7rem; color: var(--vivora-vert-profond);">
                    <?= date('Y', $ts) ?>
                  </div>
                </div>
                <h3 class="card-title h6 mb-0">
                  <?= htmlspecialchars($evenement->getTitre()) ?>
                </h3>
              </div>

              <!-- Lieu (via jointure) -->
              <?php if ($evenement->getNomLieu()): ?>
                <p class="text-muted small mb-1">
                  <i class="bi bi-geo-alt me-1" aria-hidden="true"></i>
                  <?= htmlspecialchars($evenement->getNomLieu()) ?>
                </p>
              <?php endif; ?>

              <!-- Heure et places -->
              <div class="d-flex justify-content-between align-items-center mt-2">
                <span class="small text-muted">
                  <i class="bi bi-clock me-1" aria-hidden="true"></i>
                  <?= htmlspecialchars($evenement->getHeureCourte()) ?>
                </span>
                <span class="badge"
                      style="background-color: <?= $evenement->getNbPlaces() > 0 ? 'var(--vivora-corail)' : '#dc3545' ?>; color: #fff;"
                      aria-label="<?= $evenement->getNbPlaces() ?> places disponibles">
                  <?= $evenement->getNbPlaces() ?> place<?= $evenement->getNbPlaces() > 1 ? 's' : '' ?>
                </span>
              </div>
            </div>

            <div class="card-footer bg-transparent border-0">
              <a href="<?= BASE_URL ?>index.php?controller=evenement&action=show&id=<?= $evenement->getId() ?>"
                 class="btn btn-vivora-secondary w-100">
                Voir l'événement
                <i class="bi bi-arrow-right ms-1" aria-hidden="true"></i>
              </a>
            </div>
          </article>
        </div>
        <?php endforeach; ?>
      </div><!-- Fin row -->

    <?php endif; ?>

  </div><!-- Fin container -->
</section>

<?php require __DIR__ . '/../layout/footer.php'; ?>
