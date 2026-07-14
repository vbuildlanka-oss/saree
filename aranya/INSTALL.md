# Aranya WordPress Theme — Installation & Hostinger Guide

The static Aranya site (`index.html`, `shop.html`, `product.html`) has been
converted into a classic WordPress theme in this `aranya/` folder.

The theme works **immediately as a front-end showcase** (no plugins needed) and
is **WooCommerce-ready** for real e-commerce later.

---

## What's in the theme

| File | Purpose |
|------|---------|
| `style.css` | Theme header + WordPress helper styles |
| `functions.php` | Asset enqueuing, menus, WooCommerce support, helpers |
| `header.php` / `footer.php` | Shared site chrome |
| `front-page.php` | Homepage (was `index.html`) |
| `page-shop.php` | "Shop Collection" page template (was `shop.html`) |
| `page-product.php` | "Product Demo" page template (was `product.html`) |
| `index.php`, `page.php`, `single.php`, `404.php` | Standard WordPress templates |
| `woocommerce.php` | Wraps all WooCommerce pages in the theme layout |
| `template-parts/product-card.php` | Reusable product card |
| `inc/demo-products.php` | Demo product data for the front-end showcase |
| `assets/` | CSS, JS, images (migrated from the original site) |

---

## Run the front end on Hostinger WordPress — step by step

### 1. Get a WordPress site on Hostinger
- Log in to **hPanel** at Hostinger.
- If WordPress isn't installed yet: **Websites → Add website → WordPress**, then
  follow the setup wizard (site title, admin email, admin username/password).
- Wait for provisioning, then open **hPanel → WordPress → Dashboard → Edit website**
  to reach `wp-admin`.

### 2. Package the theme
- You need a ZIP whose **top-level folder is `aranya/`**.
- A prebuilt `aranya-theme.zip` is included at the repo root — use that, **or**
  zip the `aranya` folder yourself (make sure `style.css` sits inside
  `aranya/`, not at the zip root).

### 3. Upload & activate the theme
- In `wp-admin`: **Appearance → Themes → Add New → Upload Theme**.
- Choose `aranya-theme.zip` → **Install Now** → **Activate**.
- *(Alternative via File Manager/FTP: upload the `aranya` folder to
  `public_html/wp-content/themes/`, then activate under Appearance → Themes.)*

### 4. Create the pages
1. **Pages → Add New** → title **"Home"** → publish.
2. **Pages → Add New** → title **"Collection"** → in **Page Attributes → Template**
   choose **"Shop Collection"** → publish.
3. **Pages → Add New** → title **"Rani"** (or any product) → template
   **"Product Demo"** → publish.

### 5. Set the homepage
- **Settings → Reading → Your homepage displays → A static page**.
- Set **Homepage = Home**. Save.
- *(The theme's `front-page.php` renders the full homepage automatically.)*

### 6. Build the menu
- **Appearance → Menus → Create a new menu**.
- Add the Collection page and any custom links (Craft, Our Story, Journal can
  point to `#craft`, `#story`, `#journal` on the homepage).
- Under **Menu Settings**, tick **Primary Navigation** → **Save Menu**.
- *(If you skip this, the theme shows a sensible fallback menu.)*

### 7. Set logo & site identity (optional)
- **Appearance → Customize → Site Identity**: upload a logo (use
  `assets/img/logo-mark.png`), set the Site Title and Tagline.

### 8. Permalinks (recommended)
- **Settings → Permalinks → Post name → Save**. This gives clean URLs and
  prevents 404s on sub-pages.

Your front end is now live. 🎉

---

## Turning it into a real store (optional, later)
1. **Plugins → Add New →** install & activate **WooCommerce**.
2. Run the WooCommerce setup wizard (currency, payments, shipping).
3. **Products → Add New** to create real sarees (title, price, images, categories).
4. WooCommerce's shop/product/cart/checkout pages will automatically render
   inside the Aranya layout via `woocommerce.php`, styled by
   `assets/css/woocommerce.css`.
5. You can then retire the demo "Shop Collection" / "Product Demo" pages.

---

## Local testing (optional)
```bash
# From a full WordPress install:
cp -r aranya /path/to/wordpress/wp-content/themes/
# then activate under Appearance → Themes
```
