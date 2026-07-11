/* ==========================================================================
   main.js — shared behaviour across every page
   --------------------------------------------------------------------------
   Responsibilities:
     • Header scroll state (translucent bar once you leave the hero)
     • Mobile navigation toggle
     • A tiny cart-count + "added to cart" toast (front-end placeholder only —
       WooCommerce's AJAX add-to-cart replaces this logic later)

   NOTE: This site deliberately uses no scroll-triggered animation library.
   The luxurious feel comes from restrained CSS: a soft page load-in, a slow
   ambient hero zoom, a sticky craftsmanship heading, and smooth hover
   transitions. All of that lives in the stylesheets — no JS needed — so the
   experience stays calm and never fights the user's scroll.
   ========================================================================== */

(function () {
  "use strict";

  /* ------------------------------------------------------------------
     Header: translucent bar once scrolled past the hero + mobile menu
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
     Boot
     ------------------------------------------------------------------ */
  document.addEventListener("DOMContentLoaded", () => {
    initHeader();
    initCart();
  });
})();
