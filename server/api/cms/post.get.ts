import { toLocale } from '../../utils/locale'
import { getCachedPost } from '../../utils/wp-cache'

/**
 * A single blog post by slug + locale (resolved together — Polylang allows the
 * same slug across languages). Returns `null` (HTTP 200) when WordPress responds
 * but the post does not exist, so the page renders a 404. Throws 503 only when
 * WordPress itself is unreachable, so a network blip is not mistaken for "gone".
 */
export default defineEventHandler(async (event) => {
  const query = getQuery(event)
  const slug = String(query.slug ?? '').trim()
  const locale = toLocale(query.lang)

  if (!slug) throw createError({ statusCode: 400, statusMessage: 'Missing "slug"' })

  try {
    return await getCachedPost(slug, locale)
  } catch (err) {
    console.error('[cms/post] WordPress unavailable:', err)
    throw createError({ statusCode: 503, statusMessage: 'CMS temporarily unavailable' })
  }
})
