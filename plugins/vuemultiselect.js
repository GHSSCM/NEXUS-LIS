
export default defineNuxtPlugin( nuxtApp => {
    const Multiselect = defineAsyncComponent(() => import('vue-multiselect'))
    nuxtApp.vueApp.component("multiselect", Multiselect)
})