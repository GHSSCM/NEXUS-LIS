<template>
  <NuxtLayout name="inner">
      
            <!--start breadcrumb-->
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
              <div class="breadcrumb-title pe-3">
                <Translate text="Dashboard" />
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
                      <Translate text="New patient" />
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

            <div>
             
              <h6 class="mb-0 text-uppercase">
                <Translate text="Register a patient" />
              </h6>
              <hr/>

              <form @submit.prevent="save">

              <div class="row">

                <div class="col-sm-12 col-md-6">
                    <div class="mb-4">
                        <label class="form-label">
                          <Translate text="Patient Number" />
                        </label>
                        <input class="form-control" type="text" placeholder="Auto"  v-model="reference" disabled>
                      </div>
                </div>

                <div class="col-sm-12 col-md-6">
                  <div class="mb-4">
                      <label class="form-label">
                        <Translate text="Extra ID" />
                      </label>
                      <input class="form-control" type="text" placeholder="Extra ID" v-model="extraid">
                    </div>
                </div>

                <div class="col-sm-12 col-md-6">
                    <label class="form-label">
                      <Translate text="Patient Name" />
                    </label>
                    <input required type="text" class="form-control" placeholder="Patient Name" v-model="name"/>
                </div>
                <div class="col-sm-12 col-md-6">
                    <div class="mb-4">
                        <label class="form-label">
                          <Translate text="Gender" />
                        </label>
                        <select class="form-select" id="single-select-field1" data-placeholder="Enter gender" v-model="gender">
                          <option value="M" selected>
                            <Translate text="Male" />
                          </option>
                          <option value="F">
                            <Translate text="Female" />
                          </option>
                        </select>
                      </div>
                </div>

                <div class="col-sm-12 col-md-6">
                  <p>
                    <Translate text="Age/Date Of Birth" />
                  </p>
                  <div class="mb-4">
                    <input v-model="hasage" id="ageordob" class="form-check-input" type="checkbox" role="switch">
                    <label class="form-check-label ms-2" for="ageordob">
                      <Translate text="Use Age Instead" />
                    </label>
                  </div>
                  <div class="mb-4" v-if="!hasage">
                    <label class="form-label">
                      <Translate text="Date of birth" />
                    </label>
                    <input v-model="dob" required class="form-control" type="date" placeholder="Date of birth">
                  </div>
                  <div class="mb-4" v-else>
                    <label class="form-label">
                      <Translate text="Age" />
                    </label>
                    <input v-model="age" required class="form-control" type="number" placeholder="Age">
                  </div>
                </div>

                <div class="col-sm-12 col-md-6">
                    <div class="mb-4">
                        <label class="form-label">
                          <Translate text="Region of origin" />
                        </label>
                        <select v-model="region" class="form-select" id="single-select-field2" data-placeholder="Region of origin">
                          <option value="Far North">
                            <Translate text="Far north" />
                          </option>
                          <option value="North">
                            <Translate text="North" />
                          </option>
                          <option value="Adamoua">
                            <Translate text="Adamoua" />
                          </option>
                          <option value="East">
                            <Translate text="East" />
                          </option>
                          <option value="South">
                            <Translate text="South" />
                          </option>
                          <option value="North-West">
                            <Translate text="North-West" />
                          </option>
                          <option value="South-West">
                            <Translate text="South-West" />
                          </option>
                          <option value="West" selected>
                            <Translate text="West" />
                          </option>
                          <option value="Centre">
                            <Translate text="Centre" />
                          </option>
                          <option value="Littoral">
                            <Translate text="Littoral" />
                          </option>
                        </select>
                      </div>
                </div>

                <div class="col-sm-12 col-md-6">
                    <div class="mb-4">
                        <label class="form-label">
                          <Translate text="Address" />
                        </label>
                        <input v-model="address" class="form-control" type="text" placeholder="Address">
                      </div>
                </div>

                <div class="col-sm-12 col-md-6">
                    <div class="mb-4">
                        <label class="form-label">
                          <Translate text="Profession" />
                        </label>
                        <input v-model="profession" class="form-control" type="text" placeholder="Profession">
                      </div>
                </div>

                <div class="col-sm-12 col-md-6">
                    <div class="mb-4">
                        <label class="form-label">
                          <Translate text="Phone number" />
                        </label>
                        <input v-model="phone" class="form-control" type="text" placeholder="Phone number">
                      </div>
                </div>

                <div class="col-sm-12 col-md-6">
                    <div class="mb-4">
                        <label class="form-label">
                          <Translate text="Email" />
                        </label>
                        <input v-model="email" class="form-control" type="email" placeholder="Email">
                      </div>
                </div>

              </div>
              <hr/>

              <!--    <option value="freeinput">Free input/text</option>
                          <option value="number">Number</option>
                          <option value="yesno">Yes/No</option>
                          <option value="limitedvalues">Limited values</option>
                          <option value="datetime">Date/Time</option>
                          <option value="dateonly">Date Only</option>
                          <option value="timeonly">Time Only</option> -->
              <div class="row">
                <div class="col-sm-12 col-md-6" v-for="(f,i) in fields" :key="'cf-'+i">

                  <div class="mb-4" v-if="f.type=='number'">
                    <label class="form-label">
                      {{f.name}}
                    </label>
                    <input v-model="meta['fields'][f.name]" :required="f.required" class="form-control" type="number" step="0.000000001" :placeholder="f.name">
                  </div>

                  <div class="mb-4" v-else-if="f.type=='yesno'">
                        <input v-model="meta['fields'][f.name]" :required="f.required" class="form-check-input" type="checkbox" role="switch">
                        <label class="form-check-label ms-2" for="referredout">
                          {{f.name}}
                        </label>
                  </div>

                  <div class="mb-4" v-else-if="f.type=='limitedvalues'">
                      <label class="form-label">
                        {{f.name}}
                      </label>
                      <multiselect v-model="meta['fields'][f.name]" :required="f.required" :options="f.meta.enum ?? []"></multiselect>
                  </div>

                  <div class="mb-4" v-else-if="f.type=='limitedmultiplevalues'">
                      <label class="form-label">
                        {{f.name}}
                      </label>
                      <multiselect v-model="meta['fields'][f.name]" :required="f.required" :options="f.meta.enum ?? []" multiple="true"></multiselect>
                  </div>
                    
                  <div class="mb-4" v-else-if="f.type=='datetime'">
                      <label class="form-label">
                        {{f.name}}
                      </label>
                      <input v-model="meta['fields'][f.name]" :required="f.required" class="form-control" type="datetime-local" :placeholder="f.name">
                  </div>

                  <div class="mb-4" v-else-if="f.type=='dateonly'">
                      <label class="form-label">
                        {{f.name}}
                      </label>
                      <input v-model="meta['fields'][f.name]" :required="f.required" class="form-control" type="date" :placeholder="f.name">
                  </div>

                  <div class="mb-4" v-else-if="f.type=='timeonly'">
                      <label class="form-label">
                        {{f.name}}
                      </label>
                      <input v-model="meta['fields'][f.name]" :required="f.required" class="form-control" type="time" :placeholder="f.name">
                  </div>

                  <div class="mb-4" v-else>
                      <label class="form-label">
                        {{f.name}}
                      </label>
                      <input v-model="meta['fields'][f.name]" :required="f.required" class="form-control" type="text" :placeholder="f.name">
                  </div>
                </div>
              </div>

              <div class="mt-4">
                <Button type="submit" class="btn btn-primary w-100">
                  <Translate text="Save" />
                </Button>
              </div>
              </form>
              
              <br/>
              <br/>
              <br/>
              <br/>
            </div>

  </NuxtLayout>
