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
                      <li class="breadcrumb-item active" aria-current="page">New patient</li>
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
               
                  
                <h6 class="mb-0 text-uppercase">Register a patient</h6>
                <hr/>


                <div class="row">
                    <div class="col-sm-12 col-md-3">
                        <label for="single-select-field3" class="form-label">Patient Name</label>
                    </div>
                <div class="col-sm-12 col-md-9">

                    <div class="mb-4">
                        
                        <select class="form-select single-select-field-tags" id="single-select-field1" data-placeholder="Enter patient name">
                          <option></option>
                          <option>Proposed Name, 22yo, Address:Nsimeyong</option>
                          <option>Other name 1, 22yo, Address:Nsimeyong</option>
                          <option>Other name 2, 22yo, Address:Nsimeyong</option>
                          <option>Other name 3, 22yo, Address:Nsimeyong</option>
                          <option>Last name, 22yo, Address:Nsimeyong</option>
                        </select>
                      </div>
                      <span  data-bs-toggle="popover" title="Help content" data-bs-content="Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat" class=" fw-bold text-orange" style="cursor:pointer"> <i class="fadeIn animated bx bx-help-circle"></i> Need help?</span>
                      
                </div>

                </div>


                <div class="d-flex flex-row justify-content-end">
                    <NuxtLink class="btn btn-primary btn-sm" to="/new/createpatient">Continue</NuxtLink>
                </div>
                
                <br/>
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
        patientId:"",
        patientName:"",
        gender:"",
        dateOfBirth:"",
        gender:"",
        region:"",
        address:"",
        profession:"",
        
    }
  }
}
</script>