<script setup lang="ts">
const { t } = useI18n()
const localePath = useLocalePath()

const billing = ref<'monthly' | 'yearly'>('monthly')

const plans = computed(() => [
  {
    key: 'starter',
    name: t('pricing.starter.name'),
    description: t('pricing.starter.description'),
    monthly: 290_000,
    yearly: 2_900_000, // 2 months free
    featured: false,
    features: [
      t('pricing.starter.f1'),
      t('pricing.starter.f2'),
      t('pricing.starter.f3'),
      t('pricing.starter.f4'),
      t('pricing.starter.f5'),
    ],
  },
  {
    key: 'pro',
    name: t('pricing.pro.name'),
    description: t('pricing.pro.description'),
    monthly: 690_000,
    yearly: 6_900_000,
    featured: true,
    features: [
      t('pricing.pro.f1'),
      t('pricing.pro.f2'),
      t('pricing.pro.f3'),
      t('pricing.pro.f4'),
      t('pricing.pro.f5'),
      t('pricing.pro.f6'),
    ],
  },
  {
    key: 'enterprise',
    name: t('pricing.enterprise.name'),
    description: t('pricing.enterprise.description'),
    monthly: null, // custom
    yearly: null,
    featured: false,
    features: [
      t('pricing.enterprise.f1'),
      t('pricing.enterprise.f2'),
      t('pricing.enterprise.f3'),
      t('pricing.enterprise.f4'),
      t('pricing.enterprise.f5'),
    ],
  },
])

const formatPrice = (n: number) => {
  return new Intl.NumberFormat('uz-UZ').format(n)
}
</script>

<template>
  <section class="py-20 sm:py-28">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
      <div class="text-center max-w-2xl mx-auto mb-12">
        <h2 class="font-display text-3xl sm:text-4xl font-bold text-neutral-900 dark:text-white">
          {{ t('pricing.title') }}
        </h2>
        <p class="mt-4 text-lg text-neutral-600 dark:text-neutral-400">
          {{ t('pricing.subtitle') }}
        </p>

        <UTabs
          v-model="billing"
          :items="[
            { label: t('pricing.monthly'), value: 'monthly' },
            { label: t('pricing.yearly') + ' • ' + t('pricing.savePct'), value: 'yearly' },
          ]"
          color="primary"
          variant="pill"
          class="mt-8 inline-flex"
        />
      </div>

      <div class="grid grid-cols-1 md:grid-cols-3 gap-6 max-w-5xl mx-auto">
        <div
          v-for="plan in plans"
          :key="plan.key"
          class="relative rounded-2xl p-8 flex flex-col"
          :class="plan.featured
            ? 'bg-gradient-to-b from-primary-50 to-white dark:from-primary-950/50 dark:to-neutral-950 border-2 border-primary-500 shadow-xl shadow-primary-500/10'
            : 'bg-white dark:bg-neutral-950 border border-neutral-200 dark:border-neutral-800'"
        >
          <UBadge
            v-if="plan.featured"
            color="primary"
            variant="solid"
            class="absolute -top-3 left-1/2 -translate-x-1/2"
          >
            {{ t('pricing.popular') }}
          </UBadge>

          <h3 class="font-display text-2xl font-bold text-neutral-900 dark:text-white">
            {{ plan.name }}
          </h3>
          <p class="mt-2 text-sm text-neutral-600 dark:text-neutral-400">
            {{ plan.description }}
          </p>

          <div class="mt-6">
            <template v-if="plan.monthly !== null">
              <div class="flex items-baseline gap-1">
                <span class="text-4xl font-display font-bold text-neutral-900 dark:text-white">
                  {{ formatPrice(billing === 'monthly' ? plan.monthly : Math.round(plan.yearly! / 12)) }}
                </span>
                <span class="text-sm text-neutral-500">{{ t('pricing.currency') }}/{{ t('pricing.perMonth') }}</span>
              </div>
              <p v-if="billing === 'yearly'" class="text-xs text-primary-600 dark:text-primary-400 mt-1">
                {{ t('pricing.yearlyHint', { total: formatPrice(plan.yearly!) }) }}
              </p>
            </template>
            <template v-else>
              <div class="text-3xl font-display font-bold text-neutral-900 dark:text-white">
                {{ t('pricing.custom') }}
              </div>
              <p class="text-sm text-neutral-500 mt-1">{{ t('pricing.customHint') }}</p>
            </template>
          </div>

          <ul class="mt-8 space-y-3 flex-1">
            <li v-for="(f, i) in plan.features" :key="i" class="flex items-start gap-3 text-sm text-neutral-700 dark:text-neutral-300">
              <UIcon name="i-lucide-check" class="size-5 text-primary-600 dark:text-primary-400 flex-shrink-0 mt-0.5" />
              <span>{{ f }}</span>
            </li>
          </ul>

          <UButton
            :to="localePath('/contact')"
            :color="plan.featured ? 'primary' : 'neutral'"
            :variant="plan.featured ? 'solid' : 'outline'"
            size="lg"
            block
            class="mt-8"
          >
            {{ plan.key === 'enterprise' ? t('pricing.contactSales') : t('pricing.startTrial') }}
          </UButton>
        </div>
      </div>
    </div>
  </section>
</template>
