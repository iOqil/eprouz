<script setup lang="ts">
const { t } = useI18n()

const features = computed(() => [
  { icon: 'i-lucide-graduation-cap', key: 'lms' },
  { icon: 'i-lucide-wallet',         key: 'billing' },
  { icon: 'i-lucide-users',          key: 'tenants' },
  { icon: 'i-lucide-bar-chart-3',    key: 'reports' },
  { icon: 'i-lucide-message-square', key: 'chat' },
  { icon: 'i-lucide-bell',           key: 'telegram' },
  { icon: 'i-lucide-smartphone',     key: 'mobile' },
  { icon: 'i-lucide-shield-check',   key: 'security' },
  { icon: 'i-lucide-globe',          key: 'i18n' },
])
</script>

<template>
  <section class="py-20 sm:py-28 bg-neutral-50/50 dark:bg-neutral-900/30 border-y border-neutral-200 dark:border-neutral-800">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
      <div class="text-center max-w-2xl mx-auto mb-16">
        <h2 class="font-display text-3xl sm:text-4xl font-bold text-neutral-900 dark:text-white">
          {{ t('features.title') }}
        </h2>
        <p class="mt-4 text-lg text-neutral-600 dark:text-neutral-400">
          {{ t('features.subtitle') }}
        </p>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <div
          v-for="f in features"
          :key="f.key"
          class="group p-6 rounded-xl bg-white dark:bg-neutral-950 border border-neutral-200 dark:border-neutral-800 hover:border-primary-300 dark:hover:border-primary-700 hover:shadow-lg transition-all"
        >
          <div class="size-12 rounded-lg bg-primary-100 dark:bg-primary-950 flex items-center justify-center text-primary-600 dark:text-primary-400 group-hover:scale-110 transition-transform">
            <UIcon :name="f.icon" class="size-6" />
          </div>
          <h3 class="mt-4 font-display font-semibold text-lg text-neutral-900 dark:text-white">
            {{ t(`features.${f.key}.title`) }}
          </h3>
          <p class="mt-2 text-sm text-neutral-600 dark:text-neutral-400 leading-relaxed">
            {{ t(`features.${f.key}.description`) }}
          </p>
        </div>
      </div>
    </div>
  </section>
</template>
