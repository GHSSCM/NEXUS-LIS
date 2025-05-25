<template>
  <NuxtLayout name="patientlayout">
      
            <!--start breadcrumb-->
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
              <div class="breadcrumb-title pe-3">
                <Translate text="Nexus Patients" />
              </div>
              <div class="ps-3">
                <nav aria-label="breadcrumb">
                  <ol class="breadcrumb mb-0 p-0 align-items-center">
                    <li class="breadcrumb-item">
                      <a href="javascript:;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24"><!-- Icon from Covid Icons by Streamline - https://creativecommons.org/licenses/by/4.0/ --><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.25 20.679a3.429 3.429 0 1 0 0-6.858a3.429 3.429 0 0 0 0 6.858m-.571-9.429h1.142m-.571 0v2.571m3.839-1.218l.808.808m-.404-.404l-1.819 1.819m3.576 1.853v1.142m0-.571h-2.571m1.218 3.839l-.808.808m.404-.404l-1.819-1.819m-1.853 3.576h-1.142m.571 0v-2.571m-3.839 1.218l-.808-.808m.404.404l1.819-1.819m-3.576-1.853v-1.142m0 .571h2.571m-1.218-3.839l.808-.808m-.404.404l1.819 1.819M7.5 9a4.125 4.125 0 1 0 0-8.25A4.125 4.125 0 0 0 7.5 9M.75 17.25a6.753 6.753 0 0 1 9.4-6.208"/></svg>
                      </a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                      <Translate text="Patient Profile" />
                    </li>
                  </ol>
                </nav>
              </div>
              <div class="ms-auto">
                <div class="btn-group">
                  <button type="button" class="btn btn-outline-primary">
                    <Translate text="Options" />
                  </button>
                  <button type="button"
                    class="btn btn-outline-primary split-bg-primary dropdown-toggle dropdown-toggle-split"
                    data-bs-toggle="dropdown">
                    <span class="visually-hidden">
                      <Translate text="Toggle Dropdown" />
                    </span>
                  </button>
                  <div class="dropdown-menu dropdown-menu-right dropdown-menu-lg-end">
                    <NuxtLink v-if="user && servicesStore.serviceCodes.includes(ServiceCode.NEXUS_LABORATORY) && hasPermission('LABORATORY.REGISTER_SPECIMEN')" class="dropdown-item"
                      :to="'/nexus.lab/addspecimen/'+user.id">
                      <Translate text="Add patient specimen" />
                    </NuxtLink>
                    <NuxtLink v-if="user && hasPermission('PATIENT.MODIFY_PATIENT_INFO')" class="dropdown-item"
                      :to="'/nexus.patients/patientinfo/'+user.id">
                      <Translate text="Edit patient Info" />
                    </NuxtLink>
                    <!-- <a class="dropdown-item" href="javascript:;">Another action</a> -->
                    <!-- <a class="dropdown-item" href="javascript:;">Something else here</a> -->
                    <!-- <div class="dropdown-divider"></div> <a class="dropdown-item" href="javascript:;">Separated link</a> -->
                  </div>
                </div>
              </div>
            </div>
            <!--end breadcrumb-->

            <div v-if="user">
            
              <br/>
              <h6 class="mb-0 text-uppercase" v-if="user && user.name">{{user.name}}</h6>
   
              <hr/>

              <!-- start -->
              <div class="row">
                  <div class="col-12">
                    <div class="card overflow-hidden radius-10">
                      <div class="profile-cover bg-dark position-relative mb-4">
                        <div class="user-profile-avatar shadow position-absolute top-50 start-0 translate-middle-x" style="width: 80px; height: 80px; margin-left: 4.5rem;">
                          <img src="../../../public/assets/images/man.png" alt="...">
                        </div>
                      </div>
                      <div class="card-body">
                        <div class="mt-2 d-flex align-items-start justify-content-between">
                          <div class="">
                            <h3 class="mb-2">{{user.name}}</h3>
                            <p class="mb-1">
                              <Translate text="Age:" /> {{calculateAge(user.dob)}}, ({{user.dob}})
                            </p>
                            <p>Reference: {{user.reference}}</p>
                            <div class="">
                              <NuxtLink class="btn btn-primary me-2" :to="'/nexus.lab/addspecimen/'+user.id"  v-if=" servicesStore.serviceCodes.includes(ServiceCode.NEXUS_LABORATORY) && hasPermission('LABORATORY.REGISTER_SPECIMEN')">
                                <Translate text="Register Specimen" />
                              </NuxtLink>
                              <NuxtLink class="btn btn-primary me-2" :to="'/nexus.billing/initbilling/patient/'+user.id"  v-if="servicesStore.serviceCodes.includes(ServiceCode.NEXUS_BILLING) && hasPermission('LABORATORY.MANAGE_BILLING')">
                                <Translate text="Create a bill" />
                              </NuxtLink>
                              <!-- <span class="badge rounded-pill bg-primary">UX Research</span>
                              <span class="badge rounded-pill bg-primary">CX Strategy</span>
                              <span class="badge rounded-pill bg-primary">Project Management</span> -->
                            </div> 
                          </div>
                          <!-- <div class="">
                             <a href="javascript:;" class="btn btn-primary"><ion-icon name="send-sharp"></ion-icon>Send Message</a>
                          </div> -->
                        </div>
                      </div>
                    </div>
                   
                  </div>
                
                  <div class="col-sm-4">
                      <div class="card radius-10">
                        <div class="card-body">
                          <h5 class="mb-3">
                            <Translate text="Contacts" />
                          </h5>
                           <p class="">
                             <ion-icon name="globe-sharp" class="me-2"></ion-icon>
                             {{user.email ?? $t("No Email")}}
                           </p>
                           <p class="">
                             <i class="lni lni-phone me-2"></i>
                             {{user.phone ?? $t("No phone number")}}
                           </p>
                        </div>
                      </div>
                  </div>
                  <div class="col-sm-8">
                    <div class="card radius-10">
                      <div class="card-body">
                        <h5 class="mb-3">
                          <Translate text="More Info" />
                        </h5>
                        
                        <div class="row">
                          <div class="col-4">
                            <p>
                              <Translate text="Profession:" /> {{user.profession ?? $t("Unset")}}
                            </p>
                          </div>
                          <div class="col-4">
                            <p>
                              <Translate text="Gender:" /> {{user.gender=='M' ? $t("Male") : $t("Female")}}
                            </p>
                          </div>
                          <div class="col-4">
                            <p>
                              <Translate text="Region of origin:" /> {{user.region ?? $t("Unset")}}
                            </p>
                          </div>
                          <div class="col-4" v-for="(o,i) in Object.keys(user.meta.fields)" :key="'cf-value-'+i">
                            <p>
                              {{o}}: {{user.meta.fields[o] ? (user.meta.fields[o] === true || user.meta.fields[o] === false ? (user.meta.fields[o] ? $t("Yes") : $t("No")) : user.meta.fields[o]) : $t("Unset")}}
                            </p>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-12" v-if="servicesStore.serviceCodes.includes(ServiceCode.NEXUS_LABORATORY)">
                    <div class="card">
                      <div class="card-body">
                        <h4 class="mb-2">
                          <Translate text="Specimens & Tests" />
                        </h4>
                        <br/>
                        <!-- SPECIMENS TABLE -->
                        <div class="table-responsive">
                          <div class="dataTables_wrapper dt-bootstrap5 dttable_wrapper">
                            <div class="row">
                              <div class="col-sm-12">
                                <table id="onetoabc" class="table table-striped table-bordered dttable" role="grid" aria-describedby="example2_info">
                                  <thead>
                                   <tr role="row">
                                    <th rowspan="1" colspan="1">
                                      <Translate text="Patient" />
                                    </th>
                                    <th rowspan="1" colspan="1">
                                      <Translate text="Specimen" />
                                    </th>
                                    <th rowspan="1" colspan="1">
                                      <Translate text="Test" />
                                    </th>
                                    <th rowspan="1" colspan="1">
                                      <Translate text="Physician" />
                                    </th>
                                    <th rowspan="1" colspan="1">
                                      <Translate text="Received On" />
                                    </th>
                                    <th rowspan="1" colspan="1">
                                      <Translate text="Referred?" />
                                    </th>
                                    <th rowspan="1" colspan="1">
                                      <Translate text="Referred From" />
                                    </th>
                                    <th rowspan="1" colspan="1"></th>
                                   </tr>
                                  </thead>
                                  <tbody>
                                   <tr role="row" v-for="(u,i) in specimens" :class="i % 2 === 0 ? 'even' : 'odd'" :key="'account-'+i">
                                       <td>{{ u.patient.name }}</td>
                                       <td>{{ u.specimen.name }}</td>
                                       <td>{{ u.test.name }}</td>
                                       <td>{{ u.physician }}</td>
                                       <td>{{ u.received.receptiondate }} {{ u.received.receptiontime }}</td>
                                       <td>{{ u.referredout ? $t("Yes") : $t("No") }}</td>
                                       <td>{{ u.referredto ?? "" }}</td>
                                       <td>
                                           <NuxtLink class="btn btn-success btn-sm me-3" v-if="u.meta && u.meta.enteredby && !u.meta.validated &&  hasPermission('LABORATORY.VALIDATE_RESULTS')" :to="'/nexus.lab/viewspecimen/'+u.id">
                                             <Translate text="Verify" />
                                           </NuxtLink>
                                           <NuxtLink class="btn btn-primary btn-sm me-3" v-else-if="u.meta && !u.meta.enteredby && !u.meta.validated && hasPermission('LABORATORY.ENTER_RESULTS')" :to="'/nexus.lab/viewspecimen/'+u.id" >
                                             <Translate text="Enter Results" />
                                           </NuxtLink>
                                           <NuxtLink class="btn btn-primary btn-sm me-3" :to="'/nexus.lab/viewspecimen/'+u.id" v-if="hasPermission('LABORATORY.REGISTER_SPECIMEN')">
                                             <Translate text="View" />
                                           </NuxtLink>
                                           <NuxtLink class="btn btn-primary btn-sm me-3" v-if="!u.meta.validated && hasPermission('LABORATORY.REGISTER_SPECIMEN')" :to="'/nexus.lab/editspecimen/'+u.id">
                                             <Translate text="Edit" />
                                           </NuxtLink>
                                           <NuxtLink class="btn btn-primary btn-sm" v-if="!u.meta && !u.meta.enteredby && !u.meta.validated && hasPermission('LABORATORY.REGISTER_SPECIMEN')" :to="'/nexus.lab/editspecimen/'+u.id">
                                             <Translate text="Edit" />
                                           </NuxtLink>
                                           <NuxtLink class="btn btn-primary btn-sm me-3" target="_blank" v-if="u.meta && u.meta.validated && hasPermission('LABORATORY.EXPORT_SHEET')" :to="'/nexus.lab/visualizer/'+u.id">
                                             <Translate text="Export PDF" />
                                           </NuxtLink>
                                           <NuxtLink class="btn btn-primary btn-sm me-3" v-if="!u.billing && hasPermission('LABORATORY.MANAGE_BILLING')" :to="'/nexus.lab/initbilling/specimen/'+u.id">
                                             <Translate text="Generate Bill" />
                                           </NuxtLink>
                                           <NuxtLink class="btn btn-primary btn-sm me-3" v-else-if="hasPermission('LABORATORY.MANAGE_BILLING')" target="_blank" :to="baseUrl+'/bill-report?id='+u.billing.id"  >
                                             <Translate text="View Bill" />
                                           </NuxtLink>
                                           <!-- <NuxtLink class="btn btn-primary btn-sm" :to="'/nexus.patients/profile/'+u.patient.id">View profile</NuxtLink> -->
                                       </td>
                                   </tr>
                                  </tbody>
                                  <tfoot>
                                   <tr>
                                    <th rowspan="1" colspan="1">
                                      <Translate text="Patient" />
                                    </th>
                                    <th rowspan="1" colspan="1">
                                      <Translate text="Specimen" />
                                    </th>
                                    <th rowspan="1" colspan="1">
                                      <Translate text="Test" />
                                    </th>
                                    <th rowspan="1" colspan="1">
                                      <Translate text="Physician" />
                                    </th>
                                    <th rowspan="1" colspan="1">
                                      <Translate text="Received On" />
                                    </th>
                                    <th rowspan="1" colspan="1"></th>
                                   </tr>
                                  </tfoot>
                                </table>
                              </div>
                            </div>
                          </div>
                        </div>
                        <!--  SPECIMENS TABLES ENDS -->
                      </div>
                    </div>
                  </div>
                </div>
                <!-- end -->

              </div>
  </NuxtLayout>
</template>

  <script>
  export default{
    setup(){
      const servicesStore =  useMyServicesStore();
      return {
        servicesStore
      }
    },
    mounted(){
      // forceOutPermissionVerify('PATIENT.VIEW_PATIENT_PROFILE',this); 

      const context=this;
      setTimeout(function(){
        getRequestLoad_('/patient/'+context.id,{},(user)=>{
        context.user= user;
          getRequestLoad_('/specimens/',{patient:user.uniqid},(specimens)=>{
            context.specimens= specimens;
            console.log(specimens)
            setTimeout(function(){
              loadDataTables();
            },500)
          });
      })
      },500)
    },  
    methods:{
      calculateAge(dob){
          return calculateAge(dob);
      } 
    }, 
    data(){
      const route=useRoute();

      return {
          id:route.params.id,
          user:{
            reference:"",
          name:"",
          dob:"",
          gender:"",
          region:"",
          address:"",
          profession:"",
          meta:{
            fields:{}
          }
          },
          specimens:[], 
          tests:[],
          baseUrl:getBaseUrl()
      }
    }
  }
  
  </script>