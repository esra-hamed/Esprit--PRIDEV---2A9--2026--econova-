<?php
/**
 * VIVORA – Vue Back : Formulaire Ajouter/Modifier un événement
 * Variables attendues depuis EvenementController :
 *   $evenement (Evenement) – objet vide (création) ou peuplé (modification)
 *   $lieux     (array)     – liste des objets Lieu pour le <select>
 *   $action    (string)    – 'create' ou 'edit'
 */

$estModif    = ($action === 'edit');
$titreOnglet = $estModif ? 'Modifier l\'événement' : 'Ajouter un événement';
$pageActive  = $estModif ? 'evenements-modifier' : 'evenements-ajouter';
$menuActif   = 'lieux-evenements';

require __DIR__ . '/../layout/header.php';
?>

<!-- ── En-tête ───────────────────────────────────────────────── -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">
          <i class="bi <?= $estModif ? 'bi-pencil-square' : 'bi-plus-circle' ?> me-2" aria-hidden="true"></i>
          <?= $estModif ? 'Modifier l\'événement' : 'Ajouter un événement' ?>
        </h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right" aria-label="Fil d'Ariane">
          <li class="breadcrumb-item">
            <a href="<?= BASE_URL ?>index.php?controller=evenement&action=adminDashboard">Tableau de bord</a>
          </li>
          <li class="breadcrumb-item">
            <a href="<?= BASE_URL ?>index.php?controller=evenement&action=adminList">Événements</a>
          </li>
          <li class="breadcrumb-item active">
            <?= $estModif ? 'Modifier' : 'Ajouter' ?>
          </li>
        </ol>
      </div>
    </div>
  </div>
</div>

