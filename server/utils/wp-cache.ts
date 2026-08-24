import { POST_BY_SLUG_QUERY, POSTS_LIST_QUERY } from '../graphql/posts'
import { i18nToWpLang, type Locale } from './locale'
import { sanitizeWpHtml } from './sanitize'
import { wpQuery } from './wp-client'
import {
  normalizeBlogListItem,
  wpPostNodeSchema,
  type BlogListItem,
  type BlogPost,
} from './wp-schema'

/**
 * SWR-cached WordPress fetchers. This is the single layer that actually hits
 * WP; the `/api/cms/*` routes call these. The cache lives in Nitro's `cache`
 * storage and is purged by the publish webhook (server/api/revalidate.post.ts).
 */
interface PostsResponse {
  posts?: { nodes?: unknown[] } | null
}

export const getCachedPostList = defineCachedFunction(
  async (locale: Locale): Promise<BlogListItem[]> => {
    const data = await wpQuery<PostsResponse>(POSTS_LIST_QUERY, {
      variables: { language: i18nToWpLang(locale) },
    })
    const items: BlogListItem[] = []
    for (const raw of data.posts?.nodes ?? []) {
      const parsed = wpPostNodeSchema.safeParse(raw)
      if (parsed.success) items.push(normalizeBlogListItem(parsed.data, locale))
      else console.error('[wp] list node failed validation:', parsed.error.issues)
    }
    return items
  },
  { name: 'wp:post-list', getKey: (locale: Locale) => locale, maxAge: 300, swr: true },
)

export const getCachedPost = defineCachedFunction(
  async (slug: string, locale: Locale): Promise<BlogPost | null> => {
    const data = await wpQuery<PostsResponse>(POST_BY_SLUG_QUERY, {
      variables: { slug, language: i18nToWpLang(locale) },
    })
    const raw = data.posts?.nodes?.[0]
    if (!raw) return null
    const parsed = wpPostNodeSchema.safeParse(raw)
    if (!parsed.success) {
      console.error('[wp] post node failed validation:', parsed.error.issues)
      return null
    }
    return {
      ...normalizeBlogListItem(parsed.data, locale),
      html: sanitizeWpHtml(parsed.data.content),
    }
  },
  { name: 'wp:post', getKey: (slug: string, locale: Locale) => `${locale}:${slug}`, maxAge: 300, swr: true },
)
