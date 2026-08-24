# EPRO Marketing Site — epro.uz

Marketing website for [EPRO](https://epro.uz) — a multi-tenant SaaS management platform for tutoring centers.

## Stack

- **Nuxt 4** — framework
- **@nuxt/ui v4** — components (Tailwind CSS v4)
- **Headless WordPress** (WPGraphQL) — blog & CMS content (see [`wordpress/`](wordpress/README.md))
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

Blog content is managed in **headless WordPress** (no longer markdown). Create a
post in the WordPress admin (`cms.epro.uz`), set its language (Polylang) and the
`Reading time` ACF field, and publish. It appears on the site within seconds via
the `/api/revalidate` webhook — no rebuild required.

For Russian/English versions, use Polylang to create the translations of the post.

The Nuxt side fetches posts over WPGraphQL through cached server routes
(`server/api/cms/*`, `server/utils/wp-*`) and renders them SSR + SWR. See
[`wordpress/README.md`](wordpress/README.md) for the full CMS setup (plugins,
ACF fields, languages, webhook).

## Environment variables

See `.env.example`:

| Var | Default | Description |
|---|---|---|
| `NUXT_PUBLIC_SITE_URL` | `https://epro.uz` | Canonical URL |
| `NUXT_PUBLIC_API_BASE` | `https://api.epro.uz` | Laravel API for lead form |
| `NUXT_PUBLIC_ADMIN_URL` | `https://admin.epro.uz` | Sign-in redirect |
| `NUXT_PUBLIC_TELEGRAM_BOT` | `EproSupportBot` | Telegram support bot username |
| `NUXT_WP_GRAPHQL_ENDPOINT` | `https://cms.epro.uz/graphql` | Headless WordPress WPGraphQL endpoint (server-only) |
| `NUXT_WP_REVALIDATE_SECRET` | — | Shared secret for the WP publish webhook → `/api/revalidate` (server-only) |

## Deployment

Deployed on Coolify with Docker. See `Dockerfile`. Domain: `epro.uz` (root). Wildcard tenant routes have lower priority so root domain wins.

## Lead form

Contact form POSTs to `${NUXT_PUBLIC_API_BASE}/api/v1/marketing/lead`. Backend (Laravel) should expose this endpoint to store leads + send Telegram notification.
