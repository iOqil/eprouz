import { Buffer } from 'node:buffer'
import { timingSafeEqual } from 'node:crypto'

/**
 * On-demand cache invalidation webhook. WordPress calls this on publish/update
 * with the shared secret (header `x-webhook-secret` or `?secret=`). We purge
 * the whole Nitro `cache` storage (WP function caches + blog SWR HTML) so the
 * change is visible on the very next request — no full rebuild required.
 */
export default defineEventHandler(async (event) => {
  const { wpRevalidateSecret } = useRuntimeConfig()
  if (!wpRevalidateSecret) {
    throw createError({ statusCode: 503, statusMessage: 'Revalidation is not configured' })
  }

  const provided = getHeader(event, 'x-webhook-secret') ?? String(getQuery(event).secret ?? '')
  if (!safeEqual(provided, wpRevalidateSecret)) {
    throw createError({ statusCode: 401, statusMessage: 'Invalid revalidation secret' })
  }

  const body = await readBody(event).catch(() => null)
  await useStorage('cache').clear()

  return { revalidated: true, at: new Date().toISOString(), received: body }
})

function safeEqual(a: string, b: string): boolean {
  const ab = Buffer.from(a)
  const bb = Buffer.from(b)
  if (ab.length !== bb.length) return false
  return timingSafeEqual(ab, bb)
}
