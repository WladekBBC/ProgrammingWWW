(function () {
  var sidebar = document.getElementById('sidebar');
  var mobileToggle = document.querySelector('.mobile-nav-toggle');
  var sidebarToggle = document.querySelector('.sidebar-toggle');
  
  if (!sidebar) return;

  function setSidebarExpanded(expanded) {
    if (mobileToggle) {
      mobileToggle.setAttribute('aria-expanded', String(expanded));
    }
    if (expanded) {
      sidebar.classList.add('open');
    } else {
      sidebar.classList.remove('open');
    }
  }

  if (mobileToggle) {
    mobileToggle.addEventListener('click', function () {
      var isOpen = sidebar.classList.contains('open');
      setSidebarExpanded(!isOpen);
    });
  }

  if (sidebarToggle) {
    sidebarToggle.addEventListener('click', function () {
      setSidebarExpanded(false);
    });
  }

  var navLinks = sidebar.querySelectorAll('[data-nav]');
  navLinks.forEach(function(link) {
    link.addEventListener('click', function () {
      setSidebarExpanded(false);
    });
  });


  document.addEventListener('click', function (e) {
    if (window.innerWidth <= 768) {
      var isClickInsideSidebar = sidebar.contains(e.target);
      var isClickOnMobileToggle = mobileToggle && mobileToggle.contains(e.target);
      
      if (!isClickInsideSidebar && !isClickOnMobileToggle && sidebar.classList.contains('open')) {
        setSidebarExpanded(false);
      }
    }
  });


  window.addEventListener('resize', function () {
    if (window.innerWidth >= 768) {
      setSidebarExpanded(false);
    }
  });
})();


(function() {
  var form = document.forms['fm'];
  if (!form) return;
  

  var dateFrom = document.getElementById('date-from');
  var dateTo = document.getElementById('date-to');
  
  if (dateFrom && dateTo) {

    var today = new Date();
    var minDate = new Date(2025, 10, 1);
    var maxDate = new Date(2100, 11, 31);
    
    dateFrom.setAttribute('min', minDate.toISOString().split('T')[0]);
    dateFrom.setAttribute('max', maxDate.toISOString().split('T')[0]);
    dateTo.setAttribute('min', minDate.toISOString().split('T')[0]);
    dateTo.setAttribute('max', maxDate.toISOString().split('T')[0]);
    
    function validateDateRange() {
      var fromDate = new Date(dateFrom.value);
      var toDate = new Date(dateTo.value);
      

      if (dateFrom.value) {
        if (fromDate < minDate || fromDate > maxDate) {
          dateFrom.setCustomValidity('Data musi być między 2025 a 2100 rokiem');
        } else {
          dateFrom.setCustomValidity('');
        }
      }

      if (dateTo.value) {
        if (toDate < fromDate || toDate > maxDate || toDate < minDate) {
          dateTo.setCustomValidity('Data musi być między 2025 a 2100 rokiem i późniejsza niż data początkowa');
        } else {
          dateTo.setCustomValidity('');
        } 
      }
    }
    
    dateFrom.addEventListener('change', validateDateRange);
    dateTo.addEventListener('change', validateDateRange);
  }
  
  form.addEventListener('submit', function(e) {
    if (!form.checkValidity()) {
      e.preventDefault();
      alert('Proszę wypełnić wszystkie wymagane pola poprawnie.');
      return false;
    }
  });
})();

(async function () {
  const clockNode = document.getElementById('live-clock');
  if (!clockNode) return;

  const formatter = new Intl.DateTimeFormat('pl-PL', {
    hour: '2-digit',
    minute: '2-digit',
    second: '2-digit',
    day: '2-digit',
    month: '2-digit',
    year: 'numeric'
  });

  function updateClock() {
    clockNode.textContent = formatter.format(new Date());
  }

  function startClock() {
    return new Promise((resolve) => {
      updateClock();
      const timerId = setInterval(updateClock, 1000);

      document.addEventListener('visibilitychange', () => {
        if (document.hidden) {
          clearInterval(timerId);
        } else {
          updateClock();
        }
      });

      resolve(timerId);
    });
  }

  await startClock();
})();


