# syntax=docker/dockerfile:1.7

# ─── Stage 1: Build ───────────────────────────────────────────
FROM node:22-alpine AS builder

WORKDIR /app

RUN npm install -g pnpm@10.16.1

# Copy lockfiles first for layer caching
COPY package.json pnpm-lock.yaml* ./
RUN pnpm install --frozen-lockfile || pnpm install

# Copy source
COPY . .

# Build (Nuxt SSR/SSG)
RUN pnpm build


# ─── Stage 2: Runtime ─────────────────────────────────────────
FROM node:22-alpine AS runner

WORKDIR /app

# Copy built output only (no source/deps)
COPY --from=builder /app/.output ./.output

ENV NODE_ENV=production
ENV PORT=3000
ENV HOST=0.0.0.0
ENV NITRO_PORT=3000
ENV NITRO_HOST=0.0.0.0

EXPOSE 3000

# Healthcheck — Nitro serves a basic 200 on root
HEALTHCHECK --interval=30s --timeout=5s --start-period=15s --retries=3 \
    CMD wget -qO- http://127.0.0.1:3000/ > /dev/null 2>&1 || exit 1

CMD ["node", ".output/server/index.mjs"]
