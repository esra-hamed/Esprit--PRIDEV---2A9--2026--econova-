<?php
/**
 * VIVORA – Vue Front : Fiche d'un lieu
 * Affiche les informations complètes d'un lieu, sa fiche d'accessibilité
 * et la liste des événements qui s'y déroulent.
 * Variables attendues depuis LieuController::show() :
 *   $lieu       (Lieu|null)    – objet Lieu
 *   $evenements (array)        – liste des événements du lieu
 */

// Titre dynamique selon le lieu chargé
$nomLieu        = $lieu ? $lieu->getNom() : 'Fiche lieu';
$titreOnglet    = $nomLieu;
$metaDescription = $lieu ? 'Fiche d\'accessibilité de ' . $nomLieu . ' à ' . $lieu->getVille() : '';

require __DIR__ . '/../layout/header.php';
?>

<!-- ── Fil d'Ariane ─────────────────────────────────────────── -->
<section class="breadcrumbs" aria-label="Fil d'Ariane">
  <div class="container">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="<?= BASE_URL ?>index.php">Accueil</a></li>
      <li class="breadcrumb-item"><a href="<?= BASE_URL ?>index.php?controller=lieu&action=list">Lieux</a></li>
      <li class="breadcrumb-item active" aria-current="page">
        <?= htmlspecialchars($nomLieu) ?>
      </li>
    </ol>
    <h2><?= htmlspecialchars($nomLieu) ?></h2>
  </div>
</section>

