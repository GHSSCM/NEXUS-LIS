
<template>

  
      <!--start wrapper-->
      <div class="wrapper mainwrapper">
        <!-- <div id="mainloaderwrapper" class="d-flex flex-column align-items-center justify-content-center" style="height:100vh;width:100vw;position:fixed;top:0;bottom:0;left:0;right:0;background-color:rgba(0,0,0,0.1);z-index:9999999;">
          <div class="spinner-border text-primary" role="status"> <span class="visually-hidden">Loading...</span>
          </div>
        </div> -->
        <!--start sidebar -->
        <aside class="sidebar-wrapper" data-simplebar="true" style="background-color:#19257B">
          <div class="sidebar-header" style="background-color:#19257B">
            <div>
              <img src="assets/logo.png" class="logo-icon" alt="logo icon" style="filter:unset;width:50px;margin-top:20px;margin-bottom:20px;">
            </div>
            <div>
              <!-- <h4 class="logo-text">Fobia</h4> -->
            </div>
          </div>
          <!--navigation-->
          <ul class="metismenu" id="menu">
            <!-- <li>
              <NuxtLink to="/home">
                <div class="parent-icon">
                  <ion-icon name="home-outline"></ion-icon>
                </div>
                <div class="menu-title">Home</div>
              </NuxtLink>
            </li> -->
            <li>
              <a href="javascript:;" class="has-arrow">
                <div class="parent-icon">
                  <ion-icon name="person-circle-outline"></ion-icon>
                </div>
                <div class="menu-title">Patients</div>
              </a>
              <ul>
                <li><NuxtLink to="/patients">
                    <ion-icon name="ellipse-outline"></ion-icon>All Patients
                  </NuxtLink>
                </li>

                <li><NuxtLink href="/new/patient">
                  <ion-icon name="ellipse-outline"></ion-icon>New Patient
                </NuxtLink>
              </li>

                <!-- <li><NuxtLink href="/new/addspecimen">
                    <ion-icon name="ellipse-outline"></ion-icon>Register Specimens
                  </NuxtLink>
                </li> -->

             
              </ul>
            </li>
            <li class="menu-label">Laboratory </li>
            <li>
              <a href="javascript:;" class="has-arrow">
                <div class="parent-icon">
                  
                  <i class="fadeIn animated bx bx-vial me-1 md "></i>

                </div>
                <div class="menu-title">Tests</div>
              </a>
              <ul>
                
                <li> <NuxtLink to="/tests">
                  <ion-icon name="ellipse-outline"></ion-icon>
                    Registered tests
                </NuxtLink>
              </li>
                <li> <NuxtLink to="/testtypes">
                    <ion-icon name="ellipse-outline"></ion-icon>All test types
                  </NuxtLink>
                </li>
                <li> <NuxtLink to="/testtype/create">
                    <ion-icon name="ellipse-outline"></ion-icon>New Test type
                  </NuxtLink>
                </li>
                <li> <NuxtLink to="/grouptesttype/create">
                    <ion-icon name="ellipse-outline"></ion-icon>New Group Test type
                  </NuxtLink>
                </li>
              </ul>
            </li>

            <li>
              <a href="javascript:;" class="has-arrow">
                <div class="parent-icon">
                  <i class="fadeIn animated bx bx-donate-blood me-1 md "></i>
                </div>
                <div class="menu-title">Specimens</div>
              </a>
              <ul>
                <li> <NuxtLink to="/specimens">
                  <ion-icon name="ellipse-outline"></ion-icon>
                 

                  Registered specimens
                </NuxtLink>
              </li>
                <li> <NuxtLink to="/specimentypes">
                    <ion-icon name="ellipse-outline"></ion-icon>
                   

                    All specimen types
                  </NuxtLink>
                </li>
                <li> <NuxtLink to="/specimentype/create">
                    <ion-icon name="ellipse-outline"></ion-icon>New specimen type
                  </NuxtLink>
                </li>
              </ul>
            </li>
    
    
            <li class="menu-label">LAB Configuration </li>
        

            <li>
              <a href="javascript:;" class="has-arrow">
                <div class="parent-icon">
                  
                  <ion-icon name="ellipse-outline"></ion-icon>

                </div>
                <div class="menu-title">Custom fields (CF)</div>
              </a>
              <ul>
                <li> <NuxtLink to="/custom-fields/test">
                    <ion-icon name="ellipse-outline"></ion-icon>Test types CF
                  </NuxtLink>
                </li>
                <li> <NuxtLink to="/custom-fields/specimen">
                    <ion-icon name="ellipse-outline"></ion-icon>Specimen CF
                  </NuxtLink>
                </li>

                <li> <NuxtLink to="/custom-fields/patient">
                  <ion-icon name="ellipse-outline"></ion-icon>Patient CF
                </NuxtLink>
              </li>
              </ul>
            </li>

            <li>
              <a href="javascript:;" class="has-arrow">
                <div class="parent-icon">
                  
                  <ion-icon name="ellipse-outline"></ion-icon>

                </div>
                <div class="menu-title">App Config</div>
              </a>
              <ul>
                <li> <NuxtLink to="/app-config/data">
                    <ion-icon name="ellipse-outline"></ion-icon>Parameters
                  </NuxtLink>
                </li>
              </ul>
            </li>



            <li class="menu-label">Access </li>
        

            <li>
              <a href="javascript:;" class="has-arrow">
                <div class="parent-icon">
                  
                  <ion-icon name="ellipse-outline"></ion-icon>

                </div>
                <div class="menu-title">User accounts</div>
              </a>
              <ul>
                <li> <NuxtLink to="/accounts">
                    <ion-icon name="ellipse-outline"></ion-icon>All accounts
                  </NuxtLink>
                </li>
                <li> <NuxtLink to="/accounts/create">
                    <ion-icon name="ellipse-outline"></ion-icon>New Account
                  </NuxtLink>
                </li>

               
              </ul>
            </li>


            <li class="menu-label">Advanced </li>
        

            <li>
              <a href="javascript:;" class="has-arrow">
                <div class="parent-icon">
                  
                  <ion-icon name="ellipse-outline"></ion-icon>

                </div>
                <div class="menu-title">Database operations</div>
              </a>
              <ul>
                <li> <NuxtLink :to="baseUrl+'/export-database'">
                    <ion-icon name="ellipse-outline"></ion-icon>Export database
                  </NuxtLink>
                </li>
            
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
                <!-- <li class="nav-item">
                  <a class="nav-link mobile-search-button" href="javascript:;">
                    <div class="">
                      <ion-icon name="search-outline"></ion-icon>
                    </div>
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link dark-mode-icon" href="javascript:;">
                    <div class="mode-icon">
                      <ion-icon name="moon-outline"></ion-icon>
                    </div>
                  </a>
                </li> 
                <li class="nav-item dropdown dropdown-large dropdown-apps">
                  <a class="nav-link dropdown-toggle dropdown-toggle-nocaret" href="javascript:;" data-bs-toggle="dropdown">
                    <div class="">
                      <ion-icon name="apps-outline"></ion-icon>
                    </div>
                  </a>
                  <div class="dropdown-menu dropdown-menu-end dropdown-menu-dark">
                    <div class="row row-cols-3 g-3 p-3">
                      <div class="col text-center">
                        <div class="app-box mx-auto bg-gradient-purple text-white">
                          <ion-icon name="cart-outline"></ion-icon>
                        </div>
                        <div class="app-title">Orders</div>
                      </div>
                      <div class="col text-center">
                        <div class="app-box mx-auto bg-gradient-info text-white">
                          <ion-icon name="people-outline"></ion-icon>
                        </div>
                        <div class="app-title">Teams</div>
                      </div>
                      <div class="col text-center">
                        <div class="app-box mx-auto bg-gradient-success text-white">
                          <ion-icon name="shield-checkmark-outline"></ion-icon>
                        </div>
                        <div class="app-title">Tasks</div>
                      </div>
                      <div class="col text-center">
                        <div class="app-box mx-auto bg-gradient-danger text-white">
                          <ion-icon name="videocam-outline"></ion-icon>
                        </div>
                        <div class="app-title">Media</div>
                      </div>
                      <div class="col text-center">
                        <div class="app-box mx-auto bg-gradient-warning text-white">
                          <ion-icon name="file-tray-outline"></ion-icon>
                        </div>
                        <div class="app-title">Files</div>
                      </div>
                      <div class="col text-center">
                        <div class="app-box mx-auto bg-gradient-branding text-white">
                          <ion-icon name="notifications-outline"></ion-icon>
                        </div>
                        <div class="app-title">Alerts</div>
                      </div>
                    </div>
                  </div>
                </li>-->
                <li class="nav-item dropdown dropdown-large d-none">
                  <a class="nav-link dropdown-toggle dropdown-toggle-nocaret" href="javascript:;" data-bs-toggle="dropdown">
                    <div class="position-relative">
                      <span class="notify-badge">1</span>
                      <ion-icon name="notifications-outline"></ion-icon>
                    </div>
                  </a>
                  <div class="dropdown-menu dropdown-menu-end">
                    <a href="javascript:;">
                      <div class="msg-header">
                        <p class="msg-header-title">Notifications</p>
                        <p class="msg-header-clear ms-auto">Marks all as read</p>
                      </div>
                    </a>
                    <div class="header-notifications-list">
                      <a class="dropdown-item" href="javascript:;">
                        <div class="d-flex align-items-center">
                          <div class="notify text-primary">
                            <i class="fadeIn animated bx bx-dna"></i>
                          </div>
                          <div class="flex-grow-1">
                            <h6 class="msg-name">New Sample <span class="msg-time float-end">2 min
                                ago</span></h6>
                            <p class="msg-info">Something present here</p>
                          </div>
                        </div>
                      </a>
                      <!-- <a class="dropdown-item" href="javascript:;">
                        <div class="d-flex align-items-center">
                          <div class="notify text-danger">
                            <ion-icon name="person-outline"></ion-icon>
                          </div>
                          <div class="flex-grow-1">
                            <h6 class="msg-name">New Customers<span class="msg-time float-end">14 Sec
                                ago</span></h6>
                            <p class="msg-info">5 new user registered</p>
                          </div>
                        </div>
                      </a>
                      <a class="dropdown-item" href="javascript:;">
                        <div class="d-flex align-items-center">
                          <div class="notify text-success">
                            <ion-icon name="document-outline"></ion-icon>
                          </div>
                          <div class="flex-grow-1">
                            <h6 class="msg-name">24 PDF File<span class="msg-time float-end">19 min
                                ago</span></h6>
                            <p class="msg-info">The pdf files generated</p>
                          </div>
                        </div>
                      </a>
    
                      <a class="dropdown-item" href="javascript:;">
                        <div class="d-flex align-items-center">
                          <div class="notify text-info">
                            <ion-icon name="checkmark-done-outline"></ion-icon>
                          </div>
                          <div class="flex-grow-1">
                            <h6 class="msg-name">New Product Approved <span class="msg-time float-end">2 hrs ago</span></h6>
                            <p class="msg-info">Your new product has approved</p>
                          </div>
                        </div>
                      </a>
                      <a class="dropdown-item" href="javascript:;">
                        <div class="d-flex align-items-center">
                          <div class="notify text-warning">
                            <ion-icon name="send-outline"></ion-icon>
                          </div>
                          <div class="flex-grow-1">
                            <h6 class="msg-name">Time Response <span class="msg-time float-end">28 min
                                ago</span></h6>
                            <p class="msg-info">5.1 min avarage time response</p>
                          </div>
                        </div>
                      </a>
                      <a class="dropdown-item" href="javascript:;">
                        <div class="d-flex align-items-center">
                          <div class="notify text-danger">
                            <ion-icon name="chatbox-ellipses-outline"></ion-icon>
                          </div>
                          <div class="flex-grow-1">
                            <h6 class="msg-name">New Comments <span class="msg-time float-end">4 hrs
                                ago</span></h6>
                            <p class="msg-info">New customer comments recived</p>
                          </div>
                        </div>
                      </a>
                      <a class="dropdown-item" href="javascript:;">
                        <div class="d-flex align-items-center">
                          <div class="notify text-primary">
                            <ion-icon name="albums-outline"></ion-icon>
                          </div>
                          <div class="flex-grow-1">
                            <h6 class="msg-name">New 24 authors<span class="msg-time float-end">1 day
                                ago</span></h6>
                            <p class="msg-info">24 new authors joined last week</p>
                          </div>
                        </div>
                      </a>
                      <a class="dropdown-item" href="javascript:;">
                        <div class="d-flex align-items-center">
                          <div class="notify text-success">
                            <ion-icon name="shield-outline"></ion-icon>
                          </div>
                          <div class="flex-grow-1">
                            <h6 class="msg-name">Your item is shipped <span class="msg-time float-end">5 hrs
                                ago</span></h6>
                            <p class="msg-info">Successfully shipped your item</p>
                          </div>
                        </div>
                      </a>
                      <a class="dropdown-item" href="javascript:;">
                        <div class="d-flex align-items-center">
                          <div class="notify text-warning">
                            <ion-icon name="cafe-outline"></ion-icon>
                          </div>
                          <div class="flex-grow-1">
                            <h6 class="msg-name">Defense Alerts <span class="msg-time float-end">2 weeks
                                ago</span></h6>
                            <p class="msg-info">45% less alerts last 4 weeks</p>
                          </div>
                        </div>
                      </a> -->
                    </div>
                    <a href="javascript:;">
                      <div class="text-center msg-footer">View All Notifications</div>
                    </a>
                  </div>
                </li>
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
                          <div class="ms-3"><span>Profile</span></div>
                        </div>
                      </NuxtLink>
                    </li>
                    <!--  <li>
                      <a class="dropdown-item" href="javascript:;">
                        <div class="d-flex align-items-center">
                          <div class="">
                            <ion-icon name="settings-outline"></ion-icon>
                          </div>
                          <div class="ms-3"><span>Setting</span></div>
                        </div>
                      </a>
                    </li>
                 <li>
                    <a class="dropdown-item" href="javascript:;">
                      <div class="d-flex align-items-center">
                        <div class="">
                          <ion-icon name="wallet-outline"></ion-icon>
                        </div>
                        <div class="ms-3"><span>Earnings</span></div>
                      </div>
                    </a>
                  </li><li>
                      <a class="dropdown-item" href="javascript:;">
                        <div class="d-flex align-items-center">
                          <div class="">
                            <ion-icon name="speedometer-outline"></ion-icon>
                          </div>
                          <div class="ms-3"><span>Dashboard</span></div>
                        </div>
                      </a>
                    </li>mptypage
                 
                    <li>
                      <a class="dropdown-item" href="javascript:;">
                        <div class="d-flex align-items-center">
                          <div class="">
                            <ion-icon name="cloud-download-outline"></ion-icon>
                          </div>
                          <div class="ms-3"><span>Downloads</span></div>
                        </div>
                      </a>
                    </li>
                   --> <li>
                      <hr class="dropdown-divider">
                    </li>
                    <li>
                      <a class="dropdown-item" href="javascript:;" @click="logOut">
                        <div class="d-flex align-items-center">
                          <div class="">
                            <ion-icon name="log-out-outline"></ion-icon>
                          </div>
                          <div class="ms-3"><span>Logout</span></div>
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
            Copyright © 2024. All right reserved.
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
  export default {
    setup () {
    useHead({
      bodyAttrs: {
        class: 'bg-white'
      },
      htmlAttrs:{
        class: 'semi-dark'
      }
    })
  },
  data(){
    return {
      user:window?(window.localStorage.getItem("user")?JSON.parse(window.localStorage.getItem("user")):null):null,
      lab:window?window.localStorage.getItem("lab_ref"):null,
      baseUrl:BASE_URL
    }
  },
    mounted() {
      this.loadScript();

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