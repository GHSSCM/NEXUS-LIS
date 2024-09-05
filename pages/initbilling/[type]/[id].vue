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
                      <li class="breadcrumb-item active" aria-current="page">Generate billing</li>
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
                       
                <h6 class="mb-0 text-uppercase" v-if="possiblespecimens.length>0">PATIENT:&nbsp; {{possiblespecimens[0].patient}}</h6>
                <hr/>
                <br/>  <br/> 
                <p><strong>Choose the different test(s) from below: </strong></p>
                <multiselect label="label" v-model="selectedspecimens" track-by="uniqid" :options="possiblespecimens" :multiple="true" @remove="onRemove" ></multiselect>
                <br/>
                <br/>

                <table class="table table-striped table-bordered">
                    <thead>
                        <tr role="row">
                            <th rowspan="1" colspan="1">Test Name</th>
                            <th rowspan="1" colspan="1">Specimen Type</th>
                            <th rowspan="1" colspan="1">Test Cost</th>
                            <th rowspan="1" colspan="1">Discount</th>
                            <th rowspan="1" colspan="1">Discount Amount</th>
                            <th rowspan="1" colspan="1">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-if="selectedspecimens.length==0">
                            <td colspan="5"><center><strong>Please select a test.</strong></center></td>
                        </tr>
                       
                        <tr v-for="(i,j) in selectedspecimens">
                            <td>{{selectedspecimens[j].test}}</td>
                            <td>{{selectedspecimens[j].specimen}}</td>
                            <td>{{selectedspecimens[j].amount}} {{curr}}</td>
                            <td>
                                <select v-model="selectedspecimens[j].discounttype">
                                    <option  value="NONE">None</option>
                                    <option value="PERC">Percentage</option>
                                    <option value="FLAT">Flat</option>
                                </select>
                            </td>
                            <td>
                                <input class="form-control" type="number"  step="0.000000001"  v-model="selectedspecimens[j].discountamount"/>
                            </td>

                            <td>
                                <strong v-if="selectedspecimens[j].discounttype=='PERC'">{{selectedspecimens[j].amount - ((selectedspecimens[j].amount*(selectedspecimens[j].discountamount??0))/100)}} {{curr}}</strong>
                                <strong v-if="selectedspecimens[j].discounttype=='FLAT'">{{selectedspecimens[j].amount - (selectedspecimens[j].discountamount??0)}} {{curr}}</strong>
                                <strong v-if="selectedspecimens[j].discounttype=='NONE'||!selectedspecimens[j].discounttype">{{selectedspecimens[j].amount}} {{curr}}</strong>
                            </td>
                        </tr>
                    </tbody>

                    <tfoot>
                        <tr role="row">
                            <th rowspan="1" colspan="5">Total Amount</th>
                            <th rowspan="1" colspan="1">{{total}} {{curr}}</th>
                        </tr>
                    </tfoot>

                </table>

                <button v-if="selectedspecimens.length>0" class="btn btn-primary w-100 mt-5" @click="save">&check; Create bill</button>
            </div>
  
      
    
  
    </NuxtLayout>
  </template>
  <script>
    export default {
        watch: {
            selectedspecimens:{
                handler(newValue,oldValue) {
                 var total  =0;
                 for(var i=0;i<newValue.length;i++){
                    if(newValue[i].discounttype=="PERC"){
                        total+= newValue[i].amount - ((newValue[i].amount*(newValue[i].discountamount??0))/100)
                    }else if(newValue[i].discounttype=="FLAT"){
                        total+=newValue[i].amount - (newValue[i].discountamount??0)
                    }else{
                        total+=newValue[i].amount;
                    }
                 }
                 this.total=total;
        },deep:true}},
        methods:{
            onRemove(removedOption) {
                // // Handle the removal of the option here
                // console.log('Removed option:', this.selectedspecimens.indexOf(removedOption));
                // // You can perform any additional logic needed when an option is removed
                // this.selectedspecimens.splice(this.selectedspecimens.indexOf(removedOption),1);

            },
            save(){
                if(this.selectedspecimens.length==0){
                    return errorToast("You must choose a specimen");
                }
                const context=this;
                this.bill.meta={
                    specimens: this.selectedspecimens,
                    currency:this.curr
                }
                postRequestLoad_("/makebill",this.bill,(d)=>{
                    const url=(context.baseUrl + "/bill-report?id="+d.id);
                    var w=window.open(url, '_blank');
                    if(w){
                        w.focus();
                    }
                    // window.location.href=;
                });
            }
        },mounted(){
            const context=this;
           setTimeout(function(){
            getRequestLoad_((context.type=="patient"?"/initbilling-patient/"+context.id:"/initbilling-speciment/"+context.id),{},(d)=>{
                    context.possiblespecimens=d;
                    if(d.length>0){
                        context.bill.patient =d[0].patientId;
                        context.bill.generatedby =context.user.name;
                        context.bill.meta={};
                        context.bill.total=0;
                    }
                    if(context.type!="patient"){
                        context.selectedspecimens=[context.possiblespecimens[0]];
                    }
            })
           },500)
        },
        data(){
            const route = useRoute();
            return {
                user:window?(window.localStorage.getItem("user")?JSON.parse(window.localStorage.getItem("user")):null):null,
                curr:getAppConfig("currency"),
                baseUrl:getBaseUrl(),
                id:route.params.id,
                selectedspecimens:[],
                possiblespecimens:[],
                type:route.params.type,
                bill:{
                    // "uniqid","meta","generatedby","specimen_id","total","patient","lab_ref"

                },
                total:0
            }
        }
    }
  </script>