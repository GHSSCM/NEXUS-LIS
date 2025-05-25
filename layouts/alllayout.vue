
<!-- https://codervent.com/fobia/index.html?storefront=envato-elements -->
 <!-- https://elements.envato.com/fobia-bootstrap5-admin-template-SRGGDJ5 -->
<template>
  <!--start wrapper-->
  <div class="wrapper mainwrapper">
    <!--start sidebar -->
    <aside class="sidebar-wrapper" data-simplebar="true" style="background: linear-gradient(135deg, rgba(26, 88, 162, 1.0), rgb(2 100 125)); overflow-y: auto;  background: rgba(26, 88, 162, 1.0);
    background: linear-gradient(135deg, rgba(26, 88, 162, 1.0), rgba(26, 88, 162, 1.0));border:none; ">
      <div class="sidebar-header" style="align-items: center; background-color: transparent; ">
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
            <div class="menu-title"><Translate text="Nexus Lab"/></div>
          </NuxtLink>
        </li>
        <li v-if="hasPermission('PATIENT.CREATE_PATIENT')||hasPermission('LABORATORY.MANAGE_BILLING')||hasPermission('PATIENT.VIEW_PATIENT_PROFILE')">
          <a href="javascript:;" class="has-arrow">
            <div class="parent-icon">
              <ion-icon name="person-circle-outline"></ion-icon>
            </div>
            <div class="menu-title"><Translate text="Patients"/></div>
          </a>
          <ul>
            <li><NuxtLink to="/nexus.patients/patients">
              <ion-icon name="ellipse-outline"></ion-icon><Translate text="All Patients"/>
            </NuxtLink></li>
            <li><NuxtLink href="/nexus.patients/new/patient">
              <ion-icon name="ellipse-outline"></ion-icon><Translate text="New Patient"/>
            </NuxtLink></li>
          </ul>
        </li>
        <li class="menu-label" v-if="hasPermission('LABORATORY.MANAGE_TEST_TYPE') || hasPermission('LABORATORY.MANAGE_BILLING')"><Translate text="Laboratory"/></li>
        <li v-if="hasPermission('LABORATORY.MANAGE_TEST_TYPE')">
          <a href="javascript:;" class="has-arrow">
            <div class="parent-icon">
              <i class="fadeIn animated bx bx-vial me-1 md"></i>
            </div>
            <div class="menu-title"><Translate text="Tests"/></div>
          </a>
          <ul>
            <li><NuxtLink to="/nexus.lab/tests">
              <ion-icon name="ellipse-outline"></ion-icon><Translate text="Registered tests"/>
            </NuxtLink></li>
            <li><NuxtLink to="/nexus.lab/testtypes">
              <ion-icon name="ellipse-outline"></ion-icon><Translate text="All test types"/>
            </NuxtLink></li>
            <li><NuxtLink to="/nexus.lab/testtype/create">
              <ion-icon name="ellipse-outline"></ion-icon><Translate text="New Test type"/>
            </NuxtLink></li>
            <li><NuxtLink to="/nexus.lab/grouptesttype/create">
              <ion-icon name="ellipse-outline"></ion-icon><Translate text="New Group Test type"/>
            </NuxtLink></li>
          </ul>
        </li>
        <li v-if="hasPermission('LABORATORY.MANAGE_SPECIMEN_TYPE')">
          <a href="javascript:;" class="has-arrow">
            <div class="parent-icon">
              <i class="fadeIn animated bx bx-donate-blood me-1 md"></i>
            </div>
            <div class="menu-title"><Translate text="Specimens"/></div>
          </a>
          <ul>
            <li><NuxtLink to="/nexus.lab/specimens">
              <ion-icon name="ellipse-outline"></ion-icon><Translate text="Registered specimens"/>
            </NuxtLink></li>
            <li><NuxtLink to="/nexus.lab/specimentypes">
              <ion-icon name="ellipse-outline"></ion-icon><Translate text="All specimen types"/>
            </NuxtLink></li>
            <li><NuxtLink to="/nexus.lab/specimentype/create">
              <ion-icon name="ellipse-outline"></ion-icon><Translate text="New specimen type"/>
            </NuxtLink></li>
          </ul>
        </li>
        <li v-if="hasPermission('LABORATORY.MANAGE_BILLING')">
          <a href="javascript:;" class="has-arrow">
            <div class="parent-icon">
              <ion-icon name="ellipse-outline"></ion-icon>
            </div>
            <div class="menu-title"><Translate text="Billing"/></div>
          </a>
          <ul>
            <li><NuxtLink to="/nexus.lab/bills">
              <ion-icon name="ellipse-outline"></ion-icon><Translate text="Generated Bills"/>
            </NuxtLink></li>
          </ul>
        </li>
        <li v-if="hasPermission('CONFIGURATION.MANAGE_META') || hasPermission('CONFIGURATION.MANAGE_APP_CONFIG')" class="menu-label"><Translate text="LAB Configuration"/></li>
        <li v-if="hasPermission('CONFIGURATION.MANAGE_META')">
          <a href="javascript:;" class="has-arrow">
            <div class="parent-icon">
              <ion-icon name="ellipse-outline"></ion-icon>
            </div>
            <div class="menu-title"><Translate text="Custom fields (CF)"/></div>
          </a>
          <ul>
            <li><NuxtLink to="/nexus.config/custom-fields/test">
              <ion-icon name="ellipse-outline"></ion-icon><Translate text="Test types CF"/>
            </NuxtLink></li>
            <li><NuxtLink to="/nexus.config/custom-fields/specimen">
              <ion-icon name="ellipse-outline"></ion-icon><Translate text="Specimen CF"/>
            </NuxtLink></li>
            <li><NuxtLink to="/nexus.config/custom-fields/patient">
              <ion-icon name="ellipse-outline"></ion-icon><Translate text="Patient CF"/>
            </NuxtLink></li>
          </ul>
        </li>
        <li v-if="hasPermission('CONFIGURATION.MANAGE_APP_CONFIG')">
          <a href="javascript:;" class="has-arrow">
            <div class="parent-icon">
              <ion-icon name="ellipse-outline"></ion-icon>
            </div>
            <div class="menu-title"><Translate text="Lab Config"/></div>
          </a>
          <ul>
            <li><NuxtLink to="/nexus.config">
              <ion-icon name="ellipse-outline"></ion-icon><Translate text="Parameters"/>
            </NuxtLink></li>
          </ul>
        </li>
        <li v-if="hasPermission('CONFIGURATION.MANAGE_APP_CONFIG')">
          <a href="javascript:;" class="has-arrow">
            <div class="parent-icon">
              <ion-icon name="ellipse-outline"></ion-icon>
            </div>
            <div class="menu-title"><Translate text="Lab Section"/></div>
          </a>
          <ul>
            <li><NuxtLink to="/nexus.lab/lab-sections">
              <ion-icon name="ellipse-outline"></ion-icon><Translate text="Lab Sections"/>
            </NuxtLink></li>
            <li><NuxtLink to="/nexus.lab/lab-section/create">
              <ion-icon name="ellipse-outline"></ion-icon><Translate text="New Lab Section"/>
            </NuxtLink></li>
          </ul>
        </li>
        <li class="menu-label" v-if="hasPermission('CONFIGURATION.MANAGE_APP_CONFIG')"><Translate text="Access"/></li>
        <li v-if="hasPermission('CONFIGURATION.MANAGE_APP_CONFIG')">
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
        <li class="menu-label" v-if="hasPermission('CONFIGURATION.MANAGE_APP_CONFIG')"><Translate text="Advanced"/></li>
        <li v-if="hasPermission('CONFIGURATION.MANAGE_APP_CONFIG')">
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
    <Header></Header>
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
    <br/>
    <br/>
    <footer class="footer ">
      <div class="footer-text">
       <p>Powered By <strong><a href="https://healthbridge.cloud" target="_blank">HealthBridge</a></strong></p>
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