<!-- ── Contenu ───────────────────────────────────────────────── -->
<section class="content">
  <div class="container-fluid">
    <div class="row justify-content-center">
      <div class="col-lg-8">

        <div class="card">
          <div class="card-header">
            <h2 class="card-title">
              <i class="bi bi-calendar-event me-2" aria-hidden="true"></i>
              <?= $estModif ? 'Modifier les informations de l\'événement' : 'Informations du nouvel événement' ?>
            </h2>
          </div>
          <div class="card-body">

            <form method="POST"
                  action="<?= BASE_URL ?>index.php?controller=evenement&action=<?= $estModif ? 'adminEdit&id=' . $evenement->getId() : 'adminCreate' ?>"
                  enctype="multipart/form-data"
                  novalidate
                  aria-label="Formulaire de l'événement">

              <?php if ($estModif): ?>
                <input type="hidden" name="id" value="<?= (int) $evenement->getId() ?>">
              <?php endif; ?>

              <!-- ── Infos générales ─────────────────────── -->
              <fieldset class="mb-4">
                <legend class="text-uppercase fw-semibold"
                        style="font-size: 0.85rem; color: var(--vivora-sarcelle); border-bottom: 2px solid var(--vivora-sarcelle-clair); padding-bottom: 6px;">
                  Informations générales
                </legend>

                <!-- Titre -->
                <div class="mb-3">
                  <label for="titre" class="form-label fw-semibold">
                    Titre de l'événement
                    <span aria-hidden="true" style="color: var(--vivora-corail);">*</span>
                  </label>
                  <input type="text"
                         class="form-control"
                         id="titre"
                         name="titre"
                         value="<?= htmlspecialchars($evenement->getTitre()) ?>"
                         required
                         minlength="3"
                         maxlength="200"
                         aria-required="true"
                         placeholder="Ex. : Forum Emploi & Handicap 2027">
                  <div class="invalid-feedback">Le titre est obligatoire (minimum 3 caractères).</div>
                </div>

                <!-- Lieu (liste déroulante) -->
                <div class="mb-3">
                  <label for="lieu_id" class="form-label fw-semibold">
                    Lieu
                    <span aria-hidden="true" style="color: var(--vivora-corail);">*</span>
                  </label>
                  <select class="form-select"
                          id="lieu_id"
                          name="lieu_id"
                          required
                          aria-required="true"
                          aria-describedby="lieu-aide">
                    <option value="">-- Choisir un lieu --</option>
                    <?php foreach ($lieux as $lieu): ?>
                      <option value="<?= $lieu->getId() ?>"
                              <?= ($evenement->getLieuId() === $lieu->getId()) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($lieu->getNom()) ?> – <?= htmlspecialchars($lieu->getVille()) ?>
                      </option>
                    <?php endforeach; ?>
                  </select>
                  <div id="lieu-aide" class="form-text">
                    Seuls les lieux enregistrés apparaissent ici.
                    <a href="<?= BASE_URL ?>index.php?controller=lieu&action=adminCreate" target="_blank">
                      Ajouter un lieu
                    </a>
                  </div>
                  <div class="invalid-feedback">Veuillez choisir un lieu.</div>
                </div>

                <!-- Description -->
                <div class="mb-3">
                  <label for="description" class="form-label fw-semibold">
                    Description
                  </label>
                  <textarea class="form-control"
                             id="description"
                             name="description"
                             rows="4"
                             maxlength="3000"
                             placeholder="Décrivez le programme, le public cible, les mesures d'accessibilité prévues..."><?= htmlspecialchars($evenement->getDescription() ?? '') ?></textarea>
                </div>

                <!-- Image -->
                <div class="mb-3">
                  <label for="image" class="form-label fw-semibold">
                    Affiche / Image de l'événement
                  </label>
                  <?php if ($estModif && $evenement->getImage()): ?>
                    <div class="mb-2">
                      <img src="<?= BASE_URL ?>public/assets/front/img/evenements/<?= htmlspecialchars($evenement->getImage()) ?>"
                           alt="Affiche actuelle : <?= htmlspecialchars($evenement->getTitre()) ?>"
                           style="height: 100px; object-fit: cover; border-radius: 6px;">
                    </div>
                  <?php endif; ?>
                  <input type="file"
                         class="form-control"
                         id="image"
                         name="image"
                         accept="image/jpeg,image/png,image/webp">
                  <div class="form-text">JPG, PNG ou WebP. Max 2 Mo.</div>
                </div>

              </fieldset>

              <!-- ── Date, heure et places ───────────────── -->
              <fieldset class="mb-4">
                <legend class="text-uppercase fw-semibold"
                        style="font-size: 0.85rem; color: var(--vivora-sarcelle); border-bottom: 2px solid var(--vivora-sarcelle-clair); padding-bottom: 6px;">
                  Planification
                </legend>

                <div class="row">
                  <!-- Date -->
                  <div class="col-md-4 mb-3">
                    <label for="date_evenement" class="form-label fw-semibold">
                      Date
                      <span aria-hidden="true" style="color: var(--vivora-corail);">*</span>
                    </label>
                    <input type="date"
                           class="form-control"
                           id="date_evenement"
                           name="date_evenement"
                           value="<?= htmlspecialchars($evenement->getDateEvenement()) ?>"
                           required
                           min="<?= date('Y-m-d') ?>"
                           aria-required="true">
                    <div class="invalid-feedback">La date est obligatoire (ne peut pas être dans le passé).</div>
                  </div>

                  <!-- Heure -->
                  <div class="col-md-4 mb-3">
                    <label for="heure" class="form-label fw-semibold">
                      Heure
                      <span aria-hidden="true" style="color: var(--vivora-corail);">*</span>
                    </label>
                    <input type="time"
                           class="form-control"
                           id="heure"
                           name="heure"
                           value="<?= htmlspecialchars(substr($evenement->getHeure(), 0, 5)) ?>"
                           required
                           aria-required="true">
                    <div class="invalid-feedback">L'heure est obligatoire.</div>
                  </div>

                  <!-- Nombre de places -->
                  <div class="col-md-4 mb-3">
                    <label for="nb_places" class="form-label fw-semibold">
                      Nombre de places
                      <span aria-hidden="true" style="color: var(--vivora-corail);">*</span>
                    </label>
                    <input type="number"
                           class="form-control"
                           id="nb_places"
                           name="nb_places"
                           value="<?= (int) $evenement->getNbPlaces() ?>"
                           required
                           min="1"
                           max="10000"
                           aria-required="true"
                           placeholder="Ex. : 100">
                    <div class="invalid-feedback">Minimum 1 place.</div>
                  </div>
                </div><!-- Fin row planification -->

              </fieldset>

              <!-- ── Boutons ─────────────────────────────── -->
              <div class="d-flex gap-3 flex-wrap">
                <button type="submit" class="btn btn-vivora-cta btn-lg">
                  <i class="bi <?= $estModif ? 'bi-check-lg' : 'bi-plus-lg' ?> me-2" aria-hidden="true"></i>
                  <?= $estModif ? 'Enregistrer les modifications' : 'Créer l\'événement' ?>
                </button>
                <a href="<?= BASE_URL ?>index.php?controller=evenement&action=adminList"
                   class="btn btn-outline-secondary btn-lg">
                  <i class="bi bi-x-lg me-1" aria-hidden="true"></i>
                  Annuler
                </a>
              </div>

            </form>

          </div><!-- Fin card-body -->
        </div><!-- Fin card -->

      </div><!-- Fin col -->
    </div><!-- Fin row -->
  </div><!-- Fin container-fluid -->
</section>

<!-- Validation Bootstrap -->
<script>
(function () {
  'use strict';
  document.querySelectorAll('form[novalidate]').forEach(function (form) {
    form.addEventListener('submit', function (event) {
      if (!form.checkValidity()) {
        event.preventDefault();
        event.stopPropagation();
      }
      form.classList.add('was-validated');
    }, false);
  });
})();
</script>

<?php require __DIR__ . '/../layout/footer.php'; ?>
