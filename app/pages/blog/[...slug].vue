<script setup lang="ts">
const route = useRoute()
const { t, locale } = useI18n()
const localePath = useLocalePath()

// Catch-all param -> WordPress slug. With `prefix_except_default`, i18n strips
// the locale prefix, so the last segment is the bare slug.
const slug = computed(() => {
  const s = route.params.slug
  return Array.isArray(s) ? (s.at(-1) ?? '') : (s ?? '')
})

const { data: post, error } = await useFetch('/api/cms/post', {
  query: { slug, lang: locale },
})

// WordPress unreachable -> 503 (not a 404). Post genuinely absent -> 404.
if (error.value) {
  throw createError({ statusCode: 503, statusMessage: 'CMS temporarily unavailable', fatal: true })
}
if (!post.value) {
  throw createError({ statusCode: 404, message: 'Post not found', fatal: true })
}

useSeoMeta({
  title: () => post.value?.title,
  description: () => post.value?.description,
  ogTitle: () => post.value?.title,
  ogDescription: () => post.value?.description,
  ogImage: () => post.value?.cover ?? undefined,
  articlePublishedTime: () => post.value?.date,
  articleModifiedTime: () => post.value?.modified ?? undefined,
})

const formatDate = (d: string) =>
  new Date(d).toLocaleDateString(locale.value === 'uz' ? 'uz-UZ' : locale.value, {
    year: 'numeric', month: 'long', day: 'numeric',
  })
</script>

<template>
  <article v-if="post" class="py-16 sm:py-24">
    <div class="mx-auto max-w-3xl px-4 sm:px-6 lg:px-8">
      <UButton
        :to="localePath('/blog')"
        variant="ghost"
        color="neutral"
        icon="i-lucide-arrow-left"
        size="sm"
        class="mb-8"
      >
        {{ t('blogPage.backToBlog') }}
      </UButton>

      <header class="mb-10">
        <div class="text-sm text-neutral-500">
          {{ formatDate(post.date) }}
          <span v-if="post.readTime">• {{ post.readTime }} {{ t('blogPage.minRead') }}</span>
        </div>
        <h1 class="mt-3 font-display text-4xl sm:text-5xl font-bold text-neutral-900 dark:text-white leading-tight">
          {{ post.title }}
        </h1>
        <p v-if="post.description" class="mt-4 text-xl text-neutral-600 dark:text-neutral-400">
          {{ post.description }}
        </p>
      </header>

      <!-- post.html is sanitized server-side in server/api/cms/post.get.ts (sanitize-html allowlist) -->
      <!-- eslint-disable-next-line vue/no-v-html -->
      <div class="prose prose-lg dark:prose-invert max-w-none" v-html="post.html" />
    </div>
  </article>
</template>
