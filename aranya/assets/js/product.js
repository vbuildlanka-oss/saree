/* ==========================================================================
   product.js — single-product interactions (front-end only)
   --------------------------------------------------------------------------
   • Gallery: thumbnail switching, hover-to-zoom (desktop), swipe (touch)
   • Variation selectors: swatches + pills update the visible "selected" label
   • Quantity stepper
   • Description accordions
   In the WordPress theme, gallery/variation behaviour is largely provided by
   WooCommerce (flexslider/photoswipe + variations.js). This file documents the
   intended UX and keeps the static mock interactive.
   ========================================================================== */

(function () {
  "use strict";

  /* ------------------------------------------------------------------
     Gallery
     ------------------------------------------------------------------ */
  function initGallery() {
    const gallery = document.querySelector("[data-gallery]");
    if (!gallery) return;

    const stage = gallery.querySelector("[data-gallery-stage]");
    const mainImg = gallery.querySelector("[data-gallery-main]");
    const thumbs = Array.from(gallery.querySelectorAll("[data-gallery-thumb]"));

    function setImage(src, activeThumb) {
      if (mainImg.getAttribute("src") === src) return;
      mainImg.style.opacity = "0";
      // Brief fade for a smooth swap.
      setTimeout(() => {
        mainImg.setAttribute("src", src);
        mainImg.style.opacity = "1";
      }, 180);
      thumbs.forEach((t) => {
        const isActive = t === activeThumb;
        t.classList.toggle("is-active", isActive);
        t.setAttribute("aria-selected", String(isActive));
      });
    }

    mainImg.style.transition = "opacity .18s ease";

    thumbs.forEach((thumb) => {
      thumb.addEventListener("click", () =>
        setImage(thumb.getAttribute("data-gallery-thumb"), thumb)
      );
    });

    /* ---- Hover-to-zoom (desktop / pointer with hover) ---- */
    const canHover = window.matchMedia("(hover: hover) and (pointer: fine)").matches;
    if (canHover && stage) {
      stage.addEventListener("mouseenter", () => stage.classList.add("is-zoomed"));
      stage.addEventListener("mouseleave", () => {
        stage.classList.remove("is-zoomed");
        mainImg.style.transformOrigin = "center center";
      });
      stage.addEventListener("mousemove", (e) => {
        const rect = stage.getBoundingClientRect();
        const x = ((e.clientX - rect.left) / rect.width) * 100;
        const y = ((e.clientY - rect.top) / rect.height) * 100;
        mainImg.style.transformOrigin = `${x}% ${y}%`;
      });
    }

    /* ---- Swipe between images (touch) ---- */
    let startX = null;
    stage.addEventListener("touchstart", (e) => { startX = e.touches[0].clientX; }, { passive: true });
    stage.addEventListener("touchend", (e) => {
      if (startX === null) return;
      const dx = e.changedTouches[0].clientX - startX;
      if (Math.abs(dx) < 40) { startX = null; return; }
      const currentIndex = thumbs.findIndex((t) => t.classList.contains("is-active"));
      let next = dx < 0 ? currentIndex + 1 : currentIndex - 1;
      next = (next + thumbs.length) % thumbs.length; // wrap
      setImage(thumbs[next].getAttribute("data-gallery-thumb"), thumbs[next]);
      startX = null;
    }, { passive: true });
  }

  /* ------------------------------------------------------------------
     Variation selectors — swatches & pills
     ------------------------------------------------------------------ */
  function initOptions() {
    document.querySelectorAll(".product-option").forEach((option) => {
      const label = option.querySelector("[data-selected]");
      const choices = Array.from(option.querySelectorAll("[data-value]"));

      choices.forEach((choice) => {
        choice.addEventListener("click", () => {
          choices.forEach((c) => {
            c.classList.remove("is-selected");
            c.setAttribute("aria-checked", "false");
          });
          choice.classList.add("is-selected");
          choice.setAttribute("aria-checked", "true");
          if (label) label.textContent = choice.getAttribute("data-value");
          // WOOCOMMERCE NOTE: here you'd trigger variation matching to update
          // price, availability and the gallery image.
        });
      });
    });
  }

  /* ------------------------------------------------------------------
     Quantity stepper
     ------------------------------------------------------------------ */
  function initQuantity() {
    const wrap = document.querySelector("[data-qty]");
    if (!wrap) return;
    const input = wrap.querySelector("input");
    const dec = wrap.querySelector("[data-qty-decrease]");
    const inc = wrap.querySelector("[data-qty-increase]");
    const clamp = (n) => Math.max(1, n || 1);

    dec.addEventListener("click", () => { input.value = clamp(parseInt(input.value, 10) - 1); });
    inc.addEventListener("click", () => { input.value = clamp(parseInt(input.value, 10) + 1); });
    input.addEventListener("change", () => { input.value = clamp(parseInt(input.value, 10)); });
  }

  /* ------------------------------------------------------------------
     Accordions
     ------------------------------------------------------------------ */
  function initAccordion() {
    const root = document.querySelector("[data-accordion]");
    if (!root) return;
    const items = Array.from(root.querySelectorAll(".accordion-item"));

    function setOpen(item, open) {
      const panel = item.querySelector(".accordion-panel");
      const trigger = item.querySelector(".accordion-trigger");
      item.classList.toggle("is-open", open);
      trigger.setAttribute("aria-expanded", String(open));
      panel.style.maxHeight = open ? panel.scrollHeight + "px" : "0px";
    }

    items.forEach((item) => {
      const trigger = item.querySelector(".accordion-trigger");
      // Initialise open state (first item starts open).
      setOpen(item, item.classList.contains("is-open"));
      trigger.addEventListener("click", () => {
        const willOpen = !item.classList.contains("is-open");
        // Accordion behaviour: close others.
        items.forEach((other) => setOpen(other, false));
        setOpen(item, willOpen);
      });
    });

    // Recalculate the open panel height on resize (content reflow).
    window.addEventListener("resize", () => {
      const open = root.querySelector(".accordion-item.is-open");
      if (open) setOpen(open, true);
    });
  }

  document.addEventListener("DOMContentLoaded", () => {
    initGallery();
    initOptions();
    initQuantity();
    initAccordion();
  });
})();
