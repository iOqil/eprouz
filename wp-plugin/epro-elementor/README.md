# EPRO Elementor Widgets

On-brand **Elementor widgets** that render the EPRO Tailwind design. Instead of
building a page builder from scratch, this leans on Elementor's mature editor
(drag-drop, responsive, undo/redo, history) and adds **content-first EPRO
widgets** — so pages stay perfectly on-brand and editors can't break the design.

## Why this approach
- Elementor's editor/canvas/responsive/undo come **for free**.
- Our widgets output the **exact EPRO Tailwind markup** (incl. `dark:` classes → dark mode works).
- **Content-first**: mostly text / repeater / media controls, so the design stays consistent.
- **Repeater + Media** controls solve the “unlimited items + Media-Library images” need (Features, Logos, Pricing).

## Widgets (v0.1) — under the **“EPRO”** category in the Elementor panel
| Widget | Controls |
|---|---|
| **EPRO Hero** | badge, title + gradient accent, subtitle, 2 buttons, note |
| **EPRO CTA** | title, subtitle, button (gradient banner) |
| **EPRO Button** | text, link, variant (primary/outline/ghost), size, align |
| **EPRO Features** | heading, columns, **repeater**: icon picker + title + description |
| **EPRO Logos** | heading, **repeater**: Media-Library image + name, grayscale toggle |
| **EPRO Pricing** | heading, **repeater**: name, price, period, featured, feature list, CTA |

## Requirements
- **Elementor (free)** installed & active. (No Pro needed for these widgets.)
- **EPRO — Classic** theme active (it loads Tailwind + dark mode). On other themes
  the plugin auto-loads Tailwind (CDN) + the brand config itself.

## Install
1. Install & activate **Elementor** (Plugins → Add New → search “Elementor”).
2. Upload this plugin (Plugins → Add New → Upload) → **Activate**.
3. Edit any page **with Elementor** → in the widget panel, open the **EPRO** category → drag in EPRO Hero / Features / Pricing / etc.
4. Fill content in the left panel; the canvas shows the live, on-brand result.

## Files
```
epro-elementor/
├── epro-elementor.php                 # bootstrap, Elementor guard, category, registration, Tailwind fallback
├── includes/
│   ├── class-base-widget.php          # base (category) + inline-SVG icon set + helpers
│   └── widgets/
│       ├── class-hero.php   class-cta.php   class-button.php
│       └── class-features.php  class-logos.php  class-pricing.php
└── README.md
```

## Roadmap
- More widgets: Stats, FAQ (accordion), Testimonials, Steps, Icon box, Section heading.
- Optional **style controls** (spacing/colors) where it won't break the brand.
- Register an Elementor **Kit** with EPRO global colors & fonts.
- (Elementor **Pro**) Theme Builder header/footer templates using EPRO widgets.
