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
                      <li class="breadcrumb-item active" aria-current="page"></li>
                    </ol>
                  </nav>
                </div>
            
                

              </div>
              <!--end breadcrumb-->
  
              <div>

                <br/>
                <br/>
                <h4  v-if="stats" class="mb-2">Summary</h4>
                <div v-if="stats" class="row row-cols-1 row-cols-sm-1 row-cols-md-3 row-cols-xl-3 row-cols-xxl-3">
                  <div class="col">
                    <div class="card radius-10 bg-primary">
                      <div class="card-body">
                        <div class="d-flex align-items-center">
                          <div class="">
                            <p class="mb-1 text-white">Patients Registered</p>
                            <h1 class="mb-0 text-white">{{stats.totalPatients}}</h1>
                            <small style="color: #aaa;">{{stats.patientsToday}} Today</small>
                          </div>
                          <div class="ms-auto text-white fs-2">
                            <ion-icon name="accessibility-sharp"></ion-icon>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col">
                    <div class="card radius-10 bg-danger">
                      <div class="card-body">
                        <div class="d-flex align-items-center">
                          <div class="">
                            <p class="mb-1 text-white">Specimens Collected</p>
                            <h1 class="mb-0 text-white">{{stats.totalSpecimens}}</h1>

                            <small style="color: #fff;">{{stats.specimensToday}} Today</small>
                          </div>
                          <div class="ms-auto text-white fs-2">
                            <!-- <ion-icon name="leaf-sharp"></ion-icon> -->
                            <i class="fadeIn animated bx bx-donate-blood"></i>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col">
                    <div class="card radius-10 bg-success">
                      <div class="card-body">
                        <div class="d-flex align-items-center">
                          <div class="">
                            <p class="mb-1 text-white">Results entered</p>
                            <h1 class="mb-0 text-white">{{stats.totalResults}}</h1>
                            <small style="color: #fff;">{{stats.resultsToday}} Today</small>
                          </div>
                          <div class="ms-auto text-white fs-2">
                            <ion-icon name="shield-checkmark-sharp"></ion-icon>
                            
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>



                <!--  recent specimens -->


                <br/>
                <br/>
                     <!-- start -->
                     <div class="row">
                
                      <div class="col-sm-12">
                        <!-- class="card" -->
                          <div >

                            <!-- class="card-body" -->
                              <div > 
                                <div  class="d-flex justify-content-between align-items-center">
                                  <h4 class="mb-2">Recent Specimens Collected</h4>
                                  <strong><u><NuxtLink to="/specimens">View All &rightarrow;</NuxtLink></u></strong>
                                </div>
                                <br/>
  
  
                                <div class="table-responsive">
  
                                  <div >
                                       
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
                                                  <NuxtLink class="btn btn-primary btn-sm me-3"  v-if="!u.meta &&  !u.meta.enteredby && !u.meta.validated" :to="'/editspecimen/'+u.id">Edit</NuxtLink>
                                                  <NuxtLink class="btn btn-primary btn-sm me-3" :to="'/profile/'+u.patient.id">Patient profile</NuxtLink>
                                                  <NuxtLink class="btn btn-primary btn-sm me-3" v-if="!u.billing" :to="'/initbilling/specimen/'+u.id">Generate Bill</NuxtLink>
                                                  <NuxtLink class="btn btn-primary btn-sm me-3" v-else target="_blank" :to="baseUrl+'/bill-report?id='+u.billing.id">View Bill</NuxtLink>
                                                  
                                                  
                                                 </td>
                                                 
                                           </tr>
                                         </tbody>
                                     </table>
                                   </div>
                                 </div>
                     
                                   </div>
                               </div>
                                
                              
      
      
      
                             
                              <!-- tab ends here -->
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
    data(){
        return {
          specimens:[],
          baseUrl:getBaseUrl(),
          stats:null
        };
    },
    mounted(){
      const context=this;
      getRequestLoad_('/specimens/',{count:10},(specimens)=>{
        context.specimens= specimens;

      });

      getRequestLoad_('/statistica/',{},(stats)=>{
        context.stats= stats;

      });

    }
  }
  </script>