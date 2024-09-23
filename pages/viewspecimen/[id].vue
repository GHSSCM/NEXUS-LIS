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

                <div class="container mt-2 mb-3" v-if="specimen">
                    <h2>Specimen & Test Details</h2>
                    <br/>
                   <div class="row">
                        <div class="col-sm-8">

                        </div>
                        <div class="col-sm-4 d-flex">
                            <NuxtLink class="btn btn-primary btn-sm my-3 mb-5" target="_blank" v-if="meta[0] && meta[0].validated" :to="baseUrl+'/test-report?id='+specimen.id+'&multiple=true'">View PDF</NuxtLink>
                            <a class="btn btn-primary btn-sm my-3 mb-5 ms-4" target="_blank" 
                            v-if="meta[0] && meta[0].validated"  :download="'test-report-'+specimen.patient.name.trim().split(' ').join('-')+'-'+specimen.test.name.trim().split(' ').join('-')+'.pdf'" 
                            :href="baseUrl+'/test-report?id='+specimen.id+'&dl=true&multiple=true'">Download PDF</a>
                            
                        </div>
                   </div>

                    <div class="col-sm-12 col-md-6">
                        <p><b>Patient:</b> {{specimen.patient.name}}, {{specimen.patient.gender=='M'?'Male':'Female'}}, Age: {{calculateAge(specimen.patient.dob)}}</p>
                    </div>
                
                    <div class="accordion" id="accordionExample">
                        <div class="card " v-if="specimen.others" v-for="(sp,a) in specimen.others">
                            <div class="card-header" :id="'headingTwo'+a" @click="openAccord=((openAccord==a)?-1:a)">
                                <h2 class="mb-0">
                                    <button  class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                        Details: {{ sp.test.name }} ; {{ sp.specimen.name }}
                                       
                                    </button>
                                </h2>
                            </div>
                            <div id="collapseTwo" class="collapse " :class=" openAccord==a?'show':''" aria-labelledby="headingTwo" data-parent="#accordionExample">
                                <div class="card-body">
                                    <Specimendetail :specimen="sp" :meta="sp.meta" :base-url="baseUrl"/>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </div>

                
               
                </div>

                <form @submit.prevent="save"  class="p-4 mt-5" style="border:1px solid #e0e0e0;background:#f2f2f2;border-radius:5px" v-if="specimen && meta.length>0 && specimen.test.meta.fields && specimen.test.meta.fields.measures">
                    <h5 class=" mb-3">Test Results</h5>

                <div class="row p-2">

                    <div class="col-sm-2">
                        <h6><b>Test</b></h6>
                    </div>
                    <div class="col-sm-2">
                        <h6><b>Measures</b></h6>
                    </div>
                    <div class="col-sm-5">
                        <h6><b>Values</b></h6>
                    </div>
                    <div class="col-sm-3">
                        <h6><b>Remarks (Optional)</b></h6>
                    </div>
                </div>

            
                <div class="row"  v-for="(so,x) in specimen.others" v-if="specimen" >
                    <!-- OTHERS START -->
                                    <div v-for="(m,j) in specimen.others[x].test.meta.fields.measures" >
                                        <div class="row p-4" v-if="!dontshowfields[m.id]">

                                            <div class="col-sm-2">
                                                <h6><b>{{j>0?'':(so.test.name+";"+so.specimen.name)}}</b></h6>
                                            </div>

                                            <div class="col-sm-2">
                                                <h6><b>{{m.name}}</b></h6>
                                                <small v-if="meta[x].results[j].guide && m.subs.length==0" :class="(m.type=='numericrange' && ((meta[x].results[j].maxValue && meta[x].results[j].maxValue< meta[x].results[j].value) || (meta[x].results[j].minValue && meta[x].results[j].minValue> meta[x].results[j].value) ) )?'text-danger':'' ">{{meta[x].results[j].guide}}</small>
                                            </div>

                                            <div class="col-sm-5" v-if="m.subs.length==0" >
                                                <multiselect v-if="m.type=='alphanumeric' " :disabled="meta[x].validated" v-model="meta[x].results[j].value" :options="m.alphanumericvalues" ></multiselect>
                                                <div v-else-if="m.type=='autocomplete'">
                                                    <!-- <datalist :id="m.id+'_suggestions_'">
                                                        <option v-for="auto in m.autocompletevalues" :value="auto.text"/>
                                                    </datalist> -->
                                                    <div v-for="(val,valCounter) in meta[x].results[j].values" class="d-flex my-2">
                                                        <!-- <input placeholder="Enter value here" :disabled="meta[x].validated" required :list="m.id+'_suggestions_'"  type="text" class="form-control form-control-sm" v-model="meta[x].results[j].values[valCounter]" /> -->
                                                        <multiselect  :disabled="meta[x].validated" required v-model="meta[x].results[j].values[valCounter]" :options="m.autocompletevalues.map(x=>x.text)" searchable></multiselect>
                                                
                                                        <button   v-if="!meta[x].validated" class="btn btn-sm btn-danger mx-2 p-0 px-1" type="button" @click="meta[x].results[j].values.splice(valCounter,1)">Remove</button>
                                                    </div> 
                                                    <button  v-if="!meta[x].validated" class="btn btn-sm btn-primary  mt-2 p-1" type="button" @click="meta[x].results[j].values.push('')">+ Add</button>
                                                </div>
                                                <input placeholder="Enter value here" :disabled="meta[x].validated"  required v-else-if="m.type=='numericrange'"  type="number"  step="0.000000001"  class="form-control" v-model="meta[x].results[j].value" />
                                                <textarea required :disabled="meta[x].validated" v-else-if="m.type=='freeinput'" type="text" class="form-control" v-model="meta[x].results[j].value" ></textarea>
                                            </div>

                                            <div class="col-sm-2 d-flex" v-if="m.subs.length==0">
                                                <input  v-if="!m.canremove && !m.noremarks" :disabled="meta[x].validated" placeholder="Enter optional remark here" type="text" class="form-control" v-model="meta[x].results[j].remark" />
                                                <div class="p-2" v-if="m.canremove">
                                                    <u style="color:red;cursor:pointer;" @click="meta[x].results.splice(j,1);specimen.others[x].test.meta.fields.measures.splice(j,1); ">Remove</u>
                                                </div>
                                            </div>

                                            <div v-else-if='meta[x].results'>
                        <!-- OTHERS SUB START -->
                                                    <div class="row p-4" v-if="specimen && m.subs.length>0" v-for="(s,h) in m.subs">
                                                        <div class="col-sm-2"></div>
                                                        <div class="col-sm-2">
                                                            
                                                            <h6><b>{{s.name}}</b></h6>  <small v-if="meta[x].results[j].subs[h].guide" :class="(s.type=='numericrange' && ((meta[x].results[j].subs[h].maxValue && meta[x].results[j].subs[h].maxValue< meta[x].results[j].subs[h].value) || (meta[x].results[j].subs[h].minValue && meta[x].results[j].subs[h].minValue> meta[x].results[j].subs[h].value) ) )?'text-danger':'' ">{{meta[x].results[j].subs[h].guide}}</small>
                                                        </div>

                                                        <div class="col-sm-5">
                                                            <multiselect :disabled="meta[x].validated" v-if="s.type=='alphanumeric'" v-model="meta[x].results[j].subs[h].value" :options="s.alphanumericvalues" ></multiselect>
                                                            <div v-else-if="s.type=='autocomplete'">
                                                                <!-- <datalist :id="s.id+'_suggestions2_'">
                                                                    <option v-for="auto in s.autocompletevalues" :value="auto.text"/>
                                                                </datalist> -->
                                                                <div v-for="(val,valCounter) in meta[x].results[j].subs[h].values" class="d-flex my-2">
                                                                    <!-- <input placeholder="Enter value here" :disabled="meta[x].validated" required :list="s.id+'_suggestions2_'"  type="text" class="form-control mt-2 form-control-sm" v-model="meta[x].results[j].subs[h].values[valCounter]" /> -->
                                                                    
                                                                    <multiselect  :disabled="meta[x].validated" required v-model="meta[x].results[j].subs[h].values[valCounter]" :options="s.autocompletevalues.map(x=>x.text)" searchable></multiselect>
                                                                    <button  v-if="!meta[x].validated" class="btn btn-sm btn-danger mx-2 p-0 px-1" type="button" @click="meta[x].results[j].subs[h].values.splice(valCounter,1)">Remote</button>
                                                                </div>
                                                                <button v-if="!meta[x].validated" class="btn btn-sm btn-primary mt-2" type="button" @click="meta[x].results[j].subs[h].values.push('')">+ Add</button>


                                                            </div>
                                                            <input :disabled="meta[x].validated" placeholder="Enter value here" required v-else-if="s.type=='numericrange'"  type="number"  step="0.000000001"  class="form-control" v-model="meta[x].results[j].subs[h].value" />
                                                            <textarea :disabled="meta[x].validated" required v-else-if="s.type=='freeinput'" type="text" class="form-control" v-model="meta[x].results[j].subs[h].value" ></textarea>
                                                        </div>

                                                        <div class="col-sm-3">
                                                            <input :disabled="meta[x].validated"  placeholder="Enter optional remark here" type="text" class="form-control" v-model="meta[x].results[j].subs[h].remark" />
                                                        </div>
                                                    </div>
                                <!-- OTHERS SUB END -->
                                            </div>
                                            <div>
                                        </div>
                                        
                                        </div>
                                    </div>   


                                    <div class="row">
                                        <div class="col-sm-2"></div>

                                        <div class="col-sm-10" >
                                            <!-- style="border:1px solid rgba(25, 37, 123,0.5);padding:10px; margin-top:10px;margin-bottom:20px;border-radius:5px;" -->
                                            <!-- <strong>Other measures</strong> -->
                                            <br/>
                                            <br/>
                                            <a type="button" class="btn btn-secondary btn-sm " style="float:right;width:100px;" @click="var a = promptNameMeasure('Enter the title',x); ">Add +</a>
                                            <br/>
                                            <br/>
                                            <br/>
                                            <br/>

                                        </div>
                                    </div> 

                                    <div class="row">

                                            <div class="col-sm-12 col-md-2">
                                                <!-- {{ specimen.test.name }} -->
                                            </div>
                                            <div class="col-sm-12 col-md-3">

                                                <div class="mb-4">
                                                    <label class="form-label">Date of testing</label>
                                                    <input required  :disabled="meta[x].validated" v-model="specimen.others[x].testingdate"  class="result form-control " type="date" placeholder="Date of testing">
                                                </div>
                                        
                                                
                                            </div>


                                            <div class="col-sm-12 col-md-3">

                                                <div class="mb-4">
                                                    <label class="form-label">Time of testing </label>
                                                    <input  :disabled="meta[x].validated" v-model="specimen.others[x].testingtime"  class="result form-control " type="time" placeholder="Time of testing">
                                                    </div>
                                        
                                                    
                                            </div>

                                            <div class="col-sm-12 col-md-4">
                                                <div class="mb-4">
                                                    <label for="single-select-field4" class="form-label">Technique {{specimen.others[x].technique}}</label>
                                                    <multiselect required v-model="specimen.others[x].technique" :options="techniques" searchable></multiselect>
                                                  </div>
                                            </div>


                                            <div class="col-sm-12 col-md-2">
                                                <!-- {{ specimen.test.name }} -->
                                            </div>
                                            
                                            <div class="col-sm-12 col-md-10">
                                                <div class="mb-4">
                                                    <textarea :disabled="meta[x].validated" class="form-control" style="width:100%;height:100px;" placeholder="Enter clinical data (optional)" v-model="specimen.others[x].clinical"></textarea>
                                                  </div>
                                            </div>

                                    </div>

                    <!-- OTHERS END -->
                </div>




            <div class="d-flex align-items-end justify-content-end" v-if="!meta[0].validated">
                <button  type="submit" class="btn btn-primary btn-sm  ">+ {{canValidate?"Update Results":"Save Results"}}</button>

            </div>
            
                <div  v-if="canValidate">

                    <!--   -->
                    <button  :disabled="meta[0].validated" @click="validate"  type="button" class="btn btn-success btn-sm  w-100 mt-4 ">&check; {{meta[0].validated?"Verified by "+meta[0].verifiedby:"Validate Results"}}</button>
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
            
            
            context.techniques=specimen.techniques;
            context.specimen= specimen;
            if(!context.specimen.test.meta.fields || !context.specimen.test.meta.fields.measures){
                return;
            }
            const age =  context.calculateAge(specimen.patient.dob);
            const gender = specimen.patient.gender;


            console.log(JSON.parse(JSON.stringify(context.specimen.others[0])));


            if(specimen.others[0].meta.results && specimen.others[0].meta.results.length>0){
                context.canValidate=true;
            }
            context.meta=[];
            // xt.specimen.others.forEach((i,pos)=>{
                
            // })

            for(var metaCounter=0;metaCounter<context.specimen.others.length;metaCounter++){
                context.meta.push({});
                if(specimen.others[metaCounter].meta){
                    context.meta[metaCounter]=specimen.others[metaCounter].meta;
                }
                if(!specimen.others[metaCounter].meta.results){
                    context.meta[metaCounter].results=[]
                }
                for(var i=0;i<context.specimen.others[metaCounter].test.meta.fields.measures.length;i++){
                    const measure = context.specimen.others[metaCounter].test.meta.fields.measures[i];
                    if(!context.meta[metaCounter].results[i]){
                        context.meta[metaCounter].results.push({
                            name:measure.name,
                            unit:measure.unit,
                            id:measure.id,
                            condition:measure.condition,
                            subs:[]
                        })
                    }
                    if(measure.type=='autocomplete'){
                        if((!context.meta[metaCounter].results[i].values||context.meta[metaCounter].results[i].values.length==0) && context.meta[metaCounter].results[i].value){
                            context.meta[metaCounter].results[i].values=[ context.meta[metaCounter].results[i].value];
                        }else if((!context.meta[metaCounter].results[i].values||context.meta[metaCounter].results[i].values.length==0)){
                            context.meta[metaCounter].results[i].values=[""];
                        }
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
                            context.meta[metaCounter].results[i].guide=range.comparison?`Range (${range.comparisonvalue} ${range.comparisonoperand})`: `Range (${range.start} - ${range.end}) ${measure.unit??''}`;
                            // to help me show which is not a recognized value
                            context.meta[metaCounter].results[i].minValue=range.start;
                            context.meta[metaCounter].results[i].maxValue=range.end;
                            context.meta[metaCounter].results[i].unit=measure.unit;
                        })
                        }else {

                            context.meta[metaCounter].results[i].unit=measure.unit;
                            if(measure.type=='noop'){
                                context.meta[metaCounter].results[i].noop=true;
                            }
                        }
                        if(measure.subs){
                            for(var j=0;j<measure.subs.length;j++){
                            const submeasure = measure.subs[j];
                            if(!context.meta[metaCounter].results[i].subs[j])
                            {
                                    context.meta[metaCounter].results[i].subs.push({
                                        name:submeasure.name,
                                        unit:submeasure.unit
                                    })
                            }

                            if(submeasure.type=='autocomplete'){
                                if((!context.meta[metaCounter].results[i].subs[j].values || context.meta[metaCounter].results[i].subs[j].values.length==0) && context.meta[metaCounter].results[i].subs[j].value){
                                    context.meta[metaCounter].results[i].subs[j].values=[context.meta[metaCounter].results[i].subs[j].value];
                                }else if(!context.meta[metaCounter].results[i].subs[j].values ||context.meta[metaCounter].results[i].subs[j].values.length==0){
                                    context.meta[metaCounter].results[i].subs[j].values=[""];
                                }
                            }
                            else if(submeasure.type=='numericrange'){
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
                                        context.meta[metaCounter].results[i].subs[j].guide=`Range (${range.start} - ${range.end}) ${measure.unit}`;
                                        // to help me show which is not a recognized value
                                        context.meta[metaCounter].results[i].subs[j].minValue=range.start;
                                        context.meta[metaCounter].results[i].subs[j].maxValue=range.end;
                                        context.meta[metaCounter].results[i].subs[j].unit=submeasure.unit;
                                    })
                                }else{

                                    context.meta[metaCounter].results[i].subs[j].unit=submeasure.unit;
                                }

                            }
                        }
                }
            }
            console.log(JSON.parse(JSON.stringify(context.meta)))
            context.computeFormVisibility();
            // console.log(JSON.parse(JSON.stringify(context.meta[metaCounter].results)))
          });

      },500)
    },  
    watch:{
        meta:{
            handler(newvalue,oldvalue){
                this.computeFormVisibility();
            },
            deep:true
        }
    },
    methods:{
        promptNameMeasure(t,x){
            var a= window.prompt(t)
             if(a){
                this.specimen.others[x].test.meta.fields.measures.push({name:a,type:'freeinput',subs:[], canremove:true});
                this.meta[x].results.push({value:'',name:a,isNew:true,id:"NEW_"+Math.random()})
            }
        },
    computeFormVisibility(){
        const META = this.meta;

        const userAge = calculateAge(this.specimen.patient.dob)
        const gender = this.specimen.patient.gender??"";

        console.log("=========================")
        // console.log(JSON.parse(JSON.stringify(meta)))
        for(var k=0;k<META.length;k++){
            const meta = META[k].results;
            console.log(JSON.parse(JSON.stringify(meta)))
            for(var i=0;i<meta.length;i++){
                // var meta = META[k]
                if(meta[i].condition){
                     this.dontshowfields[meta[i].id]=true;

                    //check for age category
                    if(meta[i].condition[0].field && (meta[i].condition[0].field.subfield=="age"||( meta[i].condition[0].field.type=='numericrange' &&meta[i].condition[0].field.subfield!="gender"))){
                        const operator = meta[i].condition[0].operator;
                        const value = meta[i].condition[0].value;

                        var sourceValue=null;
                        if(meta[i].condition[0].field.subfield=="age"){
                            sourceValue=userAge;
                        }else{
                            const sourceInput= meta.find((x)=>x.id==meta[i].condition[0].field.id);
                            // alert(JSON.stringify(meta[i].condition[0].field))
                            sourceValue= (typeof sourceInput =="undefined")?null: sourceInput.value;
                        }
                        // const sourceValue=meta[i].condition[0].field.subfield=="age"?userAge:;
                        switch(operator){
                            case ">": 
                                if(sourceValue>value){
                                    delete this.dontshowfields[meta[i].id];
                                }
                                break;
                            case "<": 
                                if(sourceValue<value){
                                    delete this.dontshowfields[meta[i].id];
                                }
                                break;
                            case "<=": 
                                if(sourceValue<=value){
                                    delete this.dontshowfields[meta[i].id];
                                }
                                break;
                            case ">=": 
                                if(sourceValue>=value){
                                    delete this.dontshowfields[meta[i].id];
                                }
                                break;
                            case "!=": 
                                if(sourceValue!=value){
                                    delete this.dontshowfields[meta[i].id];
                                }
                                break;
                            case "=": 
                                if(sourceValue==value){
                                    delete this.dontshowfields[meta[i].id];
                                }
                                break;

                        }
                        continue;
                    }

                    //check for gender category
                    if(meta[i].condition[0].field && meta[i].condition[0].field.subfield=="gender"){
                        const operator = meta[i].condition[0].operator;
                        const value = meta[i].condition[0].value;
                        switch(operator){
                            case "equals": 
                                if(value==gender){
                                    delete this.dontshowfields[meta[i].id];
                                }
                                break;
                            case "notequals": 
                                if(value!=gender){
                                    delete this.dontshowfields[meta[i].id];
                                }
                                break;

                        }
                        continue
                    }

                    //check for alpha numeric
                    if(meta[i].condition[0].field){

                        const operator = meta[i].condition[0].operator;
                        const value = meta[i].condition[0].value;
                        
                        var sourceValue=null;

                        if(meta[i].condition[0].field.type=="autocomplete"){
                            //source input is certainly alpha numeric
                            const sourceInput= meta.find((x)=>x.id==meta[i].condition[0].field.id);
                            console.log(sourceInput);
                            sourceValue= (typeof sourceInput =="undefined")?null:(sourceInput.values??[]);
                        }else{
                            const sourceInput= meta.find((x)=>x.id==meta[i].condition[0].field.id);

                            sourceValue= (typeof sourceInput =="undefined")?null:sourceInput.value;
                        }
                        if(!sourceValue){
                            console.error("No source value "+meta[i].name);
                            continue;
                        }
                        switch(operator){
                            case "isanyof": 
                                var values = meta[i].condition[0].values??[];
                                for(var counter=0;counter<values.length;counter++){
                                    if(typeof sourceValue=="string"){
                                        if(values[counter].toLowerCase()==sourceValue.toLowerCase()){
                                            delete this.dontshowfields[meta[i].id];
                                            break;
                                        }
                                    }else{
                                        sourceValue = sourceValue.map(x=>x.toLowerCase());
                                        if(sourceValue.includes(values[counter].toLowerCase())){
                                            delete this.dontshowfields[meta[i].id];
                                            break;
                                        }
                                    }   
                                }
                                break;
                            case "isnotanyof": 
                                var values = meta[i].condition[0].values??[];
                                var found=false;
                                for(var counter=0;counter<values.length;counter++){
                                    if(typeof sourceValue=="string"){
                                        if(values[counter].toLowerCase()==sourceValue.toLowerCase()){
                                            found=true; //already found, comeout 
                                        }
                                    }else{
                                        sourceValue = sourceValue.map(x=>x.toLowerCase());
                                        if(sourceValue.includes(values[counter].toLowerCase())){
                                            found=true;//already found, comeout 
                                        }
                                    }   
                                }
                                
                                if(!found){
                                    delete this.dontshowfields[meta[i].id];
                                }
                                break;
                            case "contains": 
                                var values = meta[i].condition[0].values??[];
                                for(var counter=0;counter<values.length;counter++){
                                    if(sourceValue.toLowerCase().includes(values[counter].toLowerCase())){
                                        delete this.dontshowfields[meta[i].id];
                                        break;
                                    }
                                }
                                break;
                                

                            case "notcontains": 
                                var values = meta[i].condition[0].values??[];
                                var found=false;
                                for(var counter=0;counter<values.length;counter++){
                                    if(sourceValue.toLowerCase().includes(values[counter].toLowerCase())){
                                        found=true; //already found, comeout 
                                    }
                                }
                                if(!found){
                                    delete this.dontshowfields[meta[i].id];
                                }
                                break;
                            case "equals": 
                                if(sourceValue.toLowerCase()==value.toLowerCase()){
                                     delete this.dontshowfields[meta[i].id];
                                }
                                break;
                            case "notequals": 
                                if(sourceValue.toLowerCase()!=value.toLowerCase()){
                                     delete this.dontshowfields[meta[i].id];
                                }
                                break;

                        }
                    }


                }
            }
        }

        console.log(JSON.parse(JSON.stringify(this.dontshowfields)))
    },
      calculateAge(dob){
          return calculateAge(dob);
      }  ,
      save(){
        if(window.confirm("Are you sure you want to confirm update of these results?")){
            const context=this;
           
        
            const finalMetas =  [];
            
            for(var b=0;b<this.specimen.others.length;b++){
                var m=this.specimen.others[b];
                
                context.meta[b].results = context.meta[b].results.map(r=>{
                    if(this.dontshowfields[r.id]){
                        r.ignore=true;
                    }else{
                        if(r.ignore){
                            delete r.ignore;
                        }
                    }
                    return r;
                });
                
                var data= {
                    meta:context.meta[b],
                    id:m.id,
                    user:context.user.name,
                    testingdate:m.testingdate,
                    testingtime:m.testingtime,
                    technique:m.technique,
                    clinical:m.clinical
                }
                finalMetas.push(data);
            }
            
            postRequestLoad_("/specimenbulkupdate/",{
                "data":finalMetas
            },(meta)=>{
                // context.canValidate=true;
                context.meta=meta;
                successToast("Updated Successfully")
                context.$router.push("/specimens")
            })
        }
      },
      validate(){
        if(window.confirm("Are you sure you want to confirm verification of these results?")){
            const context=this;

            const finalMetas =  [];
            
            for(var b=0;b<this.specimen.others.length;b++){
                var m=this.specimen.others[b];
                context.meta[b].results = context.meta[b].results.map(r=>{
                    if(this.dontshowfields[r.id]){
                        r.ignore=true;
                    }else{
                        if(r.ignore){
                            delete r.ignore;
                        }
                    }
                    return r;
                });
                var data= {
                    meta:context.meta[b],
                    id:m.id,
                    user:context.user.name,
                    testingdate:m.testingdate,
                    testingtime:m.testingtime,
                    technique:m.technique,
                    clinical:m.clinical,
                    user:context.user.name
                }
                finalMetas.push(data);
            }
            

            postRequestLoad_("/specimenbulkvalidate/",{data:finalMetas},(meta)=>{
                context.meta=meta;
                context.$router.push("/specimens")
                successToast("Validated Successfully")
            })
        }
      }
    }, 
    data(){
      const route=useRoute();

      return {
        baseUrl:getBaseUrl(),
        techniques:[],
        openAccord:-1,
         user:window?(window.localStorage.getItem("user")?JSON.parse(window.localStorage.getItem("user")):null):null,
          id:route.params.id,
          specimen:null,
          canValidate:false,
            curr:getAppConfig("currency"),
            // meta:{
            //     results:[]
            // }
            meta:[],
            dontshowfields:{

            }
      }
    }
  }
  
  </script>