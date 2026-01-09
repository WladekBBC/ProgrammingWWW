      <footer class="site-footer">
        <div class="container">
          <small>© Vladyslav Berezhnyi</small>
          <?php if (isset($_COOKIE[LAST_PAGE_COOKIE])): ?>
            <span class="last-page-info">
              | Ostatnio odwiedzałeś: <?= htmlspecialchars($_COOKIE[LAST_PAGE_COOKIE]) ?>
            </span>
          <?php endif; ?>
        </div>
      </footer>
    </div>
  </body>
</html>




