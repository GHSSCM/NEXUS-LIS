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
                    <div class="col-sm-6 col-md-12">

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
                    <div class="col-sm-6 col-md-12">

                    <div class="mb-4">
                        <label class="form-label">Compatible test(s)</label>
                        <select multiple class="form-select multiple-select-field" id="single-select-field2" data-placeholder="Compatible test(s)">
                         
                          <option>HIV</option>
                          <option>Haepatithis</option>
                          <option>Malaria</option>
                          <option>Typhoid</option>
                         
                        </select>
                      </div>
                    </div>
            
                </div>
            


                </div>
  
      
    
  
    </NuxtLayout>
  </template>