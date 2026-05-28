<script setup lang="ts">
const { t } = useI18n()

// Placeholder logos — replace with real client/partner logos as they come on
const logos = [
  { name: 'School 1', initial: 'S1' },
  { name: 'EduCenter', initial: 'EC' },
  { name: 'Bilim', initial: 'B' },
  { name: 'Maktab+', initial: 'M+' },
  { name: 'TechAcademy', initial: 'TA' },
  { name: 'LangPro', initial: 'LP' },
]
</script>

<template>
  <section class="py-12 border-y border-neutral-200 dark:border-neutral-800 bg-neutral-50/50 dark:bg-neutral-900/20">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
      <p class="text-center text-sm font-medium text-neutral-500 uppercase tracking-wider">
        {{ t('logos.title') }}
      </p>
      <div class="mt-8 grid grid-cols-3 sm:grid-cols-6 gap-6 items-center opacity-70">
        <div
          v-for="logo in logos"
          :key="logo.name"
          class="flex flex-col items-center gap-2 grayscale hover:grayscale-0 hover:opacity-100 transition-all"
        >
          <div class="size-12 rounded-lg bg-neutral-300 dark:bg-neutral-800 flex items-center justify-center text-neutral-600 dark:text-neutral-400 font-bold">
            {{ logo.initial }}
          </div>
          <span class="text-xs text-neutral-500">{{ logo.name }}</span>
        </div>
      </div>
    </div>
  </section>
</template>
