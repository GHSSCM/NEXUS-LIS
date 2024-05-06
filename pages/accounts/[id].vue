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
                      <li v-if="pageId=='create'" class="breadcrumb-item active" aria-current="page">New User Account</li>
                      <li v-else class="breadcrumb-item active" aria-current="page">Edit User Account</li>
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
                       
                <h6 class="mb-0 text-uppercase" v-if="pageId=='create'">Create a new account</h6>
                <h6 class="mb-0 text-uppercase" v-else>Edit Account <span class="text-primary" v-if="ogname">({{ogname}})</span></h6>
                <small>Fields marked with (*) are obligatory</small>
                <hr/>
                <form @submit.prevent="save">
                <div class="row">
                    <div class="col-sm-12 col-md-6">

                        <div class="mb-4">
                            <label class="form-label">Full Name * </label>
                            <input v-model="name" required class="form-control" type="text" placeholder="Enter Full Name"/>
                        </div>
                

                          

                    </div>


                    <div class="col-sm-12 col-md-6">

                        <div class="mb-4">
                            <label class="form-label">Username *</label>
                            <input v-model="username" :disabled="pageId!='create'" required class="form-control" type="text" placeholder="Enter username here"/>
                        </div>
                
                    </div>
             
                  

                    <div class="col-sm-12 col-md-6">

                        <div class="mb-4">
                            <label class="form-label">Phone Number</label>
                            <input v-model="phone"  class="form-control" type="text" placeholder="Enter Phone number here"/>
                        </div>
                
                    </div>

                    <div class="col-sm-12 col-md-6">

                        <div class="mb-4">
                            <label class="form-label">Email</label>
                            <input v-model="email"  class="form-control" type="email" placeholder="Enter email here"/>
                        </div>
                
                    </div>


                    <hr v-if="pageId!='create'"/>
                
                    <small v-if="pageId!='create'"><strong>Set a new password only if you want to change the old password</strong><br/><br/></small>
                    <div class="col-sm-12 col-md-6">

                        <div class="mb-4">
                            <label v-if="pageId=='create'" class="form-label">Password *</label>
                            <label v-else  class="form-label">Password</label>
                            <input v-model="password" :required="pageId=='create'" class="form-control" type="password" placeholder="Enter Password Here"/>
                        </div>
                
                    </div>


                    <div class="col-sm-12 col-md-6">

                        <div class="mb-4">
                            <label v-if="pageId=='create'" class="form-label">Retype Password *</label>
                            <label v-else  class="form-label">Retype Password</label>
                            <input v-model="password2" :required="pageId=='create'" class="form-control" type="password" placeholder="Retype Password Here"/>
                        </div>
                
                    </div>
                </div>
            

                <br/>
                <br/>
                <br/>
                <button class="btn btn-primary w-100 " style="border:0" >+ Save</button>
            </form>
                </div>
  
      
    
  
    </NuxtLayout>
  </template>
  <script>
export default{
    watch: {
    username(newValue) {
      // Replace every space with an underscore
      this.username = newValue.replace(/ /g, '_');
    }
  },
    data(){
        const route = useRoute()
        const id = route.params.id;
        return {
            name:"",
            username:"",
            email:"",
            password:"",
            password2:"",
            phone:"",
            pageId:id,
            ogname:null
        }
    },
    mounted(){
        const context=this;
        if(this.pageId!=='create'){
            getRequestLoad_('/account/'+this.pageId,{},(u)=>{
                context.name=u.name;
                context.ogname=u.name.split(" ")[0];
                context.username=u.username;
                context.email=u.email;
                context.phone=u.phone;
            },()=>{
                // alert("Connection error. Please refresh and try again.");
            })
        }
    },
    methods:{
        save(){
            if(this.password!=this.password2){
                errorToast("The two passwords do not match");
                return;
            }
            const context=this;
            if(this.pageId=="create"){
                    postRequestLoad_('/account',JSON.parse(JSON.stringify(this)),(fields)=>{
                        context.$router.push('/accounts');
                        successToast("Account created successfully");
                    });
            }else{
                postRequestLoad_('/account/'+this.pageId,JSON.parse(JSON.stringify(this)),(fields)=>{
                    // context.$router.push('/accounts');
                    context.ogname=context.name.split(" ")[0];
                    successToast("Account updated successfully");
                },()=>{
                    // alert("Connection error. Please refresh and try again.");
                })
            }
        }
    }
}
</script>