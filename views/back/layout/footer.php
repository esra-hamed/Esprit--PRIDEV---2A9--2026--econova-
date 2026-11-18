  </div><!-- Fin .content-wrapper -->

  <!-- ══════════════════════════════════════════════════════════
       PIED DE PAGE AdminLTE
  ══════════════════════════════════════════════════════════ -->
  <footer class="main-footer" role="contentinfo">
    <strong>
      &copy; <?= date('Y') ?>
      <a href="<?= BASE_URL ?>index.php" style="color: var(--vivora-sarcelle);">Vivora</a>.
    </strong>
    Projet Technologies Web – ESPRIT, Groupe Econova.
    <div class="float-right d-none d-sm-inline-block">
      <b>Module 4</b> – Lieux &amp; Événements
    </div>
  </footer>

  <!-- Sidebar de droite (optionnel AdminLTE) -->
  <aside class="control-sidebar control-sidebar-dark" aria-label="Panneau de contrôle latéral"></aside>

</div><!-- Fin .wrapper -->

<!-- ══════════════════════════════════════════════════════════
     SCRIPTS JS AdminLTE
══════════════════════════════════════════════════════════ -->

<!-- jQuery (requis par AdminLTE) -->
<script src="<?= BASE_URL ?>public/assets/back/vendor/jquery/jquery.min.js"></script>

<!-- Bootstrap Bundle -->
<script src="<?= BASE_URL ?>public/assets/back/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- AdminLTE App -->
<script src="<?= BASE_URL ?>public/assets/back/js/adminlte.min.js"></script>

<!-- DataTables (pour les tableaux avec recherche et tri) -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap4.min.css">
<script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap4.min.js"></script>

<!-- Initialisation DataTables pour toutes les tables avec la classe .dt-table -->
<script>
$(document).ready(function () {
  $('.dt-table').DataTable({
    language: {
      url: 'https://cdn.datatables.net/plug-ins/1.13.8/i18n/fr-FR.json'
    },
    responsive: true
  });
});
</script>

</body>
</html>
