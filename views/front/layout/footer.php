  </main><!-- Fin du contenu principal -->

  <!-- ══════════════════════════════════════════════════════════
       PIED DE PAGE (Medilab style – surcharges Vivora)
  ══════════════════════════════════════════════════════════ -->
  <footer id="footer" role="contentinfo">

    <div class="footer-top">
      <div class="container">
        <div class="row">

          <!-- À propos de Vivora -->
          <div class="col-lg-3 col-md-6 footer-contact">
            <h4>Vivora</h4>
            <p>
              Plateforme de santé et bien-être<br>
              inclusive en Tunisie.<br>
              Un projet ESPRIT – Groupe Econova.<br>
            </p>
          </div>

          <!-- Liens utiles -->
          <div class="col-lg-3 col-md-6 footer-links">
            <h4>Liens utiles</h4>
            <ul>
              <li>
                <i class="bi bi-chevron-right" aria-hidden="true"></i>
                <a href="<?= BASE_URL ?>index.php">Accueil</a>
              </li>
              <li>
                <i class="bi bi-chevron-right" aria-hidden="true"></i>
                <a href="<?= BASE_URL ?>index.php?controller=lieu&action=list">Lieux accessibles</a>
              </li>
              <li>
                <i class="bi bi-chevron-right" aria-hidden="true"></i>
                <a href="<?= BASE_URL ?>index.php?controller=evenement&action=list">Événements</a>
              </li>
              <li>
                <i class="bi bi-chevron-right" aria-hidden="true"></i>
                <a href="#">Politique d'accessibilité</a>
              </li>
            </ul>
          </div>

          <!-- Module 4 : Lieux & Événements -->
          <div class="col-lg-3 col-md-6 footer-links">
            <h4>Lieux & Événements</h4>
            <ul>
              <li>
                <i class="bi bi-geo-alt" aria-hidden="true"></i>
                <a href="<?= BASE_URL ?>index.php?controller=lieu&action=list">Tous les lieux</a>
              </li>
              <li>
                <i class="bi bi-calendar-event" aria-hidden="true"></i>
                <a href="<?= BASE_URL ?>index.php?controller=evenement&action=list">Agenda des événements</a>
              </li>
            </ul>
          </div>

          <!-- Réseaux sociaux -->
          <div class="col-lg-3 col-md-6 footer-info">
            <h4>Suivez-nous</h4>
            <div class="social-links mt-3">
              <a href="#" aria-label="Facebook de Vivora" class="me-2">
                <i class="bi bi-facebook" aria-hidden="true"></i>
              </a>
              <a href="#" aria-label="Instagram de Vivora" class="me-2">
                <i class="bi bi-instagram" aria-hidden="true"></i>
              </a>
              <a href="#" aria-label="LinkedIn de Vivora" class="me-2">
                <i class="bi bi-linkedin" aria-hidden="true"></i>
              </a>
            </div>
          </div>

        </div>
      </div>
    </div><!-- Fin footer-top -->

    <!-- Mention légale -->
    <div class="container py-3">
      <div class="text-center" style="color: rgba(246,244,238,0.7); font-size: 0.85rem;">
        &copy; <?= date('Y') ?> <strong>Vivora</strong> – Projet Technologies Web, ESPRIT, Groupe Econova.
        Tous droits réservés.
      </div>
    </div>

  </footer><!-- Fin footer -->

  <!-- ══════════════════════════════════════════════════════════
       SCRIPTS JS
  ══════════════════════════════════════════════════════════ -->

  <!-- Bootstrap Bundle (inclut Popper.js) -->
  <script src="<?= BASE_URL ?>public/assets/front/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Librairies du template Medilab -->
  <script src="<?= BASE_URL ?>public/assets/front/vendor/aos/aos.js"></script>
  <script src="<?= BASE_URL ?>public/assets/front/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="<?= BASE_URL ?>public/assets/front/vendor/swiper/swiper-bundle.min.js"></script>

  <!-- Script principal Medilab -->
  <script src="<?= BASE_URL ?>public/assets/front/js/main.js"></script>

  <!-- Script Vivora (si nécessaire, pour les filtres JS) -->
  <!-- <script src="<?= BASE_URL ?>public/assets/front/js/vivora-front.js"></script> -->

</body>
</html>
