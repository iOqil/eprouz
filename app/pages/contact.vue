<script setup lang="ts">
import { z } from 'zod'

const { t } = useI18n()
const config = useRuntimeConfig()
const toast = useToast()

useSeoMeta({
  title: () => t('seo.contact.title'),
  description: () => t('seo.contact.description'),
})

const schema = z.object({
  name:    z.string().min(2, t('contactPage.errors.name')),
  email:   z.string().email(t('contactPage.errors.email')),
  phone:   z.string().min(7, t('contactPage.errors.phone')),
  message: z.string().min(10, t('contactPage.errors.message')),
})

type Form = z.output<typeof schema>

const state = reactive<Partial<Form>>({
  name: '',
  email: '',
  phone: '',
  message: '',
})

const submitting = ref(false)

const onSubmit = async () => {
  submitting.value = true
  try {
    await $fetch(`${config.public.apiBase}/api/v1/marketing/lead`, {
      method: 'POST',
      body: state,
    })
    toast.add({
      title: t('contactPage.toast.successTitle'),
      description: t('contactPage.toast.successBody'),
      color: 'success',
    })
    Object.assign(state, { name: '', email: '', phone: '', message: '' })
  } catch {
    toast.add({
      title: t('contactPage.toast.errorTitle'),
      description: t('contactPage.toast.errorBody'),
      color: 'error',
    })
  } finally {
    submitting.value = false
  }
}

const channels = computed(() => [
  {
    icon: 'i-simple-icons-telegram',
    title: t('contactPage.channels.telegram'),
    value: `@${config.public.telegramBot}`,
    href: `https://t.me/${config.public.telegramBot}`,
  },
  {
    icon: 'i-lucide-mail',
    title: t('contactPage.channels.email'),
    value: 'hello@epro.uz',
    href: 'mailto:hello@epro.uz',
  },
  {
    icon: 'i-lucide-phone',
    title: t('contactPage.channels.phone'),
    value: '+998 (XX) XXX-XX-XX',
    href: 'tel:+998000000000',
  },
])
</script>

<template>
  <div class="py-20 sm:py-28">
    <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
      <div class="text-center max-w-2xl mx-auto">
        <h1 class="font-display text-4xl sm:text-5xl font-bold text-neutral-900 dark:text-white">
          {{ t('contactPage.title') }}
        </h1>
        <p class="mt-4 text-lg text-neutral-600 dark:text-neutral-400">
          {{ t('contactPage.subtitle') }}
        </p>
      </div>

      <div class="mt-16 grid grid-cols-1 lg:grid-cols-5 gap-10">
        <!-- Channels -->
        <div class="lg:col-span-2 space-y-4">
          <a
            v-for="c in channels"
            :key="c.title"
            :href="c.href"
            target="_blank"
            rel="noopener"
            class="flex items-start gap-4 p-5 rounded-xl border border-neutral-200 dark:border-neutral-800 hover:border-primary-300 dark:hover:border-primary-700 transition-colors"
          >
            <div class="size-11 rounded-lg bg-primary-100 dark:bg-primary-950 flex items-center justify-center text-primary-600 dark:text-primary-400 flex-shrink-0">
              <UIcon :name="c.icon" class="size-5" />
            </div>
            <div>
              <div class="text-sm text-neutral-500">{{ c.title }}</div>
              <div class="font-medium text-neutral-900 dark:text-white">{{ c.value }}</div>
            </div>
          </a>
        </div>

        <!-- Form -->
        <UForm
          :schema="schema"
          :state="state"
          class="lg:col-span-3 p-8 rounded-2xl bg-white dark:bg-neutral-950 border border-neutral-200 dark:border-neutral-800 space-y-5"
          @submit="onSubmit"
        >
          <UFormField :label="t('contactPage.form.name')" name="name" required>
            <UInput v-model="state.name" size="lg" />
          </UFormField>

          <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <UFormField :label="t('contactPage.form.email')" name="email" required>
              <UInput v-model="state.email" type="email" size="lg" />
            </UFormField>
            <UFormField :label="t('contactPage.form.phone')" name="phone" required>
              <UInput v-model="state.phone" type="tel" size="lg" placeholder="+998 ..." />
            </UFormField>
          </div>

          <UFormField :label="t('contactPage.form.message')" name="message" required>
            <UTextarea v-model="state.message" :rows="5" size="lg" />
          </UFormField>

          <UButton
            type="submit"
            color="primary"
            size="lg"
            block
            :loading="submitting"
            trailing-icon="i-lucide-send"
          >
            {{ t('contactPage.form.submit') }}
          </UButton>

          <p class="text-xs text-neutral-500 text-center">
            {{ t('contactPage.form.privacy') }}
          </p>
        </UForm>
      </div>
    </div>
  </div>
</template>
