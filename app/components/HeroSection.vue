<script setup lang="ts">
const { t } = useI18n()
const localePath = useLocalePath()

const stats = computed(() => [
  { value: '23+', label: t('hero.statsModules') },
  { value: '99.9%', label: t('hero.statsUptime') },
  { value: '< 1s', label: t('hero.statsLatency') },
])
</script>

<template>
  <section class="relative overflow-hidden">
    <!-- Background gradient -->
    <div class="absolute inset-0 -z-10">
      <div class="absolute top-0 left-1/2 -translate-x-1/2 w-[800px] h-[800px] bg-primary-500/10 rounded-full blur-3xl" />
      <div class="absolute bottom-0 right-0 w-[600px] h-[600px] bg-purple-500/5 rounded-full blur-3xl" />
    </div>

    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 pt-20 pb-24 sm:pt-28 sm:pb-32">
      <div class="text-center max-w-4xl mx-auto">
        <UBadge
          color="primary"
          variant="soft"
          size="lg"
          class="mb-6"
        >
          <span class="size-2 rounded-full bg-primary-500 animate-pulse mr-2" />
          {{ t('hero.badge') }}
        </UBadge>

        <h1 class="font-display text-4xl sm:text-5xl lg:text-6xl font-bold text-neutral-900 dark:text-white leading-tight">
          {{ t('hero.title1') }}
          <span class="bg-gradient-to-r from-primary-500 to-purple-500 bg-clip-text text-transparent">
            {{ t('hero.title2') }}
          </span>
        </h1>

        <p class="mt-6 text-lg sm:text-xl text-neutral-600 dark:text-neutral-400 max-w-2xl mx-auto leading-relaxed">
          {{ t('hero.subtitle') }}
        </p>

        <div class="mt-10 flex flex-col sm:flex-row gap-3 justify-center">
          <UButton
            :to="localePath('/contact')"
            color="primary"
            size="xl"
            trailing-icon="i-lucide-arrow-right"
          >
            {{ t('hero.ctaPrimary') }}
          </UButton>
          <UButton
            :to="localePath('/features')"
            color="neutral"
            variant="outline"
            size="xl"
          >
            {{ t('hero.ctaSecondary') }}
          </UButton>
        </div>

        <p class="mt-6 text-sm text-neutral-500 dark:text-neutral-500">
          {{ t('hero.noCard') }}
        </p>
      </div>

      <!-- Stats -->
      <div class="mt-16 grid grid-cols-3 gap-4 sm:gap-8 max-w-3xl mx-auto">
        <div v-for="s in stats" :key="s.label" class="text-center">
          <div class="text-3xl sm:text-4xl font-display font-bold text-primary-600 dark:text-primary-400">
            {{ s.value }}
          </div>
          <div class="mt-1 text-sm text-neutral-600 dark:text-neutral-400">
            {{ s.label }}
          </div>
        </div>
      </div>
    </div>
  </section>
</template>
