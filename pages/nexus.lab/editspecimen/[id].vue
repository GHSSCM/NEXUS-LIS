<template>
    <NuxtLayout name="lablayout">
        
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
                      <li class="breadcrumb-item active" aria-current="page">Edit specimen</li>
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
  
              <form @submit.prevent="save">
              
              
                <br/>
                <h6 class="mb-0 text-uppercase">Register Specimen(s)</h6>
                <p>Patient: <strong>{{ patient.name }}, {{calculateAge(patient.dob)}} year(s) old, Patient REF: {{patient.reference}}</strong></p>
                <hr/>

               
                <div v-for="(po,i) in inputdata">
                  <!-- <br/>
                  <strong class="text-primary">Specimen {{i+1}}</strong>
                  <br/>
                  <br/> -->
                <div class="row" >
                    
                    <div class="col-sm-12 col-md-6">

                        <div class="mb-4">
                            <label :for="'single-select-field1'+pos" class="form-label">Specimen type</label>
                           
                          <multiselect required v-model="inputdata[i].specimen" :options="specimens" label="name" track-by="uniqid" searchable></multiselect>
                            
                          </div>
                
                          
                    </div>
                    <div class="col-sm-12 col-md-6">

                        <div class="mb-4">
                            <label for="single-select-field2" class="form-label">Test type(s)</label>
                           
                            <multiselect required  v-if="inputdata[i].specimen" v-model="inputdata[i].test" :options="inputdata[i].specimen.tests" label="name" track-by="uniqid" searchable></multiselect>
                            <p v-else> Choose a specimen type.</p>
                          </div>
                
                          
                    </div>

                    <!-- <div class="col-sm-12 col-md-6">

                        <div class="mb-4">
                            <label class="form-label">Date of reception</label>
                            <input v-model="inputdata[i].receptiondate" required class="result form-control " type="date" placeholder="Date of reception">
                          </div>
                
                          
                    </div>


                    <div class="col-sm-12 col-md-6">

                      <div class="mb-4">
                          <label class="form-label">TIme of reception (optional)</label>
                          <input v-model="inputdata[i].receptiontime"  class="result form-control " type="time" placeholder="Time of reception">
                        </div>
              
                        
                  </div> -->




                  <div class="col-sm-12 col-md-6">

                    <div class="mb-4">
                        <label class="form-label">Date of reception</label>
                        <input v-model="inputdata[i].receptiondate" required class="result form-control " type="date" placeholder="Date of reception">
                      </div>
            
                      
                </div>


                <div class="col-sm-12 col-md-6">

                  <div class="mb-4">
                      <label class="form-label">TIme of reception (optional)</label>
                      <input v-model="inputdata[i].receptiontime"  class="result form-control " type="time" placeholder="Time of reception">
                    </div>
          
                    
              </div>


              <div class="col-sm-12 col-md-6">

                <div class="mb-4">
                    <label class="form-label">Date of collection</label>
                    <input v-model="inputdata[i].collectiondate" required class="result form-control " type="date" placeholder="Date of collection">
                  </div>
        
                  
            </div>


            <div class="col-sm-12 col-md-6">

              <div class="mb-4">
                  <label class="form-label">TIme of collection (optional)</label>
                  <input v-model="inputdata[i].collectiontime"  class="result form-control " type="time" placeholder="Time of collection">
                </div>
      
                
          </div>



                  <div class="col-sm-12 col-md-6">

                    <div class="mb-4">
                        <label class="form-label">Place of Collection</label>
                        <input v-model="inputdata[i].placeofcollection"  class="result form-control " type="text" placeholder="Place of Collection">
                      </div>
            
                      
                </div>






                    <div class="col-sm-12 col-md-6">

                        <div class="mb-4">
                            <label for="single-select-field3" class="form-label">Physician</label>
                            <multiselect required v-model="inputdata[i].physician" :options="physicians" searchable :taggable="true"
                            @tag="addNewPhysicianOption(i,$event)"></multiselect>
                            
                          </div>
                
                          
                    </div>


                    <div class="col-sm-12 col-md-6">

                        <div class="mb-4">
                            <label for="single-select-field5" class="form-label">Sample state</label>
                            <multiselect required v-model="inputdata[i].state" :options="['Registered','Tested','Results Available','Results Printed']"></multiselect>

                          </div>
                
            
                    </div>

                    <div class="col-sm-12 col-md-6">

                      <div class="mb-4">
                          <label for="single-select-field5" class="form-label">Sample quality</label>
                          <multiselect required v-model="inputdata[i].sample_quality" :options="['PASSED','FAILED']"></multiselect>

                      </div>
              
                  </div>
                  <div class="col-sm-12 col-md-12" v-if="inputdata[i].sample_quality=='FAILED'">

                    <div class="mb-4">
                        <label for="single-select-field5" class="form-label">Sample quality reason</label>
                        <textarea required v-model="inputdata[i].sample_quality_reason" class="form-control" type="text" ></textarea>


                    </div>
            
                </div>

                    <div class="col-sm-12 col-md-6">

                        <div class="mb-4">
                            <label for="single-select-field4" class="form-label">Preleveur</label>
                            <multiselect required v-model="inputdata[i].preleveur" :options="preleveurs" searchable :taggable="true"
                            @tag="addNewPreleveurOption(i,$event)"></multiselect>
                          </div>
                
            
                    </div>

                    <div class="col-sm-12 col-md-6">

                        <div class="mb-4">
                          <div class="d-flex">

                            <div @click="inputdata[i].referredin=false">
                              <input v-model="inputdata[i].referredout" class="form-check-input" type="checkbox" role="switch" :id="i+'referredout'" >
                              <label  class="form-check-label ms-2" :for="i+'referredout'">Reffered Out?</label>
                     
                            </div>

                            <div @click="inputdata[i].referredout=false" class="ms-3">
                              <input v-model="inputdata[i].referredin" class="form-check-input" type="checkbox" role="switch" :id="i+'referredin'" >
                              <label  class="form-check-label ms-2" :for="i+'referredin'">Reffered In?</label>
                     
                            </div>


                          </div>
                     
                          </div>

                          <div class="mb-4" v-if="inputdata[i].referredout||inputdata[i].referredin">

                            <label  class="form-check-label ms-2" :for="i+'referredto'">Facility</label>
                            <input required v-model="inputdata[i].referredto" class="form-control" type="text"  :id="i+'referredto'" >
                            
                     
                          </div>
                
            
                    </div>


                    <!-- <div class="col-sm-12 col-md-6">

                      <div class="mb-4">
                          <label for="single-select-field4" class="form-label">Technique</label>
                          <multiselect required v-model="inputdata[i].technique" :options="techniques" searchable></multiselect>
                        </div>
              
          
                  </div> -->

                    <div class="col-sm-12 col-md-6">

                        <div class="mb-4">
                            <input v-model="inputdata[i].conformity"  class="form-check-input" type="checkbox" role="switch" id="conformitycheck" checked>
                            <label class="form-check-label ms-2" for="conformitycheck">Conformity?</label>
                     
                          </div>
                
            
                    </div>

                  </div>
                  <hr/>
                </div>

      
                
                  <div class="mt-5">
                    <button class="btn btn-primary w-100" type="submit">+ Save</button>
                </div>
                
                <br/>
                <br/>
                <br/>
                <br/>
  
  
              </form>
  
      
    
  
    </NuxtLayout>
  </template>
  
