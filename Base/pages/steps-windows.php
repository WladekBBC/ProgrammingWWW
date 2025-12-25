<main class="container">
  <section class="card">
    <h2>Instalacja Ubuntu Server na Windows</h2>
    <p>
      Ten przewodnik przeprowadzi Cię przez proces instalacji Ubuntu
      Server 24.04 na Windows przy użyciu VirtualBox - darmowego
      oprogramowania do wirtualizacji.
    </p>
  </section>

  <section class="card">
    <h2>Pobieranie Ubuntu Server</h2>
    <p>Pobierz najnowszą wersję Ubuntu Server:</p>
    <div class="download-section">
      <a
        href="https://releases.ubuntu.com/24.04.3/ubuntu-24.04.3-live-server-amd64.iso"
        class="download-link"
        target="_blank"
        rel="noopener noreferrer"
      >
        Ubuntu 24.04 Live Server AMD64 ISO
      </a>
      <p class="download-info">Rozmiar: ~2.9 GB | Format: ISO</p>
    </div>
  </section>

  <section class="card">
    <h2>Wymagania systemowe</h2>
    <div class="requirements">
      <h3>Minimalne wymagania:</h3>
      <ul>
        <li>
          <strong>System operacyjny:</strong> Windows 10/11 (64-bit)
        </li>
        <li>
          <strong>Procesor:</strong> Intel/AMD 64-bit z obsługą
          wirtualizacji (VT-x/AMD-V)
        </li>
        <li><strong>RAM:</strong> Minimum 4 GB (zalecane 8 GB)</li>
        <li>
          <strong>Miejsce na dysku:</strong> Minimum 25 GB wolnego miejsca
        </li>
        <li>
          <strong>Połączenie internetowe:</strong> Do pobierania
          aktualizacji
        </li>
      </ul>

      <h3>Potrzebne oprogramowanie:</h3>
      <ul>
        <li>
          <strong>VirtualBox:</strong> Darmowa aplikacja do wirtualizacji
        </li>
        <li>
          <strong>Kodery wideo:</strong> Opcjonalnie dla lepszej
          wydajności
        </li>
      </ul>
    </div>
  </section>

  <section class="card">
    <h2>Instalacja VirtualBox</h2>
    <div class="step-content">
      <h3>Krok 1: Pobierz VirtualBox</h3>
      <p>
        VirtualBox to darmowe oprogramowanie Oracle do uruchamiania maszyn
        wirtualnych:
      </p>
      <ol>
        <li>Przejdź na oficjalną stronę VirtualBox</li>
        <li>Pobierz wersję dla Windows</li>
        <li>Uruchom instalator</li>
      </ol>
    </div>
    <div class="download-section">
      <a
        href="https://www.virtualbox.org/wiki/Downloads"
        class="download-link"
        target="_blank"
        rel="noopener noreferrer"
      >VirtualBox Windows</a>
      <p class="download-info">Rozmiar: ~120 MB | Format: EXE</p>
    </div>
    <img src="./content/virtualbox.png" alt="virtualbox" />
  </section>

  <section class="card">
    <h2>Tworzenie maszyny wirtualnej</h2>
    <div class="step-content">
      <h3>Krok 3: Utwórz nową maszynę wirtualną</h3>
      <ol>
        <li>Otwórz VirtualBox</li>
        <li>Kliknij przycisk <strong>"New"</strong> (Nowa)</li>
        <li>Wprowadź nazwę: <strong>Ubuntu Server 24.04</strong></li>
        <li>Wybierz typ: <strong>Linux</strong></li>
        <li>Wybierz wersję: <strong>Ubuntu (64-bit)</strong></li>
      </ol>

      <h3>Krok 4: Przydział pamięci RAM</h3>
      <ul>
        <li><strong>Minimum:</strong> 2048 MB (2 GB)</li>
        <li><strong>Zalecane:</strong> 4096 MB (4 GB) lub więcej</li>
        <li>
          <strong>Maksimum:</strong> Nie więcej niż połowa dostępnej RAM
        </li>
      </ul>

      <h3>Krok 5: Utworzenie dysku wirtualnego</h3>
      <ol>
        <li>Wybierz <strong>"Create a virtual hard disk now"</strong></li>
        <li>Kliknij <strong>"Create"</strong></li>
        <li>
          Wybierz typ: <strong>VDI (VirtualBox Disk Image)</strong>
        </li>
        <li>Wybierz <strong>"Dynamically allocated"</strong></li>
        <li>
          Ustaw rozmiar: Minimum <strong>25 GB</strong>, zalecane
          <strong>40 GB</strong>
        </li>
      </ol>
    </div>
  </section>

  <section class="card">
    <h2>Konfiguracja i instalacja Ubuntu</h2>
    <div class="step-content">
      <h3>Krok 6: Konfiguracja ustawień</h3>
      <ol>
        <li>
          Wybierz utworzoną maszynę i kliknij
          <strong>"Settings"</strong> (Ustawienia)
        </li>
        <li>Przejdź do zakładki <strong>"System"</strong></li>
        <li>
          W sekcji "Motherboard" sprawdź kolejność bootowania (CD powinno
          być pierwsze)
        </li>
        <li>Przejdź do zakładki <strong>"Storage"</strong></li>
        <li>Dodaj obraz ISO Ubuntu jako napęd optyczny</li>
      </ol>

      <h3>Krok 7: Dodatkowe ustawienia wydajności</h3>
      <ul>
        <li>Zwiększ liczbę procesorów do 2-4 (jeśli masz dostępne)</li>
        <li>Zwiększ pamięć wideo do 128 MB</li>
      </ul>

      <h3>Krok 8: Uruchomienie instalatora</h3>
      <ol>
        <li>Wybierz maszynę wirtualną</li>
        <li>
          Kliknij przycisk <strong>"Start"</strong>
        </li>
        <li>Ubuntu Server Live CD powinien się uruchomić</li>
        <li>
          Wybierz język i opcję <strong>"Install Ubuntu Server"</strong>
        </li>
      </ol>
    </div>
  </section>

  <section class="card">
    <h2>Finalizacja instalacji</h2>
    <div class="step-content">
      <h3>Krok 13: Zakończenie instalacji</h3>
      <ol>
        <li>Wybierz <strong>"Reboot Now"</strong></li>
        <li>Poczekaj na ponowne uruchomienie</li>
        <li>Usuń ISO z napędu wirtualnego w ustawieniach maszyny</li>
      </ol>

      <h3>Krok 14: Pierwsze uruchomienie</h3>
      <ol>
        <li>Uruchom ponownie maszynę wirtualną</li>
        <li>Zaloguj się używając utworzonego konta</li>
        <li>
          Sprawdź połączenie internetowe:
          <code>ping -c 4 google.com</code>
        </li>
        <li>
          Zaktualizuj system:
          <code>sudo apt update && sudo apt upgrade -y</code>
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
    </div>
  </section>

  <section class="card">
    <h2>Rozwiązywanie problemów</h2>
    <div class="step-content">
      <h3>Typowe problemy:</h3>
      <h4>
        Problem: VirtualBox pokazuje błąd "VT-x/AMD-V is not available"
      </h4>
      <ul>
        <li>Sprawdź czy wirtualizacja jest włączona w BIOS/UEFI</li>
        <li>
          Wyłącz Hyper-V w Windows jeśli koliduje z VirtualBox
        </li>
      </ul>

      <h4>Problem: Brak połączenia internetowego</h4>
      <ul>
        <li>Sprawdź ustawienia sieci w VirtualBox (NAT)</li>
        <li>Sprawdź czy adapter jest włączony</li>
      </ul>
    </div>
  </section>
</main>



