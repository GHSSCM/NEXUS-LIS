<template>
  <NuxtLayout name="inner">
      
            <!--start breadcrumb-->
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
              <div class="breadcrumb-title pe-3">Custom Fields</div>
              <div class="ps-3">
                <nav aria-label="breadcrumb">
                  <ol class="breadcrumb mb-0 p-0 align-items-center">
                    <li class="breadcrumb-item"><a href="javascript:;">
                        <ion-icon name="home-outline"></ion-icon>
                      </a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page" v-if="category=='patient'">Patient Information </li>
                    <li class="breadcrumb-item active" aria-current="page" v-if="category=='specimen'">Specimen Information </li>
                    <li class="breadcrumb-item active" aria-current="page" v-if="category=='test'">Test Information </li>
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
                     
              <h6 class="mb-0 text-uppercase">Test type CFs</h6>
              <hr/>

              <div v-for="(f,i) in fields" :key="'ct-'+i">
                  <hr/>
                  <div class="row">
                      <div class="col-sm-5">
                          <label >Name</label>
                        <input   v-model="fields[i].name" class="form-control mb-3 mt-2" type="text" placeholder="Enter field name">
                     </div>
                     <div class="col-sm-3">
                          <label class="mb-2">Data type</label>
                          <select v-model="fields[i].type" class="form-control " :id="'idk1'+i" data-placeholder="Data type">
                              <!-- <option></option> -->
                              <option value="freeinput">Free input/text</option>
                              <option value="number">Number</option>
                              <option value="yesno">Yes/No</option>
                              <option value="limitedvalues">Limited values</option>
                              <option value="datetime">Date/Time</option>
                              <option value="dateonly">Date Only</option>
                              <option value="timeonly">Time Only</option>
                          </select>
                   </div>
              
                   
                   <div class="col-sm-3" v-if="fields[i].type=='limitedvalues'">
                    <label class="mb-2">Possible values</label> 
                    <!-- multiple-select-field -->
                    <multiselect v-model="fields[i].meta.enum" :options="[]" :taggable="true"
                    @tag="addNewOption(i,$event)" :multiple="true" ></multiselect>

                    
                  </div>
                   <div class="col-sm-1 d-flex align-items-center">
                      <center><i  class="fadeIn animated bx bx-trash fs-5 mt-4 ms-2" style="color:red;cursor:pointer" @click="deleteField(i)"></i></center>
                   </div>
                  </div>
                  <hr/>
              </div>


              <div class="d-flex flex-row justify-content-end">
                  <button class="btn btn-outline-primary btn-sm " style="border:0" @click="addNew">+ Add fields</button>
              </div>
              
              <br/>
              <br/>
              <br/>
              <br/>
              <button class="btn btn-primary w-100 " style="border:0" @click="save">+ Save</button>
              </div>

    
  

  </NuxtLayout>
</template>
<script>
export default {
  data() {
    const route = useRoute()
    const category = route.params.category;
      return {
          fields:[

          ],
          category
      }
  },
  watch: {
  
  },
  methods:{
    save(){
      const context=this;
      // return console.log(JSON.stringify(this.fields));
      postRequestLoad_('/customfields',{
        fields:this.fields,
        category:this.category
      },(fields)=>{
            successToast("Saved successfully");
          context.fields=fields;
      },()=>{
        // alert("Connection error. Please refresh and try again.");
      })
    },
    addNewOption(i,newOption){

      console.log(i, newOption);

      if(this.fields[i].meta.enum==null){

        this.fields[i].meta.enum=[newOption];

      }else{

        this.fields[i].meta.enum.push(newOption);

      }
    },
    addNew(){
      this.fields.push({
        type:'freeinput',
        name:'',
        meta:{noop:true},
        category:this.category
    });
    },
    deleteField(index){
        var field = this.fields[index];
        
          if (confirm("Sure you want to delete?")) {
              if(field.id){
                getRequestLoad_('/customfield/'+field.id+'/delete',{},()=>{
                      this.fields.splice(index, 1);
                    successToast("Field deleted successfully");
                  })
              }else{
                 this.fields.splice(index, 1);
              }
          } else {
        
          }
        
    }
  },
  mounted() {
    const context=this;
      getRequestLoad_('/customfields',{
        category:this.category
      },(fields)=>{
        context.fields= fields;
   
      },()=>{
        // alert("Connection error. Please refresh and try again.");
      })
  },
}
</script>