/* ============================================
   Управління бічною панеллю / Sidebar Management
   ============================================
   Цей модуль відповідає за відкриття/закриття бічної панелі
   на мобільних пристроях та обробку взаємодій користувача.
   
   This module handles opening/closing the sidebar on mobile
   devices and user interactions.
   ============================================ */
(function () {
  // Отримуємо елементи DOM / Get DOM elements
  var sidebar = document.getElementById('sidebar');              /* Бічна панель / Sidebar */
  var mobileToggle = document.querySelector('.mobile-nav-toggle'); /* Кнопка мобільної навігації / Mobile nav button */
  var sidebarToggle = document.querySelector('.sidebar-toggle');   /* Кнопка закриття бічної панелі / Sidebar close button */
  
  // Перевірка наявності бічної панелі / Check if sidebar exists
  if (!sidebar) return;

  /* ============================================
     Функція для встановлення стану бічної панелі
     Function to set sidebar expanded state
     ============================================ */
  function setSidebarExpanded(expanded) {
    // Встановлюємо атрибут aria-expanded для доступності / Set aria-expanded for accessibility
    if (mobileToggle) {
      mobileToggle.setAttribute('aria-expanded', String(expanded));
    }
    // Додаємо/видаляємо клас 'open' для показу/приховування / Add/remove 'open' class to show/hide
    if (expanded) {
      sidebar.classList.add('open');
    } else {
      sidebar.classList.remove('open');
    }
  }

  /* ============================================
     Обробник кліку на кнопку мобільної навігації
     Mobile navigation toggle click handler
     ============================================ */
  if (mobileToggle) {
    mobileToggle.addEventListener('click', function () {
      var isOpen = sidebar.classList.contains('open');
      setSidebarExpanded(!isOpen);  /* Перемикаємо стан / Toggle state */
    });
  }

  /* ============================================
     Обробник кліку на кнопку закриття бічної панелі
     Sidebar close button click handler
     ============================================ */
  if (sidebarToggle) {
    sidebarToggle.addEventListener('click', function () {
      setSidebarExpanded(false);  /* Закриваємо бічну панель / Close sidebar */
    });
  }

  /* ============================================
     Закриття бічної панелі при кліку на посилання навігації
     Close sidebar when clicking navigation links
     ============================================ */
  var navLinks = sidebar.querySelectorAll('[data-nav]');
  navLinks.forEach(function(link) {
    link.addEventListener('click', function () {
      setSidebarExpanded(false);  /* Закриваємо після переходу / Close after navigation */
    });
  });

  /* ============================================
     Закриття бічної панелі при кліку поза нею (на мобільних)
     Close sidebar when clicking outside (on mobile)
     ============================================ */
  document.addEventListener('click', function (e) {
    // Перевіряємо тільки на мобільних пристроях / Check only on mobile devices
    if (window.innerWidth <= 768) {
      var isClickInsideSidebar = sidebar.contains(e.target);
      var isClickOnMobileToggle = mobileToggle && mobileToggle.contains(e.target);
      
      // Якщо клік поза бічною панеллю і вона відкрита - закриваємо / If click outside sidebar and it's open - close it
      if (!isClickInsideSidebar && !isClickOnMobileToggle && sidebar.classList.contains('open')) {
        setSidebarExpanded(false);
      }
    }
  });

  /* ============================================
     Автоматичне закриття бічної панелі при зміні розміру екрану
     Auto-close sidebar on window resize
     ============================================ */
  window.addEventListener('resize', function () {
    // На великих екранах завжди закриваємо / On large screens always close
    if (window.innerWidth >= 768) {
      setSidebarExpanded(false);
    }
  });
})();

/* ============================================
   Валідація форми / Form Validation
   ============================================
   Модуль для валідації дат у формі та перевірки
   коректності заповнення всіх полів.
   
   Module for validating dates in form and checking
   that all required fields are filled correctly.
   ============================================ */
