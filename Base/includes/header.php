<?php
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/auth.php';

$currentPage = $_GET['page'] ?? 'home';

$titles = [
    'home'         => 'Strona główna',
    'steps-mac'    => 'Ubuntu Server - macOS',
    'steps-windows'=> 'Ubuntu Server - Windows',
    'gallery'      => 'Galeria',
    'resources'    => 'FAQ & Zasoby',
    'contact'      => 'Strona kontaktowa',
    'login'        => 'Logowanie',
    'register'     => 'Rejestracja',
    'notes'        => 'Notatki (CRUD)',
];

$pageTitle = $titles[$currentPage] ?? 'Strona główna';
?>
<!DOCTYPE html>
<html lang="pl">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="description" content="Serwis z instrukcjami Ubuntu Server" />
    <meta name="author" content="Vladyslav Berezhnyi" />
    <link rel="icon" type="image/jpeg" href="./content/favicon.jpeg" />
    <title><?= htmlspecialchars($pageTitle) ?></title>
    <link rel="stylesheet" href="./style/style.css" />
    <script defer src="./script/script.js"></script>
  </head>
  <body>
    <aside class="sidebar" id="sidebar">
      <div class="sidebar-header">
        <a class="brand" href="index.php?page=home">Home</a>
        <button
          class="sidebar-toggle"
          aria-expanded="false"
          aria-controls="sidebar"
          aria-label="Toggle sidebar"
        >
          ✕
        </button>
      </div>
      <nav class="sidebar-nav">
        <a href="index.php?page=home"
           class="nav-link<?= $currentPage === 'home' ? ' active' : '' ?>"
           data-nav
           <?= $currentPage === 'home' ? 'aria-current="page"' : '' ?>
        >Strona główna</a>

        <a href="index.php?page=steps-mac"
           class="nav-link<?= $currentPage === 'steps-mac' ? ' active' : '' ?>"
           data-nav
           <?= $currentPage === 'steps-mac' ? 'aria-current="page"' : '' ?>
        >Kroki macOS</a>

        <a href="index.php?page=steps-windows"
           class="nav-link<?= $currentPage === 'steps-windows' ? ' active' : '' ?>"
           data-nav
           <?= $currentPage === 'steps-windows' ? 'aria-current="page"' : '' ?>
        >Kroki Windows</a>

        <a href="index.php?page=gallery"
           class="nav-link<?= $currentPage === 'gallery' ? ' active' : '' ?>"
           data-nav
           <?= $currentPage === 'gallery' ? 'aria-current="page"' : '' ?>
        >Galeria</a>

        <a href="index.php?page=resources"
           class="nav-link<?= $currentPage === 'resources' ? ' active' : '' ?>"
           data-nav
           <?= $currentPage === 'resources' ? 'aria-current="page"' : '' ?>
        >FAQ &amp; Zasoby</a>

        <a href="index.php?page=contact"
           class="nav-link<?= $currentPage === 'contact' ? ' active' : '' ?>"
           data-nav
           <?= $currentPage === 'contact' ? 'aria-current="page"' : '' ?>
        >Strona kontaktowa</a>

        <a href="index.php?page=notes"
           class="nav-link<?= $currentPage === 'notes' ? ' active' : '' ?>"
           data-nav
           <?= $currentPage === 'notes' ? 'aria-current="page"' : '' ?>
        >Notatki (CRUD)</a>

        <?php if (auth_is_logged_in()): ?>
          <span class="nav-user">
            Zalogowany: <?= htmlspecialchars(auth_current_user_email() ?? '') ?>
          </span>
          <a href="index.php?page=login&action=logout" class="nav-link" data-nav>Wyloguj</a>
        <?php else: ?>
          <a href="index.php?page=login"
             class="nav-link<?= $currentPage === 'login' ? ' active' : '' ?>"
             data-nav
          >Logowanie</a>
          <a href="index.php?page=register"
             class="nav-link<?= $currentPage === 'register' ? ' active' : '' ?>"
             data-nav
          >Rejestracja</a>
        <?php endif; ?>
      </nav>
    </aside>

    <div class="main-content">
      <header class="site-header">
        <div class="container header-inner">
          <button
            class="mobile-nav-toggle"
            aria-expanded="false"
            aria-controls="sidebar"
            aria-label="Toggle navigation"
          >
            ☰
          </button>
          <h1 class="page-title"><?= htmlspecialchars($pageTitle) ?></h1>
          <div class="live-clock" id="live-clock" aria-live="polite"></div>
        </div>
      </header>



