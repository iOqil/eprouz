<script setup lang="ts">
const { t } = useI18n()

useSeoMeta({
  title: () => t('seo.security.title'),
  description: () => t('seo.security.description'),
})

const pillars = computed(() => [
  { icon: 'i-lucide-shield-check',   key: 'isolation' },
  { icon: 'i-lucide-lock',           key: 'encryption' },
  { icon: 'i-lucide-database',       key: 'backups' },
  { icon: 'i-lucide-key-round',      key: 'auth' },
  { icon: 'i-lucide-file-check',     key: 'audit' },
  { icon: 'i-lucide-server',         key: 'infra' },
])
</script>

<template>
  <div>
    <section class="py-20 sm:py-28 text-center">
      <div class="mx-auto max-w-3xl px-4 sm:px-6 lg:px-8">
        <UBadge color="primary" variant="soft" size="lg" class="mb-6">
          <UIcon name="i-lucide-shield-check" class="size-4 mr-1.5" />
          {{ t('securityPage.badge') }}
        </UBadge>
        <h1 class="font-display text-4xl sm:text-5xl font-bold text-neutral-900 dark:text-white">
          {{ t('securityPage.title') }}
        </h1>
        <p class="mt-6 text-lg text-neutral-600 dark:text-neutral-400">
          {{ t('securityPage.subtitle') }}
        </p>
      </div>
    </section>

    <section class="pb-20">
      <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
          <div
            v-for="p in pillars"
            :key="p.key"
            class="p-6 rounded-xl bg-white dark:bg-neutral-950 border border-neutral-200 dark:border-neutral-800"
          >
            <div class="size-12 rounded-lg bg-primary-100 dark:bg-primary-950 flex items-center justify-center text-primary-600 dark:text-primary-400">
              <UIcon :name="p.icon" class="size-6" />
            </div>
            <h3 class="mt-4 font-display font-semibold text-lg text-neutral-900 dark:text-white">
              {{ t(`securityPage.${p.key}.title`) }}
            </h3>
            <p class="mt-2 text-sm text-neutral-600 dark:text-neutral-400 leading-relaxed">
              {{ t(`securityPage.${p.key}.description`) }}
            </p>
          </div>
        </div>
      </div>
    </section>
  </div>
</template>
