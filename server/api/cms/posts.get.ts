import { toLocale } from '../../utils/locale'
import { getCachedPostList } from '../../utils/wp-cache'
import type { BlogListItem } from '../../utils/wp-schema'

/**
 * Blog listing for a given locale. Resilient by design: if WordPress is
 * unreachable we return an empty list so the page shows its empty state
 * instead of crashing the SSR render.
 */
export default defineEventHandler(async (event): Promise<BlogListItem[]> => {
  const locale = toLocale(getQuery(event).lang)
  try {
    return await getCachedPostList(locale)
  } catch (err) {
    console.error('[cms/posts] WordPress unavailable:', err)
    return []
  }
})
