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
        { src: '/assets/js/jquery.min.js' },
        { src: '/assets/js/pace.min.js' },
        { src: '/assets/plugins/simplebar/js/simplebar.min.js' },
        { src: '/assets/plugins/metismenu/js/metisMenu.min.js' },
        { src: '/assets/js/bootstrap.bundle.min.js' },
        { src: '/assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js' },
        { src: '/assets/plugins/apexcharts-bundle/js/apexcharts.min.js' },
        { src: '/assets/plugins/easyPieChart/jquery.easypiechart.js' },
        { src: '/assets/plugins/chartjs/chart.min.js' },
        { src: '/assets/js/index.js' },
        { src: '/assets/js/main.js' },  
        { src: 'https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js', type:"module" },
      ],
      link: [

        { rel: 'stylesheet', href: '/assets/plugins/simplebar/css/simplebar.css' },
        { rel: 'stylesheet', href: '/assets/css/pace.min.css' },

        { rel: 'stylesheet', href: '/assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css' },

        { rel: 'stylesheet', href: '/assets/plugins/metismenu/css/metisMenu.min.css' },

        { rel: 'stylesheet', href: '/assets/css/bootstrap.min.css' },
        { rel: 'stylesheet', href: '/assets/css/bootstrap-extended.css' },
        { rel: 'stylesheet', href: '/assets/css/style.css' },
        { rel: 'stylesheet', href: '/assets/css/icons.css' },
        { rel: 'preconnect', href: 'https://fonts.googleapis.com' },
        { rel: 'preconnect', href: 'https://fonts.gstatic.com', crossorigin:"" },
        { rel: 'stylesheet', href: 'https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap' },


        { rel: 'stylesheet', href: '/assets/css/dark-theme.css' },
        { rel: 'stylesheet', href: '/assets/css/semi-dark.css' },
        { rel: 'stylesheet', href: '/assets/css/header-colors.css' },

        
      ]
    },
  }
})
