<?php
/**
 * VIVORA – Vue Front : Liste des lieux accessibles
 * Affiche les lieux sous forme de cartes Bootstrap avec filtres.
 * Variables attendues depuis LieuController::list() :
 *   $lieux (array) – liste des objets Lieu
 */

// Métadonnées pour le <head>
$titreOnglet    = 'Lieux accessibles';
$metaDescription = 'Découvrez les lieux accessibles aux personnes en situation de handicap en Tunisie : salles culturelles, centres sportifs, parcs.';
$pageActive     = 'lieux-liste'; // Pour la sidebar back (non utilisé ici)

require __DIR__ . '/../layout/header.php';
?>

<!-- ── Fil d'Ariane ─────────────────────────────────────────── -->
<section class="breadcrumbs" aria-label="Fil d'Ariane">
  <div class="container">
    <ol class="breadcrumb" itemscope itemtype="https://schema.org/BreadcrumbList">
      <li class="breadcrumb-item" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
        <a href="<?= BASE_URL ?>index.php" itemprop="item">
          <span itemprop="name">Accueil</span>
        </a>
        <meta itemprop="position" content="1">
      </li>
      <li class="breadcrumb-item active" aria-current="page" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
        <span itemprop="name">Lieux accessibles</span>
        <meta itemprop="position" content="2">
      </li>
    </ol>
    <h2>Lieux accessibles</h2>
  </div>
</section>

