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
                      <li class="breadcrumb-item active" aria-current="page">Specimens</li>
                    </ol>
                  </nav>
                </div>
                
              </div>
              <!--end breadcrumb-->
  
              <div>
              
              
                <!-- <br/>
                <h6 class="mb-0 text-uppercase">Tamko Clarence</h6>
                <hr/> -->
  

                <!-- start -->
                <div class="row">
                
                    <div class="col-sm-12">
                        <div class="card">
                            <div class="card-body">
                              <h4 class="mb-2">Specimens</h4>
                              <br/>


                              <div class="table-responsive">

                                <div  class="dataTables_wrapper dt-bootstrap5 dttable_wrapper">
                                     
                               <div class="row">
                                 <div class="col-sm-12">
                                     <table id="onetoabc" class="table table-striped table-bordered dttable " role="grid" aria-describedby="example2_info">
                                       <thead>
                                           <tr role="row">
                                            <th rowspan="1" colspan="1"></th>
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
                                               <td class="">{{ i+1 }}</td>
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
                                                <NuxtLink class="btn btn-primary btn-sm me-3"  v-if="!u.meta &&  !u.meta.enteredby && !u.meta.validated" :to="'/editspecimen/'+u.id">Edit</NuxtLink>
                                                <NuxtLink class="btn btn-primary btn-sm me-3" :to="'/profile/'+u.patient.id">Patient profile</NuxtLink>
                                                <NuxtLink class="btn btn-primary btn-sm me-3" v-if="!u.billing" :to="'/initbilling/specimen/'+u.id">Generate Bill</NuxtLink>
                                                <NuxtLink class="btn btn-primary btn-sm me-3" v-else target="_blank"  :to="baseUrl+'/bill-report?id='+u.billing.id">View Bill</NuxtLink>
                                                
                                                
                                               </td>
                                               
                                         </tr>
                                       </tbody>
                                       <tfoot>
                                           <tr>
                                            <th rowspan="1" colspan="1"></th>
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
          baseUrl:getBaseUrl()
        };
    },
    mounted(){
      const context=this;
      getRequestLoad_('/specimens/',{},(specimens)=>{
        context.specimens= specimens;
        setTimeout(() => {
          loadDataTables();
        }, 500);
      });
    }
  }
  </script>