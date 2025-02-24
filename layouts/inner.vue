
<template>
  <!--start wrapper-->
  <div class="wrapper mainwrapper">
    <!--start sidebar -->
    <aside class="sidebar-wrapper" data-simplebar="true" style="background-color:#19257B; overflow-y: auto;">
      <div class="sidebar-header" style="background-color:#19257B;align-items: center;">
        <div>
          <img src="assets/logo.png" class="logo-icon" alt="logo icon" style="filter:unset;width:50px;margin-top:20px;margin-bottom:20px;">
        </div>
        <div class="d-flex align-items-center" style="align-items: center;">
          <p style="color:white" class="mt-4 ms-4">Lang: <select v-model="appLang">
            <option value="fr">French</option>
            <option value="en">English</option>
          </select></p>
        </div>
      </div>
      <!--navigation-->
      <ul class="metismenu" id="menu">
        <li style="color:white">
           {{ permissionsStore.labName }}
        </li>
        <li>
          <NuxtLink to="/home">
            <div class="parent-icon">
              <ion-icon name="home-outline"></ion-icon>
            </div>
            <div class="menu-title"><Translate text="Dashboard"/></div>
          </NuxtLink>
        </li>
        <li v-if="hasPermission('CREATE_PATIENT')||hasPermission('MANAGE_BILLING')||hasPermission('VIEW_PATIENT_PROFILE')">
          <a href="javascript:;" class="has-arrow">
            <div class="parent-icon">
              <ion-icon name="person-circle-outline"></ion-icon>
            </div>
            <div class="menu-title"><Translate text="Patients"/></div>
          </a>
          <ul>
            <li><NuxtLink to="/patients">
              <ion-icon name="ellipse-outline"></ion-icon><Translate text="All Patients"/>
            </NuxtLink></li>
            <li><NuxtLink href="/new/patient">
              <ion-icon name="ellipse-outline"></ion-icon><Translate text="New Patient"/>
            </NuxtLink></li>
          </ul>
        </li>
        <li class="menu-label" v-if="hasPermission('MANAGE_TEST_TYPE') || hasPermission('MANAGE_BILLING')"><Translate text="Laboratory"/></li>
        <li v-if="hasPermission('MANAGE_TEST_TYPE')">
          <a href="javascript:;" class="has-arrow">
            <div class="parent-icon">
              <i class="fadeIn animated bx bx-vial me-1 md"></i>
            </div>
            <div class="menu-title"><Translate text="Tests"/></div>
          </a>
          <ul>
            <li><NuxtLink to="/tests">
              <ion-icon name="ellipse-outline"></ion-icon><Translate text="Registered tests"/>
            </NuxtLink></li>
            <li><NuxtLink to="/testtypes">
              <ion-icon name="ellipse-outline"></ion-icon><Translate text="All test types"/>
            </NuxtLink></li>
            <li><NuxtLink to="/testtype/create">
              <ion-icon name="ellipse-outline"></ion-icon><Translate text="New Test type"/>
            </NuxtLink></li>
            <li><NuxtLink to="/grouptesttype/create">
              <ion-icon name="ellipse-outline"></ion-icon><Translate text="New Group Test type"/>
            </NuxtLink></li>
          </ul>
        </li>
        <li v-if="hasPermission('MANAGE_SPECIMEN_TYPE')">
          <a href="javascript:;" class="has-arrow">
            <div class="parent-icon">
              <i class="fadeIn animated bx bx-donate-blood me-1 md"></i>
            </div>
            <div class="menu-title"><Translate text="Specimens"/></div>
          </a>
          <ul>
            <li><NuxtLink to="/specimens">
              <ion-icon name="ellipse-outline"></ion-icon><Translate text="Registered specimens"/>
            </NuxtLink></li>
            <li><NuxtLink to="/specimentypes">
              <ion-icon name="ellipse-outline"></ion-icon><Translate text="All specimen types"/>
            </NuxtLink></li>
            <li><NuxtLink to="/specimentype/create">
              <ion-icon name="ellipse-outline"></ion-icon><Translate text="New specimen type"/>
            </NuxtLink></li>
          </ul>
        </li>
        <li v-if="hasPermission('MANAGE_BILLING')">
          <a href="javascript:;" class="has-arrow">
            <div class="parent-icon">
              <ion-icon name="ellipse-outline"></ion-icon>
            </div>
            <div class="menu-title"><Translate text="Billing"/></div>
          </a>
          <ul>
            <li><NuxtLink to="/bills">
              <ion-icon name="ellipse-outline"></ion-icon><Translate text="Generated Bills"/>
            </NuxtLink></li>
          </ul>
        </li>
        <li v-if="hasPermission('MANAGE_META') || hasPermission('MANAGE_APP_CONFIG')" class="menu-label"><Translate text="LAB Configuration"/></li>
        <li v-if="hasPermission('MANAGE_META')">
          <a href="javascript:;" class="has-arrow">
            <div class="parent-icon">
              <ion-icon name="ellipse-outline"></ion-icon>
            </div>
            <div class="menu-title"><Translate text="Custom fields (CF)"/></div>
          </a>
          <ul>
            <li><NuxtLink to="/custom-fields/test">
              <ion-icon name="ellipse-outline"></ion-icon><Translate text="Test types CF"/>
            </NuxtLink></li>
            <li><NuxtLink to="/custom-fields/specimen">
              <ion-icon name="ellipse-outline"></ion-icon><Translate text="Specimen CF"/>
            </NuxtLink></li>
            <li><NuxtLink to="/custom-fields/patient">
              <ion-icon name="ellipse-outline"></ion-icon><Translate text="Patient CF"/>
            </NuxtLink></li>
          </ul>
        </li>
        <li v-if="hasPermission('MANAGE_APP_CONFIG')">
          <a href="javascript:;" class="has-arrow">
            <div class="parent-icon">
              <ion-icon name="ellipse-outline"></ion-icon>
            </div>
            <div class="menu-title"><Translate text="Lab Config"/></div>
          </a>
          <ul>
            <li><NuxtLink to="/app-config/data">
              <ion-icon name="ellipse-outline"></ion-icon><Translate text="Parameters"/>
            </NuxtLink></li>
          </ul>
        </li>
        <li v-if="hasPermission('MANAGE_APP_CONFIG')">
          <a href="javascript:;" class="has-arrow">
            <div class="parent-icon">
              <ion-icon name="ellipse-outline"></ion-icon>
            </div>
            <div class="menu-title"><Translate text="Lab Section"/></div>
          </a>
          <ul>
            <li><NuxtLink to="/lab-sections">
              <ion-icon name="ellipse-outline"></ion-icon><Translate text="Lab Sections"/>
            </NuxtLink></li>
            <li><NuxtLink to="/lab-section/create">
              <ion-icon name="ellipse-outline"></ion-icon><Translate text="New Lab Section"/>
            </NuxtLink></li>
          </ul>
        </li>
        <li class="menu-label" v-if="hasPermission('MANAGE_APP_CONFIG')"><Translate text="Access"/></li>
        <li v-if="hasPermission('MANAGE_APP_CONFIG')">
          <a href="javascript:;" class="has-arrow">
            <div class="parent-icon">
              <ion-icon name="ellipse-outline"></ion-icon>
            </div>
            <div class="menu-title"><Translate text="User accounts"/></div>
          </a>
          <ul>
            <li><NuxtLink to="/accounts">
              <ion-icon name="ellipse-outline"></ion-icon><Translate text="All accounts"/>
            </NuxtLink></li>
            <li><NuxtLink to="/accounts/create">
              <ion-icon name="ellipse-outline"></ion-icon><Translate text="New Account"/>
            </NuxtLink></li>
          </ul>
        </li>
        <li class="menu-label" v-if="hasPermission('MANAGE_APP_CONFIG')"><Translate text="Advanced"/></li>
        <li v-if="hasPermission('MANAGE_APP_CONFIG')">
          <a href="javascript:;" class="has-arrow">
            <div class="parent-icon">
              <ion-icon name="ellipse-outline"></ion-icon>
            </div>
            <div class="menu-title"><Translate text="Database operations"/></div>
          </a>
          <ul>
            <li><NuxtLink :to="baseUrl+'/export-database'">
              <ion-icon name="ellipse-outline"></ion-icon><Translate text="Export database"/>
            </NuxtLink></li>
          </ul>
        </li>
      </ul>
      <!--end navigation-->
    </aside>
    <!--end sidebar -->
    <!--start top header-->
    <header class="top-header">
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
          </ul>
        </div>
      </nav>
    </header>
    <!--end top header-->
    <!-- start page content wrapper-->
    <div class="page-content-wrapper">
      <!-- start page content-->
      <div class="page-content">
        <slot />
      </div>
      <!-- end page content-->
    </div>
    <!--end page content wrapper-->
    <!--start footer-->
    <footer class="footer">
      <div class="footer-text">
        <Translate text="Copyright © 2024. All right reserved."/>
      </div>
    </footer>
    <!--end footer-->
    <!--Start Back To Top Button-->
    <a href="javaScript:;" class="back-to-top">
      <ion-icon name="arrow-up-outline"></ion-icon>
    </a>
    <!--End Back To Top Button-->
    <!--start overlay-->
    <div class="overlay nav-toggle-icon"></div>
    <!--end overlay-->
  </div>
  <!--end wrapper-->
</template>

<script>
import { useMyPermissionsStore } from '@/stores/permissions'
  export default {
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
        console.log("Load script");

        var s=[{src:'/assets/js/form-date-time-pickes.js'},
        { src: '/assets/js/table-datatable.js' },  

        {src:'/assets/plugins/select2/js/select2-custom.js'},
        { src: '/assets/js/main.js' },  
      
      ];

      for(var i=0;i<s.length;i++){

        var elementToRemove = document.getElementById("script_"+i);

          // Check if the element exists before attempting to remove it
          if (elementToRemove) {
              // Find the parent node of the element
              var parentElement = elementToRemove.parentNode;

              // Remove the element from its parent
              parentElement.removeChild(elementToRemove);
          }

        // Load your script here
        const script = document.createElement('script');
        script.id="script_"+i;
        script.src = s[i].src;
        script.async = true;
        document.body.appendChild(script);
      }
      
      }
    }
  }
</script>