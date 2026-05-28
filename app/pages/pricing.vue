<script setup lang="ts">
const { t } = useI18n()

useSeoMeta({
  title: () => t('seo.pricing.title'),
  description: () => t('seo.pricing.description'),
})

const faqs = computed(() => [
  { q: t('pricingPage.faq.q1'), a: t('pricingPage.faq.a1') },
  { q: t('pricingPage.faq.q2'), a: t('pricingPage.faq.a2') },
  { q: t('pricingPage.faq.q3'), a: t('pricingPage.faq.a3') },
  { q: t('pricingPage.faq.q4'), a: t('pricingPage.faq.a4') },
  { q: t('pricingPage.faq.q5'), a: t('pricingPage.faq.a5') },
])
</script>

<template>
  <div>
    <section class="py-16 sm:py-20 text-center">
      <div class="mx-auto max-w-3xl px-4 sm:px-6 lg:px-8">
        <h1 class="font-display text-4xl sm:text-5xl font-bold text-neutral-900 dark:text-white">
          {{ t('pricingPage.title') }}
        </h1>
        <p class="mt-4 text-lg text-neutral-600 dark:text-neutral-400">
          {{ t('pricingPage.subtitle') }}
        </p>
      </div>
    </section>

    <PricingTable />

    <!-- FAQ -->
    <section class="py-20 bg-neutral-50/50 dark:bg-neutral-900/30 border-y border-neutral-200 dark:border-neutral-800">
      <div class="mx-auto max-w-3xl px-4 sm:px-6 lg:px-8">
        <h2 class="font-display text-3xl font-bold text-center text-neutral-900 dark:text-white">
          {{ t('pricingPage.faq.title') }}
        </h2>
        <UAccordion :items="faqs.map(f => ({ label: f.q, content: f.a }))" class="mt-10" />
      </div>
    </section>

    <CtaBanner />
  </div>
</template>