</template>


  <script>
  import {getRequest_} from "@/utils/helper";
export default{
  setup(){
    forceOutPermissionVerify('MODIFY_PATIENT_INFO',this);
  },
  data(){
    const route=useRoute();

    return {
        pageId:route.params.id,
        // uniqid:"",
        reference:"",
        extraid:"",
        name:"",
        dob:"",
        gender:"",
        region:"",
        address:"",
        profession:"",
        email:"",
        phone:"",
        meta:{
          fields:{}
        },
        fields:[],
        hasage:false,
        age:null
        
    }
  },
  methods:{

    getQueryParameter(name) {
        // Create a regular expression to match the query parameter
        const regex = new RegExp('[?&]' + name + '=([^&#]*)', 'i');
        // Get the URL query string
        const queryString = window.location.search;
        // Match the query parameter in the URL query string
        const match = regex.exec(queryString);
        // If a match is found, decode and return the parameter value, otherwise return null
        return match ? decodeURIComponent(match[1]) : null;
    },
    getDateXYearsBefore( x) {
      const date = new Date();
      date.setFullYear(date.getFullYear() - x);
      return date.toISOString().split("T")[0];
    },
    save(){
      var data =this.$data;
      delete data.fields;
      const context=this;
      // console.log(data);
      // return;
      if(data.hasage){
        if(!data.age){
          return alert("Age is required");
        }
        data.dob = this.getDateXYearsBefore(data.age);
      }else{
        if(!data.dob){

          return alert("Date of birth is required");
        }
      }
    
      postRequestLoad_(this.pageId=='create'?'/patient':'/patient/'+this.pageId,data,(user)=>{
        context.$router.push("/p/profile/"+user.id);
      })
    }
  },
  mounted(){
    const context=this;
      getRequestLoad_('/customfields',{
        category:"patient"
      },(fields)=>{
        context.fields= fields;
      })

      setTimeout(function(){

        const name = context.getQueryParameter('name');
        // alert(name);
        console.log("This is it "+name);
        if(name){
          context.name=name;
        }

      },500);

      if(this.pageId!="create"){
        getRequestLoad_('/patient/'+this.pageId,{ 
        },(fields)=>{
          context.reference=fields.reference;
          context.name=fields.name;
          context.extraid=fields.extraid;
          context.dob=fields.dob;
          context.gender=fields.gender;
          context.region=fields.region;
          context.address=fields.address;
          context.profession=fields.profession;
          context.email=fields.email;
          context.phone=fields.phone;
          if(!fields.meta.fields){
            fields.meta.fields={};
          }
          context.meta=fields.meta;
        })
      }
  }
}
</script>