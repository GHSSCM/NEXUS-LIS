// https://nuxt.com/docs/api/configuration/nuxt-config
export default defineNuxtConfig({
  devtools: { enabled: true },
  app:{
    head: {
      meta: [
        {
          "name": "viewport",
          "content": "width=device-width, initial-scale=1"
        },
        {
          "charset": "utf-8"
        }
      ],
      script: [
        { src: 'assets/js/pace.min.js' }
      ],
      link: [
        { rel: 'stylesheet', href: 'assets/css/pace.min.css' },
        { rel: 'stylesheet', href: 'assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css' },
        { rel: 'stylesheet', href: 'assets/css/bootstrap.min.css' },
        { rel: 'stylesheet', href: 'assets/css/bootstrap-extended.css' },
        { rel: 'stylesheet', href: 'assets/css/style.css' },
        { rel: 'stylesheet', href: 'assets/css/icons.css' },
        { rel: 'stylesheet', href: 'https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap' },

      ]
    },
  }
})
