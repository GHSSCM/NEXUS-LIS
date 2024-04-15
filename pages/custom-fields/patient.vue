<template>
  <NuxtLayout name="inner">
      
            <!--start breadcrumb-->
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
              <div class="breadcrumb-title pe-3">Custom Fields</div>
              <div class="ps-3">
                <nav aria-label="breadcrumb">
                  <ol class="breadcrumb mb-0 p-0 align-items-center">
                    <li class="breadcrumb-item"><a href="javascript:;">
                        <ion-icon name="home-outline"></ion-icon>
                      </a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Patient Information</li>
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
                     
              <h6 class="mb-0 text-uppercase">Test type CFs</h6>
              <hr/>

              <div v-for="f in fields">
                  <hr/>
                  <div class="row">
                      <div class="col-sm-5">
                          <label >Name</label>
                        <input class="form-control mb-3 mt-2" type="text" placeholder="Enter field name">
                     </div>
                     <div class="col-sm-5">
                          <label class="mb-2">Data type</label>
                          <select class="form-control single-select-field " id="idk1" data-placeholder="Data type">
                              <option></option>
                              <option>Free input/text</option>
                              <option>Number</option>
                              <option>Yes/No</option>
                              <option>Limited values</option>
                              <option>Date/Time</option>
                              <option>Date Only</option>
                              <option>Time Only</option>
                          </select>
                   </div>
              
                   <div class="col-sm-2 d-flex align-items-center">
                      <center><i class="fadeIn animated bx bx-trash fs-5 mt-4 ms-2" style="color:red"></i></center>
                   </div>
                  </div>
                  <hr/>
              </div>


              <div class="d-flex flex-row justify-content-end">
                  <button class="btn btn-primary btn-sm" @click="fields.push(1)">Add fields</button>
              </div>
              
              <br/>
              <br/>
              <br/>
              <br/>
              </div>

    
  

  </NuxtLayout>
</template>
<script>
export default {
  data() {
      return {
          fields:[
1
          ]
      }
  },
  mounted() {
      
  },
}
</script>