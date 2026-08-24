/**
 * The single entry point for talking to WPGraphQL. All WordPress traffic goes
 * server -> server through here, so the endpoint/token never reach the browser
 * (no CORS, no token exposure). WPGraphQL returns HTTP 200 even when a query
 * has errors, so we must inspect `body.errors` explicitly.
 */
export class WpError extends Error {
  detail?: unknown
  constructor(message: string, detail?: unknown) {
    super(message)
    this.name = 'WpError'
    this.detail = detail
  }
}

export interface WpQueryOptions {
  variables?: Record<string, unknown>
  /** Bearer token for authenticated (draft preview) requests. */
  token?: string
}

interface GraphQLResponse<T> {
  data?: T
  errors?: Array<{ message: string }>
}

export async function wpQuery<T>(query: string, options: WpQueryOptions = {}): Promise<T> {
  const { wpGraphqlEndpoint } = useRuntimeConfig()
  if (!wpGraphqlEndpoint) {
    throw new WpError('WP GraphQL endpoint is not configured (set NUXT_WP_GRAPHQL_ENDPOINT)')
  }

  const headers: Record<string, string> = { 'content-type': 'application/json' }
  if (options.token) headers.authorization = `Bearer ${options.token}`

  const res = await $fetch<GraphQLResponse<T>>(wpGraphqlEndpoint, {
    method: 'POST',
    headers,
    body: { query, variables: options.variables ?? {} },
    timeout: 8000,
    retry: 1,
    retryDelay: 300,
  })

  if (res.errors?.length) {
    throw new WpError(res.errors.map(e => e.message).join('; '), res.errors)
  }
  if (!res.data) {
    throw new WpError('WP GraphQL returned an empty response')
  }
  return res.data
}