<!-- ── Contenu principal ────────────────────────────────────── -->
<section class="py-5">
  <div class="container">

    <?php if (!$lieu): ?>
      <!-- Lieu introuvable -->
      <div class="alert alert-warning" role="alert">
        <i class="bi bi-exclamation-triangle me-2" aria-hidden="true"></i>
        Ce lieu n'existe pas ou a été supprimé.
        <a href="<?= BASE_URL ?>index.php?controller=lieu&action=list" class="ms-2">
          ← Retour à la liste
        </a>
      </div>

    <?php else: ?>

      <div class="row g-4">

        <!-- ── Colonne gauche : image + infos ────────────────── -->
        <div class="col-lg-5">

          <!-- Image du lieu -->
          <figure class="mb-4">
            <?php if ($lieu->getImage()): ?>
              <img src="<?= BASE_URL ?>public/assets/front/img/lieux/<?= htmlspecialchars($lieu->getImage()) ?>"
                   class="img-fluid rounded shadow"
                   alt="Photo de <?= htmlspecialchars($lieu->getNom()) ?>"
                   style="width: 100%; height: 300px; object-fit: cover;">
            <?php else: ?>
              <img src="<?= BASE_URL ?>public/assets/front/img/lieu-placeholder.jpg"
                   class="img-fluid rounded shadow"
                   alt="Aucune photo disponible pour ce lieu"
                   style="width: 100%; height: 300px; object-fit: cover;">
            <?php endif; ?>
            <figcaption class="text-muted mt-2 small">
              <i class="bi bi-geo-alt me-1" aria-hidden="true"></i>
              <?= htmlspecialchars($lieu->getAdresse()) ?>,
              <?= htmlspecialchars($lieu->getVille()) ?>
            </figcaption>
          </figure>

          <!-- Informations générales -->
          <div class="card border-0 shadow-sm mb-4">
            <div class="card-body">
              <h2 class="h5 mb-3" style="color: var(--vivora-vert-profond); font-family: 'Lexend', sans-serif;">
                <i class="bi bi-info-circle me-2" aria-hidden="true"></i>
                Informations
              </h2>
              <dl class="row">
                <dt class="col-sm-4">Nom</dt>
                <dd class="col-sm-8"><?= htmlspecialchars($lieu->getNom()) ?></dd>

                <dt class="col-sm-4">Ville</dt>
                <dd class="col-sm-8"><?= htmlspecialchars($lieu->getVille()) ?></dd>

                <dt class="col-sm-4">Adresse</dt>
                <dd class="col-sm-8"><?= htmlspecialchars($lieu->getAdresse()) ?></dd>
              </dl>
              <?php if ($lieu->getDescription()): ?>
                <hr>
                <p class="mb-0"><?= nl2br(htmlspecialchars($lieu->getDescription())) ?></p>
              <?php endif; ?>
            </div>
          </div>

        </div><!-- Fin col gauche -->

        <!-- ── Colonne droite : fiche accessibilité ──────────── -->
        <div class="col-lg-7">

          <!-- Fiche d'accessibilité -->
          <div class="card border-0 shadow-sm mb-4">
            <div class="card-header" style="background-color: var(--vivora-vert-profond); color: #fff;">
              <h2 class="h5 mb-0" style="color: #fff; font-family: 'Lexend', sans-serif;">
                <i class="bi bi-universal-access me-2" aria-hidden="true"></i>
                Fiche d'accessibilité
              </h2>
            </div>
            <div class="card-body">

              <!-- Score global -->
              <div class="accessibilite-score mb-4">
                <div class="d-flex justify-content-between align-items-center mb-1">
                  <strong>Score d'accessibilité global</strong>
                  <span class="badge" style="background-color: var(--vivora-sarcelle); font-size: 1rem; padding: 6px 14px;">
                    <?= $lieu->getNombreCriteres() ?> / 4
                  </span>
                </div>
                <div class="progress" role="progressbar"
                     aria-label="Score d'accessibilité : <?= $lieu->getNombreCriteres() ?> critères sur 4"
                     aria-valuenow="<?= $lieu->getNombreCriteres() * 25 ?>"
                     aria-valuemin="0" aria-valuemax="100"
                     style="height: 14px;">
                  <div class="progress-bar"
                       style="width: <?= $lieu->getNombreCriteres() * 25 ?>%; font-size: 0.8rem;">
                    <?= $lieu->getNombreCriteres() * 25 ?>%
                  </div>
                </div>
                <?php if ($lieu->estTotalementAccessible()): ?>
                  <div class="mt-2">
                    <span class="badge-accessibilite badge-oui">
                      <i class="bi bi-award-fill" aria-hidden="true"></i>
                      Lieu 100 % accessible
                    </span>
                  </div>
                <?php endif; ?>
              </div>

              <!-- Détail des critères -->
              <table class="table table-bordered" aria-label="Détail des critères d'accessibilité">
                <thead>
                  <tr style="background-color: var(--vivora-sarcelle-clair);">
                    <th scope="col">Critère</th>
                    <th scope="col" class="text-center">Disponible</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>
                      <i class="bi bi-arrow-up-right-square me-2" aria-hidden="true"></i>
                      Rampe d'accès
                    </td>
                    <td class="text-center">
                      <?php if ($lieu->hasRampeAcces()): ?>
                        <span class="badge-accessibilite badge-oui">
                          <i class="bi bi-check-circle-fill" aria-hidden="true"></i>
                          <span class="visually-hidden">Oui</span> Oui
                        </span>
                      <?php else: ?>
                        <span class="badge-accessibilite badge-non">
                          <i class="bi bi-x-circle-fill" aria-hidden="true"></i>
                          <span class="visually-hidden">Non</span> Non
                        </span>
                      <?php endif; ?>
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <i class="bi bi-elevator me-2" aria-hidden="true"></i>
                      Ascenseur
                    </td>
                    <td class="text-center">
                      <?php if ($lieu->hasAscenseur()): ?>
                        <span class="badge-accessibilite badge-oui">
                          <i class="bi bi-check-circle-fill" aria-hidden="true"></i> Oui
                        </span>
                      <?php else: ?>
                        <span class="badge-accessibilite badge-non">
                          <i class="bi bi-x-circle-fill" aria-hidden="true"></i> Non
                        </span>
                      <?php endif; ?>
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <i class="bi bi-gender-ambiguous me-2" aria-hidden="true"></i>
                      Toilettes adaptées PMR
                    </td>
                    <td class="text-center">
                      <?php if ($lieu->hasToilettesAdaptees()): ?>
                        <span class="badge-accessibilite badge-oui">
                          <i class="bi bi-check-circle-fill" aria-hidden="true"></i> Oui
                        </span>
                      <?php else: ?>
                        <span class="badge-accessibilite badge-non">
                          <i class="bi bi-x-circle-fill" aria-hidden="true"></i> Non
                        </span>
                      <?php endif; ?>
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <i class="bi bi-p-square me-2" aria-hidden="true"></i>
                      Parking PMR
                    </td>
                    <td class="text-center">
                      <?php if ($lieu->hasParkingPmr()): ?>
                        <span class="badge-accessibilite badge-oui">
                          <i class="bi bi-check-circle-fill" aria-hidden="true"></i> Oui
                        </span>
                      <?php else: ?>
                        <span class="badge-accessibilite badge-non">
                          <i class="bi bi-x-circle-fill" aria-hidden="true"></i> Non
                        </span>
                      <?php endif; ?>
                    </td>
                  </tr>
                </tbody>
              </table>

            </div><!-- Fin card-body -->
          </div><!-- Fin card accessibilité -->

          <!-- ── Événements dans ce lieu ──────────────────────── -->
          <div class="card border-0 shadow-sm">
            <div class="card-header" style="background-color: var(--vivora-vert-profond); color: #fff;">
              <h2 class="h5 mb-0" style="color: #fff; font-family: 'Lexend', sans-serif;">
                <i class="bi bi-calendar-event me-2" aria-hidden="true"></i>
                Événements organisés ici
              </h2>
            </div>
            <div class="card-body">

              <?php if (empty($evenements)): ?>
                <p class="text-muted mb-0">
                  <i class="bi bi-calendar-x me-1" aria-hidden="true"></i>
                  Aucun événement prévu pour l'instant dans ce lieu.
                </p>
              <?php else: ?>
                <div class="list-group list-group-flush">
                  <?php foreach ($evenements as $ev): ?>
                    <a href="<?= BASE_URL ?>index.php?controller=evenement&action=show&id=<?= $ev->getId() ?>"
                       class="list-group-item list-group-item-action border-0 px-0 py-3">
                      <div class="d-flex align-items-start gap-3">
                        <!-- Date encadrée -->
                        <div class="text-center rounded p-2 flex-shrink-0"
                             style="background-color: var(--vivora-sarcelle-clair); min-width: 56px;">
                          <div style="font-family: 'Lexend', sans-serif; font-size: 1.3rem; color: var(--vivora-vert-profond); line-height: 1;">
                            <?= date('d', strtotime($ev->getDateEvenement())) ?>
                          </div>
                          <div style="font-size: 0.72rem; color: var(--vivora-sarcelle); text-transform: uppercase; font-weight: 600;">
                            <?= strtoupper(substr($ev->getDateFormatee(), 3, 3)) ?>
                          </div>
                        </div>
                        <!-- Infos événement -->
                        <div>
                          <strong style="color: var(--vivora-vert-profond);">
                            <?= htmlspecialchars($ev->getTitre()) ?>
                          </strong>
                          <div class="text-muted small">
                            <i class="bi bi-clock me-1" aria-hidden="true"></i>
                            <?= htmlspecialchars($ev->getHeureCourte()) ?>
                            &nbsp;·&nbsp;
                            <i class="bi bi-people me-1" aria-hidden="true"></i>
                            <?= $ev->getNbPlaces() ?> places
                          </div>
                        </div>
                      </div>
                    </a>
                  <?php endforeach; ?>
                </div>
              <?php endif; ?>

            </div><!-- Fin card-body événements -->
          </div><!-- Fin card événements -->

        </div><!-- Fin col droite -->
      </div><!-- Fin row -->

      <!-- Bouton retour -->
      <div class="mt-4">
        <a href="<?= BASE_URL ?>index.php?controller=lieu&action=list"
           class="btn btn-outline-secondary">
          <i class="bi bi-arrow-left me-1" aria-hidden="true"></i>
          Retour à la liste des lieux
        </a>
      </div>

    <?php endif; ?>

  </div><!-- Fin container -->
</section>

<?php require __DIR__ . '/../layout/footer.php'; ?>
