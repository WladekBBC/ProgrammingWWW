<main class="container">
  <section class="card">
    <h2>Strona kontaktowa</h2>
    <form
      action=""
      method="post"
      name="fm"
    >
      <fieldset class="form-fieldset" id="fm">
        <legend>Formularz kontaktowy</legend>

        <label for="name" class="form-label">Imię</label>
        <input
          type="text"
          class="form-input"
          id="name"
          name="name"
          placeholder="Jan"
          pattern="[A-Za-zĄąĆćĘęŁłŃńÓóŚśŹźŻż\s]{2,50}"
          required
        /><br />

        <label for="surname" class="form-label">Nazwisko</label>
        <input
          type="text"
          class="form-input"
          id="surname"
          name="surname"
          placeholder="Kowalski"
          pattern="[A-Za-zĄąĆćĘęŁłŃńÓóŚśŹźŻż\s]{2,50}"
          required
        /><br />

        <label for="email" class="form-label">Email</label>
        <input
          type="email"
          class="form-input"
          id="email"
          name="email"
          placeholder="jan.kowalski@uwm.edu.pl"
          pattern="[a-z0-9._%+\-]+@[a-z0-9.\-]+\.[a-z]{2,}"
          required
        />
        <br />

        <label for="phone" class="form-label">Telefon</label>
        <input
          type="tel"
          class="form-input"
          id="phone"
          name="phone"
          placeholder="123456789"
          pattern="[0-9]{9}"
          required
        />
        <br />

        <label class="form-label">Temat zapytania:</label>
        <div class="radio-group">
          <label class="radio-label">
            <input
              type="radio"
              name="topic"
              value="instalacja"
              required
            />
            Instalacja Ubuntu
          </label>
          <label class="radio-label">
            <input type="radio" name="topic" value="problem" required />
            Problem techniczny
          </label>
          <label class="radio-label">
            <input type="radio" name="topic" value="inne" required />
            Inne
          </label>
        </div>
        <br />

        <label for="priority" class="form-label">Priorytet:</label>
        <select id="priority" name="priority" class="form-input" required>
          <option value="">-- Wybierz priorytet --</option>
          <option value="niski">Niski</option>
          <option value="sredni">Średni</option>
          <option value="wysoki">Wysoki</option>
          <option value="pilny">Pilny</option>
        </select>
        <br />

        <div class="checkbox-group">
          <label class="checkbox-label">
            <input type="checkbox" name="newsletter" value="yes" />
            Chcę otrzymywać newsletter z aktualizacjami
          </label>
        </div>
        <br />

        <label class="form-label">Termin odpowiedzi:</label>
        <div class="date-range">
          <label for="date-from" class="form-label-small">Od:</label>
          <input
            type="date"
            class="form-input"
            id="date-from"
            name="date-from"
            required
          />
          <label for="date-to" class="form-label-small">Do:</label>
          <input
            type="date"
            class="form-input"
            id="date-to"
            name="date-to"
            required
          />
        </div>
        <br />

        <label for="message" class="form-label">Wiadomość</label>
        <textarea
          class="form-input"
          id="message"
          name="message"
          placeholder="Opisz dokładnie swoje pytanie lub problem..."
          rows="5"
          minlength="10"
          maxlength="500"
          required
        ></textarea>
        <br />

        <div class="button-group">
          <button class="form-button" type="submit">Wyślij</button>
          <button class="form-button form-button-secondary" type="reset">
            Anuluj
          </button>
        </div>

        <?php if ($_SERVER['REQUEST_METHOD'] === 'POST'): ?>
          <p class="form-success">
            Dziękujemy za wiadomość. (W wersji demonstracyjnej dane nie są
            wysyłane dalej – obsługą może zająć się przyszły moduł PHP/DB.)
          </p>
        <?php endif; ?>
      </fieldset>
    </form>
  </section>
</main>