<!-- ── Contenu principal ────────────────────────────────────── -->
<section class="py-5">
  <div class="container">

    <div class="row">

      <!-- ── Colonne filtres (sidebar gauche) ──────────────── -->
      <aside class="col-lg-3 mb-4" aria-label="Filtres de recherche">
        <div class="card shadow-sm border-0">
          <div class="card-header" style="background-color: var(--vivora-vert-profond); color: #fff;">
            <h2 class="h5 mb-0" style="color: #fff; font-family: 'Lexend', sans-serif;">
              <i class="bi bi-funnel me-2" aria-hidden="true"></i>
              Filtrer les lieux
            </h2>
          </div>
          <div class="card-body filtres-accessibilite">

            <!-- Formulaire de filtres -->
            <form method="GET" action="<?= BASE_URL ?>index.php" id="form-filtres" role="search"
                  aria-label="Filtrer les lieux par ville et accessibilité">
              <input type="hidden" name="controller" value="lieu">
              <input type="hidden" name="action" value="list">

              <!-- Filtre par ville -->
              <div class="mb-3">
                <label for="filtre-ville" class="form-label fw-semibold">
                  <i class="bi bi-geo-alt me-1" aria-hidden="true"></i>Ville
                </label>
                <select class="form-select" id="filtre-ville" name="ville" aria-label="Choisir une ville">
                  <option value="">Toutes les villes</option>
                  <option value="Tunis"   <?= (($_GET['ville'] ?? '') === 'Tunis')   ? 'selected' : '' ?>>Tunis</option>
                  <option value="Ariana"  <?= (($_GET['ville'] ?? '') === 'Ariana')  ? 'selected' : '' ?>>Ariana</option>
                  <option value="Sousse"  <?= (($_GET['ville'] ?? '') === 'Sousse')  ? 'selected' : '' ?>>Sousse</option>
                  <option value="Sfax"    <?= (($_GET['ville'] ?? '') === 'Sfax')    ? 'selected' : '' ?>>Sfax</option>
                </select>
              </div>

              <!-- Filtres accessibilité -->
              <fieldset class="mb-3">
                <legend class="fw-semibold mb-2" style="font-size: 0.95rem;">
                  <i class="bi bi-universal-access me-1" aria-hidden="true"></i>
                  Critères d'accessibilité
                </legend>

                <div class="form-check mb-2">
                  <input class="form-check-input" type="checkbox" id="filtre-rampe"
                         name="rampe_acces" value="1"
                         <?= (isset($_GET['rampe_acces'])) ? 'checked' : '' ?>>
                  <label class="form-check-label" for="filtre-rampe">
                    <i class="bi bi-arrow-up-right-square me-1" aria-hidden="true"></i>
                    Rampe d'accès
                  </label>
                </div>

                <div class="form-check mb-2">
                  <input class="form-check-input" type="checkbox" id="filtre-ascenseur"
                         name="ascenseur" value="1"
                         <?= (isset($_GET['ascenseur'])) ? 'checked' : '' ?>>
                  <label class="form-check-label" for="filtre-ascenseur">
                    <i class="bi bi-elevator me-1" aria-hidden="true"></i>
                    Ascenseur
                  </label>
                </div>

                <div class="form-check mb-2">
                  <input class="form-check-input" type="checkbox" id="filtre-toilettes"
                         name="toilettes_adaptees" value="1"
                         <?= (isset($_GET['toilettes_adaptees'])) ? 'checked' : '' ?>>
                  <label class="form-check-label" for="filtre-toilettes">
                    <i class="bi bi-gender-ambiguous me-1" aria-hidden="true"></i>
                    Toilettes adaptées
                  </label>
                </div>

                <div class="form-check mb-3">
                  <input class="form-check-input" type="checkbox" id="filtre-parking"
                         name="parking_pmr" value="1"
                         <?= (isset($_GET['parking_pmr'])) ? 'checked' : '' ?>>
                  <label class="form-check-label" for="filtre-parking">
                    <i class="bi bi-p-square me-1" aria-hidden="true"></i>
                    Parking PMR
                  </label>
                </div>
              </fieldset>

              <!-- Boutons -->
              <button type="submit" class="btn btn-vivora-secondary w-100 mb-2">
                <i class="bi bi-search me-1" aria-hidden="true"></i>
                Appliquer les filtres
              </button>
              <a href="<?= BASE_URL ?>index.php?controller=lieu&action=list"
                 class="btn btn-outline-secondary w-100">
                Réinitialiser
              </a>
            </form>

          </div><!-- Fin card-body -->
        </div><!-- Fin card filtres -->
      </aside><!-- Fin colonne filtres -->

      <!-- ── Colonne résultats ──────────────────────────────── -->
      <div class="col-lg-9">

        <!-- Titre et compteur -->
        <div class="d-flex justify-content-between align-items-center mb-4">
          <h1 class="h3 mb-0" style="color: var(--vivora-vert-profond); font-family: 'Lexend', sans-serif;">
            Lieux accessibles
          </h1>
          <span class="badge" style="background-color: var(--vivora-sarcelle); font-size: 0.9rem; padding: 8px 14px;">
            <?= count($lieux) ?> lieu<?= count($lieux) > 1 ? 'x' : '' ?> trouvé<?= count($lieux) > 1 ? 's' : '' ?>
          </span>
        </div>

        <?php if (empty($lieux)): ?>
          <!-- Message si aucun résultat -->
          <div class="alert" style="background-color: var(--vivora-sarcelle-clair); border: 1px solid var(--vivora-sarcelle);" role="alert">
            <i class="bi bi-info-circle me-2" aria-hidden="true"></i>
            Aucun lieu ne correspond à vos critères de recherche.
            <a href="<?= BASE_URL ?>index.php?controller=lieu&action=list" class="ms-2">
              Voir tous les lieux
            </a>
          </div>

          <!-- Cartes de démonstration (données fictives pour prévisualisation) -->
          <div class="row row-cols-1 row-cols-md-2 row-cols-xl-3 g-4" aria-label="Aperçu des lieux (données de démonstration)">

            <?php
            // Données de démonstration pour l'aperçu visuel (à supprimer quand le CRUD sera actif)
            $exemples = [
              ['nom' => 'Centre Culturel Ibn Rachiq', 'ville' => 'Tunis', 'rampe' => true, 'ascenseur' => true, 'toilettes' => true, 'parking' => true],
              ['nom' => 'Palais des Congrès', 'ville' => 'Sousse', 'rampe' => true, 'ascenseur' => true, 'toilettes' => true, 'parking' => true],
              ['nom' => 'Maison de la Culture', 'ville' => 'Sfax', 'rampe' => true, 'ascenseur' => false, 'toilettes' => false, 'parking' => true],
            ];
            foreach ($exemples as $ex):
            ?>
            <div class="col">
              <article class="card card-lieu h-100" aria-label="Lieu : <?= htmlspecialchars($ex['nom']) ?>">
                <!-- Image du lieu -->
                <img src="<?= BASE_URL ?>public/assets/front/img/lieu-placeholder.jpg"
                     class="card-img-top"
                     alt="Photo de <?= htmlspecialchars($ex['nom']) ?>"
                     loading="lazy">
                <div class="card-body">
                  <h3 class="card-title h5"><?= htmlspecialchars($ex['nom']) ?></h3>
                  <p class="text-muted mb-2">
                    <i class="bi bi-geo-alt me-1" aria-hidden="true"></i>
                    <?= htmlspecialchars($ex['ville']) ?>
                  </p>
                  <!-- Badges accessibilité -->
                  <div class="mb-3" aria-label="Critères d'accessibilité">
                    <span class="badge-accessibilite <?= $ex['rampe'] ? 'badge-oui' : 'badge-non' ?>">
                      <i class="bi <?= $ex['rampe'] ? 'bi-check-circle-fill' : 'bi-x-circle-fill' ?>" aria-hidden="true"></i>
                      Rampe
                    </span>
                    <span class="badge-accessibilite <?= $ex['ascenseur'] ? 'badge-oui' : 'badge-non' ?>">
                      <i class="bi <?= $ex['ascenseur'] ? 'bi-check-circle-fill' : 'bi-x-circle-fill' ?>" aria-hidden="true"></i>
                      Ascenseur
                    </span>
                    <span class="badge-accessibilite <?= $ex['toilettes'] ? 'badge-oui' : 'badge-non' ?>">
                      <i class="bi <?= $ex['toilettes'] ? 'bi-check-circle-fill' : 'bi-x-circle-fill' ?>" aria-hidden="true"></i>
                      Toilettes
                    </span>
                    <span class="badge-accessibilite <?= $ex['parking'] ? 'badge-oui' : 'badge-non' ?>">
                      <i class="bi <?= $ex['parking'] ? 'bi-check-circle-fill' : 'bi-x-circle-fill' ?>" aria-hidden="true"></i>
                      Parking PMR
                    </span>
                  </div>
                </div>
                <div class="card-footer bg-transparent border-0">
                  <a href="<?= BASE_URL ?>index.php?controller=lieu&action=show&id=1"
                     class="btn btn-vivora-secondary w-100">
                    Voir la fiche
                    <i class="bi bi-arrow-right ms-1" aria-hidden="true"></i>
                  </a>
                </div>
              </article>
            </div>
            <?php endforeach; ?>
          </div><!-- Fin row démo -->

        <?php else: ?>
          <!-- ── Grille des lieux réels (données depuis la base) ── -->
          <div class="row row-cols-1 row-cols-md-2 row-cols-xl-3 g-4">
            <?php foreach ($lieux as $lieu): ?>
            <div class="col">
              <article class="card card-lieu h-100"
                       aria-label="Lieu : <?= htmlspecialchars($lieu->getNom()) ?>">
                <!-- Image -->
                <?php if ($lieu->getImage()): ?>
                  <img src="<?= BASE_URL ?>public/assets/front/img/lieux/<?= htmlspecialchars($lieu->getImage()) ?>"
                       class="card-img-top"
                       alt="Photo de <?= htmlspecialchars($lieu->getNom()) ?>"
                       loading="lazy">
                <?php else: ?>
                  <img src="<?= BASE_URL ?>public/assets/front/img/lieu-placeholder.jpg"
                       class="card-img-top"
                       alt="Lieu sans photo disponible"
                       loading="lazy">
                <?php endif; ?>

                <div class="card-body">
                  <h3 class="card-title h5"><?= htmlspecialchars($lieu->getNom()) ?></h3>
                  <p class="text-muted mb-2">
                    <i class="bi bi-geo-alt me-1" aria-hidden="true"></i>
                    <?= htmlspecialchars($lieu->getVille()) ?>
                  </p>

                  <!-- Badges accessibilité -->
                  <div class="mb-2" aria-label="Critères d'accessibilité de <?= htmlspecialchars($lieu->getNom()) ?>">
                    <span class="badge-accessibilite <?= $lieu->hasRampeAcces() ? 'badge-oui' : 'badge-non' ?>">
                      <i class="bi <?= $lieu->hasRampeAcces() ? 'bi-check-circle-fill' : 'bi-x-circle-fill' ?>"
                         aria-hidden="true"></i>
                      Rampe
                    </span>
                    <span class="badge-accessibilite <?= $lieu->hasAscenseur() ? 'badge-oui' : 'badge-non' ?>">
                      <i class="bi <?= $lieu->hasAscenseur() ? 'bi-check-circle-fill' : 'bi-x-circle-fill' ?>"
                         aria-hidden="true"></i>
                      Ascenseur
                    </span>
                    <span class="badge-accessibilite <?= $lieu->hasToilettesAdaptees() ? 'badge-oui' : 'badge-non' ?>">
                      <i class="bi <?= $lieu->hasToilettesAdaptees() ? 'bi-check-circle-fill' : 'bi-x-circle-fill' ?>"
                         aria-hidden="true"></i>
                      Toilettes
                    </span>
                    <span class="badge-accessibilite <?= $lieu->hasParkingPmr() ? 'badge-oui' : 'badge-non' ?>">
                      <i class="bi <?= $lieu->hasParkingPmr() ? 'bi-check-circle-fill' : 'bi-x-circle-fill' ?>"
                         aria-hidden="true"></i>
                      Parking PMR
                    </span>
                  </div>

                  <!-- Score accessibilité -->
                  <div class="accessibilite-score mt-2" aria-label="Score d'accessibilité : <?= $lieu->getNombreCriteres() ?> sur 4 critères">
                    <small class="text-muted"><?= $lieu->getNombreCriteres() ?>/4 critères</small>
                    <div class="progress mt-1" role="progressbar"
                         aria-valuenow="<?= $lieu->getNombreCriteres() * 25 ?>"
                         aria-valuemin="0" aria-valuemax="100">
                      <div class="progress-bar"
                           style="width: <?= $lieu->getNombreCriteres() * 25 ?>%"></div>
                    </div>
                  </div>
                </div>

                <div class="card-footer bg-transparent border-0">
                  <a href="<?= BASE_URL ?>index.php?controller=lieu&action=show&id=<?= $lieu->getId() ?>"
                     class="btn btn-vivora-secondary w-100">
                    Voir la fiche
                    <i class="bi bi-arrow-right ms-1" aria-hidden="true"></i>
                  </a>
                </div>
              </article>
            </div>
            <?php endforeach; ?>
          </div><!-- Fin row lieux réels -->

        <?php endif; ?>

      </div><!-- Fin colonne résultats -->
    </div><!-- Fin row -->
  </div><!-- Fin container -->
</section>

<?php require __DIR__ . '/../layout/footer.php'; ?>
