<?php
require_once __DIR__ . '/../includes/notes-admin.php';
require_once __DIR__ . '/../includes/visits.php';

if (!auth_is_admin()) {
    echo '<main class="container"><section class="card"><h2>Błąd dostępu</h2><p>Nie masz uprawnień do tego panelu.</p></section></main>';
    return;
}

$actionMessage = null;
$actionError = null;
$action = $_GET['action'] ?? null;

// Obsługa zmian roli
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['user_id']) && !isset($_POST['delete_note'])) {
    $userId = (int)$_POST['user_id'];
    $newRole = $_POST['role'] ?? '';
    
    if (auth_update_user_role($userId, $newRole, $actionError)) {
        $actionMessage = 'Rola użytkownika została zaktualizowana.';
    }
}

// Obsługa usuwania użytkownika
if ($action === 'delete-user' && isset($_GET['user_id'])) {
    $userId = (int)$_GET['user_id'];
    if (auth_delete_user($userId, $actionError)) {
        $actionMessage = 'Użytkownik został usunięty.';
    }
}

// Obsługa usuwania notatki przez admina
if ($action === 'delete-note' && isset($_GET['note_id'])) {
    $noteId = (int)$_GET['note_id'];
    if (notes_delete_by_id($noteId, $actionError)) {
        $actionMessage = 'Notatka została usunięta.';
    }
}

$users = auth_get_all_users();
$allNotes = notes_get_all();
$totalNotes = notes_count();

