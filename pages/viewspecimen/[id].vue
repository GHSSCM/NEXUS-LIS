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
                      <li class="breadcrumb-item active" aria-current="page">Specimen & Test Details</li>
                    </ol>
                  </nav>
                </div>
            
              </div>
              <!--end breadcrumb-->
  
              <div>
                       
                <!-- <h6 class="mb-0 text-uppercase">Page</h6> -->
                <hr/>
                <br/>
                
                <div class="row" v-if="specimen">



                   <div class="col-sm-8">

                   </div>
                   <div class="col-sm-4">
                    <NuxtLink class="btn btn-primary btn-sm my-3 mb-5" target="_blank" v-if="meta.validated" :to="baseUrl+'/test-report/'+specimen.id+'.pdf'">Export PDF</NuxtLink>
                   </div>


                    <div class="col-sm-12 col-md-4">
                        <p><b>Received:</b> {{specimen.receptiondate}}  {{specimen.receptiontime}}</p>
                    </div>


                    <div class="col-sm-12 col-md-4">
                        <p><b>Preleveur:</b> {{specimen.preleveur}}</p>
                    </div>



                    <div class="col-sm-12 col-md-4">
                        <p><b>Physician:</b> {{specimen.physician}}</p>
                    </div>


                    <div class="col-sm-12 col-md-12" v-if="meta.enteredby">
                        <p><b>Entered by:</b> {{meta.enteredby}}</p>
                    </div>

                    <div class="col-sm-12 col-md-12" v-if="meta.verifiedby">
                        <p><b>Verified by:</b> {{meta.verifiedby}}</p>
                    </div>

                    <div class="col-sm-12 col-md-12" v-if="specimen.referredout">
                        <p><b>Referred from:</b> {{specimen.referredto}}</p>
                    </div>

                   

                    <div class="col-sm-12 my-2">

                    </div>

                    <div class="col-sm-12 col-md-4">
                        <p><b>Specimen:</b> {{specimen.specimen.name}}</p>
                    </div>
                    <div class="col-sm-12 col-md-8">
                        <p><b>Description:</b> {{specimen.specimen.description}}</p>
                    </div>

                    <div class="col-sm-12 my-2">

                    </div>


                    <div class="col-sm-12 col-md-4">
                        <p><b>Test:</b> {{specimen.test.name}}</p>
                    </div>


                    <div class="col-sm-12 col-md-8">
                        <p><b>Description:</b> {{specimen.test.description}}</p>
                    </div>


                    <div class="col-sm-12 col-md-4">
                        <p><b>Expected TAT:</b> {{specimen.test.tat}} {{specimen.test.tatunit}}</p>
                    </div>

                    <div class="col-sm-12 col-md-4">
                        <p><b>Expected Cost:</b> {{specimen.test.cost}} {{curr}}</p>
                    </div>


                    <div class="col-sm-12 col-md-4">
                        <p><b>Test type:</b> {{specimen.test.type}}</p>
                    </div>



                    <div class="col-sm-12 my-2">

                    </div>

                    <div class="col-sm-12 col-md-6">
                        <p><b>Patient:</b> {{specimen.patient.name}}, {{specimen.patient.gender=='M'?'Male':'Female'}}, Age: {{calculateAge(specimen.patient.dob)}}</p>
                    </div>



                </div>
                </div>

                <form @submit.prevent="save"  class="p-4 mt-5" style="border:1px solid #e0e0e0;background:#f2f2f2;border-radius:5px" v-if="specimen && specimen.test.meta.fields && specimen.test.meta.fields.measures">
                    <h5 class=" mb-3">Test Results</h5>
  
                <div class="row p-2">
                    <div class="col-sm-2">
                        <h6><b>Measures</b></h6>
                    </div>
                    <div class="col-sm-7">
                        <h6><b>Values</b></h6>
                    </div>
                    <div class="col-sm-3">
                        <h6><b>Remarks (Optional)</b></h6>
                    </div>
                </div>
                <div class="row p-4" v-if="specimen" v-for="(m,j) in specimen.test.meta.fields.measures">
                    <div class="col-sm-2">
                        <h6><b>{{m.name}}</b></h6>
                    </div>

                    <div class="col-sm-7" v-if="m.subs.length==0">
                        <multiselect v-if="m.type=='alphanumeric'" :disabled="meta.validated" v-model="meta.results[j].value" :options="m.alphanumericvalues" ></multiselect>
                        <div v-else-if="m.type=='autocomplete'">
                            <input placeholder="Enter value here" :disabled="meta.validated" required :list="m.id+'_suggestions'"  type="text" class="form-control" v-model="meta.results[j].value" />
                            <datalist :id="m.id+'_suggestions'">
                                <option v-for="auto in m.autocompletevalues" :value="auto.text"/>
                            </datalist>
                        </div>
                        <input placeholder="Enter value here" :disabled="meta.validated"  required v-else-if="m.type=='numericrange'"  type="number" class="form-control" v-model="meta.results[j].value" />
                        <textarea required :disabled="meta.validated" v-else type="text" class="form-control" v-model="meta.results[j].value" ></textarea>
                    </div>

                    <div class="col-sm-3" v-if="m.subs.length==0">
                        <input :disabled="meta.validated" placeholder="Enter optional remark here" type="text" class="form-control" v-model="meta.results[j].remark" />
                    </div>

                    <div v-else-if='meta.results'>
