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
                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-lg-end"> 
                      
                      <NuxtLink to="/patientinfo/create" class="dropdown-item" >New patient</NuxtLink>

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
                <div class="col-sm-11 col-md-8">

                    <div class="mb-4">
                        
                      <input v-model="searchname" @input="search" class="form-control" type="text" placeholder="Enter patient name"/>
                      </div>
                      <!-- <span  data-bs-toggle="popover" title="Help content" data-bs-content="Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat" class=" fw-bold text-orange" style="cursor:pointer"> <i class="fadeIn animated bx bx-help-circle"></i> Need help?</span> -->
                      
                </div>
                <div class="col-sm-1" v-if="searching">
                  <div class="spinner-border text-primary" role="status"> <span class="visually-hidden">Loading...</span>
                  </div>
                </div>

                </div>

                <div v-if="!searching && !searchname" >
                      <h5>Enter a name to continue</h5>
                </div>
                <div v-if="searching" >
                  <h5>Searching...</h5>
              </div>

              <div v-if="!searching && results.length>0">
                <h5>({{ results.length }}) similar patients</h5>
            </div>

            <div v-if="!searching && results.length==0 && searchname">
              <h5>Nothing found.</h5>
          </div>
              <div class="card" v-if="searchname && results.length>0">
                <div class="card-body">
                  <table class="table mb-0 table-hover">
                    <thead>
                      <tr>
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <th scope="col">Age</th>
                        <th scope="col">Profession</th>
                        <th scope="col"></th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="(r,i) in results" :key="'sr-'+i">
                        <th scope="row">{{r.reference}}</th>
                        <td>{{r.name}}</td>
                        <td>{{ calculateAge(r.dob) }}</td>
                        <td>{{r.profession}}</td>
                        <td><NuxtLink class="btn btn-sm btn-primary" :to="'/profile/'+r.id">View Details</NuxtLink></td>
                      </tr>
                    
                    </tbody>
                  </table>
                </div>
              </div>
                <br/>
                <br/>

                <div class="d-flex flex-row justify-content-end" v-if="searchname">
                  <NuxtLink class="btn btn-primary w-100" to="/patientinfo/create">+ Create New</NuxtLink>
              </div>
              
                </div>
  
      
    
  
    </NuxtLayout>
  </template>
<script>
export default{
  data(){
    return {
        // patientId:"",
        // patientName:"",
        // gender:"",
        // dateOfBirth:"",
        // gender:"",
        // region:"",
        // address:"",
        // profession:"",
        searching:false,
        results:[],
        searchname:""
        
    }
  },
  mounted(){
   
  },
  methods:{
    calculateAge(dateString) {
      return calculateAge(dateString);
    },
    search(){
      if(!this.searchname){
        this.results=[];
        this.searching=false; 
        return;
      }

      this.searching = true;
      const context =this;
      getRequest_('/search-patient',{query:this.searchname},(r)=>{
        context.results = r;
        context.searching=false;
      },()=>{context.searching=false;})
    }
  }
}
</script>