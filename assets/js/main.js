/* ==========================================================================
   main.js — shared behaviour across every page
   --------------------------------------------------------------------------
   Responsibilities:
     • Header scroll state + mobile navigation
     • Global GSAP + ScrollTrigger reveal animations ([data-reveal])
     • Hero parallax
     • A tiny cart-count + "added to cart" toast (front-end placeholder only —
       WooCommerce's AJAX add-to-cart replaces this logic later)
   All animation is progressive enhancement: if GSAP is unavailable, content
   is shown immediately (see the .reveal-ready fallback below).
   ========================================================================== */

(function () {
  "use strict";

  const prefersReducedMotion = window.matchMedia(
    "(prefers-reduced-motion: reduce)"
  ).matches;

  /* ------------------------------------------------------------------
     Header: toggle a scrolled state + mobile menu
     ------------------------------------------------------------------ */
  function initHeader() {
    const header = document.querySelector(".site-header");
    const toggle = document.querySelector(".nav-toggle");

    if (header) {
      const onScroll = () => {
        header.classList.toggle("is-scrolled", window.scrollY > 40);
      };
      onScroll();
      window.addEventListener("scroll", onScroll, { passive: true });
    }

    if (toggle) {
      toggle.addEventListener("click", () => {
        document.body.classList.toggle("nav-open");
        const expanded = document.body.classList.contains("nav-open");
        toggle.setAttribute("aria-expanded", String(expanded));
      });
      // Close the menu when a nav link is tapped.
      document.querySelectorAll(".site-nav__link").forEach((link) => {
        link.addEventListener("click", () => {
          document.body.classList.remove("nav-open");
          toggle.setAttribute("aria-expanded", "false");
        });
      });
    }
  }

  /* ------------------------------------------------------------------
     Cart placeholder — increments the header count + shows a toast.
     WOOCOMMERCE NOTE: replace with the wc-add-to-cart AJAX flow; the
     header count maps to the mini-cart fragment.
     ------------------------------------------------------------------ */
  function initCart() {
    const countEl = document.querySelector(".cart-count");
    let count = countEl ? parseInt(countEl.textContent, 10) || 0 : 0;

    const toast = document.querySelector(".toast");
    let toastTimer;

    function showToast(message) {
      if (!toast) return;
      toast.querySelector(".toast__message").textContent = message;
      toast.classList.add("is-visible");
      clearTimeout(toastTimer);
      toastTimer = setTimeout(() => toast.classList.remove("is-visible"), 2800);
    }

    // Any element flagged with [data-add-to-cart] acts as an add button.
    document.querySelectorAll("[data-add-to-cart]").forEach((btn) => {
      btn.addEventListener("click", (e) => {
        e.preventDefault();
        count += 1;
        if (countEl) countEl.textContent = String(count);
        const name = btn.getAttribute("data-product-name") || "Item";
        showToast(`${name} added to your bag`);
      });
    });
  }

  /* ------------------------------------------------------------------
     GSAP-powered reveals & parallax
     ------------------------------------------------------------------ */
  function initAnimations() {
    const hasGSAP = typeof window.gsap !== "undefined";

    // Fallback: reveal everything immediately if GSAP is missing or the
    // user prefers reduced motion.
    if (!hasGSAP || prefersReducedMotion) {
      document.documentElement.classList.add("reveal-ready");
      return;
    }

    gsap.registerPlugin(ScrollTrigger);

    /* Generic reveal: any [data-reveal] fades + slides up when it enters.
       Elements sharing a [data-reveal-group] stagger together. */
    const groups = new Map();
    document.querySelectorAll("[data-reveal]").forEach((el) => {
      const group = el.getAttribute("data-reveal-group");
      if (group) {
        if (!groups.has(group)) groups.set(group, []);
        groups.get(group).push(el);
      } else {
        gsap.to(el, {
          opacity: 1,
          y: 0,
          duration: 0.9,
          ease: "power3.out",
          scrollTrigger: { trigger: el, start: "top 85%" },
        });
      }
    });

    // Staggered groups (e.g. product-card grids).
    groups.forEach((els) => {
      gsap.to(els, {
        opacity: 1,
        y: 0,
        duration: 0.9,
        ease: "power3.out",
        stagger: 0.12,
        scrollTrigger: { trigger: els[0].parentElement, start: "top 80%" },
      });
    });

    /* Hero parallax — background drifts slower than the scroll. */
    const heroMedia = document.querySelector(".hero__media");
    if (heroMedia) {
      gsap.to(heroMedia, {
        yPercent: 18,
        ease: "none",
        scrollTrigger: {
          trigger: ".hero",
          start: "top top",
          end: "bottom top",
          scrub: true,
        },
      });
      // Hero copy fades & lifts slightly as you scroll away.
      gsap.to(".hero__content", {
        yPercent: -12,
        opacity: 0,
        ease: "none",
        scrollTrigger: {
          trigger: ".hero",
          start: "top top",
          end: "bottom top",
          scrub: true,
        },
      });
    }

    /* Pinned craftsmanship storytelling (homepage only). */
    initStoryPin();

    // Recalculate after fonts/images load so triggers use final positions.
    window.addEventListener("load", () => ScrollTrigger.refresh());
  }

  /* ------------------------------------------------------------------
     Pinned scroll storytelling: pin the section while panels cross-fade.
     ------------------------------------------------------------------ */
  function initStoryPin() {
    const pin = document.querySelector(".story__pin");
    const panels = gsap.utils.toArray(".story-panel");
    const markers = gsap.utils.toArray(".story__progress span");
    if (!pin || panels.length < 2) return;

    // Disable pinning on small screens — panels simply stack and reveal.
    if (window.innerWidth < 1024) {
      panels.forEach((p) => gsap.set(p, { position: "relative", opacity: 1, marginBottom: "3rem" }));
      return;
    }

    const tl = gsap.timeline({
      scrollTrigger: {
        trigger: ".story",
        start: "top top",
        end: () => "+=" + panels.length * 60 + "%",
        scrub: true,
        pin: pin,
        anticipatePin: 1,
      },
    });

    panels.forEach((panel, i) => {
      if (i === 0) {
        setActiveMarker(markers, 0);
        return;
      }
      tl.to(panels[i - 1], { opacity: 0, duration: 0.4 })
        .to(panel, { opacity: 1, duration: 0.4 }, "<")
        .add(() => setActiveMarker(markers, i));
    });
  }

  function setActiveMarker(markers, index) {
    markers.forEach((m, i) => m.classList.toggle("is-active", i === index));
  }

  /* ------------------------------------------------------------------
     Boot
     ------------------------------------------------------------------ */
  document.addEventListener("DOMContentLoaded", () => {
    initHeader();
    initCart();
    initAnimations();
  });
})();
