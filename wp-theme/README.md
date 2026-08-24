# EPRO — WordPress theme (`epro-classic`)

The EPRO marketing UI (the Nuxt/Tailwind design under `app/`) ported to a
**complete, production-quality classic PHP WordPress theme** with **full
Customizer support** — every section of the site is editable from
**Appearance → Customize** with live preview.

```
wp-theme/
├── preview.html        ← open in a browser to see the design (no WordPress needed)
└── epro-classic/       ← the theme
```

## 👀 Quick look (no install)

Open **`preview.html`** in any browser — a self-contained static render of the
front page. Try the dark-mode toggle (top-right) and the monthly/yearly pricing
switch.

---

## What's included (everything a complete theme needs)

### Pages & templates
- **Front page** — hero · logo cloud · features · pricing · CTA (all Customizer-driven, section toggles).
- **Page templates** (assign under *Page → Template*): **Biz haqimizda** (About), **Imkoniyatlar (batafsil)** (Features), **Xavfsizlik** (Security), **Tariflar** (Pricing + native `<details>` FAQ, reuses the editable pricing table), **Bog'lanish** (Contact, with a **working AJAX form**).
- **Blog**: `index.php`, `single.php` (breadcrumbs, reading-time, categories/tags, post navigation, comments), `archive.php`, `search.php`, `searchform.php`.
- **Standard WP**: `404.php`, `comments.php`, `page.php` — all styled to match.

### Dynamic content (managed from the admin)
- **Logotiplar** (Logos CPT) — *Add New* unlimited logos, each with a **Media-Library image** (Featured image); drag to reorder (Order field). Front-end shows the real images (grayscale → colour on hover); a text initial is used only if no image is set.
- **Imkoniyatlar** (Features CPT) — *Add New* unlimited feature cards; each has a title, description (editor), and an **icon picker**; reorderable.
- Both sections **fall back to demo content** until you add your own items, so the page never looks empty.

### Editing (Customizer — “EPRO sozlamalari”)
Brand colour (single picker regenerates the whole 50→950 ramp), header buttons, hero, section titles + show/hide toggles, 3 pricing plans, CTA, footer (editable phone/email/Telegram/GitHub), Site Identity + menu locations. Content sections preview via **selective refresh**.

### Widgets
Drag widgets into **Footer ustun 1/2/3** to override the default footer columns, or into the **Blog yon paneli** sidebar — all standard, dynamic widget areas.

### Working contact form
`inc/contact.php` — nonce-protected, honeypot-guarded AJAX handler that emails the site admin via `wp_mail`; vanilla-JS front-end (`assets/js/contact.js`) with inline success/error status. No plugin required.

### SEO / sharing
`inc/seo.php` — meta description + Open Graph + Twitter Card tags, auto-disabled if Yoast / Rank Math / AIOSEO is active.

### Editor & blocks (full Gutenberg support)
`theme.json` (v3) gives the block editor the EPRO palette, fonts and spacing controls; `assets/css/blocks.css` styles core blocks (buttons, quotes, tables, code, separators, embeds, cover…) identically in the **editor and the front-end**, with **`alignwide`/`alignfull`** break-out and dark-mode variants. `assets/css/editor.css` matches typography in the canvas. `align-wide` + `wp-block-styles` supported. Blog posts authored in Gutenberg render exactly as edited.

### Accessibility & i18n
Skip-link, `id="content"` landmark, `sr-only` labels, aria attributes, semantic headings. Fully **translation-ready** — `languages/epro-classic.pot` (181 strings, text domain `epro-classic`); works with Loco Translate / Polylang / WPML. Reading-time is Unicode-aware (Latin + Cyrillic).

### Branding
`screenshot.png` (theme browser preview), gradient brand mark, Inter + Manrope (Google Fonts), inline-SVG (lucide) icons — no icon-font dependency.

## Structure

```
epro-classic/
├── style.css  functions.php  theme.json  screenshot.png
├── inc/
│   ├── options.php          # defaults, epro_mod() reader, brand-colour palette generator
│   ├── customizer.php       # panels/controls + selective-refresh partials
│   ├── post-types.php       # Logos + Features CPTs, icon meta box, admin column
│   ├── template-tags.php    # breadcrumbs, reading-time, post meta/nav
│   ├── seo.php              # Open Graph / Twitter meta
│   └── contact.php          # AJAX contact-form handler + script enqueue
├── header.php  footer.php
├── front-page.php  index.php  single.php  page.php
├── archive.php  search.php  searchform.php  404.php  comments.php
├── page-templates/          # about · features · security · pricing · contact
├── template-parts/          # hero · logos · features · pricing · cta
├── languages/epro-classic.pot
└── assets/
    ├── css/  theme.css  editor.css  blocks.css
    └── js/   theme.js  customizer-preview.js  contact.js
```

## Install

1. Copy `epro-classic/` into `wp-content/themes/` of a WordPress 6.4+ site → **Activate**.
2. **Settings → Reading → A static page** → pick a homepage (`front-page.php` renders the full landing).
3. Create Pages for About/Features/Security/Pricing/Contact and assign each the matching **Template** (Page → Page Attributes → Template).
4. Add real content: **Imkoniyatlar → Add New** (feature cards) and **Logotiplar → Add New** (logos — set a Featured image). Reorder via the *Order* field.
5. **Appearance → Customize** for copy/colour/section titles & visibility; **Appearance → Widgets** for footer columns / blog sidebar; assign menus to **Asosiy menyu** / footer locations.

## Production note

Styling uses the **Tailwind Play CDN** (configured with the brand palette in `functions.php`) — ideal for getting going. For production, compile a stylesheet against the same config (`npx tailwindcss -i input.css -o assets/css/tailwind.css --minify`) and enqueue it instead of the CDN to drop the runtime notice and the network call.

> Context: the main epro.uz site is Nuxt + headless WordPress. This theme runs the marketing site **on WordPress directly** as an alternative — evaluate, then decide.
