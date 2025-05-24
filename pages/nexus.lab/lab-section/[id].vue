<template>
  <NuxtLayout name="lablayout">
    
    <!--start breadcrumb-->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
      <div class="breadcrumb-title pe-3">
        <Translate text="Nexus Lab"/>
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
              {{ id=='create' ? $t("New Lab Section") : $t("Edit Lab Section") }}
            </li>
          </ol>
        </nav>
      </div>
      <div class="ms-auto d-none">
        <div class="btn-group">
          <button type="button" class="btn btn-outline-primary">
            <Translate text="Options"/>
          </button>
          <button type="button"
            class="btn btn-outline-primary split-bg-primary dropdown-toggle dropdown-toggle-split"
            data-bs-toggle="dropdown">
            <span class="visually-hidden">
              <Translate text="Toggle Dropdown"/>
            </span>
          </button>
          <div class="dropdown-menu dropdown-menu-right dropdown-menu-lg-end">
            <a class="dropdown-item" href="javascript:;">Action</a>
            <a class="dropdown-item" href="javascript:;">Another action</a>
            <a class="dropdown-item" href="javascript:;">Something else here</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="javascript:;">Separated link</a>
          </div>
        </div>
      </div>
    </div>
    <!--end breadcrumb-->

    <div>
      <h6 class="mb-0 text-uppercase">
        {{ id=='create' ? $t("Create A New Lab Section") : $t("Edit Lab Section") }}
      </h6>
      <hr/>
      <form @submit.prevent="save">
        <div class="row">
          <div class="col-sm-6 col-md-12">
            <div class="mb-4">
              <label class="form-label">
                <Translate text="Name"/>
              </label>
              <input required v-model="name" class="form-control" type="text" :placeholder="$t('Name')"/>
            </div>
          </div>
          <div>
            <div class="mb-4">
              <label class="form-label">
                <Translate text="Description"/>
              </label>
              <textarea v-model="description" class="form-control" type="text" :placeholder="$t('Description')"></textarea>
            </div>
          </div>
          <div class="col-sm-6 col-md-12" v-for="(f,i) in fields" :key="'cf-'+i">
            <div class="mb-4" v-if="f.type=='number'">
              <label class="form-label">{{ f.name }}</label>
              <input v-model="meta['fields'][f.name]" :required="f.required" class="form-control" type="number" step="0.000000001" :placeholder="$t(f.name)"/>
            </div>
            <div class="mb-4" v-else-if="f.type=='yesno'">
              <input v-model="meta['fields'][f.name]" :required="f.required" class="form-check-input" type="checkbox" role="switch">
              <label class="form-check-label ms-2" for="referredout">{{ f.name }}</label>
            </div>
            <div class="mb-4" v-else-if="f.type=='limitedvalues'">
              <label class="form-label">{{ f.name }}</label>
              <multiselect v-model="meta['fields'][f.name]" :required="f.required" :options="f.meta.enum ?? []"></multiselect>
            </div>
            <div class="mb-4" v-else-if="f.type=='limitedmultiplevalues'">
              <label class="form-label">{{ f.name }}</label>
              <multiselect v-model="meta['fields'][f.name]" :required="f.required" :options="f.meta.enum ?? []" multiple="true"></multiselect>
            </div>
            <div class="mb-4" v-else-if="f.type=='datetime'">
              <label class="form-label">{{ f.name }}</label>
              <input v-model="meta['fields'][f.name]" :required="f.required" class="form-control" type="datetime-local" :placeholder="$t(f.name)"/>
            </div>
            <div class="mb-4" v-else-if="f.type=='dateonly'">
              <label class="form-label">{{ f.name }}</label>
              <input v-model="meta['fields'][f.name]" :required="f.required" class="form-control" type="date" :placeholder="$t(f.name)"/>
            </div>
            <div class="mb-4" v-else-if="f.type=='timeonly'">
              <label class="form-label">{{ f.name }}</label>
              <input v-model="meta['fields'][f.name]" :required="f.required" class="form-control" type="time" :placeholder="$t(f.name)"/>
            </div>
            <div class="mb-4" v-else>
              <label class="form-label">{{ f.name }}</label>
              <input v-model="meta['fields'][f.name]" :required="f.required" class="form-control" type="text" :placeholder="$t(f.name)"/>
            </div>
          </div>
        </div>
  
        <br/>
        <br/>
        <br/>
        <button class="btn btn-primary w-100" style="border:0">
          + <Translate text="Save"/>
        </button>
      </form>
    </div>
  
  </NuxtLayout>
</template>


<script>
  export default {
    

    data(){
      const route=useRoute();
        return {
          id:route.params.id,
            loadedtests:[],
            techniques:[],
            name:"",
            description:"",fields:[],
            
            meta:{
            "fields":{}
          }
        }
    },
    mounted(){
      


      const context=this;
      if(context.id!='create'){
        getRequestLoad_('/lab-section/'+context.id,{
      
        },(data)=>{
          context.name=data.name;
          context.description=data.description;
          context.techniques=data.techniques;
          context.meta=data.meta;
        })
      }

      getRequestLoad_('/customfields',{
        category:"labsection"
      },(fields)=>{
        context.fields= fields;
      })

     
    },
    methods:{
      save(){
        console.log(this.meta);
        const context=this;
        postRequestLoad_(context.id=='create'?'/lab-section':'/lab-section/'+context.id,{
          description:this.description,
          name:this.name,
          techniques:this.techniques,
          meta:this.meta
        },(specimen)=>{
          successToast(this.$t("Created successfully"));
        context.$router.push("/nexus.lab/lab-sections");
      })
      }
    }
    
  }
</script>