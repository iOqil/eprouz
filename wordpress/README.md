# Headless WordPress — CMS backend for epro.uz

This folder configures the **WordPress instance that powers the epro.uz content**.
WordPress is used *headless*: editors manage content in `wp-admin`, and the Nuxt
site (`epro.uz`) reads it over **WPGraphQL**, server-to-server. The browser never
talks to WordPress directly.

- **Domain:** `cms.epro.uz` (WordPress admin + `/graphql` endpoint)
- **GraphQL endpoint:** `https://cms.epro.uz/graphql`
- **Public site:** `epro.uz` (the separate Nuxt app)

---

## 1. Deploy

On **Coolify**: New Resource → **Docker Compose** → paste [`docker-compose.yml`](./docker-compose.yml).
Set the FQDN to `cms.epro.uz` (mapped to the `wordpress` service, port `80`) and
add these environment variables:

| Variable | Notes |
|---|---|
| `WORDPRESS_DB_PASSWORD` | App DB user password |
| `MARIADB_ROOT_PASSWORD` | DB root password |
| `NUXT_REVALIDATE_SECRET` | **Must equal** the Nuxt app's `WP_REVALIDATE_SECRET` |

Deploy, open `https://cms.epro.uz`, and complete the famous 5‑minute WordPress install.

> Local test: `docker compose up -d` then open `http://localhost:8080`.

---

## 2. Install plugins

Plugins → Add New, install & activate **in this order**:

1. **WPGraphQL** — exposes `/graphql`.
2. **Advanced Custom Fields** (ACF) — structured fields (free edition is enough).
3. **Polylang** — multilingual (uz / ru / en).
4. **WPGraphQL for ACF** (`wp-graphql-acf`) — puts ACF fields into GraphQL.
5. **WPGraphQL Polylang** (`valu-digital/wp-graphql-polylang`) — adds the
   `language` filter (`LanguageCodeFilterEnum`) and `language { slug }` field.

---

## 3. Configure languages (Polylang)

Languages → add **Uzbek (uz)** as **default**, then **Russian (ru)** and **English (en)**.
The Nuxt side maps these to `UZ` / `RU` / `EN` automatically.

> A post and its translations may share a slug or differ — the Nuxt app always
> resolves a post by **(slug + language)**, so either is fine.

---

## 4. ACF: post reading time

The blog list/detail expects an ACF field group on posts, exposed in GraphQL as
`postMeta { readingTime }`.

ACF → Field Groups → **Add New**:
- **Title:** `Post Meta`
- **Field:** Label `Reading time`, Name `reading_time`, Type **Number**
- **Location:** Post Type **is equal to** Post
- **GraphQL** (in the group's settings, provided by wp-graphql-acf):
  - **Show in GraphQL:** ✅
  - **GraphQL Field Name:** `postMeta`
  - The field's GraphQL name should be `readingTime`

If you skip this, `readingTime` simply returns null and the UI hides the "min read" badge — nothing breaks.

---

## 5. WPGraphQL settings

GraphQL → Settings:
- Endpoint route: `graphql` (so the endpoint is `https://cms.epro.uz/graphql`).
- **Public introspection:** you may disable it in production (the Nuxt queries are fixed).
- No CORS config needed — all requests are server-to-server from Nitro.

Sanity check in GraphiQL (GraphQL → GraphiQL IDE):
```graphql
{ posts(where: { language: UZ, status: PUBLISH }) { nodes { slug title language { slug } } } }
```

---

## 6. Publish webhook → instant cache refresh

So content appears on the site within seconds of publishing (no rebuild), have
WordPress ping the Nuxt revalidate endpoint on publish/update.

Easiest: install **WP Webhooks** and add a webhook on "post published/updated"
to `https://epro.uz/api/revalidate` with header `x-webhook-secret: <NUXT_REVALIDATE_SECRET>`.

Or drop this must-use plugin at `wp-content/mu-plugins/revalidate.php`:

```php
<?php
// Ping the Nuxt site to purge its CMS cache whenever content changes.
add_action('transition_post_status', function ($new, $old, $post) {
  if (!in_array($post->post_type, ['post', 'page'], true)) return;
  if ($new !== 'publish' && $old !== 'publish') return; // publish or unpublish only

  $secret = getenv('NUXT_REVALIDATE_SECRET') ?: '';
  if (!$secret) return;

  wp_remote_post('https://epro.uz/api/revalidate', [
    'timeout'  => 5,
    'blocking' => false, // fire-and-forget; don't slow down the editor
    'headers'  => [
      'content-type'    => 'application/json',
      'x-webhook-secret' => $secret,
    ],
    'body' => wp_json_encode(['type' => $post->post_type, 'slug' => $post->post_name]),
  ]);
}, 10, 3);
```

A `200 { "revalidated": true }` response means it worked; `401` means the secret
doesn't match the Nuxt app's `WP_REVALIDATE_SECRET`.

---

## 7. Point the Nuxt app at WordPress

On the **epro.uz** Nuxt deployment (Coolify), set the runtime env vars:

```
NUXT_WP_GRAPHQL_ENDPOINT=https://cms.epro.uz/graphql
NUXT_WP_REVALIDATE_SECRET=<the same secret as NUXT_REVALIDATE_SECRET above>
```

---

## 8. Migrate the existing post

There is one seed post to recreate (it previously lived in `content/blog/salom-epro.md`):

- **Language:** Uzbek (uz)
- **Slug:** `salom-epro`
- **Title:** `Salom, EPRO!`
- **Published:** `2026-05-28`
- **Reading time (ACF):** `4`
- **Tags:** `yangiliklar`, `mahsulot`
- **Body:** paste the markdown content (convert to Gutenberg blocks or use the
  classic editor). The original file is in git history if needed.

Once published, it appears at `https://epro.uz/blog/salom-epro`.

> The Russian/English versions are created as Polylang translations of this post.

---

## What lives where

- **WordPress:** blog posts, and later (Phase 2/3) features, pricing, FAQ,
  testimonials, logos, team, and long page narrative — all via ACF + Polylang.
- **Nuxt i18n (`i18n/locales/*.json`):** pure UI chrome — nav labels, buttons,
  form errors, SEO title templates. These are the fallback if WordPress is down.
