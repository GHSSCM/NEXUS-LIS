<template>
    <NuxtLayout name="inner">
        
              <!--start breadcrumb-->
              <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Dashboard</div>
                <div class="ps-3">
                  <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0 align-items-center">
                      <li class="breadcrumb-item"><a href="javascript:;">
                          <ion-icon name="home-outline"></ion-icon>
                        </a>
                      </li>
                      <li class="breadcrumb-item active" aria-current="page">Patient Profile</li>
                    </ol>
                  </nav>
                </div>
                <div class="ms-auto">
                  <div class="btn-group">
                    <button type="button" class="btn btn-outline-primary">Options</button>
                    <button type="button"
                      class="btn btn-outline-primary split-bg-primary dropdown-toggle dropdown-toggle-split"
                      data-bs-toggle="dropdown"> <span class="visually-hidden">Toggle Dropdown</span>
                    </button>
                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-lg-end"> <NuxtLink v-if="user" class="dropdown-item"
                      :to="'/addspecimen/'+user.id">Add patient specimen</NuxtLink>

                      <NuxtLink v-if="user" class="dropdown-item"
                      :to="'/patientinfo/'+user.id">Edit patient Info</NuxtLink>
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
                          <div class="user-profile-avatar shadow position-absolute top-50 start-0 translate-middle-x" style="width: 80px;
                          height: 80px;
                          margin-left: 4.5rem;">
                            <img src="assets/images/man.png" alt="...">
                          </div>
                        </div>
                        <div class="card-body">
                          <div class="mt-2 d-flex align-items-start justify-content-between">
                            <div class="">
                              <h3 class="mb-2">{{user.name}}</h3>
                              <p class="mb-1">Age: {{calculateAge(user.dob)}}, ({{user.dob}})</p>
                            


                              <div class="">

                                <NuxtLink class="btn btn-primary me-2" :to="'/addspecimen/'+user.id" >Register Specimen</NuxtLink>
                                <NuxtLink class="btn btn-primary me-2" :to="'/initbilling/patient/'+user.id" >Create a bill</NuxtLink>
                                <!-- <span class="badge rounded-pill bg-primary">UX Research</span>
                                <span class="badge rounded-pill bg-primary">CX Strategy</span>
                                <span class="badge rounded-pill bg-primary">Project Management</span>
                             --> </div> 
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
                            <h5 class="mb-3">Contacts</h5>
                             <p class=""><ion-icon name="globe-sharp" class="me-2"></ion-icon>{{user.email??"No Email"}}</p>
                             <p class=""><i class="lni lni-phone me-2"></i>{{user.phone??"No phone number"}}</p>
                          </div>
                        </div>
  
                       
            
  
                    </div>
                    <div class="col-sm-8">
                      <div class="card radius-10">
                        <div class="card-body">
                          <h5 class="mb-3">More Info</h5>
                          
                          <div class="row">
                            <div class="col-4">
                              <p>Profession: {{user.profession??"Unset"}}</p>
                            </div>
                            <div class="col-4">
                              <p>Gender: {{user.gender=='M'?"Male":"Female"}}</p>
                            </div>
                            <div class="col-4">
                              <p>Region of origin: {{user.region??"Unset"}}</p>
                            </div>
                            <div class="col-4" v-for="(o,i) in Object.keys(user.meta.fields)" :key="'cf-value-'+i">
                              <p >{{o}}: {{user.meta.fields[o]? (user.meta.fields[o] ===true||user.meta.fields[o] ===false)?(user.meta.fields[o]?"Yes":"No"):user.meta.fields[o] :"Unset"}}</p>
                            </div>
                          </div>
                      
    
                        </div>
                      </div>
                     
                    </div>
                    <div class="col-sm-12">
                      <div class="card">
                        <div class="card-body">
                          <h4 class="mb-2">Specimens & Tests</h4>
                          <br/>
                                <!-- SPECIMENS TABLE -->

                        <div class="table-responsive">

                          <div  class="dataTables_wrapper dt-bootstrap5 dttable_wrapper">
                               
                         <div class="row">
                           <div class="col-sm-12">
                               <table id="onetoabc" class="table table-striped table-bordered dttable " role="grid" aria-describedby="example2_info">
                                 <thead>
                                     <tr role="row">
                                      <th rowspan="1" colspan="1">Patient</th>
                                      <th rowspan="1" colspan="1">Specimen</th>
                                      <th rowspan="1" colspan="1">Test</th>
                                      <th rowspan="1" colspan="1">Physician</th>
                                      <th rowspan="1" colspan="1">Received On</th>
                                      <th rowspan="1" colspan="1">Referred?</th>
                                      <th rowspan="1" colspan="1">Referred From</th>
                                      <th rowspan="1" colspan="1"></th>
                                       </tr>
                                 </thead>
                                 <tbody>
     
                                     
                                 <tr role="row" v-for="(u,i) in specimens" :class="i%2==0?'even':'odd'" :key="'account-'+i">
                                         <td class="">{{ u.patient.name }}</td>
                                         <td class="">{{u.specimen.name}}</td>
                                         <td class="">{{u.test.name}}</td>
                                         <td class="">{{u.physician}}</td>
                                         <td class="">{{u.received.receptiondate}} {{u.received.receptiontime}}</td>
                                         <td class="">{{u.referredout?"Yes":"No"}}</td>
                                         <td class="">{{u.referredto??""}}</td>
                                         <td>
                                             <NuxtLink class="btn btn-success btn-sm me-3" v-if="u.meta && u.meta.enteredby && !u.meta.validated" :to="'/viewspecimen/'+u.id">Verify</NuxtLink>
                                             <NuxtLink class="btn btn-primary btn-sm me-3" v-else-if="u.meta &&  !u.meta.enteredby && !u.meta.validated" :to="'/viewspecimen/'+u.id">Enter Results</NuxtLink>
                                             <NuxtLink class="btn btn-primary btn-sm me-3" :to="'/viewspecimen/'+u.id">View </NuxtLink>
                                             <NuxtLink class="btn btn-primary btn-sm me-3" v-if="!u.meta.validated" :to="'/editspecimen/'+u.id">Edit </NuxtLink>

                                             <NuxtLink class="btn btn-primary btn-sm"  v-if="!u.meta &&  !u.meta.enteredby && !u.meta.validated" :to="'/editspecimen/'+u.id">Edit</NuxtLink>
                                             <NuxtLink class="btn btn-primary btn-sm me-3" target="_blank" v-if="u.meta && u.meta.validated" :to="baseUrl+'/test-report?id='+u.id">Export PDF</NuxtLink>
                                             
                                             <NuxtLink class="btn btn-primary btn-sm me-3" v-if="!u.billing" :to="'/initbilling/specimen/'+u.id">Generate Bill</NuxtLink>
                                             <NuxtLink class="btn btn-primary btn-sm me-3" v-else target="_blank"  :to="baseUrl+'/bill-report?id='+u.billing.id">View Bill</NuxtLink>
                                             <!-- <NuxtLink class="btn btn-primary btn-sm" :to="'/profile/'+u.patient.id">View profile</NuxtLink> -->
                                         </td>
                                         
                                   </tr>
                                 </tbody>
                                 <tfoot>
                                     <tr>
                                      <th rowspan="1" colspan="1">Patient</th>
                                      <th rowspan="1" colspan="1">Specimen</th>
                                      <th rowspan="1" colspan="1">Test</th>
                                      <th rowspan="1" colspan="1">Physician</th>
                                      <th rowspan="1" colspan="1">Received On</th>
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
    mounted(){
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