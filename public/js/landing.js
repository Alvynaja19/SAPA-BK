/**
 * SAPA BK - Frontend Landing Page Interactivity
 * SMA Negeri 4 Jember
 */

document.addEventListener('DOMContentLoaded', () => {
  const isReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

  // 1. Mobile Navigation Toggle
  const navToggle = document.getElementById('navToggle');
  const navLinks = document.getElementById('navLinks');

  if (navToggle && navLinks) {
    navToggle.addEventListener('click', () => {
      const isOpen = navLinks.classList.toggle('open');
      navToggle.setAttribute('aria-expanded', String(isOpen));
    });

    // Close nav menu when clicking any navigation link
    navLinks.querySelectorAll('a').forEach(link => {
      link.addEventListener('click', () => {
        if (navLinks.classList.contains('open')) {
          navLinks.classList.remove('open');
          navToggle.setAttribute('aria-expanded', 'false');
        }
      });
    });
  }

  // 2. Chatbot Consultation Widget Toggle
  const fabBtn = document.getElementById('fabBtn');
  const widgetPanel = document.getElementById('widgetPanel');
  const closeWidgetBtn = document.getElementById('closeWidgetBtn');

  function toggleWidget(forceState) {
    if (!widgetPanel || !fabBtn) return;
    const willOpen = typeof forceState === 'boolean' ? forceState : !widgetPanel.classList.contains('open');
    widgetPanel.classList.toggle('open', willOpen);
    fabBtn.setAttribute('aria-expanded', String(willOpen));

    if (willOpen) {
      const widgetInput = widgetPanel.querySelector('input[type="text"]');
      if (widgetInput) {
        setTimeout(() => widgetInput.focus(), 150);
      }
    }
  }

  if (fabBtn) {
    fabBtn.addEventListener('click', () => toggleWidget());
  }

  if (closeWidgetBtn) {
    closeWidgetBtn.addEventListener('click', () => toggleWidget(false));
  }

  // Close widget when pressing Escape key
  document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape' && widgetPanel && widgetPanel.classList.contains('open')) {
      toggleWidget(false);
      fabBtn?.focus();
    }
  });

  // CTA button in Hero to trigger widget/chat
  const openWidgetFromHero = document.getElementById('openWidgetFromHero');
  if (openWidgetFromHero) {
    openWidgetFromHero.addEventListener('click', (e) => {
      // If user clicks, open widget and smooth scroll
      e.preventDefault();
      toggleWidget(true);
      widgetPanel?.scrollIntoView({ behavior: 'smooth', block: 'end' });
    });
  }

  // 3. Hero Card Tilt Interaction (Desktop only, respects reduced-motion)
  if (!isReducedMotion) {
    const chatWrap = document.querySelector('.chat-mock-wrap');
    const chatCard = document.querySelector('.chat-mock');

    if (chatWrap && chatCard && window.innerWidth >= 900) {
      chatWrap.addEventListener('mousemove', (e) => {
        const rect = chatWrap.getBoundingClientRect();
        const px = (e.clientX - rect.left) / rect.width - 0.5;
        const py = (e.clientY - rect.top) / rect.height - 0.5;
        chatCard.style.transform = `rotateX(${(-py * 6).toFixed(2)}deg) rotateY(${(px * 8).toFixed(2)}deg) translateZ(4px)`;
      });

      chatWrap.addEventListener('mouseleave', () => {
        chatCard.style.transform = 'rotateX(0deg) rotateY(0deg) translateZ(0px)';
      });
    }
  }

  // 4. Hero Consultation Interactive Form Handler
  const heroChatForm = document.getElementById('heroChatForm');
  if (heroChatForm) {
    heroChatForm.addEventListener('submit', (e) => {
      const input = heroChatForm.querySelector('input[name="initial_query"], input[name="q"]');
      if (input && !input.value.trim()) {
        e.preventDefault();
        input.focus();
      }
    });
  }
});
