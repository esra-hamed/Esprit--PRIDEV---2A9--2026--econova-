<?php
/**
 * VIVORA – Vue Back : Tableau de gestion des événements
 * Affiche les événements avec le nom du lieu (jointure SQL).
 * Variables attendues depuis EvenementController::adminList() :
 *   $evenements (array) – liste des objets Evenement (avec nom_lieu)
 */

$titreOnglet = 'Gestion des événements';
$pageActive  = 'evenements-liste';
$menuActif   = 'lieux-evenements';

require __DIR__ . '/../layout/header.php';
?>

<!-- ── En-tête de la page ────────────────────────────────────── -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">
          <i class="bi bi-calendar-event me-2" aria-hidden="true"></i>
          Gestion des événements
        </h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right" aria-label="Fil d'Ariane">
          <li class="breadcrumb-item">
            <a href="<?= BASE_URL ?>index.php?controller=evenement&action=adminDashboard">Tableau de bord</a>
          </li>
          <li class="breadcrumb-item active">Événements</li>
        </ol>
      </div>
    </div>
  </div>
</div>

<!-- ── Contenu ───────────────────────────────────────────────── -->
<section class="content">
  <div class="container-fluid">

    <!-- Messages flash -->
    <?php if (isset($_GET['message'])): ?>
      <?php if ($_GET['message'] === 'deleted'): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert" aria-live="polite">
          <i class="bi bi-check-circle me-2" aria-hidden="true"></i>
          L'événement a été supprimé.
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fermer"></button>
        </div>
      <?php elseif ($_GET['message'] === 'created'): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert" aria-live="polite">
          <i class="bi bi-check-circle me-2" aria-hidden="true"></i>
          L'événement a été créé avec succès.
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fermer"></button>
        </div>
      <?php elseif ($_GET['message'] === 'updated'): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert" aria-live="polite">
          <i class="bi bi-check-circle me-2" aria-hidden="true"></i>
          L'événement a été modifié avec succès.
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fermer"></button>
        </div>
      <?php endif; ?>
    <?php endif; ?>

    <!-- Carte principale -->
    <div class="card">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h2 class="card-title mb-0">
          <i class="bi bi-table me-2" aria-hidden="true"></i>
          Liste des événements (<?= count($evenements) ?>)
        </h2>
        <a href="<?= BASE_URL ?>index.php?controller=evenement&action=adminCreate"
           class="btn btn-vivora-cta"
           aria-label="Créer un nouvel événement">
          <i class="bi bi-plus-lg me-1" aria-hidden="true"></i>
          Ajouter un événement
        </a>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-hover dt-table w-100"
                 id="table-evenements"
                 aria-label="Tableau des événements">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">Titre</th>
                <th scope="col">Lieu</th>
                <th scope="col">Date</th>
                <th scope="col">Heure</th>
                <th scope="col" class="text-center">Places</th>
                <th scope="col" class="text-center">Statut</th>
                <th scope="col" class="text-center">Actions</th>
              </tr>
            </thead>
            <tbody>
              <?php if (empty($evenements)): ?>
                <tr>
                  <td colspan="8" class="text-center text-muted py-4">
                    <i class="bi bi-inbox me-2" aria-hidden="true"></i>
                    Aucun événement enregistré pour l'instant.
                  </td>
                </tr>
              <?php else: ?>
                <?php foreach ($evenements as $ev): ?>
                <tr>
                  <td><?= $ev->getId() ?></td>
                  <td><strong><?= htmlspecialchars($ev->getTitre()) ?></strong></td>
                  <td>
                    <a href="<?= BASE_URL ?>index.php?controller=lieu&action=adminEdit&id=<?= $ev->getLieuId() ?>"
                       style="color: var(--vivora-sarcelle);">
                      <?= htmlspecialchars($ev->getNomLieu() ?? '—') ?>
                    </a>
                  </td>
                  <td>
                    <span title="<?= htmlspecialchars($ev->getDateFormatee()) ?>">
                      <?= htmlspecialchars(date('d/m/Y', strtotime($ev->getDateEvenement()))) ?>
                    </span>
                  </td>
                  <td><?= htmlspecialchars($ev->getHeureCourte()) ?></td>
                  <td class="text-center">
                    <span class="badge"
                          style="background-color: <?= $ev->getNbPlaces() > 0 ? 'var(--vivora-sarcelle)' : '#dc3545' ?>; color: #fff;">
                      <?= $ev->getNbPlaces() ?>
                    </span>
                  </td>
                  <td class="text-center">
                    <?php if ($ev->estAVenir()): ?>
                      <span class="badge" style="background-color: var(--vivora-sarcelle); color: #fff;">
                        À venir
                      </span>
                    <?php else: ?>
                      <span class="badge bg-secondary">Passé</span>
                    <?php endif; ?>
                  </td>
                  <!-- Actions -->
                  <td class="text-center" style="white-space: nowrap;">
                    <!-- Voir les participants -->
                    <a href="<?= BASE_URL ?>index.php?controller=evenement&action=adminParticipants&id=<?= $ev->getId() ?>"
                       class="btn btn-sm btn-outline-secondary me-1"
                       aria-label="Participants de <?= htmlspecialchars($ev->getTitre()) ?>">
                      <i class="bi bi-people" aria-hidden="true"></i>
                    </a>
                    <!-- Modifier -->
                    <a href="<?= BASE_URL ?>index.php?controller=evenement&action=adminEdit&id=<?= $ev->getId() ?>"
                       class="btn btn-sm btn-vivora me-1"
                       aria-label="Modifier <?= htmlspecialchars($ev->getTitre()) ?>">
                      <i class="bi bi-pencil" aria-hidden="true"></i>
                    </a>
                    <!-- Supprimer -->
                    <a href="<?= BASE_URL ?>index.php?controller=evenement&action=adminDelete&id=<?= $ev->getId() ?>"
                       class="btn btn-sm btn-danger"
                       aria-label="Supprimer <?= htmlspecialchars($ev->getTitre()) ?>"
                       onclick="return confirm('Supprimer l\'événement « <?= htmlspecialchars(addslashes($ev->getTitre())) ?> » ?')">
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
