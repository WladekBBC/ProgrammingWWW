<?php
$loginError = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $remember = isset($_POST['remember']);

    if (auth_login($email, $password, $remember, $loginError)) {
        header('Location: index.php?page=notes');
        exit;
    }
}

$rememberedEmail = $_COOKIE['remember_email'] ?? '';
?>
<main class="container">
  <section class="card">
    <h2>Logowanie</h2>
    <?php if ($loginError): ?>
      <p class="form-error"><?= htmlspecialchars($loginError) ?></p>
    <?php endif; ?>

    <form method="post" action="index.php?page=login">
      <label for="email" class="form-label">Email</label>
      <input
        type="email"
        class="form-input"
        id="email"
        name="email"
        value="<?= htmlspecialchars($rememberedEmail) ?>"
        required
      />

      <label for="password" class="form-label">Hasło</label>
      <input
        type="password"
        class="form-input"
        id="password"
        name="password"
        required
      />

      <label class="checkbox-label">
        <input type="checkbox" name="remember" />
        Zapamiętaj mnie (ciasteczko z e-mailem)
      </label>

      <div class="button-group">
        <button class="form-button" type="submit">Zaloguj</button>
      </div>
    </form>
    <p>
      Nie masz konta?
      <a href="index.php?page=register">Zarejestruj się</a>.
    </p>
  </section>
</main>




