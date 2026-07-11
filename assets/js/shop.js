/* ==========================================================================
   shop.js — Collection/archive page interactions (front-end only)
   --------------------------------------------------------------------------
   Handles the demo category filter and price ordering purely on the client.
   In the WordPress theme these are replaced by WooCommerce's product_cat
   term archives and the catalog-ordering query var — this file would then be
   removed or reduced to progressive-enhancement niceties.
   ========================================================================== */

(function () {
  "use strict";

  const grid = document.querySelector(".products-grid--shop");
  if (!grid) return;

  const cards = Array.from(grid.querySelectorAll(".product-card"));
  const filterButtons = Array.from(document.querySelectorAll(".shop-filter"));
  const orderSelect = document.getElementById("orderby");
  const countEl = document.querySelector(".shop-toolbar__count");

  /* Parse the demo price (e.g. "₹ 48,000") into a number for sorting. */
  function priceOf(card) {
    const text = card.querySelector(".product-card__price").textContent;
    return parseInt(text.replace(/[^\d]/g, ""), 10) || 0;
  }

  function updateCount(visible) {
    if (countEl) countEl.textContent = `Showing ${visible} of ${cards.length} weaves`;
  }

  /* ---- Category filter ---- */
  function applyFilter(filter) {
    let visible = 0;
    cards.forEach((card) => {
      const cats = (card.getAttribute("data-category") || "").split(/\s+/);
      const show = filter === "all" || cats.includes(filter);
      card.style.display = show ? "" : "none";
      if (show) visible += 1;
    });
    updateCount(visible);
    // Positions changed — let ScrollTrigger recompute.
    if (window.ScrollTrigger) window.ScrollTrigger.refresh();
  }

  filterButtons.forEach((btn) => {
    btn.addEventListener("click", () => {
      filterButtons.forEach((b) => b.classList.remove("is-active"));
      btn.classList.add("is-active");
      applyFilter(btn.getAttribute("data-filter"));
    });
  });

  /* ---- Ordering ---- */
  function applyOrder(value) {
    const sorted = cards.slice();
    switch (value) {
      case "price":
        sorted.sort((a, b) => priceOf(a) - priceOf(b));
        break;
      case "price-desc":
        sorted.sort((a, b) => priceOf(b) - priceOf(a));
        break;
      default:
        // "menu_order" / "date" — restore original DOM order.
        sorted.sort(
          (a, b) => cards.indexOf(a) - cards.indexOf(b)
        );
    }
    sorted.forEach((card) => grid.appendChild(card));
    if (window.ScrollTrigger) window.ScrollTrigger.refresh();
  }

  if (orderSelect) {
    orderSelect.addEventListener("change", (e) => applyOrder(e.target.value));
  }
})();
