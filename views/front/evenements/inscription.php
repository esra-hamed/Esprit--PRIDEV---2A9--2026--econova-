<?php
/**
 * VIVORA – Vue Front : Formulaire d'inscription à un événement
 * Formulaire avec validation HTML5 et retour des erreurs/succès.
 * Variables attendues depuis EvenementController::inscription() :
 *   $evenement (Evenement|null) – contexte de l'événement
 *   $erreurs   (array)         – messages d'erreur de validation
 *   $succes    (bool)          – true si l'inscription a réussi
 */

$titreEv     = $evenement ? $evenement->getTitre() : 'Inscription';
$titreOnglet = 'Inscription – ' . $titreEv;

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
      <?php if ($evenement): ?>
        <li class="breadcrumb-item">
          <a href="<?= BASE_URL ?>index.php?controller=evenement&action=show&id=<?= $evenement->getId() ?>">
            <?= htmlspecialchars($titreEv) ?>
          </a>
        </li>
      <?php endif; ?>
      <li class="breadcrumb-item active" aria-current="page">Inscription</li>
    </ol>
    <h2>Inscription à l'événement</h2>
  </div>
</section>

<!-- ── Contenu principal ────────────────────────────────────── -->
<section class="py-5">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-7">

        <!-- Message de succès (après soumission réussie) -->
        <?php if ($succes): ?>
          <div class="text-center py-5" role="status" aria-live="polite">
            <i class="bi bi-check-circle-fill" style="font-size: 4rem; color: var(--vivora-sarcelle);" aria-hidden="true"></i>
            <h2 class="mt-3" style="font-family: 'Lexend', sans-serif; color: var(--vivora-vert-profond);">
              Inscription confirmée !
            </h2>
            <p class="text-muted">
              Votre inscription à <strong><?= htmlspecialchars($titreEv) ?></strong> a bien été enregistrée.
              Un e-mail de confirmation vous sera envoyé.
            </p>
            <a href="<?= BASE_URL ?>index.php?controller=evenement&action=list"
               class="btn btn-vivora-secondary mt-3">
              Voir d'autres événements
            </a>
          </div>

        <?php else: ?>

          <!-- En-tête : contexte de l'événement -->
          <?php if ($evenement): ?>
            <div class="card border-0 mb-4"
                 style="background-color: var(--vivora-sarcelle-clair); border-radius: 12px;">
              <div class="card-body d-flex align-items-center gap-3">
                <i class="bi bi-calendar-event-fill"
                   style="font-size: 2.5rem; color: var(--vivora-sarcelle);" aria-hidden="true"></i>
                <div>
                  <h1 class="h5 mb-1" style="font-family: 'Lexend', sans-serif; color: var(--vivora-vert-profond);">
                    <?= htmlspecialchars($evenement->getTitre()) ?>
                  </h1>
                  <p class="mb-0 text-muted small">
                    <i class="bi bi-calendar me-1" aria-hidden="true"></i>
                    <?= htmlspecialchars($evenement->getDateFormatee()) ?>
                    à <?= htmlspecialchars($evenement->getHeureCourte()) ?>
                    <?php if ($evenement->getNomLieu()): ?>
                      &nbsp;·&nbsp;
                      <i class="bi bi-geo-alt me-1" aria-hidden="true"></i>
                      <?= htmlspecialchars($evenement->getNomLieu()) ?>
                    <?php endif; ?>
                  </p>
                </div>
              </div>
            </div>
          <?php endif; ?>

          <!-- Affichage des erreurs de validation côté serveur -->
          <?php if (!empty($erreurs)): ?>
            <div class="alert alert-danger" role="alert" aria-live="assertive">
              <strong><i class="bi bi-exclamation-triangle me-2" aria-hidden="true"></i>Erreurs dans le formulaire :</strong>
              <ul class="mb-0 mt-2">
                <?php foreach ($erreurs as $erreur): ?>
                  <li><?= htmlspecialchars($erreur) ?></li>
                <?php endforeach; ?>
              </ul>
            </div>
          <?php endif; ?>

          <!-- ── Formulaire d'inscription ───────────────────── -->
          <div class="card border-0 shadow-sm">
            <div class="card-header" style="background-color: var(--vivora-vert-profond); color: #fff;">
              <h2 class="h5 mb-0" style="color: #fff; font-family: 'Lexend', sans-serif;">
                <i class="bi bi-person-plus me-2" aria-hidden="true"></i>
                Vos coordonnées
              </h2>
            </div>
            <div class="card-body form-inscription">

              <form method="POST"
                    action="<?= BASE_URL ?>index.php?controller=evenement&action=inscription&id=<?= $evenement ? $evenement->getId() : 0 ?>"
                    novalidate
                    aria-label="Formulaire d'inscription à l'événement">

                <!-- Token CSRF (sera implémenté à l'étape CRUD) -->
                <!-- <input type="hidden" name="csrf_token" value="..."> -->

                <!-- Prénom -->
                <div class="mb-3">
                  <label for="prenom" class="form-label fw-semibold">
                    Prénom <span aria-hidden="true" style="color: var(--vivora-corail);">*</span>
                  </label>
                  <input type="text"
                         class="form-control <?= isset($erreurs['prenom']) ? 'is-invalid' : '' ?>"
                         id="prenom"
                         name="prenom"
                         value="<?= htmlspecialchars($_POST['prenom'] ?? '') ?>"
                         required
                         minlength="2"
                         maxlength="100"
                         autocomplete="given-name"
                         aria-required="true"
                         aria-describedby="prenom-aide"
                         placeholder="Votre prénom">
                  <div id="prenom-aide" class="form-text">Minimum 2 caractères.</div>
                  <?php if (isset($erreurs['prenom'])): ?>
                    <div class="invalid-feedback" role="alert"><?= htmlspecialchars($erreurs['prenom']) ?></div>
                  <?php endif; ?>
                </div>

                <!-- Nom -->
                <div class="mb-3">
                  <label for="nom" class="form-label fw-semibold">
                    Nom <span aria-hidden="true" style="color: var(--vivora-corail);">*</span>
                  </label>
                  <input type="text"
                         class="form-control <?= isset($erreurs['nom']) ? 'is-invalid' : '' ?>"
                         id="nom"
                         name="nom"
                         value="<?= htmlspecialchars($_POST['nom'] ?? '') ?>"
                         required
                         minlength="2"
                         maxlength="100"
                         autocomplete="family-name"
                         aria-required="true"
                         placeholder="Votre nom de famille">
                  <?php if (isset($erreurs['nom'])): ?>
                    <div class="invalid-feedback" role="alert"><?= htmlspecialchars($erreurs['nom']) ?></div>
                  <?php endif; ?>
                </div>

                <!-- E-mail -->
                <div class="mb-3">
                  <label for="email" class="form-label fw-semibold">
                    Adresse e-mail <span aria-hidden="true" style="color: var(--vivora-corail);">*</span>
                  </label>
                  <input type="email"
                         class="form-control <?= isset($erreurs['email']) ? 'is-invalid' : '' ?>"
                         id="email"
                         name="email"
                         value="<?= htmlspecialchars($_POST['email'] ?? '') ?>"
                         required
                         maxlength="150"
                         autocomplete="email"
                         aria-required="true"
                         aria-describedby="email-aide"
                         placeholder="exemple@email.com">
                  <div id="email-aide" class="form-text">
                    Un e-mail de confirmation vous sera envoyé à cette adresse.
                  </div>
                  <?php if (isset($erreurs['email'])): ?>
                    <div class="invalid-feedback" role="alert"><?= htmlspecialchars($erreurs['email']) ?></div>
                  <?php endif; ?>
                </div>

                <!-- Téléphone -->
                <div class="mb-3">
                  <label for="telephone" class="form-label fw-semibold">
                    Téléphone
                  </label>
                  <input type="tel"
                         class="form-control <?= isset($erreurs['telephone']) ? 'is-invalid' : '' ?>"
                         id="telephone"
                         name="telephone"
                         value="<?= htmlspecialchars($_POST['telephone'] ?? '') ?>"
                         maxlength="20"
                         autocomplete="tel"
                         pattern="[0-9+\s\-]{6,20}"
                         aria-describedby="tel-aide"
                         placeholder="+216 XX XXX XXX">
                  <div id="tel-aide" class="form-text">Facultatif. Format : +216 XX XXX XXX</div>
                  <?php if (isset($erreurs['telephone'])): ?>
                    <div class="invalid-feedback" role="alert"><?= htmlspecialchars($erreurs['telephone']) ?></div>
                  <?php endif; ?>
                </div>

                <!-- Besoin d'accessibilité spécifique -->
                <div class="mb-4">
                  <label for="besoin_accessibilite" class="form-label fw-semibold">
                    Besoin d'accessibilité spécifique
                  </label>
                  <textarea class="form-control"
                            id="besoin_accessibilite"
                            name="besoin_accessibilite"
                            rows="3"
                            maxlength="500"
                            aria-describedby="besoin-aide"
                            placeholder="Ex. : fauteuil roulant, interprète LST, place en premier rang..."><?= htmlspecialchars($_POST['besoin_accessibilite'] ?? '') ?></textarea>
                  <div id="besoin-aide" class="form-text">
                    Facultatif. Vos besoins seront transmis aux organisateurs pour faciliter votre participation.
                  </div>
                </div>

                <!-- Consentement RGPD -->
                <div class="form-check mb-4">
                  <input class="form-check-input <?= isset($erreurs['consentement']) ? 'is-invalid' : '' ?>"
                         type="checkbox"
                         id="consentement"
                         name="consentement"
                         value="1"
                         required
                         aria-required="true"
                         <?= !empty($_POST['consentement']) ? 'checked' : '' ?>>
                  <label class="form-check-label" for="consentement">
                    J'accepte que mes données soient utilisées uniquement pour la gestion de mon inscription.
                    <span aria-hidden="true" style="color: var(--vivora-corail);">*</span>
                  </label>
                  <?php if (isset($erreurs['consentement'])): ?>
                    <div class="invalid-feedback" role="alert"><?= htmlspecialchars($erreurs['consentement']) ?></div>
                  <?php endif; ?>
                </div>

                <!-- Indication champs obligatoires -->
                <p class="text-muted small mb-3">
                  <span aria-hidden="true" style="color: var(--vivora-corail);">*</span>
                  Champs obligatoires
                </p>

                <!-- Boutons -->
                <div class="d-flex gap-3 flex-wrap">
                  <button type="submit" class="btn btn-vivora-primary btn-lg">
                    <i class="bi bi-check-lg me-2" aria-hidden="true"></i>
                    Confirmer mon inscription
                  </button>
                  <a href="<?= BASE_URL ?>index.php?controller=evenement&action=show&id=<?= $evenement ? $evenement->getId() : 0 ?>"
                     class="btn btn-outline-secondary btn-lg">
                    Annuler
                  </a>
                </div>

              </form>

            </div><!-- Fin card-body -->
          </div><!-- Fin card formulaire -->

        <?php endif; // Fin condition $succes ?>

      </div><!-- Fin col -->
    </div><!-- Fin row -->
  </div><!-- Fin container -->
</section>

<?php require __DIR__ . '/../layout/footer.php'; ?>