// Statystyki odwiedzin
$totalVisits = visits_get_total_visits();
$visitsToday = visits_get_visits_today();
$visitsThisWeek = visits_get_visits_this_week();
$visitsThisMonth = visits_get_visits_this_month();
$uniqueVisitorsToday = visits_get_unique_visitors_today();
$visitsByPage = visits_get_visits_by_page();
$visitsByUser = visits_get_visits_by_user();
$recentVisits = visits_get_recent_visits(15);
$usersLastVisits = visits_get_all_users_last_visits();
?>
<main class="container">
  <section class="card">
    <h2>Panel Administratora</h2>
    
    <?php if ($actionMessage): ?>
      <div class="form-success">✓ <?= htmlspecialchars($actionMessage) ?></div>
    <?php endif; ?>
    
    <?php if ($actionError): ?>
      <div class="form-error">✗ <?= htmlspecialchars($actionError) ?></div>
    <?php endif; ?>

    <h3>Zarządzanie użytkownikami</h3>
    
    <div class="table-responsive">
      <table class="admin-table">
        <thead>
          <tr>
            <th>ID</th>
            <th>Email</th>
            <th>Rola</th>
            <th>Utworzono</th>
            <th>Akcje</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($users as $user): ?>
            <tr>
              <td><?= (int)$user['id'] ?></td>
              <td><?= htmlspecialchars($user['email']) ?></td>
              <td>
                <form method="post" action="index.php?page=admin" class="role-form">
                  <input type="hidden" name="user_id" value="<?= (int)$user['id'] ?>" />
                  <select name="role" onchange="this.form.submit()" class="role-select">
                    <option value="user" <?= $user['role'] === 'user' ? 'selected' : '' ?>>Użytkownik</option>
                    <option value="admin" <?= $user['role'] === 'admin' ? 'selected' : '' ?>>Administrator</option>
                  </select>
                </form>
              </td>
              <td><?= htmlspecialchars($user['created_at']) ?></td>
              <td>
                <?php if ((int)$user['id'] !== auth_current_user_id()): ?>
                  <a href="index.php?page=admin&action=delete-user&user_id=<?= (int)$user['id'] ?>" 
                     class="btn-delete"
                     onclick="return confirm('Czy na pewno chcesz usunąć tego użytkownika?')">
                    Usuń
                  </a>
                <?php else: ?>
                  <span class="text-muted">(Twoje konto)</span>
                <?php endif; ?>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>

    <div class="admin-stats">
      <h3>Statystyki</h3>
      <p>Łączna liczba użytkowników: <strong><?= count($users) ?></strong></p>
      <p>Administratorów: <strong><?= count(array_filter($users, fn($u) => $u['role'] === 'admin')) ?></strong></p>
      <p>Łączna liczba notatek: <strong><?= $totalNotes ?></strong></p>
    </div>
  </section>

  <section class="card">
    <h3>📊 Statystyki Odwiedzin</h3>
    <div class="stats-grid">
      <div class="stat-card">
        <div class="stat-label">Łącznie odwiedzin</div>
        <div class="stat-value"><?= number_format($totalVisits, 0, ',', ' ') ?></div>
      </div>
      <div class="stat-card">
        <div class="stat-label">Dziś</div>
        <div class="stat-value"><?= number_format($visitsToday, 0, ',', ' ') ?></div>
      </div>
      <div class="stat-card">
        <div class="stat-label">Ten tydzień</div>
        <div class="stat-value"><?= number_format($visitsThisWeek, 0, ',', ' ') ?></div>
      </div>
      <div class="stat-card">
        <div class="stat-label">Ten miesiąc</div>
        <div class="stat-value"><?= number_format($visitsThisMonth, 0, ',', ' ') ?></div>
      </div>
      <div class="stat-card">
        <div class="stat-label">Unikalni gośćmi dzisiaj</div>
        <div class="stat-value"><?= number_format($uniqueVisitorsToday, 0, ',', ' ') ?></div>
      </div>
    </div>
  </section>

  <section class="card">
    <h3>🔝 Najpopularniejsze strony</h3>
    
    <?php if (empty($visitsByPage)): ?>
      <p class="text-muted">Brak danych o odwiedzinach.</p>
    <?php else: ?>
      <div class="table-responsive">
        <table class="admin-table">
          <thead>
            <tr>
              <th>Strona</th>
              <th>Ilość odwiedzin</th>
              <th>Procent</th>
            </tr>
          </thead>
          <tbody>
            <?php 
              $totalPageVisits = array_sum(array_column($visitsByPage, 'count'));
              foreach ($visitsByPage as $visit): 
                $percentage = $totalPageVisits > 0 ? round(($visit['count'] / $totalPageVisits) * 100, 1) : 0;
            ?>
              <tr>
                <td><?= htmlspecialchars($visit['page']) ?></td>
                <td><?= number_format($visit['count'], 0, ',', ' ') ?></td>
                <td>
                  <div class="progress-bar">
                    <div class="progress-fill" style="width: <?= $percentage ?>%"></div>
                    <span class="progress-text"><?= $percentage ?>%</span>
                  </div>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    <?php endif; ?>
  </section>

  <section class="card">
    <h3>👥 Najaktywniejsi użytkownicy</h3>
    
    <?php if (empty($visitsByUser)): ?>
      <p class="text-muted">Brak danych o użytkownikach.</p>
    <?php else: ?>
      <div class="table-responsive">
        <table class="admin-table">
          <thead>
            <tr>
              <th>Email</th>
              <th>Ilość odwiedzin</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($visitsByUser as $user): ?>
              <tr>
                <td><?= htmlspecialchars($user['email'] ?? 'Anonimowy') ?></td>
                <td><?= number_format($user['count'], 0, ',', ' ') ?></td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    <?php endif; ?>
  </section>

  <section class="card">
    <h3>⏱️ Ostatnie odwiedziny (15 ostatnich)</h3>
    
    <?php if (empty($recentVisits)): ?>
      <p class="text-muted">Brak danych o odwiedzinach.</p>
    <?php else: ?>
      <div class="table-responsive">
        <table class="admin-table">
          <thead>
            <tr>
              <th>Strona</th>
              <th>Użytkownik / IP</th>
              <th>Czas</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($recentVisits as $visit): ?>
              <tr>
                <td><?= htmlspecialchars($visit['page']) ?></td>
                <td>
                  <div>
                    <div><?= htmlspecialchars($visit['email'] ?? 'Anonimowy') ?></div>
                    <div class="text-muted"><?= htmlspecialchars($visit['ip_address'] ?? 'N/A') ?></div>
                  </div>
                </td>
                <td>
                  <span class="text-muted"><?= htmlspecialchars($visit['visited_at']) ?></span>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    <?php endif; ?>
  </section>

  <section class="card">
    <h3>Zarządzanie notatkami</h3>
    
    <?php if (empty($allNotes)): ?>
      <p class="text-muted">Brak notatek w systemie.</p>
    <?php else: ?>
      <div class="table-responsive">
        <table class="admin-table">
          <thead>
            <tr>
              <th>ID</th>
              <th>Autor</th>
              <th>Tytuł</th>
              <th>Treść (podgląd)</th>
              <th>Utworzono</th>
              <th>Akcje</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($allNotes as $note): ?>
              <tr>
                <td><?= (int)$note['id'] ?></td>
                <td><?= htmlspecialchars($note['email'] ?? 'Brak użytkownika') ?></td>
                <td><?= htmlspecialchars(substr($note['title'], 0, 30)) ?></td>
                <td>
                  <span class="note-preview">
                    <?= htmlspecialchars(substr($note['body'], 0, 50)) ?>...
                  </span>
                </td>
                <td><?= htmlspecialchars($note['created_at']) ?></td>
                <td>
                  <a href="index.php?page=admin&action=delete-note&note_id=<?= (int)$note['id'] ?>" 
                     class="btn-delete"
                     onclick="return confirm('Czy na pewno chcesz usunąć tę notatkę?')">
                    Usuń
                  </a>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    <?php endif; ?>
  </section>

  <section class="card">
    <h3>🕐 Ostatnia wizyta użytkowników</h3>
    
    <?php if (empty($usersLastVisits)): ?>
      <p class="text-muted">Brak danych o użytkownikach.</p>
    <?php else: ?>
      <div class="table-responsive">
        <table class="admin-table">
          <thead>
            <tr>
              <th>Email</th>
              <th>Ostatnia wizyta</th>
              <th>Status</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($usersLastVisits as $user): 
              if ($user['last_visit']) {
                $lastVisitTime = strtotime($user['last_visit']);
                $currentTime = time();
                $diffSeconds = $currentTime - $lastVisitTime;
                
                if ($diffSeconds < 300) { // 5 minut
                  $status = '🟢 Online';
                  $statusClass = 'status-online';
                } elseif ($diffSeconds < 3600) { // 1 godzina
                  $status = '🟡 Niedawno';
                  $statusClass = 'status-active';
                } elseif ($diffSeconds < 86400) { // 1 dzień
                  $status = '⚪ Dziś';
                  $statusClass = 'status-today';
                } else {
                  $status = '⚫ Nieaktywny';
                  $statusClass = 'status-inactive';
                }
              } else {
                $user['last_visit'] = 'Nigdy';
                $status = '⚫ Nowy użytkownik';
                $statusClass = 'status-inactive';
              }
            ?>
              <tr>
                <td><?= htmlspecialchars($user['email']) ?></td>
                <td>
                  <span class="text-muted"><?= htmlspecialchars($user['last_visit']) ?></span>
                </td>
                <td>
                  <span class="status-badge <?= $statusClass ?>">
                    <?= $status ?>
                  </span>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    <?php endif; ?>
  </section>
</main>
