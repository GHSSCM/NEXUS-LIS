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
                      <li class="breadcrumb-item active" aria-current="page">{{id=='create'?"New Lab Section":"Edit Lab Section"}}</li>
                    </ol>
                  </nav>
                </div>
                <div class="ms-auto d-none">
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
               
                <h6 class="mb-0 text-uppercase">{{id=='create'?"Create A New Lab Section":"Edit Lab Section"}}</h6>
                <hr/>
                <form @submit.prevent="save">    
                <div class="row">

                    <div class="col-sm-6 col-md-12">

                        <div class="mb-4">
                            <label class="form-label">Name</label>
                            <input required v-model="name" class="form-control" type="text" placeholder="Name"/>
                          </div>
                

                          

                    </div>
                    <div>
                        <div class="mb-4">
                            <label class="form-label">Description</label>
                            <textarea v-model="description"  class="form-control" type="text" placeholder="Description"></textarea>
                          </div>
                    </div>
                    <div class="col-sm-6 col-md-12">

                    <div class="mb-4">
                        <label class="form-label">Lab Techniques</label>
                        <br/>
                        <div >

                          <div class="d-flex align-items-center mt-3" v-for="(u,i) in techniques">


                              <input v-model="techniques[i]" required placeholder="Enter a technique here" class="form-control" style="max-width: 300px;"/>

                              <div class="d-flex" style="margin-left: 10px;">

                                <svg @click="techniques.splice(i,1)" style="color:red; cursor:pointer" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"><path fill="currentColor" d="M12 2C6.47 2 2 6.47 2 12s4.47 10 10 10s10-4.47 10-10S17.53 2 12 2m4.3 14.3a.996.996 0 0 1-1.41 0L12 13.41L9.11 16.3a.996.996 0 1 1-1.41-1.41L10.59 12L7.7 9.11A.996.996 0 1 1 9.11 7.7L12 10.59l2.89-2.89a.996.996 0 1 1 1.41 1.41L13.41 12l2.89 2.89c.38.38.38 1.02 0 1.41"/></svg>

                              </div>
                          </div>

                          <br/>

                          <div class="d-flex justify-content-end">
                              <button type="button" class="btn-sm btn-primary btn" @click="techniques.push('')">+ Add technique</button>
                          </div>
                        </div>
                      
                      </div>
                    </div>
            
                    <div class="row">
                      <div class="col-sm-12 col-md-6" v-for="(f,i) in fields" :key="'cf-'+i">
    
                        <div class="mb-4" v-if="f.type=='number'">
                          <label class="form-label">{{f.name}}</label>
                          <input v-model="meta['fields'][f.name]" :required="f.required" class=" form-control" type="number" :placeholder="f.name">
                        </div>
    
    
                          <div class="mb-4" v-else-if="f.type=='yesno'">
                              <input v-model="meta['fields'][f.name]" :required="f.required" class="form-check-input" type="checkbox" role="switch">
                              <label class="form-check-label ms-2" for="referredout">{{f.name}}</label>
                          </div>
                  
    
                          <div class="mb-4" v-else-if="f.type=='limitedvalues'">
                            <label class="form-label">{{f.name}}</label>
                            <multiselect v-model="meta['fields'][f.name]" :required="f.required" :options="f.meta.enum??[]"></multiselect>
                          </div>

                          <div class="mb-4" v-else-if="f.type=='limitedmultiplevalues'">
                            <label class="form-label">{{f.name}}</label>
                            <multiselect v-model="meta['fields'][f.name]" :required="f.required" :options="f.meta.enum??[]" multiple="true"></multiselect>
                          </div>

    
                          <div class="mb-4" v-else-if="f.type=='datetime'">
                            <label class="form-label">{{f.name}}</label>
                            <input v-model="meta['fields'][f.name]" :required="f.required" class=" form-control" type="datetime-local" :placeholder="f.name">
                          </div>
    
                          <div class="mb-4" v-else-if="f.type=='dateonly'">
                            <label class="form-label">{{f.name}}</label>
                            <input v-model="meta['fields'][f.name]" :required="f.required" class=" form-control" type="date" :placeholder="f.name">
                          </div>
    
                          <div class="mb-4" v-else-if="f.type=='timeonly'">
                            <label class="form-label">{{f.name}}</label>
                            <input v-model="meta['fields'][f.name]" :required="f.required" class=" form-control" type="time" :placeholder="f.name">
                          </div>
    
    
                          <div class="mb-4" v-else>
                            <label class="form-label">{{f.name}}</label>
                            <input v-model="meta['fields'][f.name]" :required="f.required" class=" form-control" type="text" :placeholder="f.name">
                          </div>
                      </div>
                   
    
                
    
    
    
                  </div>

                  
                    <div class="d-flex flex-row justify-content-end" v-if="name">
                      <button type="submit" class="btn btn-primary w-100">+ Save
                        </button>
                   
                    </div>
                 
                </div>

            

              </form>
                

                </div>
  
      
    
  
    </NuxtLayout>
  </template>
<script>
  export default {
    

    data(){
      const route=useRoute();
        return {
          id:route.params.id,
            loadedtests:[],
            techniques:[],
            name:"",
            description:"",fields:[],
            
            meta:{
            "fields":{}
          }
        }
    },
    mounted(){
      


      const context=this;
      getRequestLoad_('/lab-section/'+context.id,{
      
      },(data)=>{
        context.name=data.name;
        context.description=data.description;
        context.techniques=data.techniques;
        context.meta=data.meta;
      })

      getRequestLoad_('/customfields',{
        category:"labsection"
      },(fields)=>{
        context.fields= fields;
      })

     
    },
    methods:{
      save(){
        console.log(this.meta);
        const context=this;
        postRequestLoad_(context.id=='create'?'/lab-section':'/lab-section/'+context.id,{
          description:this.description,
          name:this.name,
          techniques:this.techniques,
          meta:this.meta
        },(specimen)=>{
          successToast("Created successfully");
        context.$router.push("/lab-sections");
      })
      }
    }
    
  }
</script>