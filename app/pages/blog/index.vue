<script setup lang="ts">
const { t, locale } = useI18n()

useSeoMeta({
  title: () => t('seo.blog.title'),
  description: () => t('seo.blog.description'),
})

const { data: posts } = await useAsyncData('blog-list', () =>
  queryCollection('blog')
    .where('locale', '=', locale.value)
    .order('date', 'DESC')
    .all(),
)

const localePath = useLocalePath()

const formatDate = (d: string) =>
  new Date(d).toLocaleDateString(locale.value === 'uz' ? 'uz-UZ' : locale.value, {
    year: 'numeric', month: 'long', day: 'numeric',
  })
</script>

<template>
  <div class="py-20 sm:py-28">
    <div class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8">
      <div class="text-center mb-16">
        <h1 class="font-display text-4xl sm:text-5xl font-bold text-neutral-900 dark:text-white">
          {{ t('blogPage.title') }}
        </h1>
        <p class="mt-4 text-lg text-neutral-600 dark:text-neutral-400">
          {{ t('blogPage.subtitle') }}
        </p>
      </div>

      <div v-if="posts && posts.length" class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <article
          v-for="post in posts"
          :key="post.path"
          class="group"
        >
          <NuxtLink :to="localePath(post.path)" class="block">
            <div class="aspect-video rounded-xl bg-gradient-to-br from-primary-100 to-purple-100 dark:from-primary-950 dark:to-purple-950 overflow-hidden">
              <NuxtImg
                v-if="post.cover"
                :src="post.cover"
                :alt="post.title"
                class="w-full h-full object-cover group-hover:scale-105 transition-transform"
                loading="lazy"
              />
            </div>
            <div class="mt-4">
              <div class="flex items-center gap-2 text-xs text-neutral-500">
                <span>{{ formatDate(post.date as string) }}</span>
                <span v-if="post.readTime">• {{ post.readTime }} {{ t('blogPage.minRead') }}</span>
              </div>
              <h2 class="mt-2 font-display text-xl font-bold text-neutral-900 dark:text-white group-hover:text-primary-600 dark:group-hover:text-primary-400 transition-colors">
                {{ post.title }}
              </h2>
              <p class="mt-2 text-neutral-600 dark:text-neutral-400 line-clamp-2">
                {{ post.description }}
              </p>
            </div>
          </NuxtLink>
        </article>
      </div>

      <div v-else class="text-center py-20">
        <UIcon name="i-lucide-file-text" class="size-12 text-neutral-300 dark:text-neutral-700 mx-auto" />
        <p class="mt-4 text-neutral-500">{{ t('blogPage.empty') }}</p>
      </div>
    </div>
  </div>
</template>
