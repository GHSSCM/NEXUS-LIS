// https://nuxt.com/docs/api/configuration/nuxt-config
export default defineNuxtConfig({

  devtools: { enabled: false },

  plugins: [
    {src:'~/plugins/vuemultiselect.js',ssr:false},
    { src: '~/plugins/tinymce.js', mode: 'client' }
  ],

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
        
        { src: '/assets/js/pace.min.js' },
        { src: '/assets/js/jquery.min.js' },
        { src: '/assets/plugins/metismenu/js/metisMenu.min.js' },
        { src: '/assets/js/bootstrap.bundle.min.js' },
        { src: '/assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js' },
        { src: '/assets/js/custom.js' },
        // { src: '/assets/plugins/simplebar/js/simplebar.min.js' },
        // { src: '/assets/plugins/apexcharts-bundle/js/apexcharts.min.js' },
        // { src: '/assets/plugins/easyPieChart/jquery.easypiechart.js' },
        // { src: '/assets/plugins/chartjs/chart.min.js' },
        // { src: '/assets/js/index.js' },
    
        { src: 'https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js', type:"module" },



        //datatables
        { src: '/assets/plugins/datatable/js/jquery.dataTables.min.js' },  
        { src: '/assets/plugins/datatable/js/dataTables.bootstrap5.min.js' },  
     
        {src:'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js'},
        


        {src:'/assets/plugins/datetimepicker/js/legacy.js'},
        {src:'/assets/plugins/datetimepicker/js/picker.js'},
        {src:'/assets/plugins/datetimepicker/js/picker.time.js'},
        {src:'/assets/plugins/datetimepicker/js/picker.date.js'},
        {src:'/assets/plugins/datetimepicker/js/picker.time.js'},
        {src:'/assets/plugins/bootstrap-material-datetimepicker/js/moment.min.js'},
        {src:'/assets/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.min.js'},
       


        {src:'/assets/js/component-popovers-tooltips.js'},
        {src:'/assets/plugins/notifications/js/lobibox.min.js'},


        {src:'/assets/plugins/tinymce/tinymce.min.js'},
        {src:'/assets/plugins/tinymce/themes/silver/theme.min.js'},
        {src:'/assets/plugins/tinymce/icons/default/icons.min.js'},
        {src:'/assets/plugins/tinymce/plugins/autolink/plugin.min.js'},
        {src:'/assets/plugins/tinymce/plugins/lists/plugin.min.js'},
        {src:'/assets/plugins/tinymce/plugins/link/plugin.min.js'},
        {src:'/assets/plugins/tinymce/plugins/image/plugin.min.js'},
        {src:'/assets/plugins/tinymce/plugins/media/plugin.min.js'},
        {src:'/assets/plugins/tinymce/plugins/table/plugin.min.js'},
        {src:'/assets/plugins/tinymce/plugins/code/plugin.min.js'}

        
      
      ],
      link: [

  
        { rel: 'stylesheet', href: '/assets/css/pace.min.css' },

        { rel: 'stylesheet', href: '/assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css' },
        { rel: 'stylesheet', href: '/assets/plugins/simplebar/css/simplebar.css' },
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

        { rel: 'stylesheet', href:'/assets/plugins/datatable/css/dataTables.bootstrap5.min.css' },  
        
        { rel: 'stylesheet',href:'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css'},
        { rel: 'stylesheet',href:'https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css'},
        


        { rel: 'stylesheet', href:'/assets/plugins/datetimepicker/css/classic.css' },
        { rel: 'stylesheet', href:'/assets/plugins/datetimepicker/css/classic.time.css' },
        { rel: 'stylesheet', href:'/assets/plugins/datetimepicker/css/classic.date.css' },
        { rel: 'stylesheet', href:'/assets/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.min.css' },

        { rel: 'stylesheet', href:'https://fonts.googleapis.com/icon?family=Material+Icons' },
        
        {rel:'stylesheet',href:'/assets/plugins/others/vue-multiselect.css'},

        {rel:'stylesheet',href:'/assets/plugins/notifications/css/lobibox.min.css'},

        { rel: 'stylesheet', href: '/assets/css/nexus.css' },

        { rel: 'stylesheet', href: 'cropperjs/dist/cropper.css' },
      ]
    },
  },

  compatibilityDate: '2025-02-23',
  modules: ['@pinia/nuxt', '@nuxtjs/i18n'],
  //,'@nuxtjs/i18n'
  pinia: {
    storesDirs: ['./stores/**'],
  },
  i18n: {
    locales: [
      { code: 'en', name: 'English', file: 'en.json' },
      { code: 'fr', name: 'Français', file: 'fr.json' }
    ],
    defaultLocale: 'en',
    strategy: "no_prefix",

    // lazy: true,
    langDir: './locales/',
    // vueI18n: {
    //   legacy: false,
    //   locale: 'en'
    // }
  }
})