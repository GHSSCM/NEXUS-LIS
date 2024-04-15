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
                              <h3 class="mb-2">Tamko Clarence</h3>
                              <p class="mb-1">My Profession</p>
                              <p>My address</p>


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
                     
                    </div>
                    <div class="col-12 col-lg-4 col-xl-3">
                      <div class="card radius-10">
                        <div class="card-body">
                          <h5 class="mb-3">Address</h5>
                           <p class="mb-0"><ion-icon name="compass-sharp" class="me-2"></ion-icon>Avenue Nsimeyong</p>
                        </div>
                      </div>
      
                      <div class="card radius-10">
                        <div class="card-body">
                          <h5 class="mb-3">Contacts</h5>
                           <p class=""><ion-icon name="globe-sharp" class="me-2"></ion-icon>clarence@gmail.com</p>
                           <p class=""><ion-icon name="logo-facebook" class="me-2"></ion-icon>(+237) 651 235 791</p>
                        </div>
                      </div>
      
                     
                    </div>

                    <div class="col-sm-12">
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
                                        <div  class="dataTables_wrapper dt-bootstrap5 dttable_wrapper"><div class="row"><div class="col-sm-12 col-md-6"><div class="dt-buttons btn-group">      <button class="btn btn-outline-secondary buttons-copy buttons-html5" tabindex="0" aria-controls="example2" type="button"><span>Copy</span></button> <button class="btn btn-outline-secondary buttons-excel buttons-html5" tabindex="0" aria-controls="example2" type="button"><span>Excel</span></button> <button class="btn btn-outline-secondary buttons-pdf buttons-html5" tabindex="0" aria-controls="example2" type="button"><span>PDF</span></button> <button class="btn btn-outline-secondary buttons-print" tabindex="0" aria-controls="example2" type="button"><span>Print</span></button> </div></div><div class="col-sm-12 col-md-6"><div id="example2_filter" class="dataTables_filter"><label>Search:<input type="search" class="form-control form-control-sm" placeholder="" aria-controls="example2"></label></div></div></div><div class="row"><div class="col-sm-12"><table id="example2" class="table table-striped table-bordered dataTable" role="grid" aria-describedby="example2_info">
                                            <thead>
                                                <tr role="row">
                                                   <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" style="width: 146.683px;" aria-label="Name: activate to sort column ascending">Test</th><th class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" style="width: 243.533px;" aria-label="Position: activate to sort column descending" aria-sort="ascending">Physician</th><th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" style="width: 100.533px;" aria-label="Start date: activate to sort column ascending">Received on </th><th rowspan="1" colspan="1">Specimen label</th></tr>
                                            </thead>
                                            <tbody>
                
                                                
                                            <tr role="row" v-for="u in [1,2,3,4,5,6,7,8]" class="odd">
                                                    <!-- <td class="">Blood</td> -->
                                                    <td class="">HIV</td>
                                                    <td class="sorting_1">Airi Satou</td>
                                                    <td>2008/11/28</td>
                                                    <td>AABBC</td>
                                                    <td>VALIDATED</td>
                                                    <td>
                                                        <NuxtLink class="btn btn-primary btn-sm" to="/profile">View details</NuxtLink>
                                                        <NuxtLink class="btn btn-primary btn-sm ms-4" to="/">Print result</NuxtLink>
                                                    </td>
                                                    
                                               </tr>
                                            </tbody>
                                            <tfoot>
                                                <tr><th rowspan="1" colspan="1">Specimen</th><th rowspan="1" colspan="1">Test</th><th rowspan="1" colspan="1">Physician</th><th rowspan="1" colspan="1">Received On</th><th rowspan="1" colspan="1">Specimen label</th></tr>
                                            </tfoot>
                                        </table></div></div><div class="row"><div class="col-sm-12 col-md-5"><div class="dataTables_info dttable"  role="status" aria-live="polite">Showing 1 to 10 of 57 entries</div></div><div class="col-sm-12 col-md-7"><div class="dataTables_paginate paging_simple_numbers" id="example2_paginate"><ul class="pagination"><li class="paginate_button page-item previous disabled" id="example2_previous"><a href="#" aria-controls="example2" data-dt-idx="0" tabindex="0" class="page-link">Prev</a></li><li class="paginate_button page-item active"><a href="#" aria-controls="example2" data-dt-idx="1" tabindex="0" class="page-link">1</a></li><li class="paginate_button page-item "><a href="#" aria-controls="example2" data-dt-idx="2" tabindex="0" class="page-link">2</a></li><li class="paginate_button page-item "><a href="#" aria-controls="example2" data-dt-idx="3" tabindex="0" class="page-link">3</a></li><li class="paginate_button page-item "><a href="#" aria-controls="example2" data-dt-idx="4" tabindex="0" class="page-link">4</a></li><li class="paginate_button page-item "><a href="#" aria-controls="example2" data-dt-idx="5" tabindex="0" class="page-link">5</a></li><li class="paginate_button page-item "><a href="#" aria-controls="example2" data-dt-idx="6" tabindex="0" class="page-link">6</a></li><li class="paginate_button page-item next" id="example2_next"><a href="#" aria-controls="example2" data-dt-idx="7" tabindex="0" class="page-link">Next</a></li></ul></div></div></div></div>
                                    </div>
                                </div>
                                <div class="tab-pane fade " id="primary-pills-profile" role="tabpanel">
                                    
                                    <div class="table-responsive">
                                        <div  class="dataTables_wrapper dt-bootstrap5 dttable_wrapper"><div class="row"><div class="col-sm-12 col-md-6"><div class="dt-buttons btn-group">      <button class="btn btn-outline-secondary buttons-copy buttons-html5" tabindex="0" aria-controls="example2" type="button"><span>Copy</span></button> <button class="btn btn-outline-secondary buttons-excel buttons-html5" tabindex="0" aria-controls="example2" type="button"><span>Excel</span></button> <button class="btn btn-outline-secondary buttons-pdf buttons-html5" tabindex="0" aria-controls="example2" type="button"><span>PDF</span></button> <button class="btn btn-outline-secondary buttons-print" tabindex="0" aria-controls="example2" type="button"><span>Print</span></button> </div></div><div class="col-sm-12 col-md-6"><div id="example2_filter" class="dataTables_filter"><label>Search:<input type="search" class="form-control form-control-sm" placeholder="" aria-controls="example2"></label></div></div></div><div class="row"><div class="col-sm-12"><table id="example2" class="table table-striped table-bordered dataTable" role="grid" aria-describedby="example2_info">
                                            <thead>
                                                <tr role="row">
                                                    <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" style="width: 146.683px;" aria-label="Name: activate to sort column ascending">Specimen</th><th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" style="width: 146.683px;" aria-label="Name: activate to sort column ascending">Test</th><th class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" style="width: 243.533px;" aria-label="Position: activate to sort column descending" aria-sort="ascending">Physician</th><th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" style="width: 100.533px;" aria-label="Start date: activate to sort column ascending">Received on </th><th rowspan="1" colspan="1">Specimen label</th></tr>
                                            </thead>
                                            <tbody>
                
                                                
                                            <tr role="row" v-for="u in [1,2,3,4,5,6,7,8]" class="odd">
                                                    <td class="">Blood</td>
                                                    <td class="">HIV</td>
                                                    <td class="sorting_1">Airi Satou</td>
                                                    <td>2008/11/28</td>
                                                    <td>AABBC</td>
                                                 
                                                    <td>
                                                        <NuxtLink class="btn btn-primary btn-sm" to="/profile">View details</NuxtLink>

                                                        <NuxtLink class="btn btn-primary btn-sm ms-4" to="/">Set results</NuxtLink>
                                                    </td>
                                                    
                                               </tr>
                                            </tbody>
                                            <tfoot>
                                                <tr><th rowspan="1" colspan="1">Test</th><th rowspan="1" colspan="1">Physician</th><th rowspan="1" colspan="1">Received On</th><th rowspan="1" colspan="1">Specimen label</th></tr>
                                            </tfoot>
                                        </table></div></div><div class="row"><div class="col-sm-12 col-md-5"><div class="dataTables_info dttable"  role="status" aria-live="polite">Showing 1 to 10 of 57 entries</div></div><div class="col-sm-12 col-md-7"><div class="dataTables_paginate paging_simple_numbers" id="example2_paginate"><ul class="pagination"><li class="paginate_button page-item previous disabled" id="example2_previous"><a href="#" aria-controls="example2" data-dt-idx="0" tabindex="0" class="page-link">Prev</a></li><li class="paginate_button page-item active"><a href="#" aria-controls="example2" data-dt-idx="1" tabindex="0" class="page-link">1</a></li><li class="paginate_button page-item "><a href="#" aria-controls="example2" data-dt-idx="2" tabindex="0" class="page-link">2</a></li><li class="paginate_button page-item "><a href="#" aria-controls="example2" data-dt-idx="3" tabindex="0" class="page-link">3</a></li><li class="paginate_button page-item "><a href="#" aria-controls="example2" data-dt-idx="4" tabindex="0" class="page-link">4</a></li><li class="paginate_button page-item "><a href="#" aria-controls="example2" data-dt-idx="5" tabindex="0" class="page-link">5</a></li><li class="paginate_button page-item "><a href="#" aria-controls="example2" data-dt-idx="6" tabindex="0" class="page-link">6</a></li><li class="paginate_button page-item next" id="example2_next"><a href="#" aria-controls="example2" data-dt-idx="7" tabindex="0" class="page-link">Next</a></li></ul></div></div></div></div>
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