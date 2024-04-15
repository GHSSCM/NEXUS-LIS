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
  
              <div>
              
              
                <br/>
                <h6 class="mb-0 text-uppercase">Register Specimen(s)</h6>
                <p>Patient: <strong>Tamko Clarence, 19years old, Patient ID: 4595</strong></p>
                <hr/>

               
                <div v-for="po in specimens">
                <div class="row" >
                    
                    <div class="col-sm-12 col-md-6">

                        <div class="mb-4">
                            <label :for="'single-select-field1'+pos" class="form-label">Specimen type</label>
                            <select class="form-select single-select-field" :id="'single-select-field1'+pos" data-placeholder="Choose specimen type">
                              <option></option>
                              <option>Name</option>
                              <option>Other name 1</option>
                              <option>Other name 2</option>
                              <option>Other name 3</option>
                              <option>Last name</option>
                            </select>
                          </div>
                
                          
                    </div>
                    <div class="col-sm-12 col-md-6">

                        <div class="mb-4">
                            <label for="single-select-field2" class="form-label">Test type(s)</label>
                            <select class="form-select multiple-select-field" :id="'multiple-select-field2'+pos" data-placeholder="Choose test type(s)" multiple>
                              <option></option>
                              <option>Name</option>
                              <option>Other name 1</option>
                              <option>Other name 2</option>
                              <option>Other name 3</option>
                              <option>Last name</option>
                            </select>
                          </div>
                
                          
                    </div>

                    <div class="col-sm-12 col-md-6">

                        <div class="mb-4">
                            <label class="form-label">Date of reception</label>
                            <input class="result form-control " type="date" placeholder="Date of reception">
                          </div>
                
                          
                    </div>


                    <div class="col-sm-12 col-md-6">

                      <div class="mb-4">
                          <label class="form-label">TIme of reception (optional)</label>
                          <input class="result form-control " type="time" placeholder="Time of reception">
                        </div>
              
                        
                  </div>

                    <div class="col-sm-12 col-md-6">

                        <div class="mb-4">
                            <label for="single-select-field3" class="form-label">Physician</label>
                            <select class="form-select single-select-field-tags" :id="'single-select-field1'+pos" data-placeholder="Enter physician name">
                              <option></option>
                              <option>Name</option>
                              <option>Other name 1</option>
                              <option>Other name 2</option>
                              <option>Other name 3</option>
                              <option>Last name</option>
                            </select>
                          </div>
                
                          
                    </div>


                    <div class="col-sm-12 col-md-6">

                        <div class="mb-4">
                            <label for="single-select-field5" class="form-label">Sample state</label>
                            <select class="form-select single-select-field" id="single-select-field5" data-placeholder="Sample state">
                              <option></option>
                              <option>Approved</option>
                              <option>Rejected</option>
                              <option>N/A</option>
                            </select>
                          </div>
                
            
                    </div>

                    <div class="col-sm-12 col-md-6">

                        <div class="mb-4">
                            <label for="single-select-field4" class="form-label">Preleveur</label>
                            <select class="form-select single-select-field-tags" id="single-select-field4" data-placeholder="Preleveur">
                              <option></option>
                              <option>Name</option>
                              <option>Name again</option>
                              <option>Another name</option>
                            </select>
                          </div>
                
            
                    </div>

                    <div class="col-sm-12 col-md-6">

                        <div class="mb-4">
                            <input class="form-check-input" type="checkbox" role="switch" id="referredout" checked>
                            <label class="form-check-label ms-2" for="referredout">Reffered Out?</label>
                     
                          </div>
                
            
                    </div>


                    <div class="col-sm-12 col-md-6">

                        <div class="mb-4">
                            <input class="form-check-input" type="checkbox" role="switch" id="referredout" checked>
                            <label class="form-check-label ms-2" for="referredout">Conformity?</label>
                     
                          </div>
                
            
                    </div>

                  </div>
                  <hr/>
                </div>

                  

                  <div class="d-flex flex-row justify-content-end">
                    <button class="btn btn-primary btn-sm" @click="specimens.push(1)">Add Specimens</button>
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
            specimens:[1]
        }
    }
  }
</script>