<main class="container">
  <section class="card">
    <h2>Instalacja Ubuntu Server ARM64 na macOS z Apple Silicon</h2>
    <p>
      Ten przewodnik przeprowadzi Cię przez proces instalacji Ubuntu
      Server 24.04.3 ARM64 na macOS z procesorem Apple Silicon (M1/M2/M3)
      przy użyciu narzędzi wirtualizacji.
    </p>
  </section>

  <?php // Dalej treść przeniesiona wprost ze starej podstrony ?>
  <section class="card">
    <h2>Pobieranie Ubuntu Server ARM64</h2>
    <p>Pobierz najnowszą wersję Ubuntu Server ARM64:</p>
    <div class="download-section">
      <a
        href="https://cdimage.ubuntu.com/releases/24.04/release/ubuntu-24.04.3-live-server-arm64.iso"
        class="download-link"
        target="_blank"
        rel="noopener noreferrer"
      >
        Ubuntu 24.04.3 Live Server ARM64 ISO
      </a>
      <p class="download-info">Rozmiar: ~3 GB | Format: ISO</p>
    </div>
  </section>

  <section class="card">
    <h2>Wymagania systemowe</h2>
    <div class="requirements">
      <h3>Minimalne wymagania:</h3>
      <ul>
        <li>
          <strong>Mac:</strong> Apple Silicon (M1, M2, M3 lub nowszy)
        </li>
        <li><strong>macOS:</strong> macOS 12 Monterey lub nowszy</li>
        <li><strong>RAM:</strong> Minimum 4 GB (zalecane 8 GB)</li>
        <li>
          <strong>Miejsce na dysku:</strong> Minimum 20 GB wolnego miejsca
        </li>
        <li>
          <strong>Połączenie internetowe:</strong> Do pobierania
          aktualizacji
        </li>
      </ul>

      <h3>Potrzebne oprogramowanie:</h3>
      <ul>
        <li><strong>UTM:</strong> Darmowa aplikacja do wirtualizacji</li>
        <li>
          <strong>Homebrew:</strong> Menedżer pakietów (opcjonalnie)
        </li>
      </ul>
    </div>
  </section>

  <section class="card">
    <h2>Instalacja UTM</h2>
    <div class="step-content">
      <h3>Krok 1: Pobierz UTM</h3>
      <p>
        UTM to najlepsza opcja do uruchamiania maszyn wirtualnych na Apple
        Silicon:
      </p>
      <ol>
        <li>Otwórz App Store na swoim Macu</li>
        <li>Wyszukaj "UTM"</li>
        <li>Pobierz i zainstaluj aplikację</li>
      </ol>
    </div>
    <div class="download-section">
      <a
        href="https://github.com/utmapp/UTM/releases/latest/download/UTM.dmg"
        class="download-link"
      >UTM MacOS</a>
      <p class="download-info">Rozmiar: ~250 MB | Format: DMG</p>
    </div>
    <img src="./content/UTM.png" alt="UTM" />
  </section>

  <section class="card">
    <h2>Tworzenie maszyny wirtualnej</h2>
    <div class="step-content">
      <h3>Krok 3: Utwórz nową maszynę wirtualną</h3>
      <ol>
        <li>Otwórz UTM</li>
        <li>Kliknij "Create a New Virtual Machine"</li>
        <li>Wybierz "Emulate"</li>
        <li>Wybierz "Linux"</li>
      </ol>

      <h3>Krok 4: Konfiguracja podstawowa</h3>
      <ul>
        <li><strong>Nazwa:</strong> Ubuntu Server ARM64</li>
        <li><strong>System:</strong> Linux</li>
        <li><strong>Architektura:</strong> ARM64 (aarch64)</li>
      </ul>

      <h3>Krok 5: Wybór obrazu ISO</h3>
      <ol>
        <li>Kliknij "Browse" w sekcji "Boot ISO Image"</li>
        <li>
          Wybierz pobrany plik
          <code>ubuntu-24.04.3-live-server-arm64.iso</code>
        </li>
        <li>Kliknij "Continue"</li>
      </ol>
    </div>
  </section>

  <section class="card">
    <h2>Konfiguracja zasobów</h2>
    <div class="step-content">
      <h3>Krok 6: Przydział pamięci RAM</h3>
      <ul>
        <li><strong>Minimum:</strong> 2 GB</li>
        <li><strong>Zalecane:</strong> 4-8 GB</li>
        <li>
          <strong>Maksimum:</strong> Nie więcej niż połowa dostępnej RAM
        </li>
      </ul>

      <h3>Krok 7: Przydział miejsca na dysku</h3>
      <ul>
        <li><strong>Minimum:</strong> 20 GB</li>
        <li><strong>Zalecane:</strong> 40-60 GB</li>
        <li><strong>Format:</strong> qcow2 (zalecany)</li>
      </ul>

      <h3>Krok 8: Ustawienia sieci</h3>
      <ul>
        <li>
          <strong>Tryb:</strong> Shared Network (odpowiednik NAT w
          VirtualBox)
        </li>
        <li><strong>Port forwarding:</strong> Opcjonalnie dla SSH</li>
      </ul>
    </div>
  </section>

  <section class="card">
    <h2>Instalacja Ubuntu Server</h2>
    <div class="step-content">
      <h3>Krok 9: Uruchomienie instalatora</h3>
      <ol>
        <li>Kliknij "Save" w UTM</li>
        <li>Kliknij "Play" aby uruchomić maszynę wirtualną</li>
        <li>Ubuntu Server Live CD powinien się uruchomić</li>
      </ol>

      <h3>Krok 10: Proces instalacji</h3>
      <ol>
        <li><strong>Wybierz język:</strong> Polski lub English</li>
        <li><strong>Układ klawiatury:</strong> Polish lub US</li>
        <li><strong>Typ instalacji:</strong> Normal installation</li>
        <li><strong>Sieć:</strong> Skonfiguruj połączenie internetowe</li>
        <li><strong>Proxy:</strong> Zostaw puste (jeśli nie używasz)</li>
        <li><strong>Mirror:</strong> Wybierz najbliższy serwer</li>
      </ol>

      <h3>Krok 11: Partycjonowanie dysku</h3>
      <ul>
        <li>
          <strong>Opcja:</strong> "Use entire disk" (zalecane dla
          początkujących)
        </li>
        <li>
          <strong>LVM:</strong> Można włączyć dla zaawansowanych
          użytkowników
        </li>
        <li><strong>Encryption:</strong> Opcjonalnie</li>
      </ul>

      <h3>Krok 12: Konfiguracja użytkownika</h3>
      <ul>
        <li><strong>Imię:</strong> Twoje imię</li>
        <li><strong>Nazwa użytkownika:</strong> Twój login</li>
        <li><strong>Hasło:</strong> Silne hasło</li>
        <li><strong>Potwierdź hasło:</strong> Powtórz hasło</li>
      </ul>

      <h3>Krok 13: SSH Server</h3>
      <ul>
        <li><strong>Zainstaluj SSH Server:</strong> ✅ Zaznacz</li>
        <li><strong>Import SSH keys:</strong> Opcjonalnie</li>
      </ul>

      <h3>Krok 14: Dodatkowe pakiety</h3>
      <ul>
        <li><strong>Snap packages:</strong> Opcjonalnie</li>
        <li><strong>Standard system utilities:</strong> ✅ Zaznacz</li>
      </ul>
    </div>
  </section>

  <section class="card">
    <h2>Finalizacja instalacji</h2>
    <div class="step-content">
      <h3>Krok 15: Zakończenie instalacji</h3>
      <ol>
        <li>Kliknij "Install Now"</li>
        <li>Poczekaj na zakończenie instalacji (10-30 minut)</li>
        <li>Po zakończeniu kliknij "Restart Now"</li>
        <li>Usuń ISO z UTM (Settings → Drives → Remove ISO)</li>
      </ol>

      <h3>Krok 16: Pierwsze uruchomienie</h3>
      <ol>
        <li>Uruchom ponownie maszynę wirtualną</li>
        <li>Zaloguj się używając utworzonego konta</li>
        <li>
          Sprawdź połączenie internetowe: <code>ping google.com</code>
        </li>
        <li>
          Zaktualizuj system:
          <code>sudo apt update && sudo apt upgrade</code>
        </li>
      </ol>
    </div>
  </section>

  <section class="card">
    <h2>Przydatne komendy po instalacji</h2>
    <div class="step-content">
      <h3>Podstawowe komendy:</h3>
      <div class="code-block">
        <code>sudo apt update</code> - Aktualizacja listy pakietów<br />
        <code>sudo apt upgrade</code> - Aktualizacja systemu<br />
        <code>sudo apt install htop</code> - Instalacja monitora
        systemu<br />
        <code>sudo apt install nano</code> - Instalacja edytora tekstu<br />
        <code>sudo apt install curl wget</code> - Narzędzia do
        pobierania<br />
        <code>sudo systemctl status ssh</code> - Status serwera SSH<br />
        <code>ip addr show</code> - Sprawdzenie adresu IP<br />
        <code>df -h</code> - Sprawdzenie miejsca na dysku
      </div>

      <h3>Konfiguracja SSH:</h3>
      <div class="code-block">
        <code>sudo systemctl enable ssh</code> - Włączenie SSH przy
        starcie<br />
        <code>sudo systemctl start ssh</code> - Uruchomienie SSH<br />
        <code>sudo ufw allow ssh</code> - Zezwolenie na SSH w firewall
      </div>
    </div>
  </section>

  <section class="card">
    <h2>Rozwiązywanie problemów</h2>
    <div class="step-content">
      <h3>Typowe problemy:</h3>

      <h4>Problem: Maszyna wirtualna nie uruchamia się</h4>
      <ul>
        <li>Sprawdź czy architektura jest ustawiona na ARM64</li>
        <li>Upewnij się, że masz wystarczająco RAM</li>
        <li>Spróbuj zmniejszyć przydział pamięci</li>
      </ul>

      <h4>Problem: Wolna wydajność</h4>
      <ul>
        <li>Zwiększ przydział RAM</li>
        <li>Użyj dysku SSD</li>
        <li>Zamknij niepotrzebne aplikacje na macOS</li>
      </ul>

      <h4>Problem: Brak połączenia internetowego</h4>
      <ul>
        <li>Sprawdź ustawienia sieci w UTM</li>
        <li>Użyj trybu "Shared Network"</li>
        <li>Sprawdź konfigurację DHCP</li>
      </ul>

      <h4>Problem: Nie można zalogować się przez SSH</h4>
      <ul>
        <li>
          Sprawdź czy SSH jest zainstalowany:
          <code>sudo systemctl status ssh</code>
        </li>
        <li>Sprawdź adres IP: <code>ip addr show</code></li>
        <li>Sprawdź firewall: <code>sudo ufw status</code></li>
      </ul>
    </div>
  </section>

  <section class="card">
    <h2>Dodatkowe zasoby</h2>
    <div class="step-content">
      <h3>Przydatne linki:</h3>
      <ul>
        <li>
          <a href="https://ubuntu.com/server" target="_blank"
            >Oficjalna strona Ubuntu Server</a
          >
        </li>
        <li>
          <a href="https://mac.getutm.app/" target="_blank">Strona UTM</a>
        </li>
        <li>
          <a href="https://help.ubuntu.com/" target="_blank"
            >Dokumentacja Ubuntu</a
          >
        </li>
        <li>
          <a href="https://ubuntu.com/tutorials" target="_blank"
            >Samouczki Ubuntu</a
          >
        </li>
      </ul>

      <h3>Dokumentacja:</h3>
      <ul>
        <li>
          <a href="https://ubuntu.com/server/docs" target="_blank"
            >Dokumentacja Ubuntu Server</a
          >
        </li>
        <li>
          <a href="https://help.ubuntu.com/community" target="_blank"
            >Społeczność Ubuntu</a
          >
        </li>
      </ul>
    </div>
  </section>
</main>


