import { defineCollection, defineContentConfig, z } from '@nuxt/content'

export default defineContentConfig({
  collections: {
    blog: defineCollection({
      type: 'page',
      source: 'blog/**/*.md',
      schema: z.object({
        title: z.string(),
        description: z.string(),
        date: z.string(),
        locale: z.enum(['uz', 'ru', 'en']).default('uz'),
        cover: z.string().optional(),
        readTime: z.number().optional(),
        tags: z.array(z.string()).optional(),
      }),
    }),
  },
})
