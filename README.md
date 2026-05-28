# EPRO Marketing Site — epro.uz

Marketing website for [EPRO](https://epro.uz) — a multi-tenant SaaS management platform for tutoring centers.

## Stack

- **Nuxt 4** — framework
- **@nuxt/ui v4** — components (Tailwind CSS v4)
- **@nuxt/content v3** — markdown blog
- **@nuxtjs/i18n** — uz/ru/en localization
- **@nuxtjs/seo** — sitemap, OG, robots, schema.org
- **@nuxt/image** — responsive image optimization

## Pages

| Route | Source |
|---|---|
| `/` | `app/pages/index.vue` — hero, features, pricing, CTA |
| `/features` | `app/pages/features.vue` — feature detail |
| `/pricing` | `app/pages/pricing.vue` — plans + FAQ |
| `/security` | `app/pages/security.vue` — security pillars |
| `/about` | `app/pages/about.vue` — company story |
| `/contact` | `app/pages/contact.vue` — lead form |
| `/blog` | `app/pages/blog/index.vue` — post list |
| `/blog/:slug` | `app/pages/blog/[...slug].vue` — post detail |

## Localization

3 locales: `uz` (default), `ru`, `en`. Files in `i18n/locales/`. Strategy: `prefix_except_default` — `/`, `/ru/`, `/en/`.

## Development

```bash
pnpm install
pnpm dev
# http://localhost:3000
```

## Production build

```bash
pnpm build       # SSR build
pnpm generate    # Static SSG build (recommended for marketing)
pnpm preview
```

## Adding a blog post

Create `content/blog/<slug>.md`:

```markdown
---
title: "Post title"
description: "Short description for SEO"
date: 2026-06-01
locale: uz
readTime: 5
tags: [news, product]
---

Content in markdown...
```

For Russian/English versions, create `content/blog/<slug>.ru.md` etc. with `locale: ru` in frontmatter.

## Environment variables

See `.env.example`:

| Var | Default | Description |
|---|---|---|
| `NUXT_PUBLIC_SITE_URL` | `https://epro.uz` | Canonical URL |
| `NUXT_PUBLIC_API_BASE` | `https://api.epro.uz` | Laravel API for lead form |
| `NUXT_PUBLIC_ADMIN_URL` | `https://admin.epro.uz` | Sign-in redirect |
| `NUXT_PUBLIC_TELEGRAM_BOT` | `EproSupportBot` | Telegram support bot username |

## Deployment

Deployed on Coolify with Docker. See `Dockerfile`. Domain: `epro.uz` (root). Wildcard tenant routes have lower priority so root domain wins.

## Lead form

Contact form POSTs to `${NUXT_PUBLIC_API_BASE}/api/v1/marketing/lead`. Backend (Laravel) should expose this endpoint to store leads + send Telegram notification.
