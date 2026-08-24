// https://nuxt.com/docs/api/configuration/nuxt-config
export default defineNuxtConfig({
  compatibilityDate: '2026-05-01',
  devtools: { enabled: true },

  modules: [
    '@nuxt/eslint',
    '@nuxt/ui',
    '@nuxt/content',
    '@nuxt/image',
    '@nuxtjs/i18n',
    '@nuxtjs/seo',
    '@vueuse/nuxt',
  ],

  css: ['~/assets/css/main.css'],

  // Site metadata for @nuxtjs/seo
  site: {
    url: 'https://epro.uz',
    name: 'EPRO',
    description: "O'quv markazlar uchun zamonaviy SaaS boshqaruv tizimi",
    defaultLocale: 'uz',
    indexable: true,
  },

  // Static generation for marketing site (faster, cheaper)
  nitro: {
    prerender: {
      // Marketing pages stay static. Blog is now SSR + SWR (sourced from WordPress),
      // so it is excluded here to keep the build free of any WP dependency.
      routes: ['/', '/features', '/pricing', '/about', '/contact', '/security'],
      crawlLinks: true,
      ignore: [/^\/(?:ru\/|en\/)?blog(?:\/|$)/],
      failOnError: false,
    },
    // Near-instant content updates without a full rebuild: serve cached HTML/JSON
    // and revalidate in the background. Invalidated on publish via /api/revalidate.
    routeRules: {
      '/api/cms/**': { cache: { swr: true, maxAge: 300 } },
      '/blog': { swr: 300 },
      '/blog/**': { swr: 300 },
      '/ru/blog': { swr: 300 },
      '/ru/blog/**': { swr: 300 },
      '/en/blog': { swr: 300 },
      '/en/blog/**': { swr: 300 },
    },
    compressPublicAssets: true,
  },

  i18n: {
    defaultLocale: 'uz',
    lazy: false,
    langDir: 'locales', 
    locales: [
      { code: 'uz', language: 'uz-UZ', name: "O'zbekcha", file: 'uz.json' },
      { code: 'ru', language: 'ru-RU', name: 'Русский', file: 'ru.json' },
      { code: 'en', language: 'en-US', name: 'English', file: 'en.json' },
    ],
    strategy: 'prefix_except_default',
    detectBrowserLanguage: {
      useCookie: true,
      cookieKey: 'i18n_locale',
      redirectOn: 'root',
    },
  },

  content: {
    build: {
      markdown: {
        highlight: {
          theme: { default: 'github-light', dark: 'github-dark' },
        },
      },
    },
    renderer: {
      anchorLinks: { h2: true, h3: true },
    },
  },

  image: {
    formats: ['avif', 'webp'],
    quality: 80,
    // Allow @nuxt/image to optimize media served from the headless WordPress host
    domains: ['cms.epro.uz'],
  },

  // OG / Twitter defaults
  ogImage: {
    enabled: true,
    fonts: ['Inter:400', 'Inter:700'],
  },

  // Sitemap
  sitemap: {
    sitemaps: true,
    // Dynamic blog URLs (all locales) sourced from WordPress at runtime
    sources: ['/api/__sitemap__/urls'],
  },

  // Robots
  robots: {
    groups: [
      { userAgent: '*', allow: '/', disallow: ['/admin', '/api'] },
    ],
  },

  app: {
    head: {
      htmlAttrs: { lang: 'uz' },
      meta: [
        { name: 'theme-color', content: '#6366f1', media: '(prefers-color-scheme: light)' },
        { name: 'theme-color', content: '#0b0d12', media: '(prefers-color-scheme: dark)' },
      ],
      link: [
        { rel: 'icon', type: 'image/svg+xml', href: '/favicon.svg' },
        { rel: 'apple-touch-icon', href: '/icons/apple-touch-icon.png' },
      ],
    },
  },

  runtimeConfig: {
    // Server-only (never exposed to the client). Override at runtime on Coolify
    // via NUXT_WP_GRAPHQL_ENDPOINT / NUXT_WP_REVALIDATE_SECRET / NUXT_WP_PREVIEW_TOKEN.
    wpGraphqlEndpoint: process.env.WP_GRAPHQL_ENDPOINT || 'https://cms.epro.uz/graphql',
    wpRevalidateSecret: process.env.WP_REVALIDATE_SECRET || '',
    wpPreviewToken: process.env.WP_PREVIEW_TOKEN || '',
    public: {
      siteUrl: process.env.NUXT_PUBLIC_SITE_URL || 'https://epro.uz',
      apiBase: process.env.NUXT_PUBLIC_API_BASE || 'https://api.epro.uz',
      adminUrl: process.env.NUXT_PUBLIC_ADMIN_URL || 'https://admin.epro.uz',
      telegramBot: process.env.NUXT_PUBLIC_TELEGRAM_BOT || 'EproSupportBot',
    },
  },

  future: {
    compatibilityVersion: 4,
  },
})
