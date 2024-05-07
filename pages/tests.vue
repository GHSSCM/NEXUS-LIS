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
                      <li class="breadcrumb-item active" aria-current="page">Registered Tests</li>
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
              
              
                <!-- <br/>
                <h6 class="mb-0 text-uppercase">Tamko Clarence</h6>
                <hr/>
   -->

                <!-- start -->
                <div class="row">
                
                    <div class="col-sm-12">
                        <div class="card">
                            <div class="card-body">
                              <h4 class="mb-2">Tests</h4>
                              <br/>
                       
    
    
    
                            <div class="table-responsive">
                                <div  class="dataTables_wrapper dt-bootstrap5 dttable_wrapper"><div class="row"><div class="col-sm-12 col-md-6"><div class="dt-buttons btn-group">      <button class="btn btn-outline-secondary buttons-copy buttons-html5" tabindex="0" aria-controls="example2" type="button"><span>Copy</span></button> <button class="btn btn-outline-secondary buttons-excel buttons-html5" tabindex="0" aria-controls="example2" type="button"><span>Excel</span></button> <button class="btn btn-outline-secondary buttons-pdf buttons-html5" tabindex="0" aria-controls="example2" type="button"><span>PDF</span></button> <button class="btn btn-outline-secondary buttons-print" tabindex="0" aria-controls="example2" type="button"><span>Print</span></button> </div></div><div class="col-sm-12 col-md-6"><div id="example2_filter" class="dataTables_filter"><label>Search:<input type="search" class="form-control form-control-sm" placeholder="" aria-controls="example2"></label></div></div></div><div class="row"><div class="col-sm-12"><table id="example2" class="table table-striped table-bordered dataTable" role="grid" aria-describedby="example2_info">
                                    <thead>
                                        <tr role="row">
                                            <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" style="width: 146.683px;" aria-label="Name: activate to sort column ascending">Test</th> <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" style="width: 146.683px;" aria-label="Name: activate to sort column ascending">Patient</th><th class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" style="width: 243.533px;" aria-label="Position: activate to sort column descending" aria-sort="ascending">Physician</th><th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" style="width: 100.533px;" aria-label="Start date: activate to sort column ascending">Received on </th><th rowspan="1" colspan="1">Specimen label</th></tr>
                                    </thead>
                                    <tbody>
        
                                        
                                    <tr role="row" v-for="u in []" class="odd">
                                            <!-- <td class="">Blood</td> -->
                                            <td class="">HIV</td>
                                            <td class="sorting_1">Airi Satou</td>
                                            <td class="sorting_1">Airi Satou</td>
                                            <td>2008/11/28</td>
                                            <td>AABBC</td>
                                            <td>VALIDATED</td>
                                            <td>
                                                <NuxtLink class="btn btn-primary btn-sm" to="/profile">View details</NuxtLink>
                                                <NuxtLink class="btn btn-primary btn-sm ms-4" to="/">Print result</NuxtLink>
                                                <br/>
                                                <NuxtLink class="btn btn-primary btn-sm mt-2" to="/">View sample</NuxtLink>
                                                <NuxtLink class="btn btn-primary btn-sm ms-4 mt-2" to="/profile">View patient profile</NuxtLink>
                                            </td>
                                            
                                       </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr><th rowspan="1" colspan="1">Specimen</th><th rowspan="1" colspan="1">Patient</th><th rowspan="1" colspan="1">Specimen</th><th rowspan="1" colspan="1">Test</th><th rowspan="1" colspan="1">Physician</th><th rowspan="1" colspan="1">Received On</th><th rowspan="1" colspan="1">Specimen label</th></tr>
                                    </tfoot>
                                </table></div></div><div class="row"><div class="col-sm-12 col-md-5"><div class="dataTables_info dttable"  role="status" aria-live="polite">Showing 1 to 10 of 57 entries</div></div><div class="col-sm-12 col-md-7"><div class="dataTables_paginate paging_simple_numbers" id="example2_paginate"><ul class="pagination"><li class="paginate_button page-item previous disabled" id="example2_previous"><a href="#" aria-controls="example2" data-dt-idx="0" tabindex="0" class="page-link">Prev</a></li><li class="paginate_button page-item active"><a href="#" aria-controls="example2" data-dt-idx="1" tabindex="0" class="page-link">1</a></li><li class="paginate_button page-item "><a href="#" aria-controls="example2" data-dt-idx="2" tabindex="0" class="page-link">2</a></li><li class="paginate_button page-item "><a href="#" aria-controls="example2" data-dt-idx="3" tabindex="0" class="page-link">3</a></li><li class="paginate_button page-item "><a href="#" aria-controls="example2" data-dt-idx="4" tabindex="0" class="page-link">4</a></li><li class="paginate_button page-item "><a href="#" aria-controls="example2" data-dt-idx="5" tabindex="0" class="page-link">5</a></li><li class="paginate_button page-item "><a href="#" aria-controls="example2" data-dt-idx="6" tabindex="0" class="page-link">6</a></li><li class="paginate_button page-item next" id="example2_next"><a href="#" aria-controls="example2" data-dt-idx="7" tabindex="0" class="page-link">Next</a></li></ul></div></div></div></div>
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