<script setup lang="ts">
const { t } = useI18n()
const localePath = useLocalePath()
</script>

<template>
  <section class="py-20 sm:py-24">
    <div class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8">
      <div class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-primary-600 via-primary-700 to-purple-700 p-8 sm:p-16 text-center">
        <!-- decorative -->
        <div class="absolute -top-24 -right-24 size-64 bg-white/10 rounded-full blur-3xl" />
        <div class="absolute -bottom-24 -left-24 size-64 bg-white/5 rounded-full blur-3xl" />

        <div class="relative">
          <h2 class="font-display text-3xl sm:text-4xl font-bold text-white">
            {{ t('cta.title') }}
          </h2>
          <p class="mt-4 text-lg text-primary-100 max-w-2xl mx-auto">
            {{ t('cta.subtitle') }}
          </p>
          <div class="mt-8 flex flex-col sm:flex-row gap-3 justify-center">
            <UButton
              :to="localePath('/contact')"
              size="xl"
              color="neutral"
              variant="solid"
              class="bg-white text-primary-700 hover:bg-neutral-100"
            >
              {{ t('cta.button') }}
            </UButton>
            <UButton
              :to="localePath('/pricing')"
              size="xl"
              color="neutral"
              variant="ghost"
              class="text-white hover:bg-white/10"
            >
              {{ t('cta.secondary') }}
            </UButton>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>
