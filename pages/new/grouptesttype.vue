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
                      <li class="breadcrumb-item active" aria-current="page">New Specimen Type</li>
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
  
              <div>
                       
                <h6 class="mb-0 text-uppercase">Create a new specimen</h6>
                <hr/>

                <div class="row">
                    <div class="col-sm-12 col-md-6">

                        <div class="mb-4">
                            <label class="form-label">Name</label>
                            <input class="form-control" type="text" placeholder="Name"/>
                          </div>
                

                          

                    </div>
                    <div>
                        <div class="mb-4">
                            <label class="form-label">Description</label>
                            <textarea class="form-control" type="text" placeholder="Description"></textarea>
                          </div>
                    </div>
                    <div class="col-sm-12 col-md-6">

                    <div class="mb-4">
                        <label class="form-label">Tests</label>
                        <select multiple class="form-select multiple-select-field" id="single-select-field2" data-placeholder="Test types in group">
                         
                          <option>HIV</option>
                          <option>Haepatithis</option>
                          <option>Malaria</option>
                          <option>Typhoid</option>
                         
                        </select>
                      </div>
                    </div>
            
                </div>


                <!-- <p><strong>Measures</strong></p>
                <div v-for="f in fields">
                    <hr/>
                    <div class="row">
                        <div class="col-sm-2">
                            <label >Name</label>
                          <input class="form-control mb-3 mt-2" type="text" placeholder="Enter name">
                       </div>
                       <div class="col-sm-2">
                            <label class="mb-2">Data type</label>
                            <select class="form-control single-select-field " id="idk1" data-placeholder="Data type">
                                <option></option>
                                <option>Alpha numeric</option>
                                <option>Number</option>
                                <option>Yes/No</option>
                                <option>Limited values</option>
                                <option>Date/Time</option>
                                <option>Date Only</option>
                                <option>Time Only</option>
                            </select>
                     </div>

                     <div class="col-sm-4">
                        <label >Values</label>
                   </div>

                   <div class="col-sm-3">
                    <label >Unit</label>
               </div>

                
                     <div class="col-sm-1 d-flex align-items-center">
                        <center><i class="fadeIn animated bx bx-trash fs-5 mt-4 ms-2" style="color:red"></i></center>
                     </div>
                    </div>
                    <hr/>
                </div>-->

                <hr/>
                <div class="row">

                    <div class="col-sm-12 col-md-6">
                        <div class="mb-4">
                            <input class="form-check-input" type="checkbox" role="switch" id="referredout" checked>
                            <label class="form-check-label ms-2" for="referredout">Hide patient name in report?</label>
                     
                          </div>
                
                    </div>

                


                    <div class="col-sm-12 col-md-6">

                        <div class="mb-4">
                            <label class="form-label">Target TAT </label>
                            <input class="result form-control time-picker" type="text" placeholder="Target TAT"/>
                          </div>
                

                          

                    </div>

                    <div class="col-sm-12 col-md-6">

                        <div class="mb-4">
                            <label class="form-label">Cost to patient in FCFA</label>
                            <input class="form-control" type="number" placeholder="Cost to patient"/>
                          </div>
                

                          

                    </div>



                </div>
            

                <div class="d-flex flex-row justify-content-end">
                    <NuxtLink class="btn btn-primary" to="/profile">Save</NuxtLink>
                </div>
                <br/>
                <br/>
                <br/>
                </div>
  
      
    
  
    </NuxtLayout>
  </template>
  <script>
  export default{
    data(){
        return {
            fields:[0]
        }
    }
  }
  </script>