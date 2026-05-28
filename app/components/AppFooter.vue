<script setup lang="ts">
const { t } = useI18n()
const localePath = useLocalePath()
const config = useRuntimeConfig()
const year = new Date().getFullYear()

const columns = computed(() => [
  {
    title: t('footer.product'),
    links: [
      { label: t('nav.features'), to: localePath('/features') },
      { label: t('nav.pricing'),  to: localePath('/pricing') },
      { label: t('nav.security'), to: localePath('/security') },
    ],
  },
  {
    title: t('footer.company'),
    links: [
      { label: t('nav.about'),   to: localePath('/about') },
      { label: t('nav.blog'),    to: localePath('/blog') },
      { label: t('nav.contact'), to: localePath('/contact') },
    ],
  },
  {
    title: t('footer.legal'),
    links: [
      { label: t('footer.terms'),   to: localePath('/terms') },
      { label: t('footer.privacy'), to: localePath('/privacy') },
      { label: t('footer.cookies'), to: localePath('/cookies') },
    ],
  },
])
</script>

<template>
  <footer class="border-t border-neutral-200 dark:border-neutral-800 bg-neutral-50 dark:bg-neutral-950 mt-auto">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-12">
      <div class="grid grid-cols-2 md:grid-cols-5 gap-8">
        <div class="col-span-2">
          <NuxtLink :to="localePath('/')" class="flex items-center gap-2 font-display font-bold text-xl">
            <div class="size-8 rounded-lg bg-gradient-to-br from-primary-500 to-primary-700 flex items-center justify-center text-white">
              E
            </div>
            <span class="text-neutral-900 dark:text-white">EPRO</span>
          </NuxtLink>
          <p class="mt-4 text-sm text-neutral-600 dark:text-neutral-400 max-w-sm">
            {{ t('footer.tagline') }}
          </p>
          <div class="mt-6 flex items-center gap-3">
            <UButton
              :to="`https://t.me/${config.public.telegramBot}`"
              external
              target="_blank"
              icon="i-simple-icons-telegram"
              color="neutral"
              variant="ghost"
              size="sm"
              square
              aria-label="Telegram"
            />
            <UButton
              to="https://github.com/iOqil"
              external
              target="_blank"
              icon="i-simple-icons-github"
              color="neutral"
              variant="ghost"
              size="sm"
              square
              aria-label="GitHub"
            />
            <UButton
              to="mailto:hello@epro.uz"
              icon="i-lucide-mail"
              color="neutral"
              variant="ghost"
              size="sm"
              square
              aria-label="Email"
            />
          </div>
        </div>

        <div v-for="col in columns" :key="col.title">
          <h3 class="text-sm font-semibold text-neutral-900 dark:text-white uppercase tracking-wide">
            {{ col.title }}
          </h3>
          <ul class="mt-4 space-y-3">
            <li v-for="link in col.links" :key="link.to">
              <NuxtLink
                :to="link.to"
                class="text-sm text-neutral-600 dark:text-neutral-400 hover:text-primary-600 dark:hover:text-primary-400 transition-colors"
              >
                {{ link.label }}
              </NuxtLink>
            </li>
          </ul>
        </div>
      </div>

      <div class="mt-12 pt-8 border-t border-neutral-200 dark:border-neutral-800 flex flex-col sm:flex-row justify-between items-center gap-4">
        <p class="text-sm text-neutral-500 dark:text-neutral-500">
          © {{ year }} EPRO. {{ t('footer.rights') }}
        </p>
        <p class="text-xs text-neutral-400 dark:text-neutral-600">
          {{ t('footer.madeIn') }} 🇺🇿
        </p>
      </div>
    </div>
  </footer>
</template>
