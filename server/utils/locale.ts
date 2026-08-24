/**
 * Locale helpers for the headless WordPress integration.
 *
 * The site runs i18n with locales `uz` (default), `ru`, `en` using the
 * `prefix_except_default` strategy. Polylang exposes the same languages in
 * WPGraphQL as an uppercased `LanguageCodeFilterEnum` (UZ / RU / EN).
 */
export const LOCALES = ['uz', 'ru', 'en'] as const
export type Locale = (typeof LOCALES)[number]
export type WpLanguage = 'UZ' | 'RU' | 'EN'

export const DEFAULT_LOCALE: Locale = 'uz'

export function isLocale(value: unknown): value is Locale {
  return typeof value === 'string' && (LOCALES as readonly string[]).includes(value)
}

/** Coerce an unknown value (e.g. a `?lang=` query param) to a valid Locale. */
export function toLocale(value: unknown): Locale {
  if (Array.isArray(value)) value = value[0]
  return isLocale(value) ? value : DEFAULT_LOCALE
}

/** i18n locale -> Polylang WPGraphQL language enum. */
export function i18nToWpLang(locale: Locale): WpLanguage {
  return locale.toUpperCase() as WpLanguage
}

/** Polylang language slug (e.g. "uz") -> i18n locale. */
export function wpLangToI18n(slug: string | null | undefined): Locale {
  return toLocale(slug?.toLowerCase())
}

/** Build a localized `/blog/<slug>` path honouring `prefix_except_default`. */
export function localizedBlogPath(locale: Locale, slug: string): string {
  return locale === DEFAULT_LOCALE ? `/blog/${slug}` : `/${locale}/blog/${slug}`
}

/**
 * Split a localized path into its locale and the remaining path.
 *   "/blog/foo"    -> { locale: "uz", rest: "blog/foo" }
 *   "/ru/blog/foo" -> { locale: "ru", rest: "blog/foo" }
 */
export function stripLocalePrefix(path: string): { locale: Locale; rest: string } {
  const clean = path.replace(/^\/+/, '')
  const [head, ...tail] = clean.split('/')
  if (head && isLocale(head) && head !== DEFAULT_LOCALE) {
    return { locale: head, rest: tail.join('/') }
  }
  return { locale: DEFAULT_LOCALE, rest: clean }
}
