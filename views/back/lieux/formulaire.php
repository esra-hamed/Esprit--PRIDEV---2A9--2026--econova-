<?php
/**
 * VIVORA – Vue Back : Formulaire Ajouter/Modifier un lieu
 * Utilisé pour les deux actions adminCreate et adminEdit.
 * Variables attendues depuis LieuController :
 *   $lieu   (Lieu)   – objet Lieu (vide pour création, peuplé pour modification)
 *   $action (string) – 'create' ou 'edit'
 */

$estModif    = ($action === 'edit');
$titreOnglet = $estModif ? 'Modifier le lieu' : 'Ajouter un lieu';
$pageActive  = $estModif ? 'lieux-modifier' : 'lieux-ajouter';
$menuActif   = 'lieux-evenements';

require __DIR__ . '/../layout/header.php';
?>

<!-- ── En-tête de la page ────────────────────────────────────── -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">
          <i class="bi <?= $estModif ? 'bi-pencil-square' : 'bi-plus-circle' ?> me-2" aria-hidden="true"></i>
          <?= $estModif ? 'Modifier le lieu' : 'Ajouter un lieu' ?>
        </h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right" aria-label="Fil d'Ariane">
          <li class="breadcrumb-item">
            <a href="<?= BASE_URL ?>index.php?controller=evenement&action=adminDashboard">Tableau de bord</a>
          </li>
          <li class="breadcrumb-item">
            <a href="<?= BASE_URL ?>index.php?controller=lieu&action=adminList">Lieux</a>
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
              <i class="bi bi-geo-alt me-2" aria-hidden="true"></i>
              <?= $estModif ? 'Modifier les informations du lieu' : 'Informations du nouveau lieu' ?>
            </h2>
          </div>
          <div class="card-body">

            <!-- ── Formulaire ──────────────────────────────── -->
            <form method="POST"
                  action="<?= BASE_URL ?>index.php?controller=lieu&action=<?= $estModif ? 'adminEdit&id=' . $lieu->getId() : 'adminCreate' ?>"
                  enctype="multipart/form-data"
                  novalidate
                  aria-label="<?= $estModif ? 'Formulaire de modification du lieu' : 'Formulaire d\'ajout d\'un lieu' ?>">

              <!-- Champ caché pour l'ID (modification) -->
              <?php if ($estModif): ?>
                <input type="hidden" name="id" value="<?= (int) $lieu->getId() ?>">
              <?php endif; ?>

              <!-- ── Informations générales ─────────────── -->
              <fieldset class="mb-4">
                <legend class="text-uppercase fw-semibold"
                        style="font-size: 0.85rem; color: var(--vivora-sarcelle); border-bottom: 2px solid var(--vivora-sarcelle-clair); padding-bottom: 6px;">
                  Informations générales
                </legend>

                <!-- Nom du lieu -->
                <div class="mb-3">
                  <label for="nom" class="form-label fw-semibold">
                    Nom du lieu
                    <span aria-hidden="true" style="color: var(--vivora-corail);">*</span>
                  </label>
                  <input type="text"
                         class="form-control"
                         id="nom"
                         name="nom"
                         value="<?= htmlspecialchars($lieu->getNom()) ?>"
                         required
                         minlength="2"
                         maxlength="150"
                         aria-required="true"
                         placeholder="Ex. : Centre Culturel Ibn Rachiq">
                  <div class="invalid-feedback">Le nom est obligatoire (minimum 2 caractères).</div>
                </div>

                <!-- Ville -->
                <div class="mb-3">
                  <label for="ville" class="form-label fw-semibold">
                    Ville
                    <span aria-hidden="true" style="color: var(--vivora-corail);">*</span>
                  </label>
                  <select class="form-select" id="ville" name="ville" required aria-required="true">
                    <option value="">-- Choisir une ville --</option>
                    <?php
                    $villes = ['Tunis', 'Ariana', 'Ben Arous', 'La Manouba', 'Sousse', 'Sfax', 'Bizerte', 'Nabeul', 'Monastir', 'Mahdia', 'Kairouan', 'Gabès', 'Gafsa', 'Médenine', 'Tataouine', 'Tozeur', 'Kébili', 'Kasserine', 'Siliana', 'Jendouba', 'El Kef', 'Béja', 'Zaghouan', 'Sidi Bouzid'];
                    foreach ($villes as $v):
                    ?>
                      <option value="<?= htmlspecialchars($v) ?>"
                              <?= ($lieu->getVille() === $v) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($v) ?>
                      </option>
                    <?php endforeach; ?>
                  </select>
                  <div class="invalid-feedback">Veuillez choisir une ville.</div>
                </div>

                <!-- Adresse -->
                <div class="mb-3">
                  <label for="adresse" class="form-label fw-semibold">
                    Adresse complète
                    <span aria-hidden="true" style="color: var(--vivora-corail);">*</span>
                  </label>
                  <input type="text"
                         class="form-control"
                         id="adresse"
                         name="adresse"
                         value="<?= htmlspecialchars($lieu->getAdresse()) ?>"
                         required
                         maxlength="255"
                         aria-required="true"
                         placeholder="Ex. : 14, Rue Ibn Rachiq, Lafayette">
                  <div class="invalid-feedback">L'adresse est obligatoire.</div>
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
                             maxlength="2000"
                             placeholder="Décrivez le lieu, ses activités, son histoire..."><?= htmlspecialchars($lieu->getDescription() ?? '') ?></textarea>
                  <div class="form-text">Maximum 2000 caractères.</div>
                </div>

                <!-- Image -->
                <div class="mb-3">
                  <label for="image" class="form-label fw-semibold">
                    Image du lieu
                  </label>
                  <?php if ($estModif && $lieu->getImage()): ?>
                    <div class="mb-2">
                      <img src="<?= BASE_URL ?>public/assets/front/img/lieux/<?= htmlspecialchars($lieu->getImage()) ?>"
                           alt="Image actuelle : <?= htmlspecialchars($lieu->getNom()) ?>"
                           style="height: 100px; object-fit: cover; border-radius: 6px;">
                      <p class="form-text">Image actuelle. Choisissez un nouveau fichier pour la remplacer.</p>
                    </div>
                  <?php endif; ?>
                  <input type="file"
                         class="form-control"
                         id="image"
                         name="image"
                         accept="image/jpeg,image/png,image/webp"
                         aria-describedby="image-aide">
                  <div id="image-aide" class="form-text">
                    Formats acceptés : JPG, PNG, WebP. Taille max recommandée : 2 Mo.
                  </div>
                </div>

              </fieldset>

              <!-- ── Critères d'accessibilité ───────────── -->
              <fieldset class="mb-4">
                <legend class="text-uppercase fw-semibold"
                        style="font-size: 0.85rem; color: var(--vivora-sarcelle); border-bottom: 2px solid var(--vivora-sarcelle-clair); padding-bottom: 6px;">
                  <i class="bi bi-universal-access me-1" aria-hidden="true"></i>
                  Critères d'accessibilité PMR
                </legend>

                <p class="text-muted small mb-3">
                  Cochez les équipements d'accessibilité disponibles dans ce lieu.
                </p>

                <div class="row">
                  <!-- Rampe d'accès -->
                  <div class="col-md-6 mb-3">
                    <div class="form-check">
                      <input class="form-check-input"
                             type="checkbox"
                             id="rampe_acces"
                             name="rampe_acces"
                             value="1"
                             <?= $lieu->hasRampeAcces() ? 'checked' : '' ?>>
                      <label class="form-check-label" for="rampe_acces">
                        <i class="bi bi-arrow-up-right-square me-1" aria-hidden="true"></i>
                        Rampe d'accès
                        <span class="form-text d-block ms-4">
                          Rampe permettant l'accès en fauteuil roulant.
                        </span>
                      </label>
                    </div>
                  </div>

                  <!-- Ascenseur -->
                  <div class="col-md-6 mb-3">
                    <div class="form-check">
                      <input class="form-check-input"
                             type="checkbox"
                             id="ascenseur"
                             name="ascenseur"
                             value="1"
                             <?= $lieu->hasAscenseur() ? 'checked' : '' ?>>
                      <label class="form-check-label" for="ascenseur">
                        <i class="bi bi-elevator me-1" aria-hidden="true"></i>
                        Ascenseur
                        <span class="form-text d-block ms-4">
                          Ascenseur accessible aux fauteuils roulants.
                        </span>
                      </label>
                    </div>
                  </div>

                  <!-- Toilettes adaptées -->
                  <div class="col-md-6 mb-3">
                    <div class="form-check">
                      <input class="form-check-input"
                             type="checkbox"
                             id="toilettes_adaptees"
                             name="toilettes_adaptees"
                             value="1"
                             <?= $lieu->hasToilettesAdaptees() ? 'checked' : '' ?>>
                      <label class="form-check-label" for="toilettes_adaptees">
                        <i class="bi bi-gender-ambiguous me-1" aria-hidden="true"></i>
                        Toilettes adaptées PMR
                        <span class="form-text d-block ms-4">
                          Sanitaires avec espace de manœuvre suffisant.
                        </span>
                      </label>
                    </div>
                  </div>

                  <!-- Parking PMR -->
                  <div class="col-md-6 mb-3">
                    <div class="form-check">
                      <input class="form-check-input"
                             type="checkbox"
                             id="parking_pmr"
                             name="parking_pmr"
                             value="1"
                             <?= $lieu->hasParkingPmr() ? 'checked' : '' ?>>
                      <label class="form-check-label" for="parking_pmr">
                        <i class="bi bi-p-square me-1" aria-hidden="true"></i>
                        Parking PMR
                        <span class="form-text d-block ms-4">
                          Places de stationnement réservées et signalisées.
                        </span>
                      </label>
                    </div>
                  </div>
                </div><!-- Fin row checkboxes -->

              </fieldset>

              <!-- ── Boutons ─────────────────────────────── -->
              <div class="d-flex gap-3 flex-wrap">
                <button type="submit" class="btn btn-vivora-cta btn-lg">
                  <i class="bi <?= $estModif ? 'bi-check-lg' : 'bi-plus-lg' ?> me-2" aria-hidden="true"></i>
                  <?= $estModif ? 'Enregistrer les modifications' : 'Ajouter le lieu' ?>
                </button>
                <a href="<?= BASE_URL ?>index.php?controller=lieu&action=adminList"
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

<!-- Activation de la validation Bootstrap au moment de la soumission -->
<script>
(function () {
  'use strict';
  var forms = document.querySelectorAll('form[novalidate]');
  Array.prototype.slice.call(forms).forEach(function (form) {
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
