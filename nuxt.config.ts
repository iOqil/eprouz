// https://nuxt.com/docs/api/configuration/nuxt-config
export default defineNuxtConfig({
  compatibilityDate: '2026-05-01',
  devtools: { enabled: true },

  modules: [
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
      routes: ['/', '/features', '/pricing', '/about', '/contact', '/security', '/blog'],
      crawlLinks: true,
      failOnError: false,
    },
    compressPublicAssets: true,
  },

  i18n: {
    defaultLocale: 'uz',
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
  },

  // OG / Twitter defaults
  ogImage: {
    enabled: true,
    fonts: ['Inter:400', 'Inter:700'],
  },

  // Sitemap
  sitemap: {
    sitemaps: true,
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