<script>
  export default{
    methods:{
      calculateAge(dob){
        return calculateAge(dob);
      },
      newspecimen(){
        this.inputdata.push({
                specimen:null,
                meta:{"a":"b"},
                test:null,
                patient:this.inputdata[0].patient,
                receptiondate:null,
                receptiontime:null,
                state:"Registered",
                physician:null,
                preleveur:null,
                referredout:false,
                referredin:false,
                conformity:false,
                referredto:null,
              })
      },
      addNewPhysicianOption(i,newOption){

      console.log(i, newOption);

      this.inputdata[i].physician=newOption;

     
      },
      addNewPreleveurOption(i,newOption){

      console.log(i, newOption);

      this.inputdata[i].preleveur=newOption;

     
      },
      save(){
      
        var ata =JSON.parse(JSON.stringify(this.inputdata));

        console.log(ata);
        // return;
        var inf=[];
        for(var i=0; i<ata.length;i++){
          var r= ata[i];
            if(r.specimen==null){
              errorToast("No specimen choosen for specimen "+(i+1));
              return
            }
            if(r.test==null){
              errorToast("No test choosen for specimen "+(i+1));
              return
            }
            
            r.specimen =  r.specimen.uniqid;
            r.test = r.test.uniqid;
            inf.push(r);
        }

        // alert(JSON.stringify(inf));
        // return;
        const context=this;
      postRequestLoad_('/editspecimen/'+this.id,inf[0],()=>{
          successToast(this.$t("Saved successfully"));
          context.$router.push("/nexus.lab/specimens")
        
      })
      
     
      }
    },
    data(){
      const route = useRoute();

        return {
          id:route.params.id,
            patientId:null,
            patient:{},
            physicians:[],
            preleveurs:[],
            specimens:[],
            techniques:[],
            inputdata:[
              {
                specimen:null,
                meta:{"a":"b"},
                test:null,
                patient:null,
                receptiondate:null,
                receptiontime:null,
                state:"Registered",
                physician:null,
                preleveur:null,
                referredout:false,
                referredin:false,
                conformity:false,
                technique:null
              }
            ]
        }
    },
    mounted(){
      const context=this;
      getRequestLoad_('/editspecimen-data/'+this.id,{},(data)=>{  
        console.log((data.inputdata));
        context.patient = data.patient;
        context.patientId = data.patientId;
            
        context.patient.id = data.patient.id;
        context.physicians = data.physicians??[];
        context.preleveurs = data.preleveurs;
        context.specimens = data.specimens;
        context.techniques = data.techniques;

        // console.log(data.inputdata.specimen);
        // context.inputdata[0].specimen = data.inputdata.specimen;
        // for(var i=0;i<context.inputdata.length;i++){
        //   context.inputdata[i].patient = data.patient.uniqid;
        // }
        // const r = data.inputdata;
        // r.po
        context.inputdata[0]=data.inputdata;
        context.inputdata[0].referredin=context.inputdata[0].referredin==1||context.inputdata[0].referredin;
        context.inputdata[0].referredout=context.inputdata[0].referredout==1||context.inputdata[0].referredout;
        
        // console.log("OKAY",data.inputdata);
      });
    
    }
  }
</script>