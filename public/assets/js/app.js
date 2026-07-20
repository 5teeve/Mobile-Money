(function () {
  'use strict';

  // Palette de chips — doit rester identique à ui_helper::prefixPaletteIndex()
  // côté PHP (index.chip--0 à chip--4 dans tokens.css).
  function prefixPaletteIndex(prefixe) {
    var sum = 0;
    for (var i = 0; i < prefixe.length; i++) {
      sum += parseInt(prefixe.charAt(i), 10) || 0;
    }
    return sum % 5;
  }

  // --- Login : aperçu opérateur en direct pendant la saisie ------------
  function initPhoneLive() {
    var input = document.getElementById('numero_telephone');
    var live = document.getElementById('phone-live');
    if (!input || !live) return;

    var raw = document.getElementById('active-prefixes');
    var actifs = [];
    try { actifs = raw ? JSON.parse(raw.textContent) : []; } catch (e) { actifs = []; }

    function render() {
      var val = input.value.replace(/\s+/g, '');
      if (val.length < 3) {
        live.dataset.state = 'unknown';
        live.innerHTML = '';
        return;
      }
      var prefixe = val.slice(0, 3);
      var connu = actifs.indexOf(prefixe) !== -1;
      var idx = prefixPaletteIndex(prefixe);
      if (connu) {
        live.dataset.state = 'ok';
        live.innerHTML = '<span class="chip chip--' + idx + '">' + prefixe + '</span> Opérateur reconnu';
      } else {
        live.dataset.state = 'unknown';
        live.innerHTML = '<span class="chip chip--muted">' + prefixe + '</span> Préfixe non reconnu — vérifiez le numéro';
      }
    }

    input.addEventListener('input', render);
    render();
  }

  // --- Opérations : accès direct depuis le tableau de bord --------------
  // ?type=depot ou ?type=retrait met en évidence et fait défiler vers
  // la bonne section, puis place le focus sur le montant.
  function initDeepLink() {
    var params = new URLSearchParams(window.location.search);
    var type = params.get('type');
    if (type !== 'depot' && type !== 'retrait') return;

    var panel = document.getElementById(type + '-panel');
    if (!panel) return;

    panel.classList.add('is-target');
    panel.scrollIntoView({ behavior: 'smooth', block: 'center' });

    var field = panel.querySelector('input[name="montant"]');
    if (field) window.setTimeout(function () { field.focus(); }, 350);
  }

  document.addEventListener('DOMContentLoaded', function () {
    initPhoneLive();
    initDeepLink();
  });
})();
