import { z } from 'zod'
import { wpLangToI18n, type Locale } from './locale'

/**
 * Tolerant Zod schemas for the raw WPGraphQL `Post` node, plus the normalized
 * DTOs the `/api/cms/*` routes return to the app. WPGraphQL returns HTTP 200
 * even on field errors and `null` for empty fields, so everything optional /
 * nullable is validated leniently and a schema mismatch fails loudly (logged)
 * instead of silently rendering a blank page.
 */

const wpImageSchema = z
  .object({
    node: z
      .object({
        sourceUrl: z.string().nullish(),
        altText: z.string().nullish(),
      })
      .nullish(),
  })
  .nullish()

const wpPostMetaSchema = z
  .object({
    // ACF field group exposed in WPGraphQL as `postMeta` (see wordpress/README.md)
    readingTime: z.coerce.number().nullish(),
  })
  .nullish()

const wpTagsSchema = z
  .object({
    nodes: z.array(z.object({ name: z.string() })).nullish(),
  })
  .nullish()

export const wpPostNodeSchema = z.object({
  databaseId: z.number(),
  slug: z.string(),
  title: z.string().nullish(),
  date: z.string().nullish(),
  modified: z.string().nullish(),
  excerpt: z.string().nullish(),
  content: z.string().nullish(),
  featuredImage: wpImageSchema,
  postMeta: wpPostMetaSchema,
  tags: wpTagsSchema,
  language: z.object({ slug: z.string().nullish() }).nullish(),
})
export type WpPostNode = z.infer<typeof wpPostNodeSchema>

/** A blog post as the listing needs it (no body). */
export interface BlogListItem {
  slug: string
  title: string
  description: string
  date: string
  modified: string | null
  readTime: number | null
  cover: string | null
  coverAlt: string | null
  tags: string[]
  locale: Locale
}

/** A full blog post; `html` is already server-sanitized. */
export interface BlogPost extends BlogListItem {
  html: string
}

// ─── tiny, client-safe HTML helpers (used only for short text fields) ──────────
const NAMED_ENTITIES: Record<string, string> = {
  '&amp;': '&', '&lt;': '<', '&gt;': '>', '&quot;': '"', '&apos;': "'",
  '&#39;': "'", '&#039;': "'", '&nbsp;': ' ', '&hellip;': '…',
  '&mdash;': '—', '&ndash;': '–', '&laquo;': '«', '&raquo;': '»',
  '&rsquo;': '’', '&lsquo;': '‘', '&ldquo;': '“', '&rdquo;': '”',
}

export function decodeEntities(input: string): string {
  return input
    .replace(/&#(\d+);/g, (_, n: string) => String.fromCodePoint(Number(n)))
    .replace(/&#x([0-9a-f]+);/gi, (_, n: string) => String.fromCodePoint(parseInt(n, 16)))
    .replace(/&[a-z]+;/gi, m => NAMED_ENTITIES[m.toLowerCase()] ?? m)
}

/** Strip tags + decode entities + collapse whitespace — for excerpts/meta only. */
export function stripHtml(input: string): string {
  return decodeEntities(input.replace(/<[^>]*>/g, ' ')).replace(/\s+/g, ' ').trim()
}

/** Map a validated WP node to the listing DTO. */
export function normalizeBlogListItem(node: WpPostNode, fallbackLocale: Locale): BlogListItem {
  return {
    slug: node.slug,
    title: decodeEntities(node.title ?? ''),
    description: stripHtml(node.excerpt ?? ''),
    date: node.date ?? '',
    modified: node.modified ?? null,
    readTime: node.postMeta?.readingTime || null,
    cover: node.featuredImage?.node?.sourceUrl ?? null,
    coverAlt: node.featuredImage?.node?.altText ?? null,
    tags: node.tags?.nodes?.map(t => t.name) ?? [],
    locale: node.language?.slug ? wpLangToI18n(node.language.slug) : fallbackLocale,
  }
}
