<template>
  <NuxtLayout name="lablayout">
      
            <!--start breadcrumb-->
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
              <div class="breadcrumb-title pe-3">
                <Translate text="Nexus Lab" />
              </div>
              <div class="ps-3">
                <nav aria-label="breadcrumb">
                  <ol class="breadcrumb mb-0 p-0 align-items-center">
                    <li class="breadcrumb-item">
                      <a href="javascript:;">
                        <ion-icon name="home-outline"></ion-icon>
                      </a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                      <Translate text="Add specimen" />
                    </li>
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
              <h6 class="mb-0 text-uppercase">
                <Translate text="Register Specimen(s)" />
              </h6>
              <p>
                <Translate text="Patient:" /> 
                <strong>
                  {{ patient.name }}, {{ calculateAge(patient.dob) }} 
                  <Translate text="year(s) old, Patient REF:" /> {{ patient.reference }}
                </strong>
              </p>
              <hr/>

              <div v-for="(po,i) in inputdata">
                <br/>
                <strong class="text-primary">
                  <Translate text="Specimen" /> {{ i+1 }}
                </strong>
                <br/>
                <br/>
                <div class="row">
                  
                  <div class="col-sm-12 col-md-6">
                    <div class="mb-4">
                      <label :for="'single-select-field1'+pos" class="form-label">
                        <Translate text="Specimen type" />
                      </label>
                      <multiselect required v-model="inputdata[i].specimen" :options="specimens" label="name" track-by="uniqid" searchable></multiselect>
                    </div>
                  </div>
                  
                  <div class="col-sm-12 col-md-6">
                    <div class="mb-4">
                      <label for="single-select-field2" class="form-label">
                        <Translate text="Test type(s)" />
                      </label>
                      <multiselect required multiple v-if="inputdata[i].specimen" v-model="inputdata[i].tests" :options="inputdata[i].specimen.tests" label="name" track-by="uniqid" searchable></multiselect>
                      <p v-else>
                        <Translate text="Choose a specimen type." />
                      </p>
                    </div>
                  </div>

                  <div class="col-sm-12 col-md-6">
                    <div class="mb-4">
                      <label class="form-label">
                        <Translate text="Date of reception" />
                      </label>
                      <input v-model="inputdata[i].receptiondate" required class="result form-control" type="date" :placeholder="$t('Date of reception')">
                    </div>
                  </div>

                  <div class="col-sm-12 col-md-6">
                    <div class="mb-4">
                      <label class="form-label">
                        <Translate text="Time of reception (optional)" />
                      </label>
                      <input v-model="inputdata[i].receptiontime" class="result form-control" type="time" :placeholder="$t('Time of reception')">
                    </div>
                  </div>

                  <div class="col-sm-12 col-md-6">
                    <div class="mb-4">
                      <label class="form-label">
                        <Translate text="Date of collection" />
                      </label>
                      <input v-model="inputdata[i].collectiondate" required class="result form-control" type="date" :placeholder="$t('Date of collection')">
                    </div>
                  </div>

                  <div class="col-sm-12 col-md-6">
                    <div class="mb-4">
                      <label class="form-label">
                        <Translate text="Time of collection (optional)" />
                      </label>
                      <input v-model="inputdata[i].collectiontime" class="result form-control" type="time" :placeholder="$t('Time of collection')">
                    </div>
                  </div>

                  <div class="col-sm-12 col-md-6">
                    <div class="mb-4">
                      <label class="form-label">
                        <Translate text="Place of Collection" />
                      </label>
                      <input v-model="inputdata[i].placeofcollection" class="result form-control" type="text" :placeholder="$t('Place of Collection')">
                    </div>
                  </div>

                  <div class="col-sm-12 col-md-6">
                    <div class="mb-4">
                      <label for="single-select-field3" class="form-label">
                        <Translate text="Physician" />
                      </label>
                      <multiselect required v-model="inputdata[i].physician" :options="physicians" searchable :taggable="true"
                        @tag="addNewPhysicianOption(i,$event)"></multiselect>
                    </div>
                  </div>

                  <!-- Sample state commented out remains unchanged -->

                  <div class="col-sm-12 col-md-6">
                    <div class="mb-4">
                      <label for="single-select-field5" class="form-label">
                        <Translate text="Sample quality" />
                      </label>
                      <multiselect required v-model="inputdata[i].sample_quality" :options="['PASSED','FAILED']"></multiselect>
                    </div>
                  </div>
                  
                  <div class="col-sm-12 col-md-12" v-if="inputdata[i].sample_quality=='FAILED'">
                    <div class="mb-4">
                      <label for="single-select-field5" class="form-label">
                        <Translate text="Sample quality reason" />
                      </label>
                      <textarea required v-model="inputdata[i].sample_quality_reason" class="form-control" type="text"></textarea>
                    </div>
                  </div>

                  <div class="col-sm-12 col-md-6">
                    <div class="mb-4">
                      <label for="single-select-field4" class="form-label">
                        <Translate text="Preleveur" />
                      </label>
                      <multiselect required v-model="inputdata[i].preleveur" :options="preleveurs" searchable :taggable="true"
                        @tag="addNewPreleveurOption(i,$event)"></multiselect>
                    </div>
                  </div>

                  <!-- Technique commented out remains unchanged -->

                  <div class="col-sm-12 col-md-6">
                    <div class="mb-4">
                      <div class="d-flex">
                        <div @click="inputdata[i].referredin=false">
                          <input v-model="inputdata[i].referredout" class="form-check-input" type="checkbox" role="switch" :id="i+'referredout'">
                          <label class="form-check-label ms-2" :for="i+'referredout'">
                            <Translate text="Referred Out?" />
                          </label>
                        </div>
                        <div @click="inputdata[i].referredout=false" class="ms-3">
                          <input v-model="inputdata[i].referredin" class="form-check-input" type="checkbox" role="switch" :id="i+'referredin'">
                          <label class="form-check-label ms-2" :for="i+'referredin'">
                            <Translate text="Referred In?" />
                          </label>
                        </div>
                      </div>
                    </div>
                    <div class="mb-4" v-if="inputdata[i].referredout || inputdata[i].referredin">
                      <label class="form-check-label ms-2" :for="i+'referredto'">
                        <Translate text="Facility" />
                      </label>
                      <input required v-model="inputdata[i].referredto" class="form-control" type="text" :id="i+'referredto'">
                    </div>
                  </div>

                </div>
                <div class="d-flex flex-row justify-content-end">
                  <button v-if="inputdata.length>1" type="button" class="btn btn-danger btn-sm mb-2" style="border:0" @click="deleteSpecimen(i)">
                    - <Translate text="Remove Specimen" />
                  </button>
                </div>

                <div class="d-flex flex-row justify-content-end">
                  <button type="button" class="btn btn-secondary btn-sm" style="border:0" @click="duplicateSpecimen(inputdata[i],i)">
                    <i class="fadeIn animated bx bx-layer-plus"></i> <Translate text="Duplicate Specimen" />
                  </button>
                </div>

                <hr/>
              </div>

              <div class="d-flex flex-row justify-content-end">
                  <button type="button" class="btn btn-outline-primary" style="border:0" @click="newspecimen">
                    + <Translate text="Add Specimens" />
                  </button>
              </div>

              <div class="mt-5">
                  <button class="btn btn-primary w-100" type="submit">
                    + <Translate text="Save" />
                  </button>
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
    mounted(){
      forceOutPermissionVerify('LABORATORY.REGISTER_SPECIMEN',this); 
    },  
    methods:{
      duplicateSpecimen(o,i){
        this.inputdata.splice(i,0,JSON.parse(JSON.stringify(o)));
      },
      calculateAge(dob){
        return calculateAge(dob);
      },
      deleteSpecimen(i){
          this.inputdata.splice(i,1);
      },
      newspecimen(){
        const date=new Date();
        this.inputdata.push({
                specimen:null,
                meta:{"a":"b"},
                tests:[],
                patient:this.inputdata[0].patient,
                receptiontime:null,
                collectiontime:null,
                state:"Registered",
                physician:null,
                preleveur:null,
                referredout:false,
                referredin:false,
                conformity:false,
                referredto:null,
                receptiondate:date.toISOString().split("T")[0],
                collectiondate:date.toISOString().split("T")[0],
                groupID:this.groupID
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
          successToast(this.$t("Saved successfully"));
          window.location.href=("/nexus.lab/specimens")
          // context.$router.push("/nexus.lab/specimens")
        
      })
      
     
      }
    },
    data(){
      const route = useRoute();
      const groupID = generateRandomStringWithTimestamp();
        return {
            patientId:route.params.id,
            patient:{},
            physicians:[],
            preleveurs:[],
            specimens:[],
            techniques:[],
            groupID,
            inputdata:[
              {
                specimen:null,
                meta:{"a":"b"},
                tests:[],
                patient:null,
                receptiontime:null,
                collectiontime:null,
                state:"Registered",
                physician:null,
                preleveur:null,
                referredout:false,
                conformity:false,
                referredto:null,
                receptiondate:(new Date()).toISOString().split("T")[0],
                collectiondate:(new Date()).toISOString().split("T")[0],
                groupID
              }
            ]
        }
    },
    mounted(){
      const context=this;
      getRequestLoad_('/addspecimen-data/'+this.patientId,{},(data)=>{
        context.patient = data.patient;
        context.physicians = data.physicians.filter(x=>(x!=null));
        context.preleveurs = data.preleveurs.filter(x=>(x!=null));
        context.specimens = data.specimens.filter(x=>(x!=null));
        context.techniques=data.techniques.filter(x=>(x!=null));
        for(var i=0;i<context.inputdata.length;i++){
          context.inputdata[i].patient = data.patient.uniqid;
        }
        
        
      });
    
    }
  }
</script>