(function() {
  // Отримуємо форму за ім'ям / Get form by name
  var form = document.forms['fm'];
  if (!form) return;
  

  // Отримуємо поля дат / Get date fields
  var dateFrom = document.getElementById('date-from');  /* Дата початку / Start date */
    var dateTo = document.getElementById('date-to');      /* Дата кінця / End date */
    
    if (dateFrom && dateTo) {
      // Встановлюємо мінімальну та максимальну дати / Set minimum and maximum dates
      var today = new Date();
      var minDate = new Date(2025, 10, 1);      /* Мінімальна дата: 1 листопада 2025 / Min date: Nov 1, 2025 */
      var maxDate = new Date(2100, 11, 31);     /* Максимальна дата: 31 грудня 2100 / Max date: Dec 31, 2100 */
      
      // Встановлюємо обмеження для полів дат / Set constraints for date fields
      dateFrom.setAttribute('min', minDate.toISOString().split('T')[0]);
      dateFrom.setAttribute('max', maxDate.toISOString().split('T')[0]);
      dateTo.setAttribute('min', minDate.toISOString().split('T')[0]);
      dateTo.setAttribute('max', maxDate.toISOString().split('T')[0]);
      
      /* ============================================
        Функція валідації діапазону дат
        Date range validation function
        ============================================ */
      function validateDateRange() {
        var fromDate = new Date(dateFrom.value);
        var toDate = new Date(dateTo.value);
        

        // Валідація дати початку / Start date validation
        if (dateFrom.value) {
          if (fromDate < minDate || fromDate > maxDate) {
            dateFrom.setCustomValidity('Data musi być między 2025 a 2100 rokiem');
          } else {
            dateFrom.setCustomValidity('');
          }
        }

        // Валідація дати кінця / End date validation
        if (dateTo.value) {
          // Перевіряємо, що дата кінця пізніша за дату початку / Check that end date is after start date
          if (toDate < fromDate || toDate > maxDate || toDate < minDate) {
          dateTo.setCustomValidity('Data musi być między 2025 a 2100 rokiem i późniejsza niż data początkowa');
        } else {
          dateTo.setCustomValidity('');
        } 
      }
    }
    
    // Додаємо обробники подій для валідації / Add event handlers for validation
    dateFrom.addEventListener('change', validateDateRange);
    dateTo.addEventListener('change', validateDateRange);
  }
  
  /* ============================================
     Обробка відправки форми
     Form submit handler
     ============================================ */
  form.addEventListener('submit', function(e) {
    // Перевіряємо валідність форми перед відправкою / Check form validity before submit
    if (!form.checkValidity()) {
      e.preventDefault();  /* Блокуємо стандартну відправку / Prevent default submit */
      alert('Proszę wypełnić wszystkie wymagane pola poprawnie.');
      return false;
    }
  });
})();

/* ============================================
   Живий годинник / Live Clock
   ============================================
   Відображає поточну дату та час у форматі польської локалі
   з оновленням кожну секунду. Призупиняє оновлення,
   коли сторінка прихована для оптимізації.
   
   Displays current date and time in Polish locale format
   with updates every second. Pauses updates when page
   is hidden for optimization.
   ============================================ */
(async function () {
  // Отримуємо елемент для відображення годинника / Get clock display element
  const clockNode = document.getElementById('live-clock');
  if (!clockNode) return;

  // Форматер для польської локалі / Formatter for Polish locale
  const formatter = new Intl.DateTimeFormat('pl-PL', {
    hour: '2-digit',      /* Година / Hour */
    minute: '2-digit',    /* Хвилина / Minute */
    second: '2-digit',    /* Секунда / Second */
    day: '2-digit',       /* День / Day */
    month: '2-digit',     /* Місяць / Month */
    year: 'numeric'       /* Рік / Year */
  });

  /* ============================================
     Функція оновлення годинника
     Clock update function
     ============================================ */
  function updateClock() {
    clockNode.textContent = formatter.format(new Date());  /* Форматуємо поточну дату/час / Format current date/time */
  }

  /* ============================================
     Функція запуску годинника
     Clock start function
     ============================================ */
  function startClock() {
    return new Promise((resolve) => {
      updateClock();  /* Оновлюємо одразу / Update immediately */
      const timerId = setInterval(updateClock, 1000);  /* Оновлюємо кожну секунду / Update every second */

      // Оптимізація: призупиняємо оновлення, коли сторінка прихована / Optimization: pause updates when page hidden
      document.addEventListener('visibilitychange', () => {
        if (document.hidden) {
          clearInterval(timerId);  /* Зупиняємо таймер / Stop timer */
        } else {
          updateClock();  /* Оновлюємо при поверненні / Update when returning */
        }
      });

      resolve(timerId);
    });
  }

  // Запускаємо годинник / Start clock
  await startClock();
})();


