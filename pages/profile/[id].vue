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
                      <li class="breadcrumb-item active" aria-current="page">Add specimen</li>
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
                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-lg-end"> <a class="dropdown-item"
                        href="javascript:;">Action</a>
                      <a class="dropdown-item" href="javascript:;">Another action</a>
                      <a class="dropdown-item" href="javascript:;">Something else here</a>
                      <div class="dropdown-divider"></div> <a class="dropdown-item" href="javascript:;">Separated link</a>
                    </div>
                  </div>
                </div>
              </div>
              <!--end breadcrumb-->
  
              <div v-if="user">
              
              
                <br/>
                <h6 class="mb-0 text-uppercase">Tamko Clarence</h6>
                <hr/>
  

                <!-- start -->
                <div class="row">
                    <div class="col-12 col-lg-8 col-xl-9">
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

                                <NuxtLink class="btn btn-primary me-2" to="/addspecimen" >Register Specimen</NuxtLink>
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
                     


                      <div class="card">
                        <div class="card-body">
                          <h4 class="mb-2">Laboratory Activity</h4>
                          <br/>
                          
                          <!-- tab starts here -->
                          <ul class="nav nav-pills mb-3" role="tablist">
                            <li class="nav-item" role="presentation">
                                <a class="nav-link active" data-bs-toggle="pill" href="#primary-pills-home" role="tab" aria-selected="false" tabindex="-1">
                                    <div class="d-flex align-items-center">
                                        <div class="tab-icon">
                                            
                                          

                                            <i class="fadeIn animated bx bx-vial me-1 md "></i>
                                        </div>
                                        <div class="tab-title">Test Results</div>
                                    </div>
                                </a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link " data-bs-toggle="pill" href="#primary-pills-profile" role="tab" aria-selected="true">
                                    <div class="d-flex align-items-center">
                                        <div class="tab-icon">
                                            

                                            <i class="fadeIn animated bx bx-donate-blood me-1 md "></i>
                                        </div>
                                        <div class="tab-title">Specimens</div>
                                    </div>
                                </a>
                            </li>
                           
                        </ul>



                        <div class="tab-content" id="pills-tabContent">
                            <div class="tab-pane fade active show" id="primary-pills-home" role="tabpanel">
                                <div class="table-responsive">
                                   <div  class="dataTables_wrapper dt-bootstrap5 dttable_wrapper">
                                        
                                  <div class="row">
                                    <div class="col-sm-12">
                                        <table id="onetoone" class="table table-striped table-bordered dttable " role="grid" aria-describedby="example2_info">
                                          <thead>
                                              <tr role="row">
                                                <th rowspan="1" colspan="1">Test</th>
                                                <th rowspan="1" colspan="1">Physician</th>
                                                <th rowspan="1" colspan="1">Received On</th>
                                                <th rowspan="1" colspan="1">Specimen label</th>
                                                <th rowspan="1" colspan="1">State</th>
                                                <th></th>
                                                </tr>
                                          </thead>
                                          <tbody>
              
                                              
                                          <tr role="row" v-for="(u,i) in tests" :class="i%2==0?'even':'odd'" :key="'account-'+i">
                                                  <td class="">{{ u.test }}</td>
                                                  <td class="">{{u.physician}}</td>
                                                  <td class="sorting_1">{{u.received_on}}</td>
                                                  <td>{{u.specimenlabel}}</td>
                                                  <td>{{u.state}}</td>
                                                  <!-- <td>{{u.created_at.split(".")[0].split("T").join(" ")}}</td> -->
                                                  <td>
                                                      <NuxtLink class="btn btn-primary btn-sm" :to="'/accounts/'+u.id">View/Edit account</NuxtLink>
                                                  </td>
                                                  
                                            </tr>
                                          </tbody>
                                          <tfoot>
                                              <tr>
                                                <th rowspan="1" colspan="1">Test</th>
                                                <th rowspan="1" colspan="1">Physician</th>
                                                <th rowspan="1" colspan="1">Received On</th>
                                                <th rowspan="1" colspan="1">Specimen label</th>
                                                <th rowspan="1" colspan="1">State</th>
                                                <th></th>
                                              </tr>
                                          </tfoot>
                                      </table>
                                    </div>
                                  </div>
                      
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade " id="primary-pills-profile" role="tabpanel">
                                
                                <div class="table-responsive">

                                   <div  class="dataTables_wrapper dt-bootstrap5 dttable_wrapper">
                                        
                                  <div class="row">
                                    <div class="col-sm-12">
                                        <table id="onetoabc" class="table table-striped table-bordered dttable " role="grid" aria-describedby="example2_info">
                                          <thead>
                                              <tr role="row">
                                                <th rowspan="1" colspan="1">Specimen</th>
                                                <th rowspan="1" colspan="1">Test</th>
                                                <th rowspan="1" colspan="1">Physician</th>
                                                <th rowspan="1" colspan="1">Received On</th>
                                                <th rowspan="1" colspan="1">Specimen label</th>
                                                  <th></th>
                                                </tr>
                                          </thead>
                                          <tbody>
              
                                              
                                          <tr role="row" v-for="(u,i) in specimens" :class="i%2==0?'even':'odd'" :key="'account-'+i">
                                                  <td class="">{{ u.test }}</td>
                                                  <td class="">{{u.physician}}</td>
                                                  <td class="sorting_1">{{u.received_on}}</td>
                                                  <td>{{u.specimenlabel}}</td>
                                                  <td>{{u.state}}</td>
                                                  <!-- <td>{{u.created_at.split(".")[0].split("T").join(" ")}}</td> -->
                                                  <td>
                                                      <NuxtLink class="btn btn-primary btn-sm" :to="'/accounts/'+u.id">View/Edit account</NuxtLink>
                                                  </td>
                                                  
                                            </tr>
                                          </tbody>
                                          <tfoot>
                                              <tr>
                                                <th rowspan="1" colspan="1">Specimen</th>
                                                <th rowspan="1" colspan="1">Test</th>
                                                <th rowspan="1" colspan="1">Physician</th>
                                                <th rowspan="1" colspan="1">Received On</th>
                                                <th rowspan="1" colspan="1">Specimen label</th>
                                                <th></th>
                                              </tr>
                                          </tfoot>
                                      </table>
                                    </div>
                                  </div>
                      
                                    </div>
                                </div>

                            </div>
                        
                        </div>

                        <!-- tab ends here -->
                        </div>
                      </div>
                    </div>
                    <div class="col-12 col-lg-4 col-xl-3">
                      <!-- <div class="card radius-10">
                        <div class="card-body">
                          <h5 class="mb-3">Address</h5>
                           <p class="mb-0"><ion-icon name="compass-sharp" class="me-2"></ion-icon>{{user.address}}</p> 
                        </div>
                      </div> -->
      
                      <div class="card radius-10">
                        <div class="card-body">
                          <h5 class="mb-3">Contacts</h5>
                           <p class=""><ion-icon name="globe-sharp" class="me-2"></ion-icon>{{user.email??"No Email"}}</p>
                           <p class=""><i class="lni lni-phone me-2"></i>{{user.phone??"No phone number"}}</p>
                        </div>
                      </div>

                      <div class="card radius-10">
                        <div class="card-body">
                          <h5 class="mb-3">More Info</h5>
                          <p>Profession: {{user.profession??"Unset"}}</p>
                          <p>Gender: {{user.gender=='M'?"Male":"Female"}}</p>
                          <p>Region of origin: {{user.region??"Unset"}}</p>
    
                          <p v-for="(o,i) in Object.keys(user.meta.fields)" :key="'cf-value-'+i">{{o}}: {{user.meta.fields[o]??"Unset"}}</p>
    
                        </div>
                      </div>
                     
                     
                    </div>

                    <div class="col-sm-12">
                      
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
      getRequestLoad_('/patient/'+this.id,{},(user)=>{
        context.user= user;
      })
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
          },
          specimens:[], 
          tests:[]
          }
      }
    }
  }
  
  </script>