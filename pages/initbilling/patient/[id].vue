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
                      <li class="breadcrumb-item active" aria-current="page">Empty page</li>
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
                       
                <h6 class="mb-0 text-uppercase">Configure the bill</h6>
                <hr/>
                <br/>  <br/> 
                <p><strong>Choose the different test(s) from below: </strong></p>
                <multiselect label="label" v-model="selectedspecimens" :options="possiblespecimens" :multiple="true"  ></multiselect>
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
                                    <option value="NONE">None</option>
                                    <option value="PERC">Percentage</option>
                                    <option value="FLAT">Flat</option>
                                </select>
                            </td>
                            <td>
                                <input class="form-control" type="number" v-model="selectedspecimens[j].discountamount"/>
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
                            <th rowspan="1" colspan="4">Total Amount</th>
                            <th rowspan="1" colspan="1">500 {{curr}}</th>
                        </tr>
                    </tfoot>

                </table>
            </div>
  
      
    
  
    </NuxtLayout>
  </template>
  <script>
    export default {
        // watch: {
        //     selectedspecimens(newValue) {
        //     // Replace every space with an underscore
        //     this.username = newValue.replace(/ /g, '_');
        // },
        methods:{

        },mounted(){
            const context=this;
            getRequestLoad_("/initbilling-patient/"+this.id,{},(d)=>{
                    context.possiblespecimens=d;
                    if(d.length>0){
                        context.bill.patient =d[0].patientId;
                        context.bill.generatedby =context.user.name;
                        context.bill.meta=[];
                        context.bill.total=0;
                    }
            })
        },
        data(){
            const route = useRoute();
            return {
                user:window?(window.localStorage.getItem("user")?JSON.parse(window.localStorage.getItem("user")):null):null,
                curr:getAppConfig("currency"),
                id:route.params.id,
                selectedspecimens:[],
                possiblespecimens:[],
                bill:{
                    // "uniqid","meta","generatedby","specimen_id","total","patient","lab_ref"

                }
            }
        }
    }
  </script>