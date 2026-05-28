<script setup lang="ts">
const { t } = useI18n()

useSeoMeta({
  title: () => t('seo.home.title'),
  description: () => t('seo.home.description'),
  ogTitle: () => t('seo.home.title'),
  ogDescription: () => t('seo.home.description'),
})

defineOgImageComponent('NuxtSeo')
</script>

<template>
  <div>
    <HeroSection />
    <LogoCloud />
    <FeaturesGrid />
    <PricingTable />
    <CtaBanner />
  </div>
</template>