<!-- v-if="permissionsStore.showManual" -->
    <div class="manual-cover" >
    </div>

    <div class="manual" >
      <div style="float:right">

        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24"><path fill="currentColor" d="m12 13.4l-4.9 4.9q-.275.275-.7.275t-.7-.275t-.275-.7t.275-.7l4.9-4.9l-4.9-4.9q-.275-.275-.275-.7t.275-.7t.7-.275t.7.275l4.9 4.9l4.9-4.9q.275-.275.7-.275t.7.275t.275.7t-.275.7L13.4 12l4.9 4.9q.275.275.275.7t-.275.7t-.7.275t-.7-.275z"/></svg>
      </div>
      <br/>
      <div style="font-family: Arial, sans-serif; line-height: 1.6;">
  <h2 style="color: #2c3e50;">How to Create a Patient Record in the HIS</h2>
  <p>
    This guide will walk you through the process of adding a new patient to our Hospital Information System (HIS). Follow the steps below to ensure that all necessary information is captured correctly.
  </p>

  <h3 style="color: #34495e;">Step 1: Log In to the HIS</h3>
  <p>
    Use your assigned credentials to log in to the system. Once logged in, you will see the main dashboard.
  </p>

  <h3 style="color: #34495e;">Step 2: Navigate to the Patients Module</h3>
  <p>
    From the main dashboard, locate the sidebar menu and click on the <strong>Patients</strong> module to view existing patient records.
  </p>

  <h3 style="color: #34495e;">Step 3: Add a New Patient</h3>
  <ol>
    <li>
      Click on the <em>Add New Patient</em> button found at the top-right corner of the Patients page.
    </li>
    <li>
      Fill out the patient registration form. Ensure you provide accurate and complete details, including:
      <ul>
        <li><strong>Full Name</strong> – Enter the patient’s complete name.</li>
        <li><strong>Date of Birth</strong> – Use the calendar picker to select the correct date.</li>
        <li><strong>Contact Information</strong> – Provide a valid phone number and email address.</li>
        <li><strong>Address</strong> – Input the current residential address.</li>
        <li><strong>Medical History</strong> – Optionally include any relevant past medical conditions or allergies.</li>
      </ul>
    </li>
    <li>
      After filling in the form, review the information carefully and then click the <strong>Save</strong> button to create the new patient record.
    </li>
  </ol>

  <h3 style="color: #34495e;">Step 4: Verify the Patient Record</h3>
  <p>
    Once saved, the new patient record will appear in the Patients list. Verify that all details are correct and update any information if necessary.
  </p>

  <h3 style="color: #34495e;">Troubleshooting Tips</h3>
  <ul>
    <li>If the record does not appear, try refreshing the page.</li>
    <li>Double-check that all required fields in the registration form are completed.</li>
    <li>Contact IT support if you continue to experience issues with patient creation.</li>
  </ul>

  <p>
    For additional help or detailed instructions, refer to the full user manual or contact your system administrator.
  </p>
</div>

    </div>
  </div>
  <!--end wrapper-->
</template>

<script>
import { useMyPermissionsStore } from '@/stores/permissions'
  export default {
    setup () {
    const permissionsStore = useMyPermissionsStore()
    permissionsStore.loadPermissions()
    const serviceStore = useMyServicesStore()
    serviceStore.loadServices()
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
      appLang,
      serviceStore
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

        this.serviceStore.checkAfterLoad.push({
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

<style>
.manual{
  display: none;
  width:30%;
  max-width:600px;
  height:100vh;
  position:fixed;
  right:0;
  top:0;
  bottom:0;
  background:white;
  box-shadow: 0px 0px 0px rgba(0,0,0,0.1);
  z-index:99;
  padding:20px;
  overflow-y: auto;
}
.manual-cover{
  display: none;
  position:fixed;
  top:0;
  left:0;
  right:0;
  bottom:0;
  height:100vh;
  width:100vw;
  background-color:rgba(0,0,0,0.3);
  z-index:90;
}
</style>