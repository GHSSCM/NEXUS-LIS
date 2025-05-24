<template>
     <header class="top-header" :style="{background:bg??'white'}">
      <nav class="navbar navbar-expand gap-3">
        <div class="toggle-icon">
          <ion-icon name="menu-outline"></ion-icon>
        </div>
        <form class="searchbar">
          <div class="position-absolute top-50 translate-middle-y search-icon ms-3">
            <ion-icon name="search-outline"></ion-icon>
          </div>
          <input class="form-control" type="text" placeholder="Search for anything">
          <div class="position-absolute top-50 translate-middle-y search-close-icon">
            <ion-icon name="close-outline"></ion-icon>
          </div>
        </form>
        <div class="top-navbar-right ms-auto">
          <ul class="navbar-nav align-items-center">

      

            <!-- choose service-->

            <li class="nav-item dropdown dropdown-large dropdown-apps">
              <a class="nav-link dropdown-toggle dropdown-toggle-nocaret" href="javascript:;" data-bs-toggle="dropdown" aria-expanded="false">
                <div class="">
                  <ion-icon name="apps-outline" role="img" class="md hydrated" aria-label="apps outline"></ion-icon>
                </div>
              </a>
              <div class="dropdown-menu dropdown-menu-end">
                  <ServiceListHeader/>
              </div>
            </li>


            <!-- end choose service -->

            <!-- start profile -->

            <li class="nav-item dropdown dropdown-user-setting">
              <a class="nav-link dropdown-toggle dropdown-toggle-nocaret" href="javascript:;" data-bs-toggle="dropdown">
                <div class="user-setting">
                  <img src="assets/images/avatars/06.png" class="user-img" alt="">
                </div>
              </a>
              <ul class="dropdown-menu dropdown-menu-end">
                <li>
                  <a class="dropdown-item" href="javascript:;">
                    <div class="d-flex flex-row align-items-center gap-2">
                      <img src="assets/images/avatars/06.png" alt="" class="rounded-circle" width="54" height="54">
                      <div class="">
                        <h6 class="mb-0 dropdown-user-name" v-if="user">{{user.name.split(" ")[0]}}</h6>
                        <small class="mb-0 dropdown-user-designation text-secondary" v-if="lab">{{lab}}</small>
                      </div>
                    </div>
                  </a>
                </li>
                <li>
                  <hr class="dropdown-divider">
                </li>
                <li>
                  <NuxtLink v-if="user" class="dropdown-item" :to="'/accounts/'+user.id">
                    <div class="d-flex align-items-center">
                      <div class="">
                        <ion-icon name="person-outline"></ion-icon>
                      </div>
                      <div class="ms-3"><span><Translate text="Profile"/></span></div>
                    </div>
                  </NuxtLink>
                </li>
                <li>
                  <hr class="dropdown-divider">
                </li>
                <li>
                  <a class="dropdown-item" href="javascript:;" @click="logOut">
                    <div class="d-flex align-items-center">
                      <div class="">
                        <ion-icon name="log-out-outline"></ion-icon>
                      </div>
                      <div class="ms-3"><span><Translate text="Logout"/></span></div>
                    </div>
                  </a>
                </li>
              </ul>
            </li>

            <!-- end profile -->


                  <!-- Start choose language -->

            <li class="dropdown">
                <a class="nav-link dropdown-toggle arrow-none" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                    <span class="align-middle d-none d-lg-inline-block fs-6">{{appLang=='fr'?'French':'English'}}</span>
                    <span class="mdi mdi-chevron-down fs-12 d-none d-sm-inline-block align-middle"></span>

                </a>
                <div class="dropdown-menu dropdown-menu-end dropdown-menu-animated" style="">

                    <!-- item-->
                    <a href="javascript:void(0);" class="dropdown-item" @click="appLang = appLang=='fr'?'en':'fr'">
                         <span class="align-middle">{{appLang=='fr'?'English':'French'}}</span>
                    </a>

                </div>
            </li>
            

            <!-- End choose language -->
          </ul>
        </div>
      </nav>
    </header>
</template>


<script>
import { useMyPermissionsStore } from '@/stores/permissions'
  export default {
    props:["bg"],
    setup () {
    const permissionsStore = useMyPermissionsStore()
    permissionsStore.loadPermissions()
    useHead({
      bodyAttrs: {
        class: 'bg-white'
      },
      htmlAttrs:{
        class: 'semi-dark'
      }
    })
    const { locale,setLocale } = useI18n();
    locale.value = getUserLang();
    setLocale( getUserLang());
    
    const appLang = ref(locale.value);
    
    watch(appLang, (newLang) => {
      console.log("setting language to "+newLang)
      
      setUserLang(newLang);
    });

   
    return {
      permissionsStore,
      appLang
    }
  },
  data(){
    return {
      user:window?(window.localStorage.getItem("user")?JSON.parse(window.localStorage.getItem("user")):null):null,
      lab:window?window.localStorage.getItem("lab_ref"):null,
      baseUrl:getBaseUrl()
    }
  },
    mounted() {

      // if(this.permissionsStore.loadedPermissions){
      //     // this.loadScript();
      // }else{
        this.permissionsStore.checkAfterLoad.push({
          func:this.loadScript
        })
      // }
      if(window.localStorage.getItem("user")==null){
        window.location.href=("/login")
      }
    },
    methods: {
      logOut(){
          window.localStorage.removeItem("user");
          window.localStorage.removeItem("lab_ref");
          this.$router.push("/login");
      },
      loadScript() {
 
      }
    }
  }
</script>


<style>

</style>