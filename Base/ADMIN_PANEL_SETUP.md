# Panel Administratora - Instrukcja Instalacji

## Kroki konfiguracji:

### 1. Aktualizacja bazy danych

Uruchom następujące komendy SQL w PhpMyAdmin lub MySQL CLI:

```sql
-- Dodaj kolumnę roli do istniejącej tabeli
ALTER TABLE users ADD COLUMN role VARCHAR(50) DEFAULT 'user';

-- Lub jeśli tworzysz nową tabelę:
CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  email VARCHAR(255) UNIQUE NOT NULL,
  password_hash VARCHAR(255) NOT NULL,
  role VARCHAR(50) DEFAULT 'user',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tablica do śledzenia odwiedzin
CREATE TABLE page_visits (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT,
  page VARCHAR(255) NOT NULL,
  ip_address VARCHAR(45),
  user_agent TEXT,
  visited_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL,
  KEY (visited_at),
  KEY (user_id),
  KEY (page)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
```

### 2. Utwórz konto administratora

Zarejestruj się normalnie jako użytkownik, a następnie uruchom w PhpMyAdmin:

```sql
UPDATE users SET role = 'admin' WHERE email = 'twoj-email@example.com';
```

### 3. Dostęp do panelu

- Zaloguj się na konto z rolą `admin`
- W menu bocznym pojawi się link "⚙️ Panel Admina"
- Możesz zarządzać użytkownikami, notatkami i przeglądać statystyki

## Funkcje panelu administratora:

### 👤 Zarządzanie użytkownikami

✅ **Zmiana roli użytkownika** - Przydzielaj role user/admin
✅ **Usuwanie użytkowników** - Usuń niepotrzebne konta
✅ **Bezpieczeństwo** - Admin nie może usunąć siebie

### 📝 Zarządzanie notatkami

✅ **Przeglądanie notatek** - Zobacz wszystkie notatki w systemie
✅ **Usuwanie notatek** - Usuń problematyczne notatki
✅ **Informacje o autorach** - Zobacz kto napisał notatkę

### 📊 Statystyki odwiedzin

✅ **Licznik odwiedzin** - Łącznie, dzisiaj, ten tydzień, ten miesiąc
✅ **Unikalni wizyty** - Liczba unikalnych odwiedzających dzisiaj
✅ **Najpopularniejsze strony** - Ranking stron z procentem
✅ **Najaktywniejsi użytkownicy** - Top 10 użytkowników
✅ **Ostatnie odwiedziny** - 15 ostatnich odwiedzin z IP

## Pliki zmienione:

- `includes/auth.php` - Funkcje zarządzania rolami
- `includes/visits.php` - Nowe funkcje śledzenia odwiedzin
- `includes/header.php` - Link do panelu dla adminów
- `pages/admin.php` - Rozszerzony panel administratora
- `style/style.css` - Style dla tabel, statystyk i pasków postępu
- `index.php` - Logowanie odwiedzin

## Rola użytkownika:

- **user** - Standardowy użytkownik
- **admin** - Administrator z dostępem do panelu

---

**Uwaga:** Panel administratora jest chroniony - dostęp mają tylko użytkownicy z rolą `admin`.
Wszystkie odwiedziny są automatycznie rejestrowane w bazie danych.
