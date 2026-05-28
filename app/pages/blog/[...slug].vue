<script setup lang="ts">
const route = useRoute()
const { t, locale } = useI18n()
const localePath = useLocalePath()

const { data: post } = await useAsyncData(`blog-${route.path}`, () =>
  queryCollection('blog').path(route.path).first(),
)

if (!post.value) {
  throw createError({ statusCode: 404, message: 'Post not found', fatal: true })
}

useSeoMeta({
  title: () => post.value?.title,
  description: () => post.value?.description,
  ogTitle: () => post.value?.title,
  ogDescription: () => post.value?.description,
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
          {{ formatDate(post.date as string) }}
          <span v-if="post.readTime">• {{ post.readTime }} {{ t('blogPage.minRead') }}</span>
        </div>
        <h1 class="mt-3 font-display text-4xl sm:text-5xl font-bold text-neutral-900 dark:text-white leading-tight">
          {{ post.title }}
        </h1>
        <p v-if="post.description" class="mt-4 text-xl text-neutral-600 dark:text-neutral-400">
          {{ post.description }}
        </p>
      </header>

      <div class="prose prose-lg dark:prose-invert max-w-none">
        <ContentRenderer :value="post" />
      </div>
    </div>
  </article>
</template>
