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
                      <li class="breadcrumb-item active" aria-current="page">App Config</li>
                    </ol>
                  </nav>
                </div>
         
              </div>
              <!--end breadcrumb-->
  
              <div>
                       
                <h6 class="mb-0 text-uppercase">Configuration Data</h6>
                <hr/>
            

                <form @submit.prevent="save">
                    <div class="col-sm-12 col-md-6">

                        <div class="mb-4">
                            <label class="form-label">Currency Unit</label>
                            <input v-model="meta.currency" required class="form-control" type="text" placeholder="Currency Unit"/>
                          </div>
                
                    </div>

                    <br/>
                    <br/>
                    <div class="d-flex flex-row justify-content-end">
                        <button type="submit" class="btn btn-primary w-100" >+ Save</button>
                    </div>

                </form>
                </div>
  
      
    
  
    </NuxtLayout>
  </template>
  <script>
export default{
    data(){
        return {
            meta:{

            }
        }
    },
    mounted(){
        const context=this;
        getRequestLoad_('/config',{},(r)=>{
            context.meta=r;
        })
    },
    methods:{
        save(){
            const context=this;
            postRequestLoad_('/config',this.meta,(configdata)=>{
                setAppConfig(configdata)
                successToast("Saved successfully");
            })
        }
    }
}
</script>