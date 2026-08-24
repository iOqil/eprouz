# EPRO Builder

A full-screen, Elementor-style visual page builder for WordPress, built to pair
with the **EPRO — Classic** theme. Model: **Section → Column → Widget**, stored
as JSON in post meta and rendered to Tailwind HTML on the front-end.

> **Status: v0.1 (foundation).** This is the working skeleton — real, installable,
> end-to-end (edit → save → render). It is **not** the finished Elementor clone;
> see the roadmap.

## What works now (v0.1)
- **Full-screen editor** at `wp-admin/admin.php?page=epro-builder&post=<ID>` (WP admin chrome hidden).
- Open it from the **“EPRO Builder”** meta box on any Page/Post, or the **EPRO Builder** row action in the Pages list.
- **Widgets:** Heading, Text, Button, Image (Media Library), Spacer, Divider, + **presets** Hero & CTA.
- Add widgets/sections, **select & edit** settings (right panel), **reorder** (↑/↓), **delete**.
- **Section settings:** background (white / grey / dark / gradient), padding, boxed/full width.
- **Save** → writes JSON to post meta + enables the builder for that page.
- **Live preview** iframe with desktop / tablet / mobile widths (refreshes on save).
- Front-end renders the layout (full width, inside the theme header/footer) with the EPRO Tailwind design + dark-mode support.
- Secure: REST endpoints are capability- + nonce-checked; the whole tree is sanitized server-side (type-whitelisted) on save.

## Architecture
```
epro-builder/
├── epro-builder.php                 # bootstrap
├── includes/
│   ├── class-epro-builder-data.php      # meta storage + recursive sanitizer
│   ├── class-epro-builder-renderer.php  # tree → Tailwind HTML
│   ├── class-epro-builder-rest.php      # GET/POST /epro-builder/v1/layout/<id>
│   └── class-epro-builder-editor.php    # full-screen route, enqueue, entry points, front-end render
├── templates/canvas.php             # front-end builder template (header → render → footer)
└── assets/
    ├── js/app.js                    # editor app (build-free: wp.element + wp.components)
    └── css/editor.css               # full-screen UI
```
- **No build step.** The editor uses WordPress's bundled React (`wp.element`), UI controls (`wp.components`), `wp.apiFetch`, `wp.i18n` — ship & run as-is.

## Install
1. Copy `epro-builder/` into `wp-content/plugins/` (or upload the zip via **Plugins → Add New → Upload**).
2. **Plugins → Activate** “EPRO Builder”.
3. Edit a Page → in the **EPRO Builder** box (right) click **“✎ EPRO Builder bilan tahrirlash”**.
4. Add sections/widgets → **Saqlash**. The page now renders with the builder.
5. To go back to the normal editor: in the builder top bar click **“O‘chirish”**.

Requires the **EPRO — Classic** theme active (it loads Tailwind + dark mode that the rendered sections rely on).

## Roadmap
- **Phase 2:** in-canvas **drag-and-drop** (free-form), multi-column layouts, column resize, more widgets (icon, list, video, columns, accordion, tabs), copy/paste.
- **Phase 3:** style controls (color/typography/spacing per widget), responsive per-property, undo/redo & history, template/section library, global colors & fonts, live (no-reload) canvas editing.
