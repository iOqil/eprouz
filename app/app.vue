<script setup lang="ts">
const { locale } = useI18n()

useHead({
  htmlAttrs: { lang: locale.value },
})
</script>

<template>
  <UApp>
    <NuxtLoadingIndicator color="#6366f1" />
    <NuxtLayout>
      <NuxtPage />
    </NuxtLayout>
  </UApp>
</template>
