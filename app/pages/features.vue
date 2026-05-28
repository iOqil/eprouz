<script setup lang="ts">
const { t } = useI18n()

useSeoMeta({
  title: () => t('seo.features.title'),
  description: () => t('seo.features.description'),
})

const sections = computed(() => [
  {
    icon: 'i-lucide-graduation-cap',
    key: 'lms',
    points: ['p1', 'p2', 'p3', 'p4'],
  },
  {
    icon: 'i-lucide-wallet',
    key: 'billing',
    points: ['p1', 'p2', 'p3', 'p4'],
  },
  {
    icon: 'i-lucide-users',
    key: 'tenants',
    points: ['p1', 'p2', 'p3'],
  },
  {
    icon: 'i-lucide-bar-chart-3',
    key: 'reports',
    points: ['p1', 'p2', 'p3'],
  },
  {
    icon: 'i-lucide-message-square',
    key: 'chat',
    points: ['p1', 'p2', 'p3'],
  },
  {
    icon: 'i-lucide-bell',
    key: 'telegram',
    points: ['p1', 'p2', 'p3'],
  },
])
</script>

<template>
  <div>
    <!-- Hero -->
    <section class="py-20 sm:py-28">
      <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8 text-center">
        <UBadge color="primary" variant="soft" size="lg" class="mb-6">
          {{ t('featuresPage.badge') }}
        </UBadge>
        <h1 class="font-display text-4xl sm:text-5xl font-bold text-neutral-900 dark:text-white">
          {{ t('featuresPage.title') }}
        </h1>
        <p class="mt-6 text-lg text-neutral-600 dark:text-neutral-400">
          {{ t('featuresPage.subtitle') }}
        </p>
      </div>
    </section>

    <!-- Feature sections -->
    <section class="pb-20">
      <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 space-y-24">
        <div
          v-for="(s, i) in sections"
          :key="s.key"
          class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center"
          :class="{ 'lg:flex-row-reverse': i % 2 === 1 }"
        >
          <div :class="{ 'lg:order-2': i % 2 === 1 }">
            <div class="size-14 rounded-xl bg-primary-100 dark:bg-primary-950 flex items-center justify-center text-primary-600 dark:text-primary-400">
              <UIcon :name="s.icon" class="size-7" />
            </div>
            <h2 class="mt-4 font-display text-3xl font-bold text-neutral-900 dark:text-white">
              {{ t(`featuresPage.${s.key}.title`) }}
            </h2>
            <p class="mt-4 text-lg text-neutral-600 dark:text-neutral-400">
              {{ t(`featuresPage.${s.key}.description`) }}
            </p>
            <ul class="mt-6 space-y-3">
              <li v-for="p in s.points" :key="p" class="flex items-start gap-3 text-neutral-700 dark:text-neutral-300">
                <UIcon name="i-lucide-check-circle-2" class="size-5 text-primary-600 dark:text-primary-400 flex-shrink-0 mt-0.5" />
                <span>{{ t(`featuresPage.${s.key}.${p}`) }}</span>
              </li>
            </ul>
          </div>
          <div :class="{ 'lg:order-1': i % 2 === 1 }" class="aspect-video rounded-2xl bg-gradient-to-br from-primary-100 to-purple-100 dark:from-primary-950 dark:to-purple-950 border border-neutral-200 dark:border-neutral-800 flex items-center justify-center">
            <UIcon :name="s.icon" class="size-32 text-primary-500/50" />
          </div>
        </div>
      </div>
    </section>

    <CtaBanner />
  </div>
</template>
