/**
 * WPGraphQL queries for blog posts.
 *
 * Requires the WordPress plugins: WPGraphQL, WPGraphQL for ACF, and
 * WPGraphQL Polylang. `LanguageCodeFilterEnum` (UZ/RU/EN) comes from Polylang;
 * `postMeta { readingTime }` is the ACF field group (see wordpress/README.md).
 *
 * Posts are always resolved by (slug + language) — never slug alone — because
 * Polylang allows the same slug across languages.
 */
const POST_FIELDS = /* GraphQL */ `
  fragment PostFields on Post {
    databaseId
    slug
    title
    date
    modified
    excerpt
    featuredImage { node { sourceUrl altText } }
    postMeta { readingTime }
    tags { nodes { name } }
    language { slug }
  }
`

export const POSTS_LIST_QUERY = /* GraphQL */ `
  query PostsList($language: LanguageCodeFilterEnum!, $first: Int = 100) {
    posts(
      first: $first
      where: { language: $language, status: PUBLISH, orderby: { field: DATE, order: DESC } }
    ) {
      nodes { ...PostFields }
    }
  }
  ${POST_FIELDS}
`

export const POST_BY_SLUG_QUERY = /* GraphQL */ `
  query PostBySlug($slug: String!, $language: LanguageCodeFilterEnum!) {
    posts(first: 1, where: { name: $slug, language: $language, status: PUBLISH }) {
      nodes {
        ...PostFields
        content
      }
    }
  }
  ${POST_FIELDS}
`

/** Lightweight query for the sitemap: slug + modified date only. */
export const POSTS_SITEMAP_QUERY = /* GraphQL */ `
  query PostsSitemap($language: LanguageCodeFilterEnum!, $first: Int = 1000) {
    posts(first: $first, where: { language: $language, status: PUBLISH }) {
      nodes { slug modified date }
    }
  }
`