<!-- SUB START -->
                            <div class="row p-4" v-if="specimen && m.subs.length>0" v-for="(s,h) in m.subs">
                                <div class="col-sm-2">
                                    
                                    <h6><b>{{s.name}}</b></h6>  <small v-if="meta.results[j].subs[h].guide">{{meta.results[j].subs[h].guide}}</small>
                                </div>

                                <div class="col-sm-7">
                                    <multiselect :disabled="meta.validated" v-if="s.type=='alphanumeric'" v-model="meta.results[j].subs[h].value" :options="s.alphanumericvalues" ></multiselect>
                                    <div v-else-if="s.type=='autocomplete'">
                                        <input  :disabled="meta.validated" placeholder="Enter value here" required :list="s.id+'_suggestions'"  type="text" class="form-control" v-model="meta.results[j].subs[h].value" />
                                        <datalist :id="s.id+'_suggestions'">
                                            <option v-for="auto in s.autocompletevalues" :value="auto.text"/>
                                        </datalist>
                                    </div>
                                    <input :disabled="meta.validated" placeholder="Enter value here" required v-else-if="s.type=='numericrange'"  type="number" class="form-control" v-model="meta.results[j].subs[h].value" />
                                    <textarea :disabled="meta.validated" required v-else type="text" class="form-control" v-model="meta.results[j].subs[h].value" ></textarea>
                                </div>

                                <div class="col-sm-3">
                                    <input :disabled="meta.validated"  placeholder="Enter optional remark here" type="text" class="form-control" v-model="meta.results[j].subs[h].remark" />
                                </div>
                            </div>
        <!-- SUB END -->
                    </div>
                    <div>
                </div>
                
                </div>
                <div class="d-flex align-items-end justify-content-end" v-if="!meta.validated">
                    <button  type="submit" class="btn btn-primary btn-sm  ">+ Save Results</button>

                </div>
        
                <div  v-if="canValidate">

                    <button :disabled="meta.validated" @click="validate"  type="button" class="btn btn-success btn-sm  w-100 mt-4 ">&check; {{meta.validated?"Verified by "+meta.verifiedby:"Validate Results"}}</button>
                </div>
                </form>
                <div v-else class="my-5 p-3">
                    <center><p><b>Nothing else to show</b></p></center>
                </div>
            <br/>
            <br/>
            <br/>
      
    
  
    </NuxtLayout>
  </template>
  <script>
  export default{

    mounted(){
      const context=this;
      setTimeout(function(){
            console.log('/specimen/'+context.id)
          getRequestLoad_('/specimen/'+context.id,{},(specimen)=>{
            
            
            context.specimen= specimen;
            if(!context.specimen.test.meta.fields || !context.specimen.test.meta.fields.measures){
                return;
            }
            const age =  context.calculateAge(specimen.patient.dob);
            const gender = specimen.patient.gender;

            if(specimen.meta.results && specimen.meta.results.length>0){
                context.canValidate=true;
            }
            if(specimen.meta){
                context.meta=specimen.meta;
            }
            if(!specimen.meta.results){
                context.meta.results=[]
            }
            for(var i=0;i<context.specimen.test.meta.fields.measures.length;i++){
                const measure = context.specimen.test.meta.fields.measures[i];
                if(!context.meta.results[i]){
                    context.meta.results.push({
                        name:measure.name,
                        unit:measure.unit,
                        subs:[]
                    })
                }
                if(measure.type=='numericrange'){
                    //for main measures.
                    const measureValuesRange = measure.numericrangevalues;
                    measureValuesRange.forEach(range=>{
                        // check if gender corresponds
                        if(range.gender!=gender && range.gender!='B'){
                            return;
                        }

                        // check if age corresponds
                        if(!(age>=range.v1 && age <= range.v2)){
                            return;
                        }
                        context.meta.results[i].guide=`Range (${range.start} - ${range.end}) ${measure.unit}`;
                        // to help me show which is not a recognized value
                        context.meta.results[i].minValue=range.start;
                        context.meta.results[i].maxValue=range.end;
                        context.meta.results[i].unit=measure.unit;
                    })
                }else{

                    context.meta.results[i].unit=measure.unit;
                }
                if(measure.subs){
                    for(var j=0;j<measure.subs.length;j++){
                    const submeasure = measure.subs[j];
                       if(!context.meta.results[i].subs[j])
                       {
                            context.meta.results[i].subs.push({
                                name:submeasure.name,
                                unit:submeasure.unit
                            })
                       }

                       if(submeasure.type=='numericrange'){
                            //for sub measures.
                            const submeasureValuesRange = submeasure.numericrangevalues;
                            submeasureValuesRange.forEach(range=>{
                                // check if gender corresponds
                                if(range.gender!=gender && range.gender!='B'){
                                    return;
                                }

                                // check if age corresponds
                                if(!(age>=range.v1 && age <= range.v2)){
                                    return;
                                }
                                context.meta.results[i].subs[j].guide=`Range (${range.start} - ${range.end}) ${measure.unit}`;
                                // to help me show which is not a recognized value
                                context.meta.results[i].subs[j].minValue=range.start;
                                context.meta.results[i].subs[j].maxValue=range.end;
                                context.meta.results[i].subs[j].unit=submeasure.unit;
                            })
                        }else{

                            context.meta.results[i].subs[j].unit=submeasure.unit;
                        }

                    }
                }
            }
            // console.log(JSON.parse(JSON.stringify(context.meta.results)))
          });

      },500)
    },  
    methods:{
      calculateAge(dob){
          return calculateAge(dob);
      }  ,
      save(){
        if(window.confirm("Are you sure you want to confirm update of these results?")){
            const context=this;
            postRequestLoad_("/specimenupdate/"+this.id,{meta:this.meta,user:this.user.name},(meta)=>{
                context.canValidate=true;
                context.meta=meta;
                successToast("Updated Successfully")
            })
        }
      },
      validate(){
        if(window.confirm("Are you sure you want to confirm verification of these results?")){
            const context=this;
            postRequestLoad_("/specimenvalidate/"+this.id,{meta:this.meta,user:this.user.name},(meta)=>{
                context.meta=meta;
                successToast("Validated Successfully")
            })
        }
      }
    }, 
    data(){
      const route=useRoute();

      return {
        baseUrl:BASE_URL,
         user:window?(window.localStorage.getItem("user")?JSON.parse(window.localStorage.getItem("user")):null):null,
          id:route.params.id,
          specimen:null,
          canValidate:false,
            curr:getAppConfig("currency"),
            meta:{
                results:[]
            }
      }
    }
  }
  
  </script>