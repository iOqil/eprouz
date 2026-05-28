<script setup lang="ts">
const { t } = useI18n()

useSeoMeta({
  title: () => t('seo.about.title'),
  description: () => t('seo.about.description'),
})
</script>

<template>
  <div class="py-20 sm:py-28">
    <div class="mx-auto max-w-3xl px-4 sm:px-6 lg:px-8">
      <h1 class="font-display text-4xl sm:text-5xl font-bold text-neutral-900 dark:text-white">
        {{ t('aboutPage.title') }}
      </h1>
      <p class="mt-6 text-xl text-neutral-600 dark:text-neutral-400 leading-relaxed">
        {{ t('aboutPage.lead') }}
      </p>

      <div class="mt-12 prose prose-lg dark:prose-invert max-w-none">
        <h2>{{ t('aboutPage.mission.title') }}</h2>
        <p>{{ t('aboutPage.mission.body') }}</p>

        <h2>{{ t('aboutPage.story.title') }}</h2>
        <p>{{ t('aboutPage.story.body') }}</p>

        <h2>{{ t('aboutPage.values.title') }}</h2>
        <ul>
          <li>{{ t('aboutPage.values.v1') }}</li>
          <li>{{ t('aboutPage.values.v2') }}</li>
          <li>{{ t('aboutPage.values.v3') }}</li>
          <li>{{ t('aboutPage.values.v4') }}</li>
        </ul>
      </div>
    </div>
  </div>
</template>
