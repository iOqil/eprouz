import sanitizeHtml from 'sanitize-html'

/**
 * Server-only allowlist sanitizer for WordPress post HTML. This runs in Nitro
 * before the HTML is ever placed in the SSR payload, so the blog detail page
 * can safely `v-html` the result. NEVER sanitize WP HTML only on the client.
 */
const options: sanitizeHtml.IOptions = {
  allowedTags: [
    'h2', 'h3', 'h4', 'h5', 'h6', 'p', 'a', 'ul', 'ol', 'li',
    'strong', 'em', 'b', 'i', 'u', 's', 'blockquote', 'q',
    'code', 'pre', 'hr', 'br', 'span', 'div',
    'figure', 'figcaption', 'img',
    'table', 'thead', 'tbody', 'tr', 'th', 'td',
    'iframe',
  ],
  allowedAttributes: {
    a: ['href', 'name', 'target', 'rel'],
    img: ['src', 'srcset', 'sizes', 'alt', 'title', 'width', 'height', 'loading'],
    iframe: ['src', 'width', 'height', 'allow', 'allowfullscreen', 'frameborder', 'title'],
    span: ['class'],
    div: ['class'],
    code: ['class'],
    pre: ['class'],
    th: ['scope', 'colspan', 'rowspan'],
    td: ['colspan', 'rowspan'],
    '*': ['id'],
  },
  allowedSchemes: ['http', 'https', 'mailto', 'tel'],
  // Only allow embeds from trusted video hosts
  allowedIframeHostnames: ['www.youtube.com', 'youtube.com', 'www.youtube-nocookie.com', 'player.vimeo.com'],
  transformTags: {
    // Force safe rel on every link
    a: sanitizeHtml.simpleTransform('a', { rel: 'noopener noreferrer' }, true),
  },
}

export function sanitizeWpHtml(html: string | null | undefined): string {
  if (!html) return ''
  return sanitizeHtml(html, options)
}
