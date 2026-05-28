<script setup lang="ts">
const { t, locale, locales, setLocale } = useI18n()
const localePath = useLocalePath()
const config = useRuntimeConfig()
const colorMode = useColorMode()

const open = ref(false)

const nav = computed(() => [
  { label: t('nav.features'), to: localePath('/features') },
  { label: t('nav.pricing'),  to: localePath('/pricing') },
  { label: t('nav.security'), to: localePath('/security') },
  { label: t('nav.blog'),     to: localePath('/blog') },
  { label: t('nav.contact'),  to: localePath('/contact') },
])

const localeItems = computed(() =>
  (locales.value as Array<{ code: string; name: string }>).map(l => ({
    label: l.name,
    onSelect: () => setLocale(l.code),
    active: l.code === locale.value,
  })),
)

const toggleTheme = () => {
  colorMode.preference = colorMode.value === 'dark' ? 'light' : 'dark'
}
</script>

<template>
  <header class="sticky top-0 z-40 w-full border-b border-neutral-200/60 dark:border-neutral-800/60 bg-white/80 dark:bg-neutral-950/80 backdrop-blur">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
      <!-- Brand -->
      <NuxtLink :to="localePath('/')" class="flex items-center gap-2 font-display font-bold text-xl">
        <div class="size-8 rounded-lg bg-gradient-to-br from-primary-500 to-primary-700 flex items-center justify-center text-white">
          E
        </div>
        <span class="text-neutral-900 dark:text-white">EPRO</span>
      </NuxtLink>

      <!-- Desktop nav -->
      <nav class="hidden md:flex items-center gap-6">
        <NuxtLink
          v-for="item in nav"
          :key="item.to"
          :to="item.to"
          class="text-sm text-neutral-700 dark:text-neutral-300 hover:text-primary-600 dark:hover:text-primary-400 transition-colors"
        >
          {{ item.label }}
        </NuxtLink>
      </nav>

      <!-- Actions -->
      <div class="flex items-center gap-2">
        <UDropdownMenu :items="localeItems">
          <UButton
            color="neutral"
            variant="ghost"
            icon="i-lucide-languages"
            size="sm"
            class="hidden sm:inline-flex"
          >
            {{ locale.toUpperCase() }}
          </UButton>
        </UDropdownMenu>

        <UButton
          color="neutral"
          variant="ghost"
          :icon="colorMode.value === 'dark' ? 'i-lucide-sun' : 'i-lucide-moon'"
          size="sm"
          square
          aria-label="Toggle theme"
          @click="toggleTheme"
        />

        <UButton
          :to="config.public.adminUrl as string"
          external
          color="neutral"
          variant="ghost"
          size="sm"
          class="hidden sm:inline-flex"
        >
          {{ t('nav.signIn') }}
        </UButton>

        <UButton
          :to="localePath('/contact')"
          color="primary"
          size="sm"
          class="hidden sm:inline-flex"
        >
          {{ t('nav.getStarted') }}
        </UButton>

        <UButton
          class="md:hidden"
          color="neutral"
          variant="ghost"
          icon="i-lucide-menu"
          square
          @click="open = !open"
        />
      </div>
    </div>

    <!-- Mobile nav -->
    <Transition
      enter-active-class="transition duration-200 ease-out"
      enter-from-class="opacity-0 -translate-y-2"
      enter-to-class="opacity-100 translate-y-0"
      leave-active-class="transition duration-150 ease-in"
      leave-from-class="opacity-100 translate-y-0"
      leave-to-class="opacity-0 -translate-y-2"
    >
      <div v-if="open" class="md:hidden border-t border-neutral-200 dark:border-neutral-800 bg-white dark:bg-neutral-950">
        <nav class="px-4 py-4 space-y-1">
          <NuxtLink
            v-for="item in nav"
            :key="item.to"
            :to="item.to"
            class="block px-3 py-2 rounded-md text-sm text-neutral-700 dark:text-neutral-300 hover:bg-neutral-100 dark:hover:bg-neutral-900"
            @click="open = false"
          >
            {{ item.label }}
          </NuxtLink>
          <div class="pt-3 border-t border-neutral-200 dark:border-neutral-800 flex flex-col gap-2">
            <UButton
              :to="config.public.adminUrl as string"
              external
              color="neutral"
              variant="ghost"
              block
            >
              {{ t('nav.signIn') }}
            </UButton>
            <UButton :to="localePath('/contact')" color="primary" block @click="open = false">
              {{ t('nav.getStarted') }}
            </UButton>
          </div>
        </nav>
      </div>
    </Transition>
  </header>
</template>
