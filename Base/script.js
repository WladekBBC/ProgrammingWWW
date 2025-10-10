(function () {
  var toggle = document.querySelector('.nav-toggle');
  var nav = document.getElementById('site-nav');
  if (!toggle || !nav) return;

  function setExpanded(expanded) {
    toggle.setAttribute('aria-expanded', String(expanded));
    if (expanded) {
      nav.classList.add('open');
    } else {
      nav.classList.remove('open');
    }
  }

  toggle.addEventListener('click', function () {
    var isOpen = nav.classList.contains('open');
    setExpanded(!isOpen);
  });

  // Close nav on link click (mobile UX)
  nav.addEventListener('click', function (e) {
    var target = e.target;
    if (target && target.matches('[data-nav]')) {
      setExpanded(false);
    }
  });
})();


