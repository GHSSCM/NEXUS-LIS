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
                      <li class="breadcrumb-item active" aria-current="page">{{id=='create'?"New Test Type":"Edit Test Type"}}</li>
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
                       
                <h6 class="mb-0 text-uppercase">{{id=='create'?"Create a new test type":"Edit Test Type"}}</h6>
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
                    <div class="col-sm-12 col-md-6">

                    <div class="mb-4">
                        <label class="form-label">Compatible specimen(s)</label>
                        <multiselect v-model="specimens" :options="loadedspecimens" label="name" track-by="uniqid" multiple></multiselect>

                     

                      
                    </div>
                    </div>
            
                </div>

                <hr/>
                <p><strong>Measures</strong></p>
                <div v-for="f in meta.fields.measures">
                    <hr/>
                    <div class="row">
                        <div class="col-sm-2">
                            <label >Name</label>
                          <input class="form-control mb-3 mt-2" type="text" placeholder="Enter name">
                       </div>
                       <div class="col-sm-2">
                            <label class="mb-2">Data type</label>
                            <select class="form-control single-select-field " id="idk1" data-placeholder="Data type">
                                <option></option>
                                <option>Alpha numeric</option>
                                <option>Number</option>
                                <option>Yes/No</option>
                                <option>Limited values</option>
                                <option>Date/Time</option>
                                <option>Date Only</option>
                                <option>Time Only</option>
                            </select>
                     </div>

                     <div class="col-sm-4">
                        <label >Values</label>
                      <!-- <input class="form-control mb-3 mt-2" type="text" placeholder="Enter name"> -->
                   </div>

                   <div class="col-sm-3">
                    <label >Unit</label>
                  <!-- <input class="form-control mb-3 mt-2" type="text" placeholder="Enter name"> -->
               </div>

                
                     <div class="col-sm-1 d-flex align-items-center">
                        <center><i class="fadeIn animated bx bx-trash fs-5 mt-4 ms-2" style="color:red"></i></center>
                     </div>
                    </div>
                    <hr/>
                </div>


                <div class="d-flex flex-row justify-content-end">
                  <button type="button" class="btn btn-outline-primary btn-sm " style="border:0" @click="meta.fields.measures.push({})">+ Add Measures</button>
              </div>


                <hr/>
              
                  <div class="row">

                    <div class="col-sm-12 col-md-6">
                        <div class="mb-4">
                            <input v-model="hidename" class="form-check-input" type="checkbox" role="switch" id="referredout" checked>
                            <label class="form-check-label ms-2" for="referredout">Hide patient name in report?</label>
                     
                          </div>
                
                    </div>

                    <div class="col-sm-12 col-md-6">

                        <div class="mb-4">
                            <label class="form-label">Prevalence Threshold </label>
                            <input required v-model="threshold" class="form-control" type="number" placeholder="Prevalence Threshold"/>
                          </div>
                

                          

                    </div>


                    <div class="col-sm-12 col-md-6">

                        <div class="mb-4">
                            <label class="form-label">Target TAT </label>
                            <input required v-model="tat" class="result form-control" type="text" placeholder="Target TAT"/>
                          </div>
                

                          

                    </div>

                    <div class="col-sm-12 col-md-6">

                        <div class="mb-4">
                            <label class="form-label">Cost to patient in FCFA</label>
                            <input required v-model="cost" class="form-control" type="number" placeholder="Cost to patient"/>
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
            cost:1000,
            hidename:false,
            threshold:"",
            loadedspecimens:[],
            meta:{
              fields:{
                measures:[

                ]
              }
            }
        }
    },
    mounted(){
      const context=this;
      getRequestLoad_('/customfields',{
        category:"test"
      },(fields)=>{
        context.fields= fields;
      })

      getRequestLoad_('/specimentypes',{},(loadedspecimens)=>{
        context.loadedspecimens= loadedspecimens;
        if(context.id!='create'){
          getRequestLoad_('/testtype/'+context.id,{},(testtype)=>{
              context.name=testtype.name;
              context.description=testtype.description;
              context.specimens=testtype.specimens;
              context.tat=testtype.tat;
              context.cost=testtype.cost;
              context.hidename=testtype.hidename;
              context.threshold=testtype.threshold;
              context.meta=testtype.meta;
              if(!context.meta.fields){
                context.meta.fields={
                measures:[
                  
                ]};
              }
          })
        }
      })
    },
    methods:{
      save(){
        const context=this;
        postRequestLoad_(context.id=='create'?'/testtype':'/testtype/'+context.id,{
          description:this.description,
          name:this.name,
          specimens:JSON.parse(JSON.stringify(this.specimens.map(r=>r.uniqid))),
          tat:this.tat,
          hidename:this.hidename,
          threshold:this.threshold,
          cost:this.cost,
          meta:this.meta
        },(specimen)=>{
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