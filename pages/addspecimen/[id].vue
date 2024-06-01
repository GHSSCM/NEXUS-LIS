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
                  <br/>
                  <strong class="text-primary">Specimen {{i+1}}</strong>
                  <br/>
                  <br/>
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
                           
                            <multiselect required  multiple v-if="inputdata[i].specimen" v-model="inputdata[i].tests" :options="inputdata[i].specimen.tests" label="name" track-by="uniqid" searchable></multiselect>
                            <p v-else> Choose a specimen type.</p>
                          </div>
                
                          
                    </div>

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
                            <label for="single-select-field3" class="form-label">Physician</label>
                            <multiselect required v-model="inputdata[i].physician" :options="physicians" searchable :taggable="true"
                            @tag="addNewPhysicianOption(i,$event)"></multiselect>
                            
                          </div>
                
                          
                    </div>


                    <div class="col-sm-12 col-md-6">

                        <div class="mb-4">
                            <label for="single-select-field5" class="form-label">Sample state</label>
                            <multiselect required v-model="inputdata[i].state" :options="['N/A','Rejected','Approved']"></multiselect>

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
                            <input v-model="inputdata[i].referredout" class="form-check-input" type="checkbox" role="switch" :id="i+'referredout'" >
                            <label  class="form-check-label ms-2" :for="i+'referredout'">Reffered Out?</label>
                     
                          </div>
                          <div class="mb-4" v-if="inputdata[i].referredout">

                            <label  class="form-check-label ms-2" :for="i+'referredto'">Reffered To?</label>
                            <input required v-model="inputdata[i].referredto" class="form-control" type="text"  :id="i+'referredto'" >
                            
                     
                          </div>
            
                    </div>


                    <div class="col-sm-12 col-md-6">

                        <div class="mb-4">
                            <input v-model="inputdata[i].conformity"  class="form-check-input" type="checkbox" role="switch" id="conformitycheck" checked>
                            <label class="form-check-label ms-2" for="conformitycheck">Conformity?</label>
                     
                          </div>
                
            
                    </div>

                  </div>
                  <div class="d-flex flex-row justify-content-end">
                    <button v-if="inputdata.length>1" type="button" class="btn btn-outline-danger btn-sm " style="border:0" @click="deleteSpecimen(i)">- Remove Specimen</button>
                  </div>

                  <hr/>
                </div>

                  

                <div class="d-flex flex-row justify-content-end">
                    <button  type="button" class="btn btn-outline-primary " style="border:0" @click="newspecimen">+ Add Specimens</button>
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
      deleteSpecimen(i){
          this.inputdata.splice(i,1);
      },
      newspecimen(){
        this.inputdata.push({
                specimen:null,
                meta:{"a":"b"},
                tests:[],
                patient:this.inputdata[0].patient,
                receptiondate:null,
                receptiontime:null,
                state:"N/A",
                physician:null,
                preleveur:null,
                referredout:false,
                conformity:false,
                referredto:null
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
        var inf=[];
        for(var i=0; i<ata.length;i++){
          var r= ata[i];
            if(r.specimen==null){
              errorToast("No specimen choosen for specimen "+(i+1));
              return
            }
            if(r.tests==null||r.tests.length==0){
              errorToast("No test(s) choosen for specimen "+(i+1));
              return
            }
            
            r.specimen =  r.specimen.uniqid;
            r.tests = r.tests.map(t=>t.uniqid);
            inf.push(r);
        }

        // console.log(JSON.parse(JSON.stringify(inf)));
        
        const context=this;
      postRequestLoad_('/addspecimen',{
        ata:inf
      },()=>{
          successToast("Saved successfully");
          context.$router.push("/specimens")
        
      })
      
     
      }
    },
    data(){
      const route = useRoute();

        return {
            patientId:route.params.id,
            patient:{},
            physicians:[],
            preleveurs:[],
            specimens:[],

            inputdata:[
              {
                specimen:null,
                meta:{"a":"b"},
                tests:[],
                patient:null,
                receptiondate:null,
                receptiontime:null,
                state:"N/A",
                physician:null,
                preleveur:null,
                referredout:false,
                conformity:false,
                referredto:null
              }
            ]
        }
    },
    mounted(){
      const context=this;
      getRequestLoad_('/addspecimen-data/'+this.patientId,{},(data)=>{
        context.patient = data.patient;
        context.physicians = data.physicians;
        context.preleveurs = data.preleveurs;
        context.specimens = data.specimens;
        for(var i=0;i<context.inputdata.length;i++){
          context.inputdata[i].patient = data.patient.uniqid;
        }
        
        
      });
    
    }
  }
</script>