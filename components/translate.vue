<template>
  <span>{{ t(text) }}</span>
</template>

<script>
import { useI18n } from 'vue-i18n'

export default {
  props: ["text"],

  setup() {
    const { t,locale } = useI18n() 
    const { setLocale } = useI18n();
    locale.value = getUserLang();
    setLocale( getUserLang());
    return { t }
  }
}
</script>
