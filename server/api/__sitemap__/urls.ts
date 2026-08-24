import { POSTS_SITEMAP_QUERY } from '../../graphql/posts'
import { i18nToWpLang, localizedBlogPath, LOCALES } from '../../utils/locale'
import { wpQuery } from '../../utils/wp-client'

/**
 * Dynamic sitemap source for @nuxtjs/seo (nuxt-sitemap). Emits every published
 * WordPress blog post across all locales as a localized `/blog/<slug>` URL.
 * Resilient: returns [] if WordPress is unreachable (e.g. during a build with
 * no WP configured) so the build/sitemap never fails.
 */
interface SitemapNode { slug: string, modified?: string | null, date?: string | null }
interface SitemapResponse { posts?: { nodes?: SitemapNode[] } | null }

const getSitemapEntries = defineCachedFunction(
  async () => {
    const entries: Array<{ loc: string, lastmod?: string }> = []
    for (const locale of LOCALES) {
      const data = await wpQuery<SitemapResponse>(POSTS_SITEMAP_QUERY, {
        variables: { language: i18nToWpLang(locale) },
      })
      for (const node of data.posts?.nodes ?? []) {
        if (!node?.slug) continue
        entries.push({
          loc: localizedBlogPath(locale, node.slug),
          lastmod: node.modified ?? node.date ?? undefined,
        })
      }
    }
    return entries
  },
  { name: 'wp:sitemap', getKey: () => 'all', maxAge: 300, swr: true },
)

export default defineEventHandler(async () => {
  try {
    return await getSitemapEntries()
  } catch (err) {
    console.error('[sitemap] WordPress unavailable:', err)
    return []
  }
})
