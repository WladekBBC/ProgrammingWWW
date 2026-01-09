<?php
require_once __DIR__ . '/../includes/db.php';

if (!auth_is_logged_in()) {
    header('Location: index.php?page=login');
    exit;
}

/**
 * Przykładowy CRUD dla tabeli:
 *
 * CREATE TABLE notes (
 *   id INT AUTO_INCREMENT PRIMARY KEY,
 *   user_id INT NOT NULL,
 *   title VARCHAR(255) NOT NULL,
 *   body TEXT NOT NULL,
 *   created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
 *   FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
 * ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
 */

$pdo = get_pdo();
$userId = $_SESSION['user_id'];
$crudError = null;

// CREATE / UPDATE / DELETE
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    try {
        if ($action === 'create') {
            $title = trim($_POST['title'] ?? '');
            $body = trim($_POST['body'] ?? '');
            if ($title === '' || $body === '') {
                $crudError = 'Tytuł i treść są wymagane.';
            } else {
                $stmt = $pdo->prepare(
                    'INSERT INTO notes (user_id, title, body) VALUES (:user_id, :title, :body)'
                );
                $stmt->execute([
                    'user_id' => $userId,
                    'title'   => $title,
                    'body'    => $body,
                ]);
            }
        } elseif ($action === 'update') {
            $id = (int)($_POST['id'] ?? 0);
            $title = trim($_POST['title'] ?? '');
            $body = trim($_POST['body'] ?? '');
            if ($id <= 0 || $title === '' || $body === '') {
                $crudError = 'Nieprawidłowe dane do edycji.';
            } else {
                $stmt = $pdo->prepare(
                    'UPDATE notes SET title = :title, body = :body WHERE id = :id AND user_id = :user_id'
                );
                $stmt->execute([
                    'id'      => $id,
                    'user_id' => $userId,
                    'title'   => $title,
                    'body'    => $body,
                ]);
            }
        } elseif ($action === 'delete') {
            $id = (int)($_POST['id'] ?? 0);
            if ($id > 0) {
                $stmt = $pdo->prepare(
                    'DELETE FROM notes WHERE id = :id AND user_id = :user_id'
                );
                $stmt->execute([
                    'id'      => $id,
                    'user_id' => $userId,
                ]);
            }
        }
    } catch (PDOException $e) {
        $crudError = 'Błąd bazy danych: ' . htmlspecialchars($e->getMessage());
    }
}

// READ – wszystkie notatki użytkownika
$stmt = $pdo->prepare('SELECT id, title, body, created_at FROM notes WHERE user_id = :user_id ORDER BY created_at DESC');
$stmt->execute(['user_id' => $userId]);
$notes = $stmt->fetchAll();
?>
<main class="container">
  <section class="card">
    <h2>Notatki (CRUD)</h2>
    <p>
      Ten moduł demonstruje operacje CRUD (Create, Read, Update, Delete)
      na prostych notatkach powiązanych z zalogowanym użytkownikiem.
    </p>
    <?php if ($crudError): ?>
      <p class="form-error"><?= htmlspecialchars($crudError) ?></p>
    <?php endif; ?>
  </section>

  <section class="card">
    <h3>Dodaj nową notatkę</h3>
    <form method="post" action="index.php?page=notes">
      <input type="hidden" name="action" value="create" />
      <label for="title" class="form-label">Tytuł</label>
      <input
        type="text"
        class="form-input"
        id="title"
        name="title"
        required
      />

      <label for="body" class="form-label">Treść</label>
      <textarea
        class="form-input"
        id="body"
        name="body"
        rows="4"
        required
      ></textarea>

      <div class="button-group">
        <button class="form-button" type="submit">Dodaj notatkę</button>
      </div>
    </form>
  </section>

  <section class="card">
    <h3>Twoje notatki</h3>
    <?php if (!$notes): ?>
      <p>Brak notatek. Dodaj pierwszą notatkę powyżej.</p>
    <?php else: ?>
      <div class="notes-list">
        <?php foreach ($notes as $note): ?>
          <article class="note-item">
            <h4><?= htmlspecialchars($note['title']) ?></h4>
            <small>Utworzono: <?= htmlspecialchars($note['created_at']) ?></small>
            <p><?= nl2br(htmlspecialchars($note['body'])) ?></p>

            <details>
              <summary>Edytuj</summary>
              <form method="post" action="index.php?page=notes">
                <input type="hidden" name="action" value="update" />
                <input type="hidden" name="id" value="<?= (int)$note['id'] ?>" />

                <label class="form-label">Tytuł</label>
                <input
                  type="text"
                  class="form-input"
                  name="title"
                  value="<?= htmlspecialchars($note['title']) ?>"
                  required
                />

                <label class="form-label">Treść</label>
                <textarea
                  class="form-input"
                  name="body"
                  rows="3"
                  required
                ><?= htmlspecialchars($note['body']) ?></textarea>

                <div class="button-group">
                  <button class="form-button" type="submit">Zapisz</button>
                </div>
              </form>
            </details>

            <form
              method="post"
              action="index.php?page=notes"
              onsubmit="return confirm('Na pewno usunąć tę notatkę?');"
            >
              <input type="hidden" name="action" value="delete" />
              <input type="hidden" name="id" value="<?= (int)$note['id'] ?>" />
              <button class="form-button form-button-secondary" type="submit">
                Usuń
              </button>
            </form>
          </article>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
  </section>
</main>




