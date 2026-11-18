<?php
/**
 * VIVORA – Vue Back : Tableau de gestion des lieux
 * Tableau avec recherche/tri via DataTables et boutons CRUD.
 * Variables attendues depuis LieuController::adminList() :
 *   $lieux (array) – liste des objets Lieu
 */

$titreOnglet = 'Gestion des lieux';
$pageActive  = 'lieux-liste';
$menuActif   = 'lieux-evenements';

require __DIR__ . '/../layout/header.php';
?>

<!-- ── En-tête de la page ────────────────────────────────────── -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">
          <i class="bi bi-geo-alt me-2" aria-hidden="true"></i>
          Gestion des lieux
        </h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right" aria-label="Fil d'Ariane">
          <li class="breadcrumb-item">
            <a href="<?= BASE_URL ?>index.php?controller=evenement&action=adminDashboard">Tableau de bord</a>
          </li>
          <li class="breadcrumb-item active">Lieux</li>
        </ol>
      </div>
    </div>
  </div>
</div>

<!-- ── Contenu ───────────────────────────────────────────────── -->
<section class="content">
  <div class="container-fluid">

    <!-- Message flash (succès/erreur après action CRUD) -->
    <?php if (isset($_GET['message'])): ?>
      <?php if ($_GET['message'] === 'deleted'): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert" aria-live="polite">
          <i class="bi bi-check-circle me-2" aria-hidden="true"></i>
          Le lieu a été supprimé avec succès.
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fermer"></button>
        </div>
      <?php elseif ($_GET['message'] === 'created'): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert" aria-live="polite">
          <i class="bi bi-check-circle me-2" aria-hidden="true"></i>
          Le lieu a été ajouté avec succès.
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fermer"></button>
        </div>
      <?php elseif ($_GET['message'] === 'updated'): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert" aria-live="polite">
          <i class="bi bi-check-circle me-2" aria-hidden="true"></i>
          Le lieu a été modifié avec succès.
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fermer"></button>
        </div>
      <?php endif; ?>
    <?php endif; ?>

    <!-- Carte principale -->
    <div class="card">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h2 class="card-title mb-0">
          <i class="bi bi-table me-2" aria-hidden="true"></i>
          Liste des lieux (<?= count($lieux) ?>)
        </h2>
        <a href="<?= BASE_URL ?>index.php?controller=lieu&action=adminCreate"
           class="btn btn-vivora-cta"
           aria-label="Ajouter un nouveau lieu">
          <i class="bi bi-plus-lg me-1" aria-hidden="true"></i>
          Ajouter un lieu
        </a>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-hover dt-table w-100"
                 id="table-lieux"
                 aria-label="Tableau des lieux accessibles">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">Nom</th>
                <th scope="col">Ville</th>
                <th scope="col">Adresse</th>
                <th scope="col" class="text-center">Rampe</th>
                <th scope="col" class="text-center">Ascenseur</th>
                <th scope="col" class="text-center">Toilettes</th>
                <th scope="col" class="text-center">Parking PMR</th>
                <th scope="col" class="text-center">Score</th>
                <th scope="col" class="text-center">Actions</th>
              </tr>
            </thead>
            <tbody>
              <?php if (empty($lieux)): ?>
                <tr>
                  <td colspan="10" class="text-center text-muted py-4">
                    <i class="bi bi-inbox me-2" aria-hidden="true"></i>
                    Aucun lieu enregistré pour l'instant.
                  </td>
                </tr>
              <?php else: ?>
                <?php foreach ($lieux as $lieu): ?>
                <tr>
                  <td><?= $lieu->getId() ?></td>
                  <td>
                    <strong><?= htmlspecialchars($lieu->getNom()) ?></strong>
                  </td>
                  <td><?= htmlspecialchars($lieu->getVille()) ?></td>
                  <td class="text-muted" style="max-width: 200px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                    <?= htmlspecialchars($lieu->getAdresse()) ?>
                  </td>
                  <!-- Critères d'accessibilité (oui/non) -->
                  <td class="text-center">
                    <?php if ($lieu->hasRampeAcces()): ?>
                      <span class="badge bg-success badge-oui-bo" aria-label="Rampe disponible">
                        <i class="bi bi-check-lg" aria-hidden="true"></i>
                      </span>
                    <?php else: ?>
                      <span class="badge bg-danger badge-non-bo" aria-label="Rampe non disponible">
                        <i class="bi bi-x-lg" aria-hidden="true"></i>
                      </span>
                    <?php endif; ?>
                  </td>
                  <td class="text-center">
                    <?php if ($lieu->hasAscenseur()): ?>
                      <span class="badge bg-success" aria-label="Ascenseur disponible">
                        <i class="bi bi-check-lg" aria-hidden="true"></i>
                      </span>
                    <?php else: ?>
                      <span class="badge bg-danger" aria-label="Ascenseur non disponible">
                        <i class="bi bi-x-lg" aria-hidden="true"></i>
                      </span>
                    <?php endif; ?>
                  </td>
                  <td class="text-center">
                    <?php if ($lieu->hasToilettesAdaptees()): ?>
                      <span class="badge bg-success" aria-label="Toilettes adaptées disponibles">
                        <i class="bi bi-check-lg" aria-hidden="true"></i>
                      </span>
                    <?php else: ?>
                      <span class="badge bg-danger" aria-label="Toilettes non adaptées">
                        <i class="bi bi-x-lg" aria-hidden="true"></i>
                      </span>
                    <?php endif; ?>
                  </td>
                  <td class="text-center">
                    <?php if ($lieu->hasParkingPmr()): ?>
                      <span class="badge bg-success" aria-label="Parking PMR disponible">
                        <i class="bi bi-check-lg" aria-hidden="true"></i>
                      </span>
                    <?php else: ?>
                      <span class="badge bg-danger" aria-label="Pas de parking PMR">
                        <i class="bi bi-x-lg" aria-hidden="true"></i>
                      </span>
                    <?php endif; ?>
                  </td>
                  <!-- Score -->
                  <td class="text-center">
                    <span class="badge"
                          style="background-color: var(--vivora-sarcelle); font-size: 0.85rem;"
                          aria-label="Score d'accessibilité : <?= $lieu->getNombreCriteres() ?> sur 4">
                      <?= $lieu->getNombreCriteres() ?>/4
                    </span>
                  </td>
                  <!-- Boutons d'action -->
                  <td class="text-center" style="white-space: nowrap;">
                    <a href="<?= BASE_URL ?>index.php?controller=lieu&action=show&id=<?= $lieu->getId() ?>"
                       class="btn btn-sm btn-outline-secondary me-1"
                       target="_blank"
                       aria-label="Voir la fiche publique de <?= htmlspecialchars($lieu->getNom()) ?>">
                      <i class="bi bi-eye" aria-hidden="true"></i>
                    </a>
                    <a href="<?= BASE_URL ?>index.php?controller=lieu&action=adminEdit&id=<?= $lieu->getId() ?>"
                       class="btn btn-sm btn-vivora me-1"
                       aria-label="Modifier <?= htmlspecialchars($lieu->getNom()) ?>">
                      <i class="bi bi-pencil" aria-hidden="true"></i>
                    </a>
                    <a href="<?= BASE_URL ?>index.php?controller=lieu&action=adminDelete&id=<?= $lieu->getId() ?>"
                       class="btn btn-sm btn-danger btn-supprimer"
                       aria-label="Supprimer <?= htmlspecialchars($lieu->getNom()) ?>"
                       data-nom="<?= htmlspecialchars($lieu->getNom()) ?>"
                       onclick="return confirm('Supprimer le lieu « <?= htmlspecialchars(addslashes($lieu->getNom())) ?> » ? Cette action supprimera aussi tous ses événements.')">
                      <i class="bi bi-trash" aria-hidden="true"></i>
                    </a>
                  </td>
                </tr>
                <?php endforeach; ?>
              <?php endif; ?>
            </tbody>
          </table>
        </div><!-- Fin table-responsive -->
      </div><!-- Fin card-body -->
    </div><!-- Fin card -->

  </div><!-- Fin container-fluid -->
</section>

<?php require __DIR__ . '/../layout/footer.php'; ?>
