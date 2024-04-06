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


                    <div class="col-sm-12 col-md-6">

                        <div class="mb-4">
                            <label class="form-label">Patient ID</label>
                            <input class="form-control" type="text" placeholder="Patient ID" disabled value="128723">
                          </div>
                
                        
                    </div>



                    <div class="col-sm-12 col-md-6">
                        <label class="form-label">Patient Name</label>
                        <input type="text" class="form-control" placeholder="Patient Name"/>
                    </div>
                <div class="col-sm-12 col-md-6">

                    <div class="mb-4">
                        <label class="form-label">Gender</label>
                        <select class="form-select single-select-field-tags" id="single-select-field1" data-placeholder="Enter gender">
                         
                          <option>Male</option>
                          <option>Female</option>
                        </select>
                      </div>
            
                      
                </div>


                <div class="col-sm-12 col-md-6">

                    <div class="mb-4">
                        <label class="form-label">Date of birth</label>
                        <input class="result form-control date-picker" type="text" placeholder="Date of birth">
                      </div>
            
                      
                </div>



                <div class="col-sm-12 col-md-6">

                    <div class="mb-4">
                        <label class="form-label">Region of origin</label>
                        <select class="form-select single-select-field-tags" id="single-select-field2" data-placeholder="Region of origin">
                         
                          <option>Far north</option>
                          <option>North</option>
                          <option>Adamoua</option>
                          <option>East</option>
                          <option>South</option>
                          <option>North-West</option>
                          <option>South-West</option>
                          <option>West</option>
                          <option>Centre</option>
                          <option>Littoral</option>
                        </select>
                      </div>
            
                      
                </div>


                <div class="col-sm-12 col-md-6">

                    <div class="mb-4">
                        <label class="form-label">Address</label>
                        <input class="form-control" type="text" placeholder="Address">
                      </div>
            
                    
                </div>


                <div class="col-sm-12 col-md-6">

                    <div class="mb-4">
                        <label class="form-label">Profession</label>
                        <input class="form-control" type="text" placeholder="Profession">
                      </div>
            
                    
                </div>



           


              


                </div>
                <hr/>

                <div class="row">
                    <div class="col-sm-12 col-md-6">
                        <div class="mb-4">
                            <input class="form-check-input" type="checkbox" role="switch" id="referredout" checked>
                            <label class="form-check-label ms-2" for="referredout">Is pregnant?</label>
                     
                          </div>
                
                    </div>
                    <div class="col-sm-12 col-md-6">
                        <div class="mb-4">
                            <input class="form-check-input" type="checkbox" role="switch" id="referredout" checked>
                            <label class="form-check-label ms-2" for="referredout">Breastfeeding?</label>

                          </div>
                
                    </div>

                    <div class="col-sm-12 col-md-6">
                        <div class="mb-4">
                            <input class="form-check-input" type="checkbox" role="switch" id="referredout" checked>
                            <label class="form-check-label ms-2" for="referredout">HIV Diagnosis?</label>

                          </div>
                
                    </div>


                    <div class="col-sm-12 col-md-6">

                        <div class="mb-4">
                            <label class="form-label">Date of TARV initiation</label>
                            <input class="result form-control date-picker" type="text" placeholder="Date of TARV initiation">
                          </div>
                
                          
                    </div>
                    <div class="col-sm-12 col-md-6">

                        <div class="mb-4">
                            <label class="form-label">Line of treatment</label>
                            <input class="form-control" type="text" placeholder="Line of treatment">
                          </div>
                
                        
                    </div>

                </div>


                <div class="d-flex flex-row justify-content-end">
                    <NuxtLink class="btn btn-primary" to="/profile">Save</NuxtLink>
                </div>
                
                <br/>
                <br/>
                <br/>
                <br/>
                </div>
  
      
    
  
    </NuxtLayout>
  </template>