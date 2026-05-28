<script setup lang="ts">
const props = defineProps<{
  error: { statusCode: number; statusMessage?: string; message?: string }
}>()

const { t } = useI18n()
const handleError = () => clearError({ redirect: '/' })
</script>

<template>
  <div class="min-h-screen flex items-center justify-center bg-neutral-50 dark:bg-neutral-950 px-4">
    <div class="text-center max-w-md">
      <div class="text-9xl font-bold text-primary-500 mb-4">
        {{ props.error.statusCode }}
      </div>
      <h1 class="text-2xl font-bold text-neutral-900 dark:text-white mb-3">
        {{ props.error.statusCode === 404 ? t('error.notFoundTitle') : t('error.serverErrorTitle') }}
      </h1>
      <p class="text-neutral-600 dark:text-neutral-400 mb-8">
        {{ props.error.statusCode === 404 ? t('error.notFoundMessage') : t('error.serverErrorMessage') }}
      </p>
      <UButton size="lg" @click="handleError">
        {{ t('error.backHome') }}
      </UButton>
    </div>
  </div>
</template>
