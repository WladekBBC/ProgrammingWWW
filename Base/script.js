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

  // Mobile toggle functionality
  if (mobileToggle) {
    mobileToggle.addEventListener('click', function () {
      var isOpen = sidebar.classList.contains('open');
      setSidebarExpanded(!isOpen);
    });
  }

  // Sidebar close button functionality
  if (sidebarToggle) {
    sidebarToggle.addEventListener('click', function () {
      setSidebarExpanded(false);
    });
  }

  // Close sidebar on link click (mobile UX)
  var navLinks = sidebar.querySelectorAll('[data-nav]');
  navLinks.forEach(function(link) {
    link.addEventListener('click', function () {
      setSidebarExpanded(false);
    });
  });

  // Close sidebar when clicking outside on mobile
  document.addEventListener('click', function (e) {
    if (window.innerWidth <= 768) {
      var isClickInsideSidebar = sidebar.contains(e.target);
      var isClickOnMobileToggle = mobileToggle && mobileToggle.contains(e.target);
      
      if (!isClickInsideSidebar && !isClickOnMobileToggle && sidebar.classList.contains('open')) {
        setSidebarExpanded(false);
      }
    }
  });

  // Handle window resize
  window.addEventListener('resize', function () {
    if (window.innerWidth > 768) {
      setSidebarExpanded(false);
    }
  });
})();

// Form validation
(function() {
  var form = document.forms['fm'];
  if (!form) return;
  
  // Date range validation
  var dateFrom = document.getElementById('date-from');
  var dateTo = document.getElementById('date-to');
  
  if (dateFrom && dateTo) {
    // Set min and max dates
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
      
      // Validate date from
      if (dateFrom.value) {
        if (fromDate < minDate || fromDate > maxDate) {
          dateFrom.setCustomValidity('Data musi być między 2025 a 2100 rokiem');
        } else {
          dateFrom.setCustomValidity('');
        }
      }
      
      // Validate date to
      if (dateTo.value) {
        if (toDate < minDate || toDate > maxDate) {
          dateTo.setCustomValidity('Data musi być między 1900-01-01 a 2100-12-31');
        } else if (dateFrom.value && toDate < fromDate) {
          dateTo.setCustomValidity('Data końcowa musi być późniejsza niż data początkowa');
        } else {
          dateTo.setCustomValidity('');
        }
      }
    }
    
    dateFrom.addEventListener('change', validateDateRange);
    dateTo.addEventListener('change', validateDateRange);
  }
  
  // Form submit validation
  form.addEventListener('submit', function(e) {
    if (!form.checkValidity()) {
      e.preventDefault();
      alert('Proszę wypełnić wszystkie wymagane pola poprawnie.');
      return false;
    }
  });
})();


