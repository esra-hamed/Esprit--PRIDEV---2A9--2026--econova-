<?php
/**
 * VIVORA – Vue Back : Liste des participants d'un événement
 * Variables attendues depuis EvenementController::adminParticipants() :
 *   $evenement    (Evenement|null) – l'événement concerné
 *   $participants (array)         – liste des participants (sera remplie à l'étape CRUD)
 */

$titreEv     = $evenement ? $evenement->getTitre() : 'Participants';
$titreOnglet = 'Participants – ' . $titreEv;
$pageActive  = 'evenements-participants';
$menuActif   = 'lieux-evenements';

require __DIR__ . '/../layout/header.php';
?>

<!-- ── En-tête ───────────────────────────────────────────────── -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">
          <i class="bi bi-people me-2" aria-hidden="true"></i>
          Participants inscrits
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
          <li class="breadcrumb-item active">Participants</li>
        </ol>
      </div>
    </div>
  </div>
</div>

<!-- ── Contenu ───────────────────────────────────────────────── -->
<section class="content">
  <div class="container-fluid">

    <!-- Résumé de l'événement -->
    <?php if ($evenement): ?>
      <div class="card mb-4" style="background-color: var(--vivora-sarcelle-clair); border: none;">
        <div class="card-body d-flex align-items-center gap-4 flex-wrap">
          <i class="bi bi-calendar-event-fill"
             style="font-size: 2.5rem; color: var(--vivora-sarcelle);" aria-hidden="true"></i>
          <div>
            <h2 class="h5 mb-1" style="font-family: 'Lexend', sans-serif; color: var(--vivora-vert-profond);">
              <?= htmlspecialchars($evenement->getTitre()) ?>
            </h2>
            <p class="mb-0 text-muted">
              <i class="bi bi-calendar me-1" aria-hidden="true"></i>
              <?= htmlspecialchars($evenement->getDateFormatee()) ?>
              à <?= htmlspecialchars($evenement->getHeureCourte()) ?>
              &nbsp;·&nbsp;
              <i class="bi bi-people me-1" aria-hidden="true"></i>
              <strong><?= count($participants) ?></strong>
              inscription<?= count($participants) > 1 ? 's' : '' ?> /
              <?= $evenement->getNbPlaces() ?> place<?= $evenement->getNbPlaces() > 1 ? 's' : '' ?>
            </p>
          </div>
        </div>
      </div>
    <?php endif; ?>

    <!-- Tableau des participants -->
    <div class="card">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h2 class="card-title mb-0">
          <i class="bi bi-person-lines-fill me-2" aria-hidden="true"></i>
          Liste des participants (<?= count($participants) ?>)
        </h2>
        <!-- Bouton export CSV (sera implémenté à l'étape CRUD) -->
        <button class="btn btn-outline-secondary btn-sm" disabled title="Disponible à l'étape CRUD">
          <i class="bi bi-download me-1" aria-hidden="true"></i>
          Exporter CSV
        </button>
      </div>
      <div class="card-body">

        <?php if (empty($participants)): ?>
          <div class="text-center py-5 text-muted">
            <i class="bi bi-person-x" style="font-size: 3rem;" aria-hidden="true"></i>
            <h3 class="h5 mt-3">Aucun participant inscrit</h3>
            <p>Les inscriptions pour cet événement n'ont pas encore commencé, ou la table des participants n'est pas encore créée.</p>
          </div>

        <?php else: ?>
          <div class="table-responsive">
            <table class="table table-hover dt-table w-100"
                   aria-label="Liste des participants">
              <thead>
                <tr>
                  <th scope="col">#</th>
                  <th scope="col">Prénom</th>
                  <th scope="col">Nom</th>
                  <th scope="col">E-mail</th>
                  <th scope="col">Téléphone</th>
                  <th scope="col">Besoin d'accessibilité</th>
                  <th scope="col">Date d'inscription</th>
                  <th scope="col" class="text-center">Actions</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($participants as $i => $p): ?>
                <tr>
                  <td><?= $i + 1 ?></td>
                  <td><?= htmlspecialchars($p['prenom'] ?? '—') ?></td>
                  <td><?= htmlspecialchars($p['nom'] ?? '—') ?></td>
                  <td>
                    <a href="mailto:<?= htmlspecialchars($p['email'] ?? '') ?>"
                       style="color: var(--vivora-sarcelle);">
                      <?= htmlspecialchars($p['email'] ?? '—') ?>
                    </a>
                  </td>
                  <td><?= htmlspecialchars($p['telephone'] ?? '—') ?></td>
                  <td>
                    <?php if (!empty($p['besoin_accessibilite'])): ?>
                      <span class="badge" style="background-color: var(--vivora-sarcelle); color: #fff;"
                            title="<?= htmlspecialchars($p['besoin_accessibilite']) ?>">
                        <i class="bi bi-universal-access" aria-hidden="true"></i>
                        Besoin spécifique
                      </span>
                    <?php else: ?>
                      <span class="text-muted">—</span>
                    <?php endif; ?>
                  </td>
                  <td>
                    <?= isset($p['created_at'])
                        ? htmlspecialchars(date('d/m/Y à H:i', strtotime($p['created_at'])))
                        : '—' ?>
                  </td>
                  <td class="text-center">
                    <!-- Supprimer la participation -->
                    <button class="btn btn-sm btn-danger"
                            aria-label="Supprimer la participation de <?= htmlspecialchars(($p['prenom'] ?? '') . ' ' . ($p['nom'] ?? '')) ?>"
                            onclick="return confirm('Supprimer la participation de <?= htmlspecialchars(addslashes(($p['prenom'] ?? '') . ' ' . ($p['nom'] ?? ''))) ?> ?')">
                      <i class="bi bi-trash" aria-hidden="true"></i>
                    </button>
                  </td>
                </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        <?php endif; ?>

      </div><!-- Fin card-body -->
    </div><!-- Fin card -->

    <!-- Bouton retour -->
    <div class="mt-3">
      <a href="<?= BASE_URL ?>index.php?controller=evenement&action=adminList"
         class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left me-1" aria-hidden="true"></i>
        Retour à la liste des événements
      </a>
    </div>

    <!-- Note développement -->
    <div class="callout callout-info mt-4" role="note">
      <h3 class="h6">
        <i class="bi bi-info-circle me-1" aria-hidden="true"></i>
        Note de développement
      </h3>
      <p class="mb-0 small">
        La table <code>inscription</code> (prenom, nom, email, telephone, besoin_accessibilite,
        evenement_id, created_at) sera créée lors de l'implémentation du CRUD.
        Les participants seront chargés via une jointure avec la table <code>evenement</code>.
      </p>
    </div>

  </div><!-- Fin container-fluid -->
</section>

<?php require __DIR__ . '/../layout/footer.php'; ?>
