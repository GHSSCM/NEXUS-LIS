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
                        <label class="form-label">Compatible test(s)</label>
                       
                          <multiselect v-model="tests" :options="loadedtests" label="name" value="uniqid" multiple></multiselect>
                      
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
            tests:[],
            name:"",
            description:"",fields:[],
            meta:{
            "fields":{}
          }
        }
    },
    mounted(){
      


      const context=this;
      getRequestLoad_('/customfields',{
        category:"specimen"
      },(fields)=>{
        context.fields= fields;
      })

      getRequestLoad_('/testtypes',{},(loadedtests)=>{
        context.loadedtests= loadedtests;
        if(context.id!='create'){
          getRequestLoad_('/specimentype/'+context.id,{},(specimentype)=>{
              context.name=specimentype.name;
              context.description=specimentype.description;
              context.tests=specimentype.tests;
              context.meta= specimentype.meta;
              if(!context.meta.fields){
                context.meta.fields={};
              }
          })
        }
      })
    },
    methods:{
      save(){
        console.log(this.meta);
        const context=this;
        postRequestLoad_(context.id=='create'?'/specimentype':'/specimentype/'+context.id,{
          description:this.description,
          name:this.name,
          tests:JSON.parse(JSON.stringify(this.tests.map(r=>r.uniqid))),
          meta:this.meta
        },(specimen)=>{
          successToast("Created successfully");
        context.$router.push("/specimentypes");
      })
      }
    }
    
  }
</script>