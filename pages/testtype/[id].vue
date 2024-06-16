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
                <div v-for="(f,i) in meta.fields.measures">
                    <hr/>
                    <div class="row">
                        <div class="col-sm-2">
                            <label >Name</label>
                          <input v-model="meta.fields.measures[i].name" class="form-control mb-3 mt-2" type="text" placeholder="Enter name">
                          <div class="d-flex flex-row justify-content-end">
                            <button style="transform:scale(0.7); border:0" type="button" class="btn btn-outline-primary btn-sm  "  @click="meta.fields.measures[i].subs.push({type:'numericrange',subs:[],numericrangevalues:[],alphanumericvalues:[],autocompletevalues:[],id:(new Date()).getTime()})">+ Add Submeasure</button>
                          </div>
                       </div>
                       <div class="col-sm-2">
                            <label class="mb-2">Data type</label>
                            <select v-model="meta.fields.measures[i].type" class="form-control single-select-field " data-placeholder="Data type">
                
                                <option value="numericrange">Numeric Range</option>
                                <option value="alphanumeric">Alpha numeric</option>
                                <option value="autocomplete">Autocomplete</option>
                                <option value="freeinput">Free Input</option>
                                
                            </select>
                     </div>

                     <div class="col-sm-4">
                        <label ><strong>Values</strong></label>

                        <div v-if="meta.fields.measures[i].type=='numericrange'">
                            <div  class="d-flex flex-row mb-2" v-for="(v,j) in meta.fields.measures[i].numericrangevalues">
                              <div>
                                <div class="d-flex flex-row justify-content-space-between w-100">
                                    <lablel>Range</lablel>
                                </div>
                                <input required v-model="meta.fields.measures[i].numericrangevalues[j].start" class="form-control form-control-sm mt-2" type="number" style="max-width: 60px;" >
  
                                <lablel>to</lablel>
                                <input required v-model="meta.fields.measures[i].numericrangevalues[j].end" class="form-control form-control-sm mt-1" type="number" style="max-width: 60px;">
                              </div>
                            
                              <div class="ms-3">
                                <lablel>&nbsp;</lablel>
                                <select required  v-model="meta.fields.measures[i].numericrangevalues[j].gender" class="form-control form-control-sm mt-2"  style="max-width: 60px;" >
                                  <option value="M">Male</option>
                                  <option value="F">Female</option>
                                  <option value="B">Both</option>
                                </select>
  
                                <!-- <lablel>to</lablel> -->
                                <!-- <input class="form-control form-control-sm mt-1" type="number" style="max-width: 60px;"> -->
                              </div>

                              <div  class="ms-3">
                                <div class="d-flex flex-row justify-content-space-between w-100">
                                    <lablel>Range</lablel>
                                </div>
                                <input required v-model="meta.fields.measures[i].numericrangevalues[j].v1" class="form-control form-control-sm mt-2" type="number" style="max-width: 60px;" >
  
                                <lablel>to</lablel>
                                <input required v-model="meta.fields.measures[i].numericrangevalues[j].v2" class="form-control form-control-sm mt-1" type="number" style="max-width: 60px;">
                              </div>
                         
  
                            </div>
                            <div class="d-flex flex-row justify-content-end">
                              <button style="transform:scale(0.7); border:0" type="button" class="btn btn-outline-primary btn-sm  "  @click="meta.fields.measures[i].numericrangevalues.push({})">+ Add Values</button>
                            </div>

                        </div>

                        <div v-else-if="meta.fields.measures[i].type=='autocomplete'">
                          <div  class="d-flex flex-row mb-0" v-for="(v,j) in meta.fields.measures[i].autocompletevalues">
                         
                            
                            <div class="me-3 w-100">
                              <lablel>&nbsp;</lablel>
                              <input required v-model="meta.fields.measures[i].autocompletevalues[j].text"  class="form-control form-control-sm  w-100" type="text" >

                              
                            </div>
                            <div class="ms-3 d-flex flex-column justify-content-center">

                              <strong style="cursor: pointer;" class="ms text-danger " @click="meta.fields.measures[i].autocompletevalues.splice(j,1)"><small><u >Remove</u></small></strong>
              
                            </div>

                          </div>
                          <div class="d-flex flex-row justify-content-end mt-2">
                            <button style="transform:scale(0.7); border:0" type="button" class="btn btn-outline-primary btn-sm  "  @click="meta.fields.measures[i].autocompletevalues.push({})">+ Add Values</button>
                          </div>

                      </div>

                        <multiselect v-else-if="meta.fields.measures[i].type=='alphanumeric'" v-model="meta.fields.measures[i].alphanumericvalues" :options="[]" :taggable="true"
                            @tag="addNewOption(i,$event)" :multiple="true" ></multiselect>

                        <!-- <input v-else v-model="meta.fields.measures[i].value" class="form-control mb-3 mt-2" type="text" placeholder="Value"> -->

                   </div>

                   <div class="col-sm-3">
                    <label >Unit / Default</label>
                  <input v-model="meta.fields.measures[i].unit" class="form-control mb-3 mt-2" type="text" placeholder="Enter Unit / Default value">

               
                  <div class="d-flex flex-row justify-content-end">
                    <button  v-if="meta.fields.measures.length>1 && meta.fields.measures[i].condition" style="transform:scale(0.8); border:0" type="button" class="btn btn-outline-danger btn-sm  "  @click="meta.fields.measures[i].condition=null">- Remove Condition</button>
                    <button  v-else-if="meta.fields.measures.length>1" style="transform:scale(0.8); border:0" type="button" class="btn btn-outline-primary btn-sm  "  @click="meta.fields.measures[i].condition=[{logic:'and',subfield:'age',values:[]}]">+ Add Condition</button>
                  </div>
               </div>

                
                     <div class="col-sm-1 d-flex">
                        <center><i @click="meta.fields.measures.splice(i,1);" class="fadeIn animated bx bx-trash fs-5 mt-4 ms-2" style="color:red; cursor:pointer"></i></center>
                     </div>
                    </div>








                    <!--  SUB MEASURES START -->
                    <div style="transform:scale(0.95);border:1px solid rgba(0,0,0,0.2)" class="p-4" v-if="meta.fields.measures[i].subs.length>0">
                      <strong>Sub measures</strong>
                      <br/>
                      <br/>
                      <br/>
                      <div class="row mb-3 pb-3" v-for="(sub,s) in meta.fields.measures[i].subs" style="border-bottom:1px solid rgba(0,0,0,0.1)">
                        <div class="col-sm-2">
                            <label >Name</label>
                          <input v-model="meta.fields.measures[i].subs[s].name" class="form-control mb-3 mt-2" type="text" placeholder="Enter name">
                       </div>
                       <div class="col-sm-2">
                            <label class="mb-2">Data type</label>
                            <select required v-model="meta.fields.measures[i].subs[s].type" class="form-control single-select-field " data-placeholder="Data type">
                
                                <option value="numericrange">Numeric Range</option>
                                <option value="alphanumeric"> Alpha numeric </option>
                                <option value="autocomplete"> Autocomplete</option>
                                <option value="freeinput">Free Input</option>
                                
                            </select>
                     </div>

                     <div class="col-sm-4">
                        <label ><strong>Values</strong></label>

                        <div v-if="meta.fields.measures[i].subs[s].type=='numericrange'">
                            <div  class="d-flex flex-row mb-2" v-for="(v,j) in meta.fields.measures[i].subs[s].numericrangevalues">
                              <div>
                                <div class="d-flex flex-row justify-content-space-between w-100">
                                    <lablel>Range</lablel>
                                </div>
                                <input required v-model="meta.fields.measures[i].subs[s].numericrangevalues[j].start" class="form-control form-control-sm mt-2" type="number" style="max-width: 60px;" >
  
                                <lablel>to</lablel>
                                <input required v-model="meta.fields.measures[i].subs[s].numericrangevalues[j].end" class="form-control form-control-sm mt-1" type="number" style="max-width: 60px;">
                              </div>
                   
                              <div class="ms-3">
                                <lablel>&nbsp;</lablel>
                                <select required  v-model="meta.fields.measures[i].subs[s].numericrangevalues[j].gender" class="form-control form-control-sm mt-2"  style="max-width: 60px;" >
                                  <option value="M">Male</option>
                                  <option value="F">Female</option>
                                  <option value="B">Both</option>
                                </select>
  
                                <!-- <lablel>to</lablel> -->
                                <!-- <input class="form-control form-control-sm mt-1" type="number" style="max-width: 60px;"> -->
                              </div>

                              <div  class="ms-3">
                                <div class="d-flex flex-row justify-content-space-between w-100">
                                    <lablel>Range</lablel>
                                </div>
                                <input required v-model="meta.fields.measures[i].subs[s].numericrangevalues[j].v1" class="form-control form-control-sm mt-2" type="number" style="max-width: 60px;" >
  
                                <lablel>to</lablel>
                                <input required v-model="meta.fields.measures[i].subs[s].numericrangevalues[j].v2" class="form-control form-control-sm mt-1" type="number" style="max-width: 60px;">
                              </div>
              
  
                            </div>
                            <div class="d-flex flex-row justify-content-end">
                              <button style="transform:scale(0.7); border:0" type="button" class="btn btn-outline-primary btn-sm  "  @click="meta.fields.measures[i].subs[s].numericrangevalues.push({gender:'M'})">+ Add Values</button>
                            </div>

                        </div>

                        <div v-else-if="meta.fields.measures[i].subs[s].type=='autocomplete'">
                          <div  class="d-flex flex-row mb-0" v-for="(v,j) in meta.fields.measures[i].subs[s].autocompletevalues">
                         
                            
                            <div class="me-3 w-100">
                              <lablel>&nbsp;</lablel>
                              <input required v-model="meta.fields.measures[i].subs[s].autocompletevalues[j].text"  class="form-control form-control-sm  w-100" type="text" >

                              
                            </div>
                            <div class="ms-3 d-flex flex-column justify-content-center">

                              <strong style="cursor: pointer;" class="ms text-danger " @click="meta.fields.measures[i].subs[s].autocompletevalues.splice(j,1)"><small><u >Remove</u></small></strong>
              
                            </div>

                          </div>
                          <div class="d-flex flex-row justify-content-end mt-2">
                            <button style="transform:scale(0.7); border:0" type="button" class="btn btn-outline-primary btn-sm  "  @click="meta.fields.measures[i].subs[s].autocompletevalues.push({})">+ Add Values</button>
                          </div>

                      </div>



                        <multiselect v-else-if="meta.fields.measures[i].subs[s].type=='alphanumeric'" v-model="meta.fields.measures[i].subs[s].alphanumericvalues" :options="[]" :taggable="true"
                            @tag="addNewOption3(i,s,$event)" :multiple="true" ></multiselect>

                        <!-- <input v-else v-model="meta.fields.measures[i].subs[s].value" class="form-control mb-3 mt-2" type="text" placeholder="Value"> -->

                   </div>

                   <div class="col-sm-3">
                    <label >Unit / Default</label>
                  <input v-model="meta.fields.measures[i].subs[s].unit" class="form-control mb-3 mt-2" type="text" placeholder="Enter Unit / Default">

               
                  <div class="d-flex flex-row justify-content-end">
                    <button  v-if="meta.fields.measures.length>1 && meta.fields.measures[i].subs[s].condition" style="transform:scale(0.8); border:0" type="button" class="btn btn-outline-danger btn-sm  "  @click="meta.fields.measures[i].subs[s].condition=null">- Remove Condition</button>
                    <!-- <button  v-else-if="meta.fields.measures.length>1" style="transform:scale(0.8); border:0" type="button" class="btn btn-outline-primary btn-sm  "  @click="meta.fields.measures[i].subs[s].condition=[{logic:'and',subfield:'age',values:[]}]">+ Add Condition</button> -->
                  </div>
               </div>

                
                     <div class="col-sm-1 d-flex">
                        <center><i @click="meta.fields.measures[i].subs.splice(s,1);" class="fadeIn animated bx bx-trash fs-5 mt-4 ms-2" style="color:red; cursor:pointer"></i></center>
                     </div>
                    </div>

                    </div>




                    <!--  SUB MEASURES END-->




                    <div style="border : 1px solid rgba(0,0,0,0.5); background:#f2f2f2; border-radius:5px; " class="p-3" v-if="meta.fields.measures[i].condition">
                      <label>Conditions, IF:</label>  <button style="transform:scale(0.8); border:0" type="button" class="btn btn-outline-primary btn-sm  "  @click="meta.fields.measures[i].condition.push({logic:'and',subfield:'age',values:[]})">+ Add</button>
                      
                      <div v-for=" (con,pos) in meta.fields.measures[i].condition" class=" d-flex flex-row">
                        <select required v-if="pos!=0"  v-model="meta.fields.measures[i].condition[pos].logic" class="me-2 form-control form-control-sm mt-2"  style="max-width: 60px;" >
                          <option value="and">And</option>
                          <option value="or">Or</option>
                        </select>
    
                        <select required v-if="meta.fields.measures[i].condition[pos].logic"  v-model="meta.fields.measures[i].condition[pos].field" class="me-2 form-control form-control-sm mt-2"  style="max-width: 100px;" >
                          <option v-for="(field,k) in meta.fields.measures.filter((f,position)=>position!=i)" :value="field">{{field.name}}</option>
                        </select>
  
                        <select required v-if="meta.fields.measures[i].condition[pos].field && meta.fields.measures[i].condition[pos].field.type=='numericrange'"  v-model="meta.fields.measures[i].condition[pos].subfield" class="me-2 form-control form-control-sm mt-2"  style="max-width: 60px;" >
                          <option value="age">Age</option>
                          <option value="gender">Gender</option>
                          <option value="value">Value</option>
                        </select>

                        <select required   v-if="meta.fields.measures[i].condition[pos].field" v-model="meta.fields.measures[i].condition[pos].operator" class="me-2 form-control form-control-sm mt-2"  style="max-width: 100px;" >
                          <option v-if="meta.fields.measures[i].condition[pos].field.type=='numericrange' && meta.fields.measures[i].condition[pos].subfield!='gender'" value="<" > < </option>
                          <option v-if="meta.fields.measures[i].condition[pos].field.type=='numericrange' && meta.fields.measures[i].condition[pos].subfield!='gender'" value="<=" > <= </option>
                          <option v-if="meta.fields.measures[i].condition[pos].field.type=='numericrange' && meta.fields.measures[i].condition[pos].subfield!='gender'" value="=" > = </option>
                          <option v-if="meta.fields.measures[i].condition[pos].field.type=='numericrange' && meta.fields.measures[i].condition[pos].subfield!='gender'" value="!=" > != </option>
                          <option v-if="meta.fields.measures[i].condition[pos].field.type=='numericrange' && meta.fields.measures[i].condition[pos].subfield!='gender'" value=">=" > >= </option>
                          <option v-if="meta.fields.measures[i].condition[pos].field.type=='numericrange' && meta.fields.measures[i].condition[pos].subfield!='gender'" value=">" > > </option>
                          <option v-if="meta.fields.measures[i].condition[pos].field.type=='alphanumeric'||(meta.fields.measures[i].condition[pos].field.type=='numericrange' && meta.fields.measures[i].condition[pos].subfield=='gender')" value="equals" > Equals </option>
                          <option v-if="meta.fields.measures[i].condition[pos].field.type=='alphanumeric'||(meta.fields.measures[i].condition[pos].field.type=='numericrange' && meta.fields.measures[i].condition[pos].subfield=='gender')" value="notequals" > Not Equals </option>
                          <option v-if="meta.fields.measures[i].condition[pos].field.type=='alphanumeric'||meta.fields.measures[i].condition[pos].field.type=='autocomplete'||meta.fields.measures[i].condition[pos].field.type=='freeinput'" value="isanyof" > Is Any Of </option>
                          <option v-if="meta.fields.measures[i].condition[pos].field.type=='alphanumeric'||meta.fields.measures[i].condition[pos].field.type=='autocomplete'||meta.fields.measures[i].condition[pos].field.type=='freeinput'" value="isnotanyof" > Is Not Any Of </option>
                          <option v-if="meta.fields.measures[i].condition[pos].field.type=='autocomplete'||meta.fields.measures[i].condition[pos].field.type=='freeinput'" value="contains" > Contains (Or) </option>
                          <option v-if="meta.fields.measures[i].condition[pos].field.type=='autocomplete'||meta.fields.measures[i].condition[pos].field.type=='freeinput'" value="notcontains" > Not Contains (Or) </option>
                        </select>

                        <input required v-model="meta.fields.measures[i].condition[pos].value" type="number" class="me-2 mt-2  form-control form-control-sm" style="max-width:150px; " v-if="meta.fields.measures[i].condition[pos].field && meta.fields.measures[i].condition[pos].field.type=='numericrange' && !(meta.fields.measures[i].condition[pos].field.type=='numericrange' && meta.fields.measures[i].condition[pos].subfield=='gender')">
                        <select required v-model="meta.fields.measures[i].condition[pos].value"  class="me-2 mt-2  form-control form-control-sm" style="max-width:150px; " v-else-if="meta.fields.measures[i].condition[pos].field && (meta.fields.measures[i].condition[pos].field.type=='numericrange' && meta.fields.measures[i].condition[pos].subfield=='gender')">
                          <option value="M">Male</option>
                          <option value="F">Female</option>
                          <option value="B">Both</option>
                        </select>

                        <input required v-else-if="meta.fields.measures[i].condition[pos].field && (meta.fields.measures[i].condition[pos].operator=='equals'||meta.fields.measures[i].condition[pos].operator=='notequals')" type="number" class="me-2 mt-2  form-control form-control-sm" style="max-width:150px; " v-if="meta.fields.measures[i].condition[pos].field && meta.fields.measures[i].condition[pos].field.type=='numericrange' && !(meta.fields.measures[i].condition[pos].field.type=='numericrange' && meta.fields.measures[i].condition[pos].subfield=='gender')">

                        <multiselect v-else-if="meta.fields.measures[i].condition[pos].field " v-model="meta.fields.measures[i].condition[pos].values" :options="[]" :taggable="true"
                        @tag="addNewOption2(i,pos,$event)" :multiple="true" style="max-width:200px;" class="mt-2" ></multiselect>

                          <button style="transform:scale(0.8); border:0" type="button" class="btn btn-outline-danger btn-sm  "  @click="meta.fields.measures[i].condition.splice(pos,1)">- Remove</button>
                        

                      </div>
  
                    </div>
                    <hr/>
                </div>


                <div class="d-flex flex-row justify-content-end">
                  <button type="button" class="btn btn-outline-primary btn-sm " style="border:0" @click="meta.fields.measures.push({type:'numericrange',subs:[],numericrangevalues:[],alphanumericvalues:[],autocompletevalues:[],id:(new Date()).getTime()})">+ Add Measures</button>
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

                            
                        <div class="mb-4">    <label class="form-label">Target TAT </label>
                            <div class="row">
                              <div class="col-sm-9">
                            <input required v-model="tat" class="result form-control" type="number" placeholder="Target TAT"/>
                            
                              </div>
                              <div class="col-sm-3">
                                <select required v-model="tatunit" class="form-control">
                                  <option value="hours">Hours</option>
                                  <option value="minutes">Minutes</option>
                                </select>
                              </div>
                            </div>
                          </div>
                

                          

                    </div>

                    <div class="col-sm-12 col-md-6">

                        <div class="mb-4">
                            <label class="form-label">Cost to patient in {{ curr }}</label>
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

                      <div class="mb-4" v-else-if="f.type=='limitedmultiplevalues'">
                        <label class="form-label">{{f.name}}</label>
                        <multiselect v-model="meta['fields'][f.name]" :required="f.required" :options="f.meta.enum??[]" multiple="true"></multiselect>
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
            tatunit:"hours",
            cost:1000,
            hidename:false,
            threshold:"",
            loadedspecimens:[],
            meta:{
              fields:{
                measures:[

                ]
              }
            },
            
            curr:getAppConfig("currency")
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
              context.tatunit=testtype.tatunit;
              context.cost=testtype.cost;
              context.hidename=testtype.hidename;
              context.threshold=testtype.threshold;
              context.meta=testtype.meta;
              if(!context.meta.fields){
                context.meta.fields={
                measures:[
                  
                ]};
              }
              if(!context.meta.fields.measures){
                context.meta.fields.measures=[]
              }
          })
        }
      })
    },
    methods:{
      addNewOption(i,newOption){
        console.log(i, newOption);
        this.meta.fields.measures[i].alphanumericvalues.push(newOption);
 
        },

        addNewOption2(i,pos,newOption){
        console.log(i, pos,newOption);
          this.meta.fields.measures[i].condition[pos].values.push(newOption)
        },

      addNewOption3(i,s,newOption){
      console.log(i, s,newOption);
        this.meta.fields.measures[i].subs[s].alphanumericvalues.push(newOption)
      },
      save(){

        const context=this;
        postRequestLoad_(context.id=='create'?'/testtype':'/testtype/'+context.id,{
          description:this.description,
          name:this.name,
          specimens:JSON.parse(JSON.stringify(this.specimens.map(r=>r.uniqid))),
          tat:this.tat,
          tatunit:this.tatunit,
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