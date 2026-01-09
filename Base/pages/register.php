<?php
$registerError = null;
$registerSuccess = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $passwordConfirm = $_POST['password_confirm'] ?? '';

    if (auth_register($email, $password, $passwordConfirm, $registerError)) {
        $registerSuccess = true;
    }
}
?>
<main class="container">
  <section class="card">
    <h2>Rejestracja</h2>

    <?php if ($registerSuccess): ?>
      <p class="form-success">
        Konto zostało utworzone. Możesz się teraz
        <a href="index.php?page=login">zalogować</a>.
      </p>
    <?php elseif ($registerError): ?>
      <p class="form-error"><?= htmlspecialchars($registerError) ?></p>
    <?php endif; ?>

    <form method="post" action="index.php?page=register">
      <label for="email" class="form-label">Email</label>
      <input
        type="email"
        class="form-input"
        id="email"
        name="email"
        required
      />

      <label for="password" class="form-label">Hasło</label>
      <input
        type="password"
        class="form-input"
        id="password"
        name="password"
        minlength="6"
        required
      />

      <label for="password_confirm" class="form-label">Powtórz hasło</label>
      <input
        type="password"
        class="form-input"
        id="password_confirm"
        name="password_confirm"
        minlength="6"
        required
      />

      <div class="button-group">
        <button class="form-button" type="submit">Zarejestruj</button>
      </div>
    </form>
  </section>
</main>




