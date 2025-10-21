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


