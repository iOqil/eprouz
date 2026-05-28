<script setup lang="ts">
</script>

<template>
  <div class="min-h-screen flex flex-col bg-white dark:bg-neutral-950">
    <AppNavbar />
    <main class="flex-1">
      <slot />
    </main>
    <AppFooter />
  </div>
</template>
