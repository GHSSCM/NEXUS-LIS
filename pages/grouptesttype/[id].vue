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
                      <li class="breadcrumb-item active" aria-current="page">{{id=='create'?"New Group Test Type":"Edit Group Test Type"}}</li>
                    </ol>
                  </nav>
                </div>
                <!-- <div class="ms-auto">
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
                </div> -->
              </div>
              <!--end breadcrumb-->
  
              <div>
                       
                <h6 class="mb-0 text-uppercase">{{id=='create'?"Create A New Group Test Type":"Edit Group Test Type"}}</h6>
                <hr/>
                <form @submit.prevent="save">
                <div class="row">
                    <div class="col-sm-12 col-md-6">

                        <div class="mb-4">
                            <label class="form-label">Name</label>
                            <input v-model="name" required class="form-control" type="text" placeholder="Name"/>
                          </div>
                

                          

                    </div>
                    <div>
                        <div class="mb-4">
                            <label class="form-label">Description</label>
                            <textarea v-model="description" class="form-control" type="text" placeholder="Description"></textarea>
                          </div>
                    </div>
                   
            


                      <div class="mb-4">
                          <label class="form-label">Sub test(s)</label>
                         
                          <multiselect v-model="subtests" :options="loadedtests" label="name" track-by="uniqid" multiple></multiselect>
                      </div>



                      <div class="mb-4">
                        <label class="form-label">Compatible specimen(s)</label>
                       
                        <multiselect v-model="specimens" :options="loadedspecimens" label="name" track-by="uniqid" multiple></multiselect>

                      </div>
                </div>


            

                <hr/>
              
                  <div class="row">

                  

                

                    <div class="col-sm-12 col-md-6">

                        <div class="mb-4">
                            <label class="form-label">Target TAT </label>
                            <input v-model="tat" class="result form-control" type="text" placeholder="Target TAT"/>
                          </div>
                

                          

                    </div>

                    <div class="col-sm-12 col-md-6">

                        <div class="mb-4">
                            <label class="form-label">Cost to patient in {{curr}}</label>
                            <input  v-model="cost" class="form-control" type="number"  step="0.000000001"  placeholder="Cost to patient"/>
                          </div>
                

                          

                    </div>



                </div>
            
                <br/>
                <br/>
                <div class="d-flex flex-row justify-content-end">
                    <button type="submit" class="btn btn-primary w-100" >+ Save</button>
                </div>
                </form>
                <br/>
                <br/>
                <br/>
                </div>
  
      
    
  
    </NuxtLayout>
  </template>
  <script>
  export default{
    data(){
      const route = useRoute();
    const id= route.params.id;
        return {
          id,
            name:"",
            description:"",
            specimens:[],
            tat:"",
            cost:0,
            hidename:false,
            threshold:"",
            loadedtests:[],
            subtests:[],
            loadedspecimens:[],
            curr:getAppConfig("currency")
        }
    },
    mounted(){
      const context=this;
      getRequestLoad_('/specimentypes',{},(loadedspecimens)=>{
        context.loadedspecimens= loadedspecimens;
      getRequestLoad_('/testtypes',{type:"SINGLE"},(loadedtests)=>{
        context.loadedtests= loadedtests;
        if(context.id!='create'){
          getRequestLoad_('/grouptesttype/'+context.id,{},(testtype)=>{
            context.name=testtype.name;
            context.description=testtype.description;
            context.specimens=testtype.specimens;
            context.tat=testtype.tat;
            context.cost=testtype.cost??0;
            context.hidename=testtype.hidename;
            context.threshold=testtype.threshold;
            context.subtests=testtype.subtests;
          })
        }
      })
    });
    },
    methods:{
      save(){
        const context=this;
        const d = {
          description:this.description,
          name:this.name,
          tat:this.tat,
          cost:this.cost??0,
          type:"GROUP",
          specimens:JSON.parse(JSON.stringify(this.specimens.map(r=>r.uniqid))),
          hidename:false,
          threshold:"N/A",
          meta:{
            subtests:JSON.parse(JSON.stringify(this.subtests.map(r=>r.uniqid)))
          }
        };

        
        postRequestLoad_(context.id=='create'?'/testtype':'/testtype/'+context.id,d,(specimen)=>{
          if(context.id=='create'){
            successToast("Created successfully");
          }else{
            successToast("Updated successfully");
          }
        context.$router.push("/testtypes");
      })
      }
    }
  }
  </script